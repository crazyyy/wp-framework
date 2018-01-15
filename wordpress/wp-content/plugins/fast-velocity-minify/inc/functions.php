<?php

# handle better utf-8 and unicode encoding
if(function_exists('mb_internal_encoding')) { mb_internal_encoding('UTF-8'); }

# Consider fallback to PHP Minify [2017.12.17] from https://github.com/matthiasmullie/minify (must be defined on the outer scope)
$path = $plugindir . 'libs/matthiasmullie';
require_once $path . '/minify/src/Minify.php';
require_once $path . '/minify/src/CSS.php';
require_once $path . '/minify/src/JS.php';
require_once $path . '/minify/src/Exception.php';
require_once $path . '/minify/src/Exceptions/BasicException.php';
require_once $path . '/minify/src/Exceptions/FileImportException.php';
require_once $path . '/minify/src/Exceptions/IOException.php';
require_once $path . '/path-converter/src/ConverterInterface.php';
require_once $path . '/path-converter/src/Converter.php';
use MatthiasMullie\Minify;

# use HTML minification
require_once ($plugindir . 'libs/mrclay/HTML.php');

# get cache directories and urls
function fvm_cachepath() {

# custom directory
$fvm_change_cache_path = get_option('fastvelocity_min_change_cache_path');
$fvm_change_cache_base = get_option('fastvelocity_min_change_cache_base_url');
$upload = array();
if($fvm_change_cache_path !== false && $fvm_change_cache_base !== false && strlen($fvm_change_cache_path) > 1) {
	$upload['basedir'] = trim($fvm_change_cache_path);
	$upload['baseurl'] = trim($fvm_change_cache_base);
} else {
	$upload = wp_upload_dir(); # default 
}

# create
$cachebase = rtrim($upload['basedir'], '/').'/fvm';
$cachedir =  rtrim($upload['basedir'], '/').'/fvm/out';
$tmpdir = rtrim($upload['basedir'], '/').'/fvm/tmp';
$cachedirurl = rtrim($upload['baseurl'], '/').'/fvm/out';
if(!is_dir($cachebase)) { mkdir($cachebase, 0755, true); }
if(!is_dir($cachedir)) { mkdir($cachedir, 0755, true); }
if(!is_dir($tmpdir)) { mkdir($tmpdir, 0755, true); }

# return
return array('cachebase'=>$cachebase,'tmpdir'=>$tmpdir, 'cachedir'=>$cachedir, 'cachedirurl'=>$cachedirurl);
}


# detect external or internal scripts
function fvm_is_local_domain($src) {
$locations = array(home_url(), site_url(), network_home_url(), network_site_url());
foreach ($locations as $l) { 
	$l = trim(trim(str_ireplace(array('http://', 'https://', 'www.', 'cdn.', 'static.', 'assets.'), '', trim($l)), '/')); 
	if (stripos($src, $l) === false) { return true; }
}
return false;
}


# functions, get hurl info
function fastvelocity_min_get_hurl($src, $wp_domain, $wp_home) {
	
# preserve empty source handles
$hurl = trim($src); if(empty($hurl)) { return $hurl; }      

# some fixes
$hurl = str_ireplace(array('&#038;', '&amp;'), '&', $hurl);

# get current protocol scheme with cloudflare support
if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') { $protocol = 'https://'; } else { $protocol = 'http://'; }

#make sure wp_home doesn't have a forward slash
$wp_home = rtrim($wp_home, '/');

# apply some filters
if (substr($hurl, 0, 2) === "//") { $hurl = 'http://'.ltrim($hurl, "/"); }  # protocol only
if (substr($hurl, 0, 4) === "http" && stripos($hurl, $wp_domain) === false) { return $hurl; } # return if external domain
if (substr($hurl, 0, 4) !== "http" && stripos($hurl, $wp_domain) !== false) { $hurl = $wp_home.'/'.ltrim($hurl, "/"); } # protocol + home

# prevent double forward slashes in the middle
$hurl = str_ireplace('###', '://', str_ireplace('//', '/', str_ireplace('://', '###', $hurl)));

# consider different wp-content directory
$proceed = 0; if(!empty($wp_home)) { 
	$alt_wp_content = basename($wp_home); 
	if(substr($hurl, 0, strlen($alt_wp_content)) === $alt_wp_content) { $proceed = 1; } 
}

# protocol + home for relative paths
if (substr($hurl, 0, 12) === "/wp-includes" || substr($hurl, 0, 9) === "/wp-admin" || substr($hurl, 0, 11) === "/wp-content" || $proceed == 1) { 
$hurl = $wp_home.'/'.ltrim($hurl, "/"); }

# make sure there is a protocol prefix as required
$hurl = $protocol.str_ireplace(array('http://', 'https://'), '', $hurl); # enforce protocol

# no query strings
if (stripos($hurl, '.js?v') !== false) { $hurl = stristr($hurl, '.js?v', true).'.js'; } # no query strings
if (stripos($hurl, '.css?v') !== false) { $hurl = stristr($hurl, '.css?v', true).'.css'; } # no query strings

return $hurl;	
}


