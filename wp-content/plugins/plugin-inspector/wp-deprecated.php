<?php
/*
 *  List of deprecated functions of WP
 *
 */
function pc_get_wp_depricated(){
    global $wp_version;
    $ret = get_option('wp-deprecated');
    if (isset($ret['version']) && $ret['version'] == $wp_version) return $ret['list'];
    $files = array(
        'wp-includes/deprecated.php',
        'wp-admin/includes/deprecated.php',
        'wp-includes/pluggable-deprecated.php',
        'wp-includes/ms-deprecated.php',
        'wp-admin/includes/ms-deprecated.php');
    $ignore = array('__construct','__call','__get','__set','_deprecated_function'); // ignore these definitions
    $list=array();
    foreach ($files as $file) {
        $lines = file(get_home_path().$file);
        $source = @file_get_contents(get_home_path().$file);
        $tokens = token_get_all($source);
        $is_func = false; // flajok
        foreach ($tokens as $token) {
            if ($token[0] == T_FUNCTION){
                $is_func = true; // this is a start of function declaration
                continue;
            }
            elseif ($token[0] == T_STRING && $is_func){
                if (in_array($token[1],$ignore)) continue;

                $comments = array();
                $i = 2; // line above definition
                while (true) {
                    $line_num = $token[2]-$i;
                    $line = $lines[$line_num];
                    if ($pos = strpos($line,'@deprecated')) $comments[]=substr($line,$pos + 1);
                    if (false !== strpos($line,'/*')) break;
                    if ($i > 30 || $line_num <= 0) break;
                    $i++;
                }
                if (empty($comments)) continue; // no comments above function = not deprecated
                //echo '<p>'.$token[1].'='.$token[2].'='.$file;
                $list[$token[1]]=implode(' / ',$comments);
                $is_func = false; // reset it!
            }
        }
    }
    $ret = array('version'=>$wp_version,'list'=>$list);
    update_option('wp-deprecated',$ret);
    return $list;
}