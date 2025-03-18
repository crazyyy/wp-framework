<?php
if (!defined('UPDRAFTPLUS_DIR')) {
	die('No direct access allowed');
}
?>
<div tabindex="0" class="advanced_tools_button active" id="site_info">
	<span class="advanced_tools_text dashicons dashicons-info"></span>
	<?php esc_html_e('Site information', 'updraftplus'); ?>
</div>
<div tabindex="0" class="advanced_tools_button" id="lock_admin">
	<span class="advanced_tools_text dashicons dashicons-lock"></span>
	<?php esc_html_e('Lock settings', 'updraftplus'); ?>
</div>
<div tabindex="0" class="advanced_tools_button" id="updraft_central">
	<span class="advanced_tools_text dashicons dashicons-networking"></span>
	UpdraftCentral
</div>
<div tabindex="0" class="advanced_tools_button" id="search_replace">
	<span class="advanced_tools_text dashicons dashicons-search"></span>
	<?php esc_html_e('Search / replace database', 'updraftplus'); ?>
</div>
<div tabindex="0" class="advanced_tools_button" id="total_size">
	<span class="advanced_tools_text dashicons dashicons-performance"></span>
	<?php esc_html_e('Site size', 'updraftplus'); ?>
</div>
<div tabindex="0" class="advanced_tools_button" id="db_size">
	<span class="advanced_tools_text dashicons dashicons-database-view"></span>
	<?php esc_html_e('Database size', 'updraftplus'); ?>
</div>
<div tabindex="0" class="advanced_tools_button" id="cron_events">
	<span class="advanced_tools_text dashicons dashicons-list-view"></span>
	<?php esc_html_e('Cron events', 'updraftplus'); ?>
</div>
<div tabindex="0" class="advanced_tools_button" id="export_settings">
	<span class="advanced_tools_text dashicons dashicons-media-default"></span>
	<?php esc_html_e('Export / import settings', 'updraftplus'); ?>
</div>
<div tabindex="0" class="advanced_tools_button" id="wipe_settings">
	<span class="advanced_tools_text dashicons dashicons-trash"></span>
	<?php esc_html_e('Wipe settings', 'updraftplus'); ?>
</div>