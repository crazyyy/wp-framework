<?php
defined('ABSPATH') or die("you do not have acces to this page!");


add_filter('cmplz_known_iframe_tags', 'cmplz_dailymotion_iframetags');
function cmplz_dailymotion_iframetags($tags){
    $tags[] = 'dailymotion.com/embed/video/';

    return $tags;
}


function cmplz_dailymotion_placeholder($new_src, $src){
    if (preg_match('/dailymotion\.com\/(embed\/video)\/([^_]+)[^#]*\?|dailymotion\.com\/(embed\/video|video|hub)\/([^_]+)[^#]*(#video=([^_&]+))?|(dai\.ly\/([^_]+))!/i', $src, $matches)) {
        if (isset($matches[6])) {
            $daily_motion_id = $matches[6];
        }elseif (isset($matches[4])) {
            $daily_motion_id = $matches[4];
        }else{
            $daily_motion_id = $matches[2];
        }
        $new_src = get_transient("cmplz_dailymotion_image_$daily_motion_id");
        if (!$new_src || !file_exists($new_src)) {
            $thumbnail_large_url='https://api.dailymotion.com/video/'.$daily_motion_id.'?fields=thumbnail_1080_url'; //pass thumbnail_large_url, thumbnail_medium_url, thumbnail_small_url for different sizes
            $json_thumbnail = file_get_contents($thumbnail_large_url);
            $arr_dailymotion = json_decode($json_thumbnail, TRUE);
            $new_src = $arr_dailymotion['thumbnail_1080_url'];
            $new_src = cmplz_download_to_site($new_src, 'dailymotion'.$daily_motion_id);
            set_transient("cmplz_dailymotion_image_$daily_motion_id", $new_src, WEEK_IN_SECONDS);
        }
    }
    return $new_src;
}
add_filter('cmplz_placeholder_dailymotion', 'cmplz_dailymotion_placeholder', 10, 2);