# check if it's an internal url or not
function fvm_internal_url($hurl, $wp_home, $noxtra=NULL) {
if (substr($hurl, 0, strlen($wp_home)) === $wp_home) { return true; }
if (stripos($hurl, $wp_home) !== false) { return true; }
if (isset($_SERVER['HTTP_HOST']) && stripos($hurl, preg_replace('/:\d+$/', '', $_SERVER['HTTP_HOST'])) !== false) { return true; }
if (isset($_SERVER['SERVER_NAME']) && stripos($hurl, preg_replace('/:\d+$/', '', $_SERVER['SERVER_NAME'])) !== false) { return true; }
if (isset($_SERVER['SERVER_ADDR']) && stripos($hurl, preg_replace('/:\d+$/', '', $_SERVER['SERVER_ADDR'])) !== false) { return true; }

# allow specific external urls to be merged
if($noxtra === NULL) {
$merge_allowed_urls = array_map('trim', explode("\n", get_option('fastvelocity_min_merge_allowed_urls', '')));
if(is_array($merge_allowed_urls) && strlen(implode($merge_allowed_urls)) > 0) {
	foreach ($merge_allowed_urls as $e) {
		if (stripos($hurl, $e) !== false && !empty($e)) { return true; }
	}
}
}

return false;
}


# case-insensitive in_array() wrapper
function fastvelocity_min_in_arrayi($hurl, $ignore){
	$hurl = str_ireplace(array('http://', 'https://'), '//', $hurl); # better compatibility
	$hurl = strtok(urldecode(rawurldecode($hurl)), '?'); # no query string, decode entities
	
	if (!empty($hurl) && is_array($ignore)) { 
		foreach ($ignore as $i) {
		$i = str_ireplace(array('http://', 'https://'), '//', $i); # better compatibility
		$i = strtok(urldecode(rawurldecode($i)), '?'); # no query string, decode entities
		$i = trim(trim($i, '/'), '*'); # wildcard removal
		if (stripos($hurl, $i) !== false) { return true; } 
		} 
	}
	return false;
}


# better compatibility urls, fix bootstrap 4 svg images https://www.w3.org/TR/SVG/intro.html#NamespaceAndDTDIdentifiers
function fvm_compat_urls($code) {
	$code = str_ireplace(array('http://', 'https://'), '//', $code); 
	$code = str_ireplace('//www.w3.org/2000/svg', 'http://www.w3.org/2000/svg', $code);
	return $code;
}


# minify css string with PHP Minify
function fastvelocity_min_minify_css_string($css) {
$minifier = new Minify\CSS($css);
$minifier->setMaxImportSize(15); # [css only] embed assets up to 15 Kb (default 5Kb) - processes gif, png, jpg, jpeg, svg & woff
$min = $minifier->minify();
if($min !== false) { return fvm_compat_urls($min); }
return fvm_compat_urls($css);
}


# find if we are running windows
function fvm_server_is_windows() {
	if(defined('PHP_OS_FAMILY') && strtolower(PHP_OS_FAMILY) == 'windows') { return true; } # PHP 7.2.0+
	if(function_exists('php_uname')) {
		$os = @php_uname('s');
		if (stripos($os, 'Windows') !== false) { 
			return true; 
		}
	}
	return false;
}



# minify js on demand (one file at one time, for compatibility)
function fastvelocity_min_get_js($url, $js, $disable_js_minification) {

# exclude minification on already minified files + jquery (because minification might break those)
$excl = array('jquery.js', '.min.js', '-min.js', '/uploads/fusion-scripts/'); 
foreach($excl as $e) { if (stripos(basename($url), $e) !== false) { $disable_js_minification = true; break; } }	

# remove BOM
$js = fastvelocity_min_remove_utf8_bom($js); 

# minify JS
if(!$disable_js_minification) { 
	$js = fastvelocity_min_minify_js_string($js); 
} else {
	$js = fvm_compat_urls($js); 
}

# needed when merging js files
$js = $js."\r\n;"; 

# return html
return $js;
}


