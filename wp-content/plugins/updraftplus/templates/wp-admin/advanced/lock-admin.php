<?php

if (!defined('UPDRAFTPLUS_DIR')) die('No direct access allowed');

if (!class_exists('UpdraftPlus_Addon_LockAdmin') || (defined('UPDRAFTPLUS_NOADMINLOCK') && UPDRAFTPLUS_NOADMINLOCK)) { ?>
	<div class="advanced_tools lock_admin">
		<p class="updraftplus-lock-advert">
			<h3><?php esc_html_e('Lock access to the UpdraftPlus settings page', 'updraftplus'); ?></h3>
			
			<?php
			
				if (defined('UPDRAFTPLUS_NOADMINLOCK') && UPDRAFTPLUS_NOADMINLOCK) {
				
					esc_html_e('This functionality has been disabled by the site administrator.', 'updraftplus');
					
				} else {
			
					?><a href="<?php echo esc_url($updraftplus->get_url('premium'));?>" target="_blank">
						<em><?php esc_html_e('For the ability to lock access to UpdraftPlus settings with a password, upgrade to UpdraftPlus Premium.', 'updraftplus'); ?></em>
					</a><?php
			
				}
			?>
		</p>
	</div>
<?php }
