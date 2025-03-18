<?php
	if (!defined('UPDRAFTPLUS_DIR')) die('No direct access allowed');
?>
<?php if (!class_exists('UpdraftPlus_Addons_Migrator')) : ?>
	<div class="advanced_tools search_replace">
		<p class="updraftplus-search-replace-advert">
			<h3><?php esc_html_e('Search / replace database', 'updraftplus'); ?></h3>
			<a href="<?php echo esc_url($updraftplus->get_url('premium'));?>" target="_blank">
				<em><?php esc_html_e('For the ability to migrate websites, upgrade to UpdraftPlus Premium.', 'updraftplus'); ?></em>
			</a>
		</p>
	</div>
<?php endif;
