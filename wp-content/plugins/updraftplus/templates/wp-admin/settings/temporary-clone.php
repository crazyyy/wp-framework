<?php

if (!defined('ABSPATH')) die('No direct access.');

// N.B. This just turns off the UI. It's still there internally (e.g. AJAX commands)
if (defined('UPDRAFTPLUS_TEMPORARY_CLONE') && !UPDRAFTPLUS_TEMPORARY_CLONE) return;

UpdraftPlus::load_checkout_embed();

global $updraftplus_checkout_embed, $updraftplus;
$checkout_url = $updraftplus->get_url('buy_clone_tokens');
$checkout_clone_token_attributes = 'href="'.esc_url($checkout_url).'" target="_blank"';
?>

<h2><?php esc_html_e('Create a temporary clone on our servers (UpdraftClone)', 'updraftplus'); ?></h2>

<div class="postbox updraftplus-clone">

	<div class="updraft_migrate_widget_module_content">
		<header>
			<h3><span class="dashicons dashicons-admin-page"></span>UpdraftClone</h3>
			<button class="button button-link updraft_migrate_widget_temporary_clone_show_stage0"><span class="dashicons dashicons-info"></span></button>
		</header>
		<div class="updraft_migrate_widget_temporary_clone_stage0">
			<p>
				<?php
				echo esc_html(__('A temporary clone is an instant copy of this website, running on our servers.', 'updraftplus').' '.__('Rather than test things on your live site, you can UpdraftClone it, and then throw away your clone when done.', 'updraftplus')).' <a target="_blank" href="https://teamupdraft.com/updraftplus/updraftclone?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=find-out-about-updraftclone&utm_creative_format=text">'.esc_html(__('Find out more here.', 'updraftplus')).'</a> <a target="_blank" href="https://teamupdraft.com/documentation/updraftplus/topics/updraftclone/faqs?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=updraftclone-faqs&utm_creative_format=text">'.esc_html__('Read FAQs here.', 'updraftplus').'</a> <a '.wp_kses($checkout_clone_token_attributes, array()).'>'.esc_html(__("You can buy UpdraftClone tokens from our shop, here.", 'updraftplus')).'</a>';
				?>
			</p>
			<div class="updraft_migrate_widget_temporary_clone_stage0_container">
				<div class="updraft_migrate_widget_temporary_clone_stage0_box">
					<ul style="list-style: disc inside;">
						<li><strong><?php echo esc_html__('Easy', 'updraftplus'); ?>:</strong> <?php esc_html_e(__('Press the buttons...', 'updraftplus').' '.__('UpdraftClone does the work.', 'updraftplus')); ?></li>
						<li><strong><?php esc_html_e('Reliable', 'updraftplus'); ?>:</strong> <?php esc_html_e('Runs on capacity from a leading cloud computing provider.', 'updraftplus'); ?></li>
						<li><strong><?php esc_html_e('Secure', 'updraftplus'); ?>:</strong> <?php esc_html_e('One VPS (Virtual Private Server) per clone, shared with nobody.', 'updraftplus'); ?></li>
						<li><strong><?php esc_html_e('Fast', 'updraftplus'); ?>:</strong> <?php esc_html_e('Takes just the time needed to create a backup and send it.', 'updraftplus'); ?></li>
						<li><strong><?php esc_html_e('Flexible', 'updraftplus'); ?>:</strong> <?php esc_html_e('If you want, test upgrading to a different PHP or WP version.', 'updraftplus'); ?></li>
					</ul>
					<?php if (is_multisite() && is_subdomain_install()) { ?>
						<p><?php echo '<a target="_blank" href="https://updraftplus.com/faqs/how-do-i-migrate-to-a-new-site-location/">' . esc_html(__('Temporary clones of WordPress subdomain multisite installations are not yet supported.', 'updraftplus').' '.__('See our documentation on how to carry out a normal migration here', 'updraftplus')) . '.</a>'; ?></p>
					<?php
					} else {
					?>
						<button class="button button-primary button-hero updraftclone_show_step_1"><span class="dashicons dashicons-admin-page"></span><?php esc_html_e("Create a temporary clone on our servers (UpdraftClone)", "updraftplus"); ?></button>
						<p>
							<small><?php echo esc_html(__("To create a temporary clone you need credit in your account.", "updraftplus")); ?> <a <?php echo wp_kses($checkout_clone_token_attributes, array()); ?>><?php esc_html_e("You can buy UpdraftClone tokens from our shop, here.", "updraftplus"); ?></a></small>
						</p>
					<?php
					}
					?>
				</div>
			</div>
		</div>
		<div class="updraft_migrate_widget_temporary_clone_stage1" style="display: none;">
			<p>
				<?php echo wp_kses_post(sprintf(__('To clone your site, you need %s.', 'updraftplus'), '<a '.$checkout_clone_token_attributes.'>UpdraftClone tokens</a>').' '.__('Once you have them, return here to connect to your account.', 'updraftplus')); ?></a>
			</p>
			<?php $updraftplus_admin->build_credentials_form('temporary_clone', true, false, array('terms_and_conditions' => __('I accept the UpdraftClone terms and conditions', 'updraftplus'), 'terms_and_conditions_link' => 'https://teamupdraft.com/terms-and-conditions?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=i-accept-updraftclone-terms&utm_creative_format=checkbox')); ?>
			<h2> <?php esc_html_e('Or, use an UpdraftClone key', 'updraftplus'); ?></h2>
			<p class="updraftplus_com_key_status"></p>
			<div class="updraftplus_com_key">
				<table class="form-table">
					<tbody>
						<tr>
							<th><?php esc_html_e('Key', 'updraftplus'); ?></th>
							<td>
								<label for="temporary_clone_options_key">
									<input id="temporary_clone_options_key" type="text" size="36" name="temporary_clone_options[key]" value="" tabindex="1" />
									<br/>
									<a target="_blank" href="https://teamupdraft.com/documentation/updraftplus/topics/updraftclone/faqs/how-do-i-use-updraftclone-keys?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=more-about-clone-tokens&utm_creative_format=text"><?php esc_html_e('You can find out more about UpdraftClone keys here.', 'updraftplus'); ?></a>
								</label>
							</td>
						</tr>
						<tr>
							<th></th>
							<td>
								<input type="checkbox" class="temporary_clone_terms_and_conditions" name="temporary_clone_terms_and_conditions" value="1" tabindex="1">
								<a target="_blank" href="https://teamupdraft.com/terms-and-conditions?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=i-accept-updraftclone-terms&utm_creative_format=checkbox"><?php esc_html_e('I accept the UpdraftClone terms and conditions', 'updraftplus'); ?></a>
							</td>
						</tr>
					</tbody>
				</table>
				<p class="updraft-after-form-table">
					<button class="button-primary ud_key_connectsubmit" tabindex="1"><?php esc_html_e('Connect', 'updraftplus'); ?></button>
					<span class="updraftplus_spinner spinner"><?php esc_html_e('Processing', 'updraftplus'); ?>...</span></p>
				</p>
			</div>
		</div>
		<div class="updraft_migrate_widget_temporary_clone_stage2" style="display: none;"></div>
		<div class="updraft_migrate_widget_temporary_clone_stage3" style="display: none;"></div>
	</div>
</div>
