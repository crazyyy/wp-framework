<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Manual backup', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php if (empty($install_activate_link)) { ?>
			<p>
				<?php
					$backup_link = UpdraftPlus_Options::admin_page_url().'?page=updraftplus#updraft-existing-backups-heading';
				?>
				<a href="<?php echo $backup_link; ?>" title="<?php _e('UpdraftPlus Backup/Restore', 'all-in-one-wp-security-and-firewall'); ?>" alt="<?php _e('UpdraftPlus Backup/Restore', 'all-in-one-wp-security-and-firewall'); ?>"><?php echo __('Your backups are on the UpdraftPlus Backup/Restore admin page.', 'all-in-one-wp-security-and-firewall'); ?></a>
			</p>
			<button type="button" id="aios-manual-db-backup-now" class="button-primary"><?php _e('Create database backup now', 'all-in-one-wp-security-and-firewall'); ?></button>
		<?php } else { ?>
			<p>
				<?php echo wp_kses($install_activate_link, array('a' => array('title' => array(), 'href' => array()))); ?>
			</p>
		<?php } ?>
	</div>
</div>
<div class="postbox">
	<h3 id="automated-scheduled-backups-heading" class="hndle"><label for="title"><?php _e('Automated scheduled backups', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<p>
			<?php
			if (empty($install_activate_link)) {
				$link_title = __('Automate backup in the UpdraftPlus plugin', 'all-in-one-wp-security-and-firewall');
			?>
			<a href="<?php echo add_query_arg(
				array(
					'page' => 'updraftplus',
					'tab'  => 'settings',
				),
				UpdraftPlus_Options::admin_page_url()
			);
			?>" title="<?php echo $link_title; ?>" alt="<?php echo $link_title; ?>">
			<?php
			echo __('The AIOS 5.0.0 version release has removed the automated backup feature.', 'all-in-one-wp-security-and-firewall') . ' ' . __('The AIOS automated backup had issues that made it less robust than we could be happy with.', 'all-in-one-wp-security-and-firewall') . ' ' . __('Follow this link to automate backups in the superior UpdraftPlus backup plugin.', 'all-in-one-wp-security-and-firewall');
			?>
			</a>
			<?php
			} else {
				echo wp_kses($install_activate_link, array('a' => array('title' => array(), 'href' => array())));
			}
			?>
		</p>
	</div>
</div>
