<?php if (!defined('UPDRAFTPLUS_DIR')) die('No direct access allowed'); ?>

<div class="wrap" id="updraft-wrap">

	<h1><?php echo esc_html($updraftplus->plugin_title); ?></h1>
	<div class="updraftplus-top-menu">
		<a href="<?php echo esc_url(apply_filters('updraftplus_com_link', "https://updraftplus.com/"));?>" target="_blank">UpdraftPlus.Com</a> | 
		<?php
			if (!defined('UPDRAFTPLUS_NOADS_B')) {
				?>
				<a href="<?php echo esc_url($updraftplus->get_url('premium'));?>" target="_blank"><?php esc_html_e("Premium", 'updraftplus'); ?></a> |
			<?php
			}
		?>
		<a href="<?php echo esc_url(apply_filters('updraftplus_com_link', "https://updraftplus.com/news/"));?>" target="_blank"><?php esc_html_e('News', 'updraftplus');?></a>  | 
		<a href="https://twitter.com/updraftplus" target="_blank"><?php esc_html_e('Twitter', 'updraftplus');?></a> | 
		<a href="<?php echo esc_url(apply_filters('updraftplus_com_link', "https://updraftplus.com/support/"));?>" target="_blank"><?php esc_html_e('Support', 'updraftplus');?></a> | 
		<?php
			if (!is_file(UPDRAFTPLUS_DIR.'/udaddons/updraftplus-addons.php')) {
			?>
				<a href="<?php echo esc_url(apply_filters('updraftplus_com_link', "https://updraftplus.com/newsletter-signup"));?>" target="_blank"><?php esc_html_e("Newsletter sign-up", 'updraftplus'); ?></a> |
			<?php
			}
	?>
		<a href="https://david.dw-perspective.org.uk" target="_blank"><?php esc_html_e("Lead developer's homepage", 'updraftplus');?></a> | <a aria-label="F, A, Q" href="<?php echo esc_url(apply_filters('updraftplus_com_link', "https://updraftplus.com/support/frequently-asked-questions/"));?>" target="_blank"><?php esc_html_e('FAQs', 'updraftplus'); ?></a> | <a aria-label="more plug-ins" href="https://www.simbahosting.co.uk/s3/shop/" target="_blank"><?php esc_html_e('More plugins', 'updraftplus');?></a> - <span tabindex="0"><?php esc_html_e('Version', 'updraftplus');?>: <?php echo esc_html($updraftplus->version); ?></span>
	</div>