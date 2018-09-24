<?php

/**
 * Abovethefold optimization functions and hooks.
 *
 * This class provides the functionality for optimization functions and hooks.
 *
 * @since      1.0
 * @package    abovethefold
 * @subpackage abovethefold/includes
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_ExtractFullCss {

	/**
	 * Above the fold controller
	 */
	public $CTRL;

	/**
	 * CSS buffer started
	 */
	public $buffer_started = false;


	/**
	 * Initialize the class and set its properties
	 */
	public function __construct( &$CTRL ) {

		$this->CTRL =& $CTRL;

		if ($this->CTRL->disabled) {
			return; // above the fold optimization disabled for area / page
		}

		// output buffer
		$this->CTRL->loader->add_action('init', $this, 'start_output_buffer',99999);

		// disable CSS minification for supported plugins
		$this->CTRL->plugins->diable_css_minification();

	}

	/**
	 * Init output buffering
	 */
	public function start_output_buffer( ) {

		// prevent double buffer
		if ($this->buffer_started) {
			return;
		}

		$this->buffer_started = true;

		// start buffer
		ob_start(array($this, 'end_buffering'));

	}

	/**
	 * End CSS extract output buffer
	 */
	public function end_buffering($HTML) {

		// disabled, do not process buffer
		if (!$this->CTRL->is_enabled()) {
			return $HTML;
		}

		if ( stripos($HTML,"<html") === false || stripos($HTML,"<xsl:stylesheet") !== false ) {
			// Not valid HTML
			return $HTML;
		}

        $files = false;
		if (isset($_REQUEST['files'])) {
        	$files = explode(',',$_REQUEST['files']);
        	if (!is_array($files) || empty($files)) {
        		$files = false;
        	}
        }

		$siteurl = trailingslashit(home_url());
		$siteurlhost = parse_url($siteurl,PHP_URL_HOST);

		/**
		 * Load HTML into DOMDocument
		 */
		$DOM = new DOMDocument();
		$DOM->preserveWhiteSpace = false;
		@$DOM->loadHTML(mb_convert_encoding($HTML, 'HTML-ENTITIES', 'UTF-8'));

		/**
		 * Query stylesheets
		 */
		$xpath = new DOMXpath($DOM);
		$stylesheets = $xpath->query('//link[not(self::script or self::noscript)]');

		$csscode = array();

		$cssfiles = array();
		$store_cssfiles = ((isset($_REQUEST['output']) && strtolower($_REQUEST['output']) === 'print') || $this->CTRL->view === 'abtf-buildtool-css');
		$reflog = array();

		$remove = array();
		foreach ($stylesheets as $sheet) {

			$rel = $sheet->getAttribute('rel');
			if (strtolower(trim($rel)) !== 'stylesheet') {
				continue 1;
			}
			$src = $sheet->getAttribute('href');
			$media = $sheet->getAttribute('media');

			if($media) {
				$medias = explode(',',$media);
				$media = array();
				foreach($medias as $elem) {
					if (trim($elem) === '') { continue 1; }
					$media[] = $elem;
				}
			} else {
				// No media specified - applies to all
				$media = array('all');
			}

			/**
			 * Sheet file/url
			 */
			if($src) {

				$url = $src;

				// Strip query string
				$src = current(explode('?',$src,2));

				// URL decode
				if (strpos($src,'%')!==false) {
					$src = urldecode($src);
				}

				// Normalize URL
				if (strpos($url,'//')===0) {
					if (is_ssl()) {
						$url = "https:".$url;
					} else {
						$url = "http:".$url;
					}
				} else if (strpos($url,'/')===0) {
					$url = rtrim($siteurl,'/') . $url;
				} else if ((strpos($url,'//')===false) && (strpos($url,$siteurlhost)===false)) {
					$url = $siteurl.$url;
				}

				$hash = md5($url);
				if (isset($reflog[$hash])) {
					continue 1;
				}
				$reflog[$hash] = 1;

				/**
				 * External URL
				 */
				$fileurl = @parse_url($url);

				if ($fileurl['host']!==$siteurlhost) {

					// get CSS code
					$css = $this->CTRL->remote_get($url);
					if (trim($css) === '') {
						continue 1; 
					}

					if ($files && !in_array(md5($url),$files)) {
						continue 1;
					}

					if (preg_match('|url\s*\(|Ui',$css)) {

						// convert root-relative to absolute urls
						$css = preg_replace('/url\(\s*([\'"])\/([^\/][^\)]+)[\'"]\s*\)/i', 'url($1' . $fileurl['scheme'] . '://' . $fileurl['host'] . '/$2$1)', $css);
						// convert root-relative to absolute urls
						$css = preg_replace('/url\(\s*\/([^\/][^\)]+)\s*\)/i', 'url(' . $fileurl['scheme'] . '://' . $fileurl['host'] . '/$1)', $css);

						// convert relative to absolute urls
						$basename = basename($fileurl['path']);
						$path = str_replace($basename,'',$fileurl['path']);
						if (!$path || $path === '/') {
							$path = '/';
						}
						$css = preg_replace('/url\(\s*([\'"])(?!(http|https):)([a-z0-9\.][^\)]+)[\'"]\s*\)/i', 'url($1' . $fileurl['scheme'] . '://' . $fileurl['host'] . $path . '$3$1)', $css);
						$css = preg_replace('/url\(\s*(?!(http|https):)([a-z0-9\.][^\)]+)\s*\)/i', 'url($1' . $fileurl['scheme'] . '://' . $fileurl['host'] . $path . '$2)', $css);
					}

					$csscode[] = array($media,$css);

				} else {
					$path = (substr(ABSPATH,-1) === '/') ? substr(ABSPATH,0,-1) : ABSPATH;
					$path .= preg_replace('|^(http(s)?:)?//[^/]+/|','/',$src);

					if ($files && !in_array(md5($url),$files)) {
						continue 1;
					}

					// read local file
					$css = file_get_contents($path);

					if (preg_match('|url\s*\(|Ui',$css)) {

						// convert root-relative to absolute urls
						$css = preg_replace('/url\(\s*([\'"])\/([^\/][^\)]+)[\'"]\s*\)/i', 'url($1' . $fileurl['scheme'] . '://' . $fileurl['host'] . '/$2$1)', $css);
						$css = preg_replace('/url\(\s*\/([^\/][^\)]+)\s*\)/i', 'url(' . $fileurl['scheme'] . '://' . $fileurl['host'] . '/$1)', $css);

						// convert relative to absolute urls
						$basename = basename($fileurl['path']);
						$path = str_replace($basename,'',$fileurl['path']);
						if (!$path || $path === '/') {
							$path = '/';
						}
						$css = preg_replace('/url\(\s*([\'"])(?!(http|https|data):)([a-z0-9\.][^\)]+)[\'"]\s*\)/i', 'url($1' . $fileurl['scheme'] . '://' . $fileurl['host'] . $path . '$3$1)', $css);
						$css = preg_replace('/url\(\s*(?!(http|https|data):)([a-z0-9\.][^\)]+)[\'"]?\s*\)/i', 'url(' . $fileurl['scheme'] . '://' . $fileurl['host'] . $path . '$2)', $css);
					}

					$csscode[] = array($media,$css);
				}

				if ($store_cssfiles) {

					$cssfiles[] = array(
						'src' => $url, 
						'code' => $css,
						'media' => $media
					);
				}
			}

			// Remove script from DOM
			$remove[] = $sheet;
		}

		/**
		 * Query inline styles
		 */
		$inlinestyles = $xpath->query('//style[not(self::script or self::noscript)]');
		foreach ($inlinestyles as $style) {

			$media = $style->getAttribute('media');

			if($media) {
				$medias = explode(',',strtolower($media));
				$media = array();
				foreach($medias as $elem) {
					if (trim($elem) === '') { continue 1; }
					$media[] = $elem;
				}
			} else {
				// No media specified - applies to all
				$media = array('all');
			}

			$code = $style->nodeValue;

			$hash = md5($code);
			if (isset($reflog[$hash])) {
				continue 1;
			}
			$reflog[$hash] = 1;

			if ($style->getAttribute('rel') === 'abtf') {
				continue 1;
			}

			$code = preg_replace('#.*<!\[CDATA\[(?:\s*\*/)?(.*)(?://|/\*)\s*?\]\]>.*#sm','$1',$code);

			$xdoc = new DOMDocument();
			$xdoc->appendChild($xdoc->importNode($style, true));
			$inlinecode = $xdoc->saveHTML();

			if ($files && !in_array(md5($inlinecode),$files)) {
				continue 1;
			}

			$csscode[] = array($media,$code);

            if ($store_cssfiles) {

				$cssfiles[] = array(
					'src' => md5($code),
					'inline' => true,
					'code' => $inlinecode,
					'inlinecode' => $code,
					'media' => $media
				);
			}

			// Remove script from DOM
			$remove[] = $style;
		}

		/**
		 * Print CSS for extraction by Critical CSS generator
		 */
		$inlineCSS = '';
		foreach ($csscode as $code) {
			if (in_array('all',$code[0]) || in_array('screen',$code[0])) {
				$inlineCSS .= $code[1];
			}
		}

		foreach($remove as $style) {
			$style->parentNode->removeChild($style);
		}

		/**
		 * Build Tool CSS JSON output
		 */
		if ($this->CTRL->view === 'abtf-buildtool-css') {
			return "--FULL-CSS-JSON--\n" . json_encode($cssfiles) . "\n--FULL-CSS-JSON--";
		}

		$output = 'EXTRACT-CSS-' . md5(SECURE_AUTH_KEY . AUTH_KEY);
		$output .= "\n" . json_encode(array(
			'css' => $inlineCSS,
			'html' => $HTML
		));

		$url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

		$parsed = array();
		parse_str(substr($url, strpos($url, '?') + 1), $parsed);
		$extractkey = $parsed['extract-css'];
		unset($parsed['extract-css']);
		unset($parsed['output']);
		$url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . preg_replace('|\?.*$|Ui','',$_SERVER['REQUEST_URI']);
		if(!empty($parsed))
		{
			$url .= '?' . http_build_query($parsed);
		}

		if (isset($_REQUEST['output']) && (
			strtolower($_REQUEST['output']) === 'css'
			|| strtolower($_REQUEST['output']) === 'download'
		)) {

			if (strtolower($_REQUEST['output']) === 'download') {
				header('Content-type: text/css');
				header('Content-disposition: attachment; filename="full-css-'.$extractkey.'.css"');
			}

			return $inlineCSS;

		} else if (isset($_REQUEST['output']) && strtolower($_REQUEST['output']) === 'print') {

			/**
			 * Print full CSS export page
			 */

			function human_filesize($bytes, $decimals = 2) {
			    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
			    $factor = floor((strlen($bytes) - 1) / 3);
			    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
			}

			require_once(plugin_dir_path( realpath(dirname( __FILE__ ) . '/') ) . 'includes/extract-full-css.inc.php');

			return $output;
		}

		return $output;
	}

}
