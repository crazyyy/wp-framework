<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="wrap" style="background:#fff; padding:10px">
<h1><?php _e('File Manager PRO - Shortcode','wp-file-manager'); ?>  <a href="http://filemanager.webdesi9.com/product/file-manager" class="button button-primary" target="_blank" title="Click to Buy PRO"><?php  _e('Buy PRO', 'wp-file-manager'); ?></a></h1>

<p><strong>USE: <code>[wp_file_manager_admin]</code> -> It will show file manager on front end. You can control all settings from file manager settings. It will work same as backend WP File Manager.</strong></p>

<p><strong>USE: <code>[wp_file_manager]</code> -> It will show file manager on front end. But only Administrator can access it and will control from file manager settings.</strong></p>

<p><strong>USE: <code>[wp_file_manager allowed_roles="editor,author" access_folder="wp-content/plugins" write = "true" read = "false" hide_files = "kumar,abc.php" lock_extensions=".php,.css" allowed_operations="upload,download" ban_user_ids="2,3"]</code></strong>

<p><strong>Parameters:</strong></p> 

<p><strong>(1)  allowed_roles = "*"</strong> -> It will allow all roles to access file manager on front end or You can simple use for particular user roles as like allowed_roles="editor,author" (seprated by comma(,))</p>

<p> Note: * for all userroles, default: administrator</p>
<hr />
<p><strong>(2) access_folder="test"</strong> -> Here "test" is the name of folder which is located on root directory, or you can give path for sub folders as like "wp-content/plugins". If leave blank or empty it will access all folders on root directory. Default: Root directory</p>
<hr />
<p><strong>(3) write = "true"</strong> -> for access to write files permissions, note: true/false, default: false</p>
<hr />
<p><strong>(4) read = "true"</strong> -> for access to read files permission, note: true/false, default: true</p>
<hr />
<p><strong>(5) hide_files = "wp-content/plugins,wp-config.php"</strong> -> it will hide mentioned here. Note: seprated by comma(,). Default: Null</p>
<hr />
<p><strong>(6)  lock_extensions=".php,.css"</strong>  -> It will lock mentioned in commas. you can lock more as like ".php,.css,.js" etc. Default: Null</p><hr />
<p><strong>(7) allowed_operations="*"</strong> -> * for all operations and to allow some operation you can mention operation name as like, allowed_operations="upload,download". Note: seprated by comma(,). Default: *</p> 
<hr />
<p><strong>(7.1) File Operations List:</strong> </p>
<p>(1) <code>mkdir</code> -> Make directory or folder</p>
<p>(2) <code>mkfile</code> -> Make file</p>
<p>(3) <code>rename</code> -> Rename a file or folder</p>
<p>(4) <code>duplicate</code> -> Duplicate or clone a folder or file</p>
<p>(5) <code>paste</code> -> Paste a file or folder</p>
<p>(6) <code>ban</code> -> Ban</p>
<p>(7) <code>archive</code> -> To make a archive or zip</p>
<p>(8) <code>extract</code> -> Extract archive or zipped file</p>
<p>(9) <code>copy</code> -> Copy files or folders</p>
<p>(10) <code>cut</code> -> Simple cut a file or folder</p>
<p>(11) <code>edit</code> -> Edit a file</p>
<p>(12) <code>rm</code> -> Remove or delete files and folders</p>
<p>(13) <code>download</code> -> Download files</p>
<p>(14) <code>upload</code> -> Upload files</p>
<p>(15) <code>search</code> -> Search things</p>
<p>(16) <code>info</code> -> Info of file</p>
<p>(17) <code>help</code> -> Help</p>
<hr />
<p><strong>(8) ban_user_ids="2,3"</strong> -> It will ban particular users by just putting their ids seprated by commas(,). If user is Ban then they will not able to access wp file manager on front end.</p>
</div>