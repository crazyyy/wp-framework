<?php

/**
 * Critical CSS / Above The Fold quality test template
 *
 * @since      2.9.7
 * @package    abovethefold
 * @subpackage abovethefold/admin
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

$qs_start = (strpos($url, '?') !== false) ? '&' : '?';

$critical_url = $url . $qs_start . 'critical-css-view=1&t=' . time();
$full_url = $url . $qs_start . 'full-css-view=1&t=' . time();

$output = '<!DOCTYPE html>
<html><head><title>Critical CSS Editor - Split View Quality Test - Above The Fold</title><meta name="robots" content="noindex, nofollow" /><link rel="stylesheet" href="'.WPABTF_URI.'public/css/critical-css-editor.min.css" /><link rel="stylesheet" href="'.includes_url('/css/dashicons.min.css?ver=4.9.2').'" /><style>.gutter.gutter-horizontal {background-image: url(\''.WPABTF_URI.'public/vertical-grip.png\');} .gutter.gutter-vertical {background-image: url(\''.WPABTF_URI.'public/horizontal-grip.png\');}</style><script src="'.WPABTF_URI.'public/js/critical-css-editor.min.js?t='.time().'"></script></head><body scroll="nxo" cellspacing="1" cellpadding="1"><header><div class="h"><h1>Critical CSS Editor</h1><h2>Above The Fold Optimization</h2></div><button type="button" title="Split View (horizontal)" id="btn_split_h"><span class="dashicons dashicons-image-flip-horizontal"></span></button><button type="button" title="Split View (vertical)" id="btn_split_v"><span class="dashicons dashicons-image-flip-vertical"></span></button><button type="button" title="Toggle Single View: Critical CSS vs Full CSS" id="btn_full_toggle"><span class="dashicons dashicons-admin-page"></span></button><button type="button" title="Edit Critical CSS (CodeMirror)" id="btn_editor"><span class="dashicons dashicons-editor-code"></span></button>&nbsp;&nbsp;<button type="button" title="Reload Critical CSS View"><span class="dashicons dashicons-update" id="btn_reload"></span></button><button type="button" title="Open Critical CSS View in new window (useful for responsive testing)" id="btn_open"><span class="dashicons dashicons-external"></span></button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" title="Extract Critical CSS (javascript widget based on viewport)" id="btn_extract_critical_css"><span class="dashicons dashicons-media-code"></span></button><button type="button" title="Download Full CSS (javascript widget)" id="btn_extract_full_css"><span class="dashicons dashicons-download"></span></button><div class="syncscroll"><label><input type="checkbox" value="1"> Synchronize scroll</label></div><div class="clear"></div></header><div class="split split-horizontal" style="width: calc(50% - 5px);" id="critical-css-view"><iframe src="' . $critical_url . '" name="criticalcss" frameborder="0" width="100%" height="100%"></iframe></div><div class="split split-horizontal" style="width: calc(50% - 5px);" id="full-css-view"><iframe src="' . $full_url . '" frameborder="0" width="100%" height="100%"></iframe></div><div class="split split-horizontal" style="display:none;" id="css-editor-view"><textarea id="abtfcss" placeholder="Loading Critical CSS..." disabled></textarea></div></body></html>';
