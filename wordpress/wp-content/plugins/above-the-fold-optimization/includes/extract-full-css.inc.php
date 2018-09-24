<?php

/**
 * Extract Full CSS template
 *
 * @since      2.3.5
 * @package    abovethefold
 * @subpackage abovethefold/admin
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

$output = '<!DOCTYPE html>
<html>
<head>
<title>Full CSS extraction</title>
<meta name="robots" content="noindex, nofollow" />
<link rel="stylesheet" href="'.WPABTF_URI.'public/css/extractfull.min.css" />
</head>
<body rel="'.$url.'?extract-css='.$extractkey.'&output=download&files=">
<h1>Full CSS Extraction</h1>
<div style="border:solid 1px #f1b70a;background-color:#ffffee;padding:5px;font-size:11px;">Url: <a href="'.$url.'" target="_blank" style="color:black;">'.$url.'</a></div>
<br />
';

foreach ($cssfiles as $file) {
    if ($file['inline']) {
        $output .= '<textarea style="display:none;" id="inline'.$file['src'].'_display">'.htmlentities(htmlentities($file['code']), ENT_COMPAT, 'utf-8').'</textarea>
<textarea style="display:none;" id="code'.md5($file['code']).'" title="' . $file['src'] . '" data-size="'.strlen($file['inlinecode']).'">'.htmlentities($file['inlinecode'], ENT_COMPAT, 'utf-8').'</textarea><label style="display:block;border-bottom:solid 1px #efefef;padding-bottom:5px;margin-bottom:5px;" title="'.htmlentities(substr(preg_replace(array('|\n+|is','|\s+|is'), array(' ',' '), $file['inlinecode']), 0, 300), ENT_COMPAT, 'utf-8').'..."><input type="checkbox" name="cssc" value="'.md5($file['code']).'" checked="true"> Inline <a href="javascript:void(0);" class="showinline" data-id="inline'.$file['src'].'_display" style="cursor:help;">'.htmlentities(substr(preg_replace(array('|\n+|is','|\s+|is'), array(' ',' '), $file['inlinecode']), 0, 100), ENT_COMPAT, 'utf-8').'...</a> ('.human_filesize(strlen($file['inlinecode']), 2).') - Media: '.implode(', ', $file['media']).'</label>';
    } else {
        $output .= '<textarea style="display:none;" id="code'.md5($file['src']).'" title="'.$file['src'].'" data-size="'.strlen($file['code']).'">'.htmlentities($file['code'], ENT_COMPAT, 'utf-8').'</textarea>
<label style="display:block;border-bottom:solid 1px #efefef;padding-bottom:5px;margin-bottom:5px;"><input type="checkbox" name="cssc" value="'.md5($file['src']).'" checked="true"> <a href="'.$file['src'].'" target="_blank">'.$file['src'].'</a> ('.human_filesize(strlen($file['code']), 2).') - Media: '.implode(', ', $file['media']).'</label>';
    }
}

$output .= '
<br /><fieldset><legend>Full CSS (<span id="fullcsssize">&hellip;</span>)</legend>
<textarea style="width:100%;height:300px;" id="fullcss"></textarea>
<div style="padding:10px;text-align:left;font-size:20px;line-height:24px;">
<a href="'.$url.'?extract-css='.$extractkey.'&amp;output=download" class="cssdownload">Download</a> <span class="cssdownloadcount"></span>
| <a href="https://www.google.com/search?q=beautify+css+online" target="_blank">Beautify</a>
| <a href="https://www.google.com/search?q=minify+css+online" target="_blank">Minify</a>
| <a href="https://jigsaw.w3.org/css-validator/#validate_by_input+with_options" target="_blank">Validate</a>
| <a href="http://csslint.net/#utm_source=wordpress&amp;utm_medium=plugin&amp;utm_term=optimization&amp;utm_campaign=PageSpeed.pro%3A%20Above%20The%20Fold%20Optimization" target="_blank">CSS<span style="color:#768c1c;font-weight:bold;margin-left:2px;">LINT</span></a>

</div></fieldset>
<script src="'.WPABTF_URI.'public/js/extractfull.min.js"></script>
</body>
</html>';
