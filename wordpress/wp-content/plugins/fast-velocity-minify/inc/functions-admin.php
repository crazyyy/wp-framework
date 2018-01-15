<?php

/*
in development...
*/

# add admin toolbar
add_action( 'admin_bar_menu', 'fastvelocity_add_toolbar', 100 );


# admin toolbar processing
function fastvelocity_add_toolbar() {
if(current_user_can('manage_options')) {
global $wp_admin_bar;

# get cache size
$stats = fastvelocity_get_cachestats();
$count = $stats['count'];
$size = $stats['size'];

# Create or add new items into the Admin Toolbar.
$wp_admin_bar->add_node( array(
    'id'    => 'fvm',
    'title' => '<span class="ab-icon"></span><span class="ab-label">' . __("Fast Velocity",'fvm') . '</span>',
    'href'  => admin_url( 'options-general.php?page=fastvelocity-min' ),
    'meta'  => array( 'class' => 'bullet-green')
));

# Cache Info node
$wp_admin_bar->add_node( array(
    'id'    => 'fvm-cache-info',
    'title' => '<p class="bold">' . __( "Cache Info", 'fvm' ) . '</p>' .
    '<table>' .
    '<tr><td>' . __( "Size", 'fvm' ) . ':</td><td class="size green">' . $size . '</td></tr>' .
    '<tr><td>' . __( "Files", 'fvm' ) . ':</td><td class="files white">' . $count . '</td></tr>' .
    '</table>',
    'parent'=> 'fvm'
));

# Delete Cache node
$wp_admin_bar->add_node( array(
    'id'    => 'fvm-delete-cache',
    'title' => __("Purge Cache",'fvm'),
    'parent'=> 'fvm'
));

}
}


/*
# get cache size and count
function fastvelocity_get_cachestats() {
	
# info
$cachepath = fvm_cachepath();
$tmpdir = $cachepath['tmpdir'];
$cachedir =  $cachepath['cachedir'];
$search = array($tmpdir, $cachedir);
$size = 0;
$count = 0;

foreach ($search as $dir) {
if(is_dir(rtrim($dir, '/'))) {
	if ($handle = opendir($dir.'/')) {
	while (false !== ($file = readdir($handle))) { $f = $dir.'/'.$file; $size = $size + filesize($f); $count++;	} 
	closedir($handle);
	}
} 
}

return array('size'=>fastvelocity_format_filesize($size), 'count'=>$count);
}
*(

