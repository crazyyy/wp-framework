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
			
					?>
					<em>
						<?php
							/* translators: %1$s is opening <a> tag, %2$s is closing </a> tag, %3$s is the link text 'Updraftplus Premium' */
							echo wp_kses_post(sprintf(__('To %1$slock access to UpdraftPlus settings%2$s with a password, upgrade to %3$s.', 'updraftplus'), '<a href="https://teamupdraft.com/updraftplus/features/lock-updraftplus-settings/?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=lock-settings&utm_creative_format=text" target="_blank">', '</a>', '<a href="'.esc_url($updraftplus->get_url('premium')).'" target="_blank">UpdraftPlus Premium</a>').'.');
						?>
					</em>
					<?php
				}
			?>
		</p>
	</div>
<?php }
