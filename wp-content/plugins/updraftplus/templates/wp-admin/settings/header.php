<?php if (!defined('UPDRAFTPLUS_DIR')) die('No direct access allowed'); ?>

<div class="wrap" id="updraft-wrap">

	<h1><?php echo esc_html($updraftplus->plugin_title); ?></h1>
	<div class="updraftplus-top-menu">
		<a href="<?php echo esc_url(apply_filters('updraftplus_com_link', "https://teamupdraft.com?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=teamupdraft&utm_creative_format=menu"));?>" target="_blank">TeamUpdraft</a> | 
		<?php
			if (!defined('UPDRAFTPLUS_NOADS_B')) {
				?>
				<a href="<?php echo esc_url($updraftplus->get_url('premium'));?>" target="_blank"><?php esc_html_e("Premium", 'updraftplus'); ?></a> |
			<?php
			}
		?>
		<a href="<?php echo esc_url(apply_filters('updraftplus_com_link', "https://teamupdraft.com/topic/updraftplus?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=blog&utm_creative_format=menu"));?>" target="_blank"><?php esc_html_e('Blogs', 'updraftplus');?></a>  | 
		<a href="https://x.com/TeamUpdraftWP" target="_blank"><?php esc_html_e('Twitter / X', 'updraftplus');?></a> | 
		<a href="<?php echo esc_url(apply_filters('updraftplus_com_link', "https://teamupdraft.com/support?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=support&utm_creative_format=menu"));?>" target="_blank"><?php esc_html_e('Support', 'updraftplus');?></a> | 
		<?php
			if (!is_file(UPDRAFTPLUS_DIR.'/udaddons/updraftplus-addons.php')) {
			?>
				<a href="<?php echo esc_url(apply_filters('updraftplus_com_link', "https://teamupdraft.com/newsletter-signup?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=unknown&utm_creative_format=unknown"));?>" target="_blank"><?php esc_html_e("Newsletter sign-up", 'updraftplus'); ?></a> |
			<?php
			}
	?>
		<a href="https://david.dw-perspective.org.uk" target="_blank"><?php esc_html_e("Lead developer's homepage", 'updraftplus');?></a> | <a aria-label="F, A, Q" href="<?php echo esc_url(apply_filters('updraftplus_com_link', "https://teamupdraft.com/documentation/updraftplus?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=documentation&utm_creative_format=menu"));?>" target="_blank"><?php esc_html_e('Documentation', 'updraftplus'); ?></a> | <a aria-label="more plug-ins" href="https://www.simbahosting.co.uk/s3/shop/" target="_blank"><?php esc_html_e('More plugins', 'updraftplus');?></a> - <span tabindex="0"><?php esc_html_e('Version', 'updraftplus');?>: <?php echo esc_html($updraftplus->version); ?></span>
	</div>