# minify JS string with PHP Minify or YUI Compressors
function fastvelocity_min_minify_js_string($js) {
global $tmpdir, $plugindir;

# check for exec + a supported java version
$use_yui = get_option('fastvelocity_min_use_yui');
if($use_yui == true && function_exists('exec') && exec('command -v java >/dev/null && echo "yes" || echo "no"') == 'yes') {

	# create temp files
	$tmpname = hash('adler32', $js);
	$tmpin = $tmpdir.'/'.$tmpname.'.js';
	file_put_contents($tmpin, $js);
	$tmpout = $tmpdir.'/'.$tmpname.'.min.js';
	
	# define jar path and command
	$cmd = 'java -jar '.$plugindir.'libs/jar/yuicompressor-2.4.8.jar'.' --preserve-semi --nomunge '.$tmpin.' -o '.$tmpout;
		
	# run local compiler
	exec($cmd . ' 2>&1', $output);
	if(count($output) == 0 && file_exists($tmpout)) {
		$min = file_get_contents($tmpout);
		if($min !== false) { return fvm_compat_urls($min); }
		exit();
	}		
}

# PHP Minify [2016.08.01] from https://github.com/matthiasmullie/minify
$minifier = new Minify\JS($js);
$min = $minifier->minify();
if($min !== false && (strlen(trim($js)) == strlen(trim($min)) || strlen(trim($min)) > 0)) { return fvm_compat_urls($min); }

# if we are here, something went  wrong and minification didn't work
$js = "\n/*! Fast Velocity Minify: Minification of the following section has failed, so it has been merged instead. */\n".$js;
return fvm_compat_urls($js);
}

# functions, minify html
function fastvelocity_min_minify_html($html) {
return fastvelocity_min_Minify_HTML::minify($html);
}

# functions to minify HTML
function fastvelocity_min_html_compression_finish($html) { return fastvelocity_min_minify_html($html); }
function fastvelocity_min_html_compression_start() {
if (fastvelocity_exclude_contents() == true) { return; }
$use_alt_html_minification = get_option('fastvelocity_min_use_alt_html_minification', '0');
if($use_alt_html_minification == '1') { ob_start('fastvelocity_min_minify_alt_html'); }
else { ob_start('fastvelocity_min_html_compression_finish'); }
}

# alternative html minification, minimal
function fastvelocity_min_minify_alt_html($html) {
$html = trim(preg_replace('/\v(?:[\t\v\h]+)/iu', "\n", $html));
$html = trim(preg_replace('/\t(?:[\t\v\h]+)/iu', ' ', $html));
$html = trim(preg_replace('/\h(?:[\t\v\h]+)/iu', ' ', $html));
return $html;
}


# remove all cache files
function fastvelocity_rrmdir($dir) { 
	if(is_dir(rtrim($dir, '/'))) { 
		if ($handle = opendir($dir.'/')) { 
			while (false !== ($file = readdir($handle))) { 
			@unlink($dir.'/'.$file); 
			} 
		closedir($handle); } 
	} 
}




# return size in human format
function fastvelocity_format_filesize($bytes, $decimals = 2) {
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB' );
    for ($i = 0; ($bytes / 1024) > 0.9; $i++, $bytes /= 1024) {}
    return sprintf( "%1.{$decimals}f %s", round( $bytes, $decimals ), $units[$i] );
}


# get cache size and count
function fastvelocity_get_cachestats() {
clearstatcache();
$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(fvm_cachepath()['cachebase'], FilesystemIterator::SKIP_DOTS));
$size = 0; foreach ( $dir as $file ) { $size += $file->getSize(); }
return fastvelocity_format_filesize($size);
}




# minify css on demand (one file at one time, for compatibility)
function fastvelocity_min_get_css($url, $css, $disable_css_minification) {
global $wp_domain;

# remove BOM
$css = fastvelocity_min_remove_utf8_bom($css); 

# fix url paths
if(!empty($url)) { $css = preg_replace("/url\(\s*['\"]?(?!data:)(?!http)(?![\/'\"])(.+?)['\"]?\s*\)/ui", "url(".dirname($url)."/$1)", $css); } 

# remove query strings from fonts (for better seo, but add a small cache buster based on most recent updates)
$ctime = get_option('fvm-last-cache-update', '0'); # last update or zero
$css = preg_replace('/(.eot|.woff2|.woff|.ttf)+[?+](.+?)(\)|\'|\")/ui', "$1"."#".$ctime."$3", $css); # fonts cache buster

# minify CSS
if(!$disable_css_minification) { 
	$css = fastvelocity_min_minify_css_string($css); 
} else {
	$css = fvm_compat_urls($css); 
}

# cdn urls
$fvm_cdn_url = get_option('fastvelocity_min_fvm_cdn_url');
if(!empty($fvm_cdn_url)) {
	$fvm_cdn_url = trim(trim(str_ireplace(array('http://', 'https://'), '', trim($fvm_cdn_url, '/'))), '/');
	$css = str_ireplace($wp_domain, $fvm_cdn_url, $css);
}

# return html
return $css;
}



