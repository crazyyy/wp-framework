<?php

/**
 * HTTP/2 optimization functions and hooks.
 *
 * This class provides the functionality for HTTP/2 optimization functions and hooks.
 *
 * @since      2.9.0
 * @package    abovethefold
 * @subpackage abovethefold/includes
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_HTTP2
{

    /**
     * Above the fold controller
     */
    public $CTRL;

    public $push = false;
    public $config;

    public $enqueued = array();

    /**
     * Initialize the class and set its properties
     */
    public function __construct(&$CTRL)
    {
        $this->CTRL =& $CTRL;

        if ($this->CTRL->disabled) {
            return; // above the fold optimization disabled for area / page
        }

        // HTTP/2 optimization enabled
        if (isset($this->CTRL->options['http2_push']) && $this->CTRL->options['http2_push']) {
            $this->push = (isset($this->CTRL->options['http2_push_config']) && is_array($this->CTRL->options['http2_push_config'])) ? $this->CTRL->options['http2_push_config'] : array();
        }
        if (empty($this->push)) {
            $this->push = false;
        }

        if (!$this->push && isset($this->CTRL->options['http2_push_criticalcss']) && $this->CTRL->options['http2_push_criticalcss']) {
            $this->push = array();
        }

        // HTTP/2 Server Push enabled
        if (is_array($this->push)) {

            // add headers
            $this->CTRL->loader->add_action('abtf_html_pre', $this, 'push_headers', 10);
        }
    }

    /**
     * Output HTTP/2 push headers
     */
    public function push_headers($buffer)
    {
        
        // push HTML images?
        $pushTypes = array();
        foreach ($this->push as $push) {
            if (!isset($pushTypes[$push['type']])) {
                $pushTypes[$push['type']] = array();
            }
            $pushTypes[$push['type']][] = $push;
        }

        // resources to push
        $pushResources = array();

        // first priority: Critical CSS
        if ($this->CTRL->optimization->http2push_criticalcss) {
            $local = $this->is_local($this->CTRL->optimization->http2push_criticalcss);
            $pushResources[] = array(
                'src' => esc_url((($local) ? $this->url_to_relative_path($this->CTRL->optimization->http2push_criticalcss) : $this->CTRL->optimization->http2push_criticalcss)),
                'local' => $local,
                'type' => 'style',
                'meta' => true
            );
        }

        // WordPress stylesheets
        if (isset($pushTypes['style'])) {
            global $wp_styles;

            foreach ($wp_styles->queue as $style) {
                $src = $wp_styles->registered[$style]->src;

                $match = $meta = false;
                foreach ($pushTypes['style'] as $rule) {
                    $this->matchRule($src, $rule, $match, $meta);
                }
                if ($match) {
                    $local = $this->is_local($src); // (strpos($src, home_url()) !== false);
                    $pushResources[] = array(
                        'src' => esc_url((($local) ? $this->url_to_relative_path($src) : $src)),
                        'local' => $local,
                        'type' => 'style',
                        'meta' => $meta
                    );
                }
            }
        }

        // WordPress scripts
        if (isset($pushTypes['script'])) {
            global $wp_scripts;

            foreach ($wp_scripts->queue as $script) {
                $src = $wp_scripts->registered[$script]->src;

                $match = $meta = false;
                foreach ($pushTypes['script'] as $rule) {
                    $this->matchRule($src, $rule, $match, $meta);
                }
                if ($match) {
                    $local = $this->is_local($src);
                    $pushResources[] = array(
                        'src' => esc_url((($local) ? $this->url_to_relative_path($src) : $src)),
                        'local' => $local,
                        'type' => 'script',
                        'meta' => $meta
                    );
                }
            }
        }

        // HTML images
        if (isset($pushTypes['image'])) {
            
            // image regex
            $image_regex = '#<img[^>]+src[^>]+>#is';

            if (preg_match_all($image_regex, $buffer, $out)) {
                foreach ($out[0] as $n => $image) {

                    // extract image
                    $src = $this->src_regex($out[0][$n]);
                    if (!$src) {
                        continue 1;
                    }

                    // not a valid URL / path
                    if (strpos($src, 'http') === 0 || strpos($src, '/') === 0) {
                        $images[] = $src;
                    }
                }

                $images = array_unique($images);

                foreach ($images as $src) {
                    $match = $meta = false;
                    foreach ($pushTypes['image'] as $rule) {
                        $this->matchRule($src, $rule, $match, $meta);
                    }
                    if ($match) {
                        $local = $this->is_local($src);
                        $pushResources[] = array(
                            'src' => esc_url((($local) ? $this->url_to_relative_path($src) : $src)),
                            'local' => $local,
                            'type' => 'image',
                            'meta' => $meta
                        );
                    }
                }
            }
        }

        // custom resource list
        if (isset($pushTypes['custom'])) {
            foreach ($pushTypes['custom'] as $push) {
                if (isset($push['resources']) && !empty($push['resources'])) {
                    foreach ($push['resources'] as $resource) {
                        $local = $this->is_local($resource['file']);
                        $src = $resource['file'];
                        $pushResources[] = array(
                            'src' => esc_url((($local) ? $this->url_to_relative_path($src) : $src)),
                            'local' => $local,
                            'type' => $resource['type'],
                            'mime' => (isset($resource['mime']) && $resource['mime']) ? $resource['mime'] : false,
                            'meta' => (isset($push['meta']) && $push['meta']) ? $push['meta'] : false
                        );
                    }
                }
            }
        }

        // create HTTP/2 Push Header
        $links = $meta = array();
        foreach ($pushResources as $resource) {
            $link = sprintf(
                '<%s>; rel=preload; as=%s',
                $resource['src'],
                sanitize_html_class($resource['type'])
            );
            if (!$resource['local']) {
                $link .= '; crossorigin';
            }
            if (isset($resource['mime']) && $resource['mime']) {
                $link .= sprintf('; type=\'%s\'', str_replace('\'', '\\\'', $resource['mime']));
            }

            // CloudFlare support for ServerPush appears to be broken as of Sept. 8, 2017
            // @link https://community.cloudflare.com/t/is-http-2-server-push-disabled/5577
            //
            // awaiting the status of the availability and exact requirement for the Link: header,
            // the 1 link per header implementation is used from the official CloudFlare plugin,
            // instead of a more compact grouped header
            header('Link: ' . $link, false);
            //$links[] = $link;

            // meta tag fallback
            if ($resource['meta']) {
                $link = sprintf(
                    '<link rel="preload" href="%s" as="%s"',
                    $resource['src'],
                    sanitize_html_class($resource['type'])
                );
                if (!$resource['local']) {
                    $link .= ' crossorigin';
                }
                if (isset($resource['mime']) && $resource['mime']) {
                    $link .= sprintf(' type="%s"', str_replace('"', '&quot;', $resource['mime']));
                }
                $meta[] = $link .'>';
            }
        }

        // output HTTP/2 Push Header
        //header('Link: ' . implode(',',$links), false);

        // include fallback meta
        $buffer = str_replace('<link rel=http2push>', implode('', $meta), $buffer);

        return $buffer;
    }

    /**
     * Extract src from tag
     */
    public function src_regex($tag)
    {

        // detect if tag has href
        $srcpos = strpos($tag, 'src');
        if ($srcpos !== false) {

            // regex
            $char = substr($tag, ($srcpos + 4), 1);
            if ($char === '"' || $char === '\'') {
                $char = preg_quote($char);
                $regex = '#(src\s*=\s*'.$char.')([^'.$char.']+)('.$char.')#Usmi';
            } elseif ($char === ' ' || $char === "\n") {
                $regex = '#(src\s*=\s*["|\'])([^"|\']+)(["|\'])#Usmi';
            } else {
                $regex = '#(src\s*=)([^\s]+)(\s)#Usmi';
            }

            // match href
            if (!preg_match($regex, $tag, $out)) {
                return false;
            }
            return $out[2];
        }

        return false;
    }

    /**
     * Match resource push rule
     */
    public function matchRule($src, $rule, &$match, &$meta)
    {
        if ($rule['match'] === 'all') {
            $match = true;
            if (isset($rule['meta'])) {
                $meta = $rule['meta'];
            }
        } elseif (isset($rule['match']) && is_array($rule['match']) && isset($rule['match']['pattern'])) {
            $regex = (isset($rule['match']['regex']) && $rule['match']['regex']);
            $exclude = (isset($rule['match']['exclude']) && $rule['match']['exclude']);
            if ($exclude && !$match) {
                // not included
            } else {
                if ($regex) {
                    if (!@preg_match($rule['match']['pattern'], $src)) {
                        // no match
                    } else {
                        // exclude resource
                        if ($exclude) {
                            $match = false;
                        } else {
                            $match = true;
                            if (isset($rule['meta'])) {
                                $meta = $rule['meta'];
                            }
                        }
                    }
                } else {
                    if (strpos($src, $rule['match']['pattern']) !== false) {

                        // exclude resource
                        if ($exclude) {
                            $match = false;
                        } else {
                            $match = true;
                            if (isset($rule['meta'])) {
                                $meta = $rule['meta'];
                            }
                        }
                    }
                }
            }
        }

        return array($match,$meta);
    }

    /**
     * Local resource?
     */
    public function is_local($src)
    {

        // relative path
        if (strpos($src, '://') === false && strpos($src, '//') !== 0) {
            return true;
        }

        return !!$this->CTRL->proxy->is_local($src);
    }

    /**
     * URL to relative path
     */
    public function url_to_relative_path($src)
    {
        return '//' === substr($src, 0, 2) ? preg_replace('/^\/\/([^\/]*)\//', '/', $src) : preg_replace('/^http(s)?:\/\/[^\/]*/', '', $src);
    }

    /**
     * Return enqueue type
     */
    public static function enqueue_type($current_hook)
    {
        return 'style_loader_src' === $current_hook ? 'style' : 'script';
    }

    /**
     * Javascript client settings
     */
    public function client_jssettings(&$html_after)
    {

        // HTTP/2 optimization enabled
        if (!$this->push) {

            // disabled
            return;
        }

        $html_after .= '<link rel=http2push>';
    }
}
