<?php if (!defined('ABSPATH')) { exit; }
$this->custom_css();
if (isset($_POST['submit']) && wp_verify_nonce($_POST['wp_filemanager_root_nonce_field'], 'wp_filemanager_root_action')) {
    $save = update_option('wp_file_manager_settings', 
		array(
			'public_path' => isset($_POST['public_path']) ? htmlentities($_POST['public_path']) : '',
			'fm_syntax_checker' => isset($_POST['fm_syntax_checker']) ? htmlentities($_POST['fm_syntax_checker']) : '',
			'fm_enable_trash' => isset($_POST['fm_enable_trash']) ? htmlentities($_POST['fm_enable_trash']) : ''
			)
		);
    if ($save) {
        echo '<script>';
        echo 'window.location.href="?page=wp_file_manager_root&status=1"';
        echo '</script>';
    } else {
        echo '<script>';
        echo 'window.location.href="?page=wp_file_manager_root&status=2"';
        echo '</script>';
    }
}
$settings = get_option('wp_file_manager_settings'); ?>
<div class="wrap fm_rootWrap">
<h3 class="fm_headingTitle"><?php _e('Settings - Root Directory', 'wp-file-manager'); ?></h3>
<?php $path = str_replace('\\', '/', ABSPATH); ?>
<div class="fm_whiteBg">
<form action="" method="post">
<?php wp_nonce_field('wp_filemanager_root_action', 'wp_filemanager_root_nonce_field'); ?>
<table class="form-table">
<tr>
<th><?php _e('Public Root Path', 'wp-file-manager'); ?></th>
<td>
<input name="public_path" type="text" id="public_path" value="<?php echo isset($settings['public_path']) && !empty($settings['public_path']) ? $settings['public_path'] : $path; ?>" class="regular-text">
<p class="description mb15"><?php _e('File Manager Root Path, you can change according to your choice.', 'wp-file-manager'); ?></p>
<p>Default: <code><?php echo $path; ?></code></p>
<p style="color:#F00" class="description mb15"><?php _e('Please change this carefully, Wrong path can lead file manager plugin to go down.', 'file-manager-advanced'); ?></p>
</td>
</tr>
<tr>
<th><?php _e('Enable Syntax Checker?', 'wp-file-manager'); ?></th>
<td>
<input name="fm_syntax_checker" type="checkbox" id="fm_syntax_checker" value="1" class="regular-text" <?php echo (isset($settings['fm_syntax_checker']) && !empty($settings['fm_syntax_checker']) && $settings['fm_syntax_checker'] == 1) ? 'checked="checked"' : ''; ?>>
<p class="description mb15" style="color:#F00"><?php _e('When the Syntax Checker is enabled, the code updates being made to PHP files will be checked for syntax errors. If a syntax error is found, the updates will not be saved and a message box will appear which will define the error found. This checker will help prevent website downtime issues due to syntax errors.', 'wp-file-manager'); ?>
</p>
</td>
</tr>
<tr>
<th><?php _e('Enable Trash?', 'wp-file-manager'); ?></th>
<td>
<input name="fm_enable_trash" type="checkbox" id="fm_enable_trash" value="1" class="regular-text" <?php echo (isset($settings['fm_enable_trash']) && !empty($settings['fm_enable_trash']) && $settings['fm_enable_trash'] == 1) ? 'checked="checked"' : ''; ?>>
<p class="description mb15"><?php _e('After enable trash, your files will go to trash folder.', 'wp-file-manager'); ?>
</p>
</td>
</tr>
</table>
<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
</form>
</div>
</div>