# get remote urls with curl
function fvm_file_get_contents_curl($url, $uagent=NULL) {
    $ch = curl_init();
	if(isset($uagent) && !empty($uagent)) { curl_setopt($ch,CURLOPT_USERAGENT, $uagent); }
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 10); 
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}



# download and cache css and js files
function fvm_download_and_cache($hurl, $tkey, $inline=null, $disable_minification=false, $type=null, $handle=null){
global $cachedir, $cachedirurl, $wp_domain, $wp_home, $wp_home_path;

# filters and defaults
$printurl = str_ireplace(array(site_url(), home_url(), 'http:', 'https:'), '', $hurl);
$printhandle = ''; if($handle !== null) { $printhandle = "[$handle]"; }

# try to open locally first, but skip if we are on windows
if(fvm_server_is_windows() === false) {
if (stripos($hurl, $wp_domain) !== false) { 
	# default
	$f = str_ireplace(rtrim($wp_home, '/'), rtrim($wp_home_path, '/'), $hurl);
	clearstatcache();
	if (file_exists($f)) { 
		if($type == 'js') { $code = fastvelocity_min_get_js($hurl, file_get_contents($f), $disable_minification); } 
		else { $code = fastvelocity_min_get_css($hurl, file_get_contents($f).$inline, $disable_minification); }
		set_transient($tkey, $code, 7 * DAY_IN_SECONDS );
		fvm_update_transient_keys($tkey); # keep track
		$log = "$printurl --- Debug: $printhandle File was opened from $f ---\n";
		return array('log'=>$log, 'code'=>$code);
	}
	
	# failover when home_url != site_url
	$nhurl = str_ireplace(site_url(), home_url(), $hurl);
	$f = str_ireplace(rtrim($wp_home, '/'), rtrim($wp_home_path, '/'), $nhurl);
	clearstatcache();
	if (file_exists($f)) { 
		if($type == 'js') { $code = fastvelocity_min_get_js($hurl, file_get_contents($f), $disable_minification); } 
		else { $code = fastvelocity_min_get_css($hurl, file_get_contents($f).$inline, $disable_minification); }
		set_transient($tkey, $code, 7 * DAY_IN_SECONDS );
		fvm_update_transient_keys($tkey); # keep track
		$log = "$printurl --- Debug: $printhandle File was opened from $f ---\n";
		return array('log'=>$log, 'code'=>$code);
	}
}
}


# else, fallback to remote urls (or windows)
$ttl = 3600 * 24 * 7; # 7 days
$code = fastvelocity_download($hurl, $tkey, $ttl);
if($code !== false) { 
	if($type == 'js') { $code = fastvelocity_min_get_js($hurl, $code, $disable_minification); } 
	else { $code = fastvelocity_min_get_css($hurl, $code.$inline, $disable_minification); }
	set_transient($tkey, $code, 7 * DAY_IN_SECONDS );
	fvm_update_transient_keys($tkey); # keep track
	$log = "$printurl --- Debug: $printhandle Fetched url at $hurl \n";
	return array('log'=>$log, 'code'=>$code);
}


# fallback when home_url != site_url
if(stripos($hurl, $wp_domain) !== false && home_url() != site_url()) {
	$nhurl = str_ireplace(site_url(), home_url(), $hurl);
	$code = fastvelocity_download($nhurl, $tkey, $ttl);
	if($code !== false) { 
		if($type == 'js') { $code = fastvelocity_min_get_js($hurl, $code, $disable_minification); } 
		else { $code = fastvelocity_min_get_css($hurl, $code.$inline, $disable_minification); }
		set_transient($tkey, $code, 7 * DAY_IN_SECONDS );
		fvm_update_transient_keys($tkey); # keep track
		$log = "$printurl --- Debug: $printhandle Fetched url at $hurl \n";
		return array('log'=>$log, 'code'=>$code);
	}
}


# if remote urls failed... try to open locally again, regardless of OS in use
if (stripos($hurl, $wp_domain) !== false) { 
	# default
	$f = str_ireplace(rtrim($wp_home, '/'), rtrim($wp_home_path, '/'), $hurl);
	clearstatcache();
	if (file_exists($f)) { 
		if($type == 'js') { $code = fastvelocity_min_get_js($hurl, file_get_contents($f), $disable_minification); } 
		else { $code = fastvelocity_min_get_css($hurl, file_get_contents($f).$inline, $disable_minification); }
		set_transient($tkey, $code, 7 * DAY_IN_SECONDS );
		fvm_update_transient_keys($tkey); # keep track
		$log = "$printurl --- Debug: $printhandle File was opened from $f ---\n";
		return array('log'=>$log, 'code'=>$code);
	}
	
	# failover when home_url != site_url
	$nhurl = str_ireplace(site_url(), home_url(), $hurl);
	$f = str_ireplace(rtrim($wp_home, '/'), rtrim($wp_home_path, '/'), $nhurl);
	clearstatcache();
	if (file_exists($f)) { 
		if($type == 'js') { $code = fastvelocity_min_get_js($hurl, file_get_contents($f), $disable_minification); } 
		else { $code = fastvelocity_min_get_css($hurl, file_get_contents($f).$inline, $disable_minification); }
		set_transient($tkey, $code, 7 * DAY_IN_SECONDS );
		fvm_update_transient_keys($tkey); # keep track
		$log = "$printurl --- Debug: $printhandle File was opened from $f ---\n";
		return array('log'=>$log, 'code'=>$code);
	}
}

	
# else fail
$code = false; 
$log = " - FAILED --- Debug: $printhandle Tried to fetch via wp_remote_get, curl and also to open it locally. URL: $hurl ---\n";
return array('log'=>$log, 'code'=>$code);
}



