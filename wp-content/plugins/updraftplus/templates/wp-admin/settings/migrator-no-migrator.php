<?php if (!defined('ABSPATH')) die('No direct access.'); ?>

<div id="updraft_migrate_tab_main">
	<?php $updraftplus_admin->include_template('wp-admin/settings/temporary-clone.php'); ?>

	<h2><?php esc_html_e('Migrate (create a copy of a site on hosting you control)', 'updraftplus'); ?></h2>
	<div id="updraft_migrate" class="postbox">
		<p>
			<?php echo esc_html(__('UpdraftPlus Premium can perform a direct site-to-site migration.', 'updraftplus').' '.__('After using it once, you\'ll have saved the purchase price compared to the time needed to copy a site by hand.', 'updraftplus')); ?>
		</p>

		<p>
			<a href="<?php echo esc_url(apply_filters('updraftplus_com_link', "https://teamupdraft.com/updraftplus/wordpress-migration-plugin/?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=do-you-want-to-migrate&utm_creative_format=text"));?>" target="_blank"><?php esc_html_e('More information here.', 'updraftplus'); ?></a>
		</p>
	</div>

</div>
