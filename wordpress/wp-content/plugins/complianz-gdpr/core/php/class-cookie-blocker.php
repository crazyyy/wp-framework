<?php
defined('ABSPATH') or die("you do not have access to this page!");

if ( ! class_exists( 'cmplz_cookie_blocker' ) ) {
    class cmplz_cookie_blocker
    {
        private static $_this;
        public $script_tags = array();
        public $iframe_tags = array();

        function __construct()
        {

            if (isset(self::$_this))
                wp_die(sprintf(__('%s is a singleton class and you cannot create a second instance.', 'complianz-gdpr'), get_class($this)));

            self::$_this = $this;

        }

        static function this()
        {
            return self::$_this;

        }


        /**
         * Apply the mixed content fixer.
         *
         * @since  1.0
         *
         * @access public
         *
         */

        public function filter_buffer($buffer)
        {
            $buffer = $this->replace_tags($buffer);
            return $buffer;
        }

        /**
         * Start buffering the output
         *
         * @since  1.0
         *
         * @access public
         *
         */

        public function start_buffer()
        {
            ob_start(array($this, "filter_buffer"));
        }

        /**
         * Flush the output buffer
         *
         * @since  1.0
         *
         * @access public
         *
         */

        public function end_buffer()
        {
            if (ob_get_length()) ob_end_flush();
        }

        /**
         * Just before the page is sent to the visitor's browser, remove all tracked third party scripts
         *
         * @since  1.0
         *
         * @access public
         *
         */


        public function replace_tags($output)
        {
            if (strpos($output, '<html') === false):
                return $output;
            elseif (strpos($output, '<html') > 200):
                return $output;
            endif;

            /*
             * Get style tags
             *
             * */

            $known_style_tags = apply_filters('cmplz_known_style_tags', COMPLIANZ()->config->style_tags);


            /*
             * Get script tags, and add custom user scrripts
             *
             * */

            $known_script_tags = COMPLIANZ()->config->script_tags;
            $custom_scripts = cmplz_strip_spaces(cmplz_get_value('thirdparty_scripts'));
            if (!empty($custom_scripts) && strlen($custom_scripts)>0){
                $custom_scripts = explode(',', $custom_scripts);
                $known_script_tags = array_merge($known_script_tags ,  $custom_scripts);
            }
            $known_script_tags = apply_filters('cmplz_known_script_tags', $known_script_tags);

            /*
             * Get async list tags
             *
             * */

            $async_list = apply_filters('cmplz_known_async_tags', COMPLIANZ()->config->async_list);

            /*
             * Get iframe tags, and add custom user iframes
             *
             * */

            $known_iframe_tags = COMPLIANZ()->config->iframe_tags;
            $custom_iframes = cmplz_strip_spaces(cmplz_get_value('thirdparty_iframes'));
            if (!empty($custom_iframes) && strlen($custom_iframes)>0){
                $custom_iframes = explode(',', $custom_iframes);
                $known_iframe_tags = array_merge($known_iframe_tags ,  $custom_iframes);
            }
            $known_iframe_tags = apply_filters('cmplz_known_iframe_tags', $known_iframe_tags);

            //not meant as a "real" URL pattern, just a loose match for URL type strings.
            //edit: instagram uses ;width, so we need to allow ; as well.
            $url_pattern = '([\w.,;@?^=%&:\/~+#!\-*]*?)';

            /*
             * Handle scripts loaded with dns prefetch
             *
             *
             * */

/*            $prefetch_pattern = '/<link rel=[\'|"]dns-prefetch[\'|"] href=[\'|"](\X*?)[\'|"].*?>/i';*/
//            if (preg_match_all($prefetch_pattern, $output, $matches, PREG_PATTERN_ORDER)) {
//                foreach($matches[1] as $key => $prefetch_url){
//                    $total_match = $matches[0][$key];
//                    if ($this->strpos_arr($prefetch_url, $known_script_tags) !== false) {
//                        $new = $this->replace_href($total_match);
//                        $output = str_replace($total_match, $new, $output);
//                    }
//                }
//            }


            /*
             * Handle images from third party services, e.g. google maps
             *
             *
             * */

            $image_tags = COMPLIANZ()->config->image_tags;
            $image_tags = apply_filters('cmplz_image_tags', $image_tags);
            $image_pattern = '/<img.*?src=[\'|"](\X*?)[\'|"].*?>/i';
            if (preg_match_all($image_pattern, $output, $matches, PREG_PATTERN_ORDER)) {
                foreach($matches[1] as $key => $image_url){
                    $total_match = $matches[0][$key];
                    if ($this->strpos_arr($image_url, $image_tags) !== false) {
                        $placeholder = cmplz_placeholder(false, $image_url);

                        $new = $total_match;
                        $new = str_replace('<iframe ', '<iframe data-src-cmplz="'.$image_url.'" ', $new);
                        $new = $this->add_class($new, 'img', 'cmplz-iframe cmplz-iframe-styles '.apply_filters('cmplz_video_class', 'cmplz-no-video'));

                        $new = $this->replace_src($new, apply_filters('cmplz_source_placeholder',$placeholder));

                        if (!cmplz_get_value('dont_use_placeholders')) {
                            $new = $this->add_data($new, 'img', 'placeholder-text', apply_filters('cmplz_accept_cookies_blocked_content', cmplz_get_value('blocked_content_text')));
                        }
                        $output = str_replace($total_match, $new, $output);
                    }
                }
            }


            /*
             * Handle styles (e.g. google fonts)
             * fonts.google.com has currently been removed in favor of plugin recommendation
             *
             * */
            $style_pattern = '/<link rel=[\'|"]stylesheet[\'|"].*?href=[\'|"](\X*?)[\'|"].*?>/i';
            if (preg_match_all($style_pattern, $output, $matches, PREG_PATTERN_ORDER)) {
                foreach($matches[1] as $key => $style_url){
                    $total_match = $matches[0][$key];
                    if ($this->strpos_arr($style_url, $known_style_tags) !== false) {
                        $new = $this->replace_href($total_match);
                        $new = $this->add_class($new, 'link', 'cmplz-style-element');
                        $output = str_replace($total_match, $new, $output);
                    }

                }
            }

            /*
             * Handle iframes from third parties
             *
             *
             * */

            $iframe_pattern = '/<(iframe)[^>].*?src=[\'"](http:\/\/|https:\/\/|\/\/)'.$url_pattern.'[\'"].*?>.*?<\/iframe>/i';
            if (preg_match_all($iframe_pattern, $output, $matches, PREG_PATTERN_ORDER)) {
                foreach($matches[2] as $key => $match){
                    $total_match = $matches[0][$key];
                    $iframe_src = $matches[2][$key].$matches[3][$key];
                    if ($this->strpos_arr($iframe_src, $known_iframe_tags) !== false) {
                        $placeholder = cmplz_placeholder(false, $iframe_src);
                        $new = $total_match;
                        $new = str_replace('<iframe ', '<iframe data-src-cmplz="'.$iframe_src.'" ', $new);
                        //an iframes-styles class is added so we can reset styles from the theme, and release them after consent

                        //we insert no-video class so the script can activate on div not being video, preventing issues with additional divs.
                        if ($this->is_video($iframe_src)){
                            $video_class = apply_filters('cmplz_video_class','cmplz-video cmplz-hidden');
                            //we add a variable behind the placeholder, so other scripts which randomly add a variable with & won't cause a 404.
                            $source_placeholder =  cmplz_url . 'core/assets/video/youtube-placeholder.mp4?cmplz=1';
                        } else {
                            $video_class = apply_filters('cmplz_video_class', 'cmplz-no-video');
                            $source_placeholder =  cmplz_get_value('dont_use_placeholders') ? cmplz_url . 'core/assets/images/placeholder.html' : cmplz_url . 'core/assets/images/s.png';
                        }
                        $new = $this->add_class($new, 'iframe', 'cmplz-iframe cmplz-iframe-styles '.$video_class);

                        $source_placeholder = apply_filters('cmplz_source_placeholder',$source_placeholder);
                        $new = $this->replace_src($new, $source_placeholder);

                        if (!cmplz_get_value('dont_use_placeholders')) {
                            $new = $this->add_data($new, 'iframe','placeholder-image', $placeholder);
                            $new = $this->add_data($new, 'iframe','placeholder-text', apply_filters('cmplz_accept_cookies_blocked_content',cmplz_get_value('blocked_content_text')));
                        }

                        $output = str_replace($total_match, $new, $output);

                    }
                }
            }

            /*
             * set non iframe placeholders
             *
             *
             * */

//            $placeholder_markers = COMPLIANZ()->config->placeholder_markers;
//            foreach($placeholder_markers as $type => $marker){
/*                $placeholder_pattern = '/<(div).*?class=[\'"](.*?'.$marker.'.*?)[\'"].*?>/i';*/
//                if (preg_match_all($placeholder_pattern, $output, $matches, PREG_PATTERN_ORDER)) {
//                    $html_match = $matches[0][0];
//                    foreach($matches[2] as $key => $match) {
//
//                        $placeholder = cmplz_placeholder($type, $marker);
//                        $new_html = $this->add_data($html_match, 'div', 'placeholder-image', $placeholder);
//                        $output = str_replace($html_match, $new_html, $output);
//                        $output = str_replace($marker, $marker." cmplz-div-placeholder", $output);
//                    }
//
//                }
//            }


            /*
             * Handle scripts from third parties
             *
             *
             * */

            $script_pattern = '/(<script.*?>)(\X*?)<\/script>/i';
            $index = 0;
            if (preg_match_all($script_pattern, $output, $matches, PREG_PATTERN_ORDER)) {
                foreach($matches[1] as $key => $script_open){
                    //we don't block scripts with the cmplz-native class
                    if (strpos($script_open,'cmplz-native')!==FALSE) continue;
                    //exclude ld+json
                    if (strpos($script_open,'application/ld+json')!==FALSE) continue;
                    $total_match = $matches[0][$key];
                    $content = $matches[2][$key];

                    //if there is inline script here, it has some content
                    if (!empty($content)) {
                        if (strpos($content, 'avia_preview')!==false) continue;
                        $found = $this->strpos_arr($content, $known_script_tags);
                        if ($found !== false) {
                            $new = $total_match;
                            $new = $this->add_class($new, 'script', 'cmplz-script');

                            $new = $this->set_javascript_to_plain($new);
                            $output = str_replace($total_match, $new, $output);
                        }
                    }

                    //when script contains src
                    $script_src_pattern = '/<script [^>]*?src=[\'"](http:\/\/|https:\/\/|\/\/)'.$url_pattern.'[\'"].*?>/i';
                    if (preg_match_all($script_src_pattern, $total_match, $src_matches, PREG_PATTERN_ORDER)) {

                        foreach ($src_matches[2] as $src_key => $script_src) {

                            $script_src = $src_matches[1][$src_key].$src_matches[2][$src_key];
                            $found = $this->strpos_arr($script_src, $known_script_tags);
                            if ($found !== false){
                                $new = $total_match;
                                $new = $this->add_class($new, 'script', 'cmplz-script');
                                $new = $this->set_javascript_to_plain($new);

                                if ($this->strpos_arr($found, $async_list)){
                                    $index ++;
                                    $new = $this->add_data($new, 'script', 'post_scribe_id', 'cmplz-ps-'.$index);
                                    if (cmplz_has_async_documentwrite_scripts()) {
                                        $new .= '<div class="cmplz-blocked-content-container"><div class="cmplz-blocked-content-notice cmplz-accept-cookies">'.apply_filters('cmplz_accept_cookies_blocked_content',cmplz_get_value('blocked_content_text')).'</div><div id="cmplz-ps-' . $index . '"><img src="'.cmplz_placeholder('div').'"></div></div>';
                                    }
                                }

                                $output = str_replace($total_match, $new, $output);
                            }
                        }
                    }
                }
            }

            //add a marker so we can recognize if this function is active on the front-end
            $output = str_replace("<body ", '<body data-cmplz=1 ', $output);
            return $output;
        }



        /**
         * check if there is a partial match between a keys of the array and the haystack
         * We cannot use array_search, as this would not allow partial matches.
         *
         * @param string $haystack
         * @param array $needle
         * @return bool|string
         */

        private function strpos_arr($haystack, $needle)
        {
            if (empty($haystack)) return false;

            if (!is_array($needle)) $needle = array($needle);

            foreach ($needle as $key => $what) {
                $search = (is_numeric($key)) ? $what : $key;
                if (($pos = strpos($haystack, $search)) !== false) return $search;
            }
            return false;
        }

        private function set_javascript_to_plain($script){
            $pattern = '/<script[^>].*?\K(type=[\'|\"]text\/javascript[\'|\"])(?=.*>)/i';
            preg_match($pattern, $script, $matches);
            if ($matches) {
                $script = preg_replace($pattern, 'type="text/plain"', $script, 1);
            } else {
                $pos = strpos($script, "<script");
                if ($pos !== false) {
                    $script = substr_replace($script, '<script type="text/plain"', $pos, strlen("<script"));
                }
            }

            return $script;
        }

        private function remove_src($script){
            $pattern = '/src=[\'"](http:\/\/|https:\/\/)([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-]?)[\'"]/i';
            $script = preg_replace($pattern, '', $script);
            return $script;
        }

        /**
         * replace the src attribute with a placeholder of choice
         *
         * @param string $script
         * @param string $new_src
         * @return string
         */

        private function replace_src($script, $new_src){
            $pattern = '/src=[\'"](http:\/\/|https:\/\/|\/\/)([\w.,@!?^=%&:\/~+#-;]*[\w@!?^=%&\/~+#-;]?)[\'"]/i';
            $new_src = ' src="'.$new_src.'" ';
            preg_match($pattern, $script, $matches);
            $script = preg_replace($pattern, $new_src, $script);
            return $script;
        }

        /**
         * replace the href attribute with a data-href attribute
         *
         * @param string $link
         * @return string
         */

        private function replace_href($link){
            return str_replace('href=', 'href="#" data-href=', $link);
        }

        /**
         * Add a class to an HTML element
         *
         * @param $html
         * @param $el
         * @param $class
         * @return string
         */

        private function add_class($html, $el, $class){
            $class = esc_attr($class);
            preg_match('/<'.$el.'[^>].*?\K(class=")(?=.*">)/i', $html, $matches);

            if ($matches) {
                $html = preg_replace('/<'.$el.'[^>].*?\K(class=")(?=.*">)/i', 'class="'.$class.' ', $html, 1);
            } else {
                $pos = strpos($html, "<$el");
                if ($pos !== false) {
                    $html = substr_replace($html, '<'.$el.' class="'.$class.'"', $pos, strlen("<$el"));
                }
            }
            return $html;
        }

        /**
         * Add a data attribute to an html element
         *
         * @param string $html
         * @param string $el
         * @param string $id
         * @param string $content
         * @return string $html
         */

        private function add_data($html, $el, $id, $content){
            $content = esc_attr($content);
            $id = esc_attr($id);

            $pos = strpos($html, "<$el");
            if ($pos !== false) {
                $html = substr_replace($html, '<'.$el.' data-'.$id.'="'.$content.'"', $pos, strlen("<$el"));
            }

            return $html;
        }

        /**
         * Check if this iframe source is a video
         * @param $iframe_src
         * @return bool
         */

        private function is_video($iframe_src){
           if (strpos($iframe_src, 'dailymotion')!==false || strpos($iframe_src, 'youtube')!==false || strpos($iframe_src, 'vimeo')!==false){
               return true;
           }

           return false;
        }

    }
}