# Concatenate Google Fonts tags (http://fonts.googleapis.com/css?...)
function fastvelocity_min_concatenate_google_fonts($array) {

# extract unique font families
$families = array(); foreach ($array as $font) {

# get fonts name, type and subset, remove wp query strings
$font = explode('family=', htmlspecialchars_decode(rawurldecode(urldecode($font))));
$a = explode('&v', end($font)); $font = trim(trim(trim(current($a)), ','));

# reprocess if fonts are already concatenated in this url
if(stristr($font, '|') !== FALSE) { 
	$multiple = explode('|', $font); if (count($multiple) > 0) { foreach ($multiple as $f) { $families[] = trim($f); } }
} else { $families[] = $font; }
}

# process types, subsets, merge, etc
$fonts = array(); 
foreach ($families as $font) {
		
# if no type or subset
if(stristr($font, ':') === FALSE) { 
	$fonts[] = array('name'=>$font, 'type'=>'', 'sub'=>''); 
} else {

	# get type and subset
	$name = stristr($font, ':', true);       # font name, before :
	$ftype = trim(stristr($font, ':'), ':'); # second part of the string, after :

	# get font types and subset
	if(stristr($ftype, '&subset=') === FALSE) { 
		$fonts[] = array('name'=>$name, 'type'=>$ftype, 'sub'=>''); 
	} else { 
		$newftype = stristr($ftype, '&', true);        # font type, before &
		$subset = trim(str_ireplace('&subset=', '', stristr($ftype, '&')));     # second part of the string, after &
		$fonts[] = array('name'=>$name, 'type'=>$newftype, 'sub'=>$subset); 
	}

}
}

# make sure we have unique font names, types and subsets
$ufonts = array(); foreach ($fonts as $f) { $ufonts[$f['name']] = $f['name']; }                              # unique font names
$usubsets = array(); foreach ($fonts as $f) { if(!empty($f['sub'])) { $usubsets[$f['sub']] = $f['sub']; } }  # unique subsets

# prepare
$fonts_and_types = $ufonts;

# get unique types and subsets for each unique font name
foreach ($ufonts as $uf) {
	
	# types
	$utypes = array(); 
	foreach ($fonts as $f) {
		if($f['name'] == $uf && !empty($f['type'])) { $utypes = array_merge($utypes, explode(',', $f['type'])); }
	}
	
	# filter types
	$utypes = array_unique($utypes);
    sort($utypes);
	$ntype = ''; if(count($utypes) > 0) { $ntype = ':'.implode(',', $utypes); } # types to append to the font name
	
	# generate font url queries
	$fonts_and_types[$uf] = str_ireplace(' ', '+', $uf).$ntype;
}

# concat fonts, generate unique google fonts url
if(count($fonts_and_types) > 0) {
	$msubsets = ''; if(count($usubsets) > 0 && implode(',', $usubsets) != 'latin') { $msubsets = "&subset=".implode(',', $usubsets); } # merge subsets
	return trim('https://fonts.googleapis.com/css?family='.implode('|', $fonts_and_types).$msubsets); # process
}

return false;
}



