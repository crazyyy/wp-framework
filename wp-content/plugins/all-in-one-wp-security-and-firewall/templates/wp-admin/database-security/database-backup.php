<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php esc_html_e('Manual backup', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php if (empty($install_activate_link)) { ?>
			<p>
				<?php
					$backup_link = UpdraftPlus_Options::admin_page_url().'?page=updraftplus#updraft-existing-backups-heading';
				?>
				<a href="<?php echo esc_url($backup_link); ?>" title="<?php esc_html_e('UpdraftPlus Backup/Restore', 'all-in-one-wp-security-and-firewall'); ?>" alt="<?php esc_html_e('UpdraftPlus Backup/Restore', 'all-in-one-wp-security-and-firewall'); ?>"><?php echo esc_html__('Your backups are on the UpdraftPlus Backup/Restore admin page.', 'all-in-one-wp-security-and-firewall'); ?></a>
			</p>
			<button type="button" id="aios-manual-db-backup-now" class="button-primary"><?php esc_html_e('Create database backup now', 'all-in-one-wp-security-and-firewall'); ?></button>
		<?php } else { ?>
			<p>
				<?php echo wp_kses($install_activate_link, array('a' => array('title' => array(), 'href' => array()))); ?>
			</p>
		<?php } ?>
	</div>
</div>
<div class="postbox">
	<h3 id="automated-scheduled-backups-heading" class="hndle"><label for="title"><?php esc_html_e('Automated scheduled backups', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<p>
			<?php
			if (empty($install_activate_link)) {
				$link_title = esc_html__('Automate backup in the UpdraftPlus plugin', 'all-in-one-wp-security-and-firewall');
			?>
			<?php
			echo esc_html__('The automated backup feature in All-In-One Security was removed as of version 5.0.0.', 'all-in-one-wp-security-and-firewall') . ' ' . __('For a reliable backup solution, we recommend', 'all-in-one-wp-security-and-firewall');
			?>
			<a href="https://teamupdraft.com/updraftplus/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=automated-back-up-feature-info&utm_creative_format=notice" title="<?php echo $link_title; ?>" alt="<?php echo $link_title; ?>">
			UpdraftPlus
			</a>
			<?php
			} else {
				echo wp_kses($install_activate_link, array('a' => array('title' => array(), 'href' => array())));
			}
			?>
		</p>
	</div>
</div>
