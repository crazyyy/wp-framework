<?php
	if (!defined('UPDRAFTPLUS_DIR')) die('No direct access allowed');
?>
<?php if (!class_exists('UpdraftPlus_Addons_Migrator')) : ?>
	<div class="advanced_tools search_replace">
		<p class="updraftplus-search-replace-advert">
			<h3><?php esc_html_e('Search / replace database', 'updraftplus'); ?></h3>
			<em><?php echo wp_kses_post(sprintf(__('For direct site-to-site migration, get %s.', 'updraftplus'), '<a href="'.esc_url($updraftplus->get_url('premium')).'" target="_blank">UpdraftPlus Premium</a>')); ?></em>
		</p>
	</div>
<?php endif;