# readme parser
function fastvelocity_min_readme($url) {

	# read file
	$file = @file_get_contents( $url );
	if (empty($file)) { return '<strong>Readme Parser: readme.txt not found!</strong>'; }
	
	// line end to \n
	$file = preg_replace("/(\n\r|\r\n|\r|\n)/", "\n", $file);

	// headlines
	$s = array('===','==','=' ); 
	$r = array('h2' ,'h3','h4');
	for ( $x = 0; $x < sizeof($s); $x++ ) { 
		$file = preg_replace('/(.*?)'.$s[$x].'(?!\")(.*?)'.$s[$x].'(.*?)/', '$1<'.$r[$x].'>$2</'.$r[$x].'>$3', $file); 
	}

	// inline
	$s = array('\*\*','\`'); 
	$r = array('b'   ,'code');
	for ( $x = 0; $x < sizeof($s); $x++ ) { 
		$file = preg_replace('/(.*?)'.$s[$x].'(?!\s)(.*?)(?!\s)'.$s[$x].'(.*?)/', '$1<'.$r[$x].'>$2</'.$r[$x].'>$3', $file); 
	}
	
	// ' _italic_ '
	$file = preg_replace('/(\s)_(\S.*?\S)_(\s|$)/', ' <em>$2</em> ', $file);
	
	// ul lists	
	$s = array('\*','\+','\-');
	for ( $x = 0; $x < sizeof($s); $x++ )
	$file = preg_replace('/^['.$s[$x].'](\s)(.*?)(\n|$)/m', '<li>$2</li>', $file);
	$file = preg_replace('/\n<li>(.*?)/', '<ul><li>$1', $file);
	$file = preg_replace('/(<\/li>)(?!<li>)/', '$1</ul>', $file);
	
	// ol lists
	$file = preg_replace('/(\d{1,2}\.)\s(.*?)(\n|$)/', '<li>$2</li>', $file);
	$file = preg_replace('/\n<li>(.*?)/', '<ol><li>$1', $file);
	$file = preg_replace('/(<\/li>)(?!(\<li\>|\<\/ul\>))/', '$1</ol>', $file);
	
	// ol screenshots style
	$file = preg_replace('/(?=Screenshots)(.*?)<ol>/', '$1<ol class="readme-parser-screenshots">', $file);
	
	// line breaks
	$file = preg_replace('/(.*?)(\n)/', "<p>$1</p>", $file);
	$file = preg_replace('/(1|2|3|4)(><br\/>)/', '$1>', $file);
	$file = str_ireplace('</ul><br/>', '</ul>', $file);
	
	# cleanup
	$file = str_ireplace('<p></p>', '', $file);
	$file = str_ireplace('<p><h4>', '<h4>', $file);
	$file = str_ireplace('</h4></p>', '</h4>', $file);
	
	// urls
	$file = str_replace('http://www.', 'www.', $file);
	$file = str_replace('www.', 'http://www.', $file);
	$file = preg_replace('#(^|[^\"=]{1})(http://|ftp://|mailto:|https://)([^\s<>]+)([\s\n<>]|$)#', '$1<a target="_blank" href="$2$3">$2$3</a>$4', $file);
	
	# extract faqs
	$prefix = "Frequently Asked Questions";
	$faq = substr($file, strpos($file, $prefix) + strlen($prefix));
	$faq = substr($faq, 0, strpos($faq, '<p><h3>'));
	
	
	return trim($faq);
}


# remove emoji support
function fastvelocity_min_disable_wp_emojicons() {
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
}

# escape double quotes
function fastvelocity_escape_double($string) {
	return str_ireplace(array('"', '\\"', '\\\"'), '\"', $string);
}


# remove UTF8 BOM
function fastvelocity_min_remove_utf8_bom($text) {
    $bom = pack('H*','EFBBBF');
    $text = preg_replace("/^$bom/ui", '', $text);
    return $text;
}


# Remove query string from static css files
function fastvelocity_remove_cssjs_ver( $src ) {
 if(stripos($src, '?ver=')) { $src = remove_query_arg('ver', $src); }
 return $src;
}


# rewrite cache files to http, https or dynamic
function fvm_get_protocol($url) {
	global $wp_domain;
	$url = ltrim(str_ireplace(array('http://', 'https://'), '', $url), '/'); # better compatibility

	# cdn support
	$fvm_cdn_url = get_option('fastvelocity_min_fvm_cdn_url');
	$defer_for_pagespeed = get_option('fastvelocity_min_defer_for_pagespeed'); 
	
	# excluded from cdn because of https://www.chromestatus.com/feature/5718547946799104 (we use document.write to preserve render blocking)
	if(!empty($fvm_cdn_url) && $defer_for_pagespeed != true) {
		$fvm_cdn_url = trim(trim(str_ireplace(array('http://', 'https://'), '', trim($fvm_cdn_url, '/'))), '/');
		$url = str_ireplace($wp_domain, $fvm_cdn_url, $url);
	}

	# enforce protocol if needed
	$fp = get_option('fastvelocity_min_default_protocol', 'dynamic'); 
	if($fp == 'http') { $url = 'http://'.$url; } elseif($fp == 'https') { $url = 'https://'.$url; } else { $url = '//'.$url; }
	
	# return
	return $url;
}

# keep track of transients, whenever we save a transient.
function fvm_update_transient_keys($new_transient_key) {
$transient_keys = get_option('fvm_transient_keys'); # get
$transient_keys[]= $new_transient_key; # append
update_option( 'fvm_transient_keys', $transient_keys); # save
}

# keep track of transients, dump our plugin transients as needed
function fvm_transients_purge() {
update_option('fvm-last-cache-update', time()); # last cache update to now
$transient_keys = get_option( 'fvm_transient_keys' ); # get
update_option( 'fvm_transient_keys', array()); # reset
foreach( $transient_keys as $t ) { delete_transient( $t ); } # delete
} 


# purge all caches
function fvm_purge_all() {



# get cache directories and urls
$cachepath = fvm_cachepath();
$tmpdir = $cachepath['tmpdir'];
$cachedir =  $cachepath['cachedir'];
$cachedirurl = $cachepath['cachedirurl'];

# delete minification files and transients
if(!is_dir($cachedir)) { return false; }
fastvelocity_rrmdir($cachedir);
fvm_transients_purge();

return true;
}



# exclude processing from some pages / posts / contents
function fastvelocity_exclude_contents() {

# ajax requests
if ( 
	(defined('DOING_AJAX') && DOING_AJAX) || (function_exists('wp_doing_ajax') && wp_doing_ajax()) || 
	(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') || 
	(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
) { return true; }

# robots.txt and xml dynamically generated sitemaps
if(isset($_SERVER['REQUEST_URI']) && (substr($_SERVER['REQUEST_URI'], -4) == '.txt' || substr($_SERVER['REQUEST_URI'], -4) == '.xml')) { return true; }

# customizer preview, visual composer
$arr = array('customize_theme', 'preview_id', 'preview');
foreach ($arr as $a) { if(isset($_GET[$a])) { return true; } }

# Thrive plugins and other post_types
$arr = array('tve_form_type', 'tve_lead_shortcode', 'tqb_splash');
foreach ($arr as $a) { if(isset($_GET['post_type']) && $_GET['post_type'] == $a) { return true; } }

# default
return false;
}

# Know files that should always be ignored
function fastvelocity_default_ignore($ignore) {
if(is_array($ignore)) {
	
	# from the database
	$exc = array_map('trim', explode("\n", get_option('fastvelocity_min_ignorelist', '')));
	
	# should we exclude jquery when defer is enabled?
	$exclude_defer_jquery = get_option('fastvelocity_min_exclude_defer_jquery');
	$enable_defer_js = get_option('fastvelocity_min_enable_defer_js');
	if($enable_defer_js == true && $exclude_defer_jquery == true) {
		$exc[] = '/jquery.js';
		$exc[] = '/jquery.min.js';
	}

	# make sure it's unique and not empty
	$uniq = array();
	foreach ($ignore as $i) { $k = hash('adler32', $i); if(!empty($i)) { $uniq[$k] = $i; } }
	foreach ($exc as $e) { $k = hash('adler32', $e); if(!empty($e)) { $uniq[$k] = $e; } }

	# merge and return
	return $uniq;
} else { return $ignore; }
}


# IE only files that should always be ignored, without incrementing our groups
function fastvelocity_ie_blacklist($url) {

	# from the database
	$exc = array_map('trim', explode("\n", get_option('fastvelocity_min_blacklist', '')));
	
	# must have
	$exc[] = '/fvm/cache/';
	
	# is the url on our list and return
	$res = fastvelocity_min_in_arrayi($url, $exc);
	if($res == true) { return true; } else { return false; }
}


# download function with cache support and fallback
function fastvelocity_download($url, $tkey, $ttl) {
	
	# rate limit requests, prevent slowdowns
	$rtlim = false; $rtlim = get_transient($tkey.'_access');
	if ( $rtlim !== false) { return false; }
	
	# info (needed for google fonts woff files + hinted fonts)
	$uagent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Safari/537.36 Edge/13.10586';
	$data = false; $data = get_transient($tkey);
	if ( $data === false) {
		
		# get updated list from our api and cache it for 24 hours
		$response = wp_remote_get($url, array('user-agent'=>$uagent, 'timeout' => 7, 'httpversion' => '1.1', 'sslverify'=>false)); 
		$res_code = wp_remote_retrieve_response_code($response);
		if($res_code == '200') { 			
			$data = wp_remote_retrieve_body($response);
			if(strlen($data) > 1 && $ttl > 0) {
				set_transient($tkey, $data, $ttl);
				fvm_update_transient_keys($tkey); # keep track
				return $data; 
			}
		}	
	
		# fallback, let's try curl if available
		if(function_exists('curl_version')) {
			$curl = fvm_file_get_contents_curl($url, $uagent);
			if(!empty($curl) && strlen($curl) > 1 && $ttl > 0) {
				set_transient($tkey, $data, $ttl);
				fvm_update_transient_keys($tkey); # keep track
				return $data;
			}
		}
		
		# error
		set_transient($tkey.'_access', "Failed to fetch: $url on ".current_time('timestamp'), $ttl);
		return false;
	}
	
	# return transient
	return $data;
}


# Purge Godaddy Managed WordPress Hosting (Varnish)
# https://github.com/wp-media/wp-rocket/blob/master/inc/3rd-party/hosting/godaddy.php
function fastvelocity_godaddy_request( $method, $url = null ) {
	$url  = empty( $url ) ? home_url() : $url;
	$host = parse_url( $url, PHP_URL_HOST );
	$url  = set_url_scheme( str_replace( $host, WPaas\Plugin::vip(), $url ), 'http' );
	wp_cache_flush();
	update_option( 'gd_system_last_cache_flush', time() ); # purge apc
	wp_remote_request( esc_url_raw( $url ), array('method' => $method, 'blocking' => false, 'headers' => array('Host' => $host)) );
}


function fastvelocity_purge_others(){
	
# wodpress default cache
if (function_exists('wp_cache_flush')) {
wp_cache_flush();
}
	
# Purge all W3 Total Cache
if (function_exists('w3tc_pgcache_flush')) {
w3tc_pgcache_flush();
return __('<div class="notice notice-info is-dismissible"><p>All caches from <strong>W3 Total Cache</strong> have also been purged.</p></div>');
}

# Purge WP Super Cache
if (function_exists('wp_cache_clear_cache')) {
wp_cache_clear_cache();
return __('<div class="notice notice-info is-dismissible"><p>All caches from <strong>WP Super Cache</strong> have also been purged.</p></div>');
}

# Purge WP Rocket
if (function_exists('rocket_clean_domain')) {
rocket_clean_domain();
return __('<div class="notice notice-info is-dismissible"><p>All caches from <strong>WP Rocket</strong> have also been purged.</p></div>');
}

# Purge Wp Fastest Cache
if(isset($GLOBALS['wp_fastest_cache']) && method_exists($GLOBALS['wp_fastest_cache'], 'deleteCache')){
$GLOBALS['wp_fastest_cache']->deleteCache();
return __('<div class="notice notice-info is-dismissible"><p>All caches from <strong>Wp Fastest Cache</strong> have also been purged.</p></div>');
}

# Purge Cachify
if (function_exists('cachify_flush_cache')) {
cachify_flush_cache();
return __('<div class="notice notice-info is-dismissible"><p>All caches from <strong>Cachify</strong> have also been purged.</p></div>');
}

# Purge Comet Cache
if ( class_exists("comet_cache") ) {
comet_cache::clear();
return __('<div class="notice notice-info is-dismissible"><p>All caches from <strong>Comet Cache</strong> have also been purged.</p></div>');
}

# Purge Zen Cache
if ( class_exists("zencache") ) {
zencache::clear();
return __('<div class="notice notice-info is-dismissible"><p>All caches from <strong>Comet Cache</strong> have also been purged.</p></div>');
}

# Purge LiteSpeed Cache 
if (class_exists('LiteSpeed_Cache_Tags')) {
LiteSpeed_Cache_Tags::add_purge_tag('*');
return __('<div class="notice notice-info is-dismissible"><p>All caches from <strong>LiteSpeed Cache</strong> have also been purged.</p></div>');
}

# Purge SG Optimizer
if (function_exists('sg_cachepress_purge_cache')) {
sg_cachepress_purge_cache();
return __('<div class="notice notice-info is-dismissible"><p>All caches from <strong>SG Optimizer</strong> have also been purged.</p></div>');
}

# Purge Godaddy Managed WordPress Hosting (Varnish + APC)
if (class_exists('WPaaS\Plugin')) {
fastvelocity_godaddy_request('BAN');
return __('<div class="notice notice-info is-dismissible"><p>All caches from <strong>WP Engine</strong> have also been purged.</p></div>');
}

# Purge WP Engine
if (class_exists("WpeCommon")) {
if (method_exists('WpeCommon', 'purge_memcached')) { WpeCommon::purge_memcached(); }
if (method_exists('WpeCommon', 'clear_maxcdn_cache')) { WpeCommon::clear_maxcdn_cache(); }
if (method_exists('WpeCommon', 'purge_varnish_cache')) { WpeCommon::purge_varnish_cache(); }
}

}
