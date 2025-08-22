<?php

if (!defined('UPDRAFTPLUS_DIR')) die('No direct access allowed');

?>
<div>
	<div class="updraftcentral_cloud_wizard_container">
		<div class="updraftcentral_cloud_wizard_image">
			<img src="<?php echo esc_attr(UPDRAFTPLUS_URL.'/images/updraftcentral_cloud.png');?>" alt="<?php esc_attr_e('UpdraftCentral Cloud', 'updraftplus');?>" width="150" height="150">
		</div>
		<div class="updraftcentral_cloud_wizard">
			<h2>UpdraftCentral - <?php esc_attr_e('Backup, update and manage all your WordPress sites from one dashboard', 'updraftplus');?></h2>
			<p>
				<?php echo esc_html(__('If you have a few sites, it\'ll save hours.', 'updraftplus').' '.__('It\'s free to use or try up to 5 sites.', 'updraftplus'));?> <a href="https://updraftplus.com/updraftcentral" target="_blank"><?php esc_html_e('Follow this link for more information', 'updraftplus'); ?></a>.
			</p>
			<p>
				<button id="btn_cloud_connect" class="btn btn-primary button-primary"><?php esc_html_e('Connect this site to UpdraftCentral Cloud', 'updraftplus');?></button>
			</p>
			<p>
				<a href="https://wordpress.org/plugins/updraftcentral/" target="_blank"><?php esc_html_e('Or if you prefer to self-host, then you can get the self-hosted version here.', 'updraftplus');?></a> <a id="self_hosted_connect" href="<?php echo esc_url(UpdraftPlus::get_current_clean_url()); ?>"><?php esc_html_e('Go here to connect it.', 'updraftplus');?></a>
			</p>
		</div>
		<div class="updraftcentral_cloud_clear"></div>
	</div>
</div>

<div id="updraftcentral_cloud_login_form" style="display:none;">
	<div>
		<h2><?php esc_html_e('Login or register for UpdraftCentral Cloud', 'updraftplus');?></h2>
		<div class="updraftcentral-subheading">
		<?php esc_html_e('Add this website to your UpdraftCentral Cloud dashboard at teamupdraft.com.', 'updraftplus');?>
		<ul style="list-style: disc inside;">
			<li><?php esc_html_e('If you already have an updraftplus.com account, then enter the details below.', 'updraftplus');?></li>
			<li><?php esc_html_e('If not, then choose your details and a new account will be registered.', 'updraftplus');?></li>
		</ul>
		</div>
	</div>
	<div class="updraftcentral_cloud_notices"></div>
		<form id="updraftcentral_cloud_redirect_form" method="POST"></form>
	<div class="updraftcentral_cloud_form_container">
		<table id="updraftcentral_cloud_form">
			<tbody>
			<tr class="non_tfa_fields">
				<td><?php esc_html_e('Email', 'updraftplus');?></td>
				<td>
					<input id="email" name="email" type="text" value="<?php echo esc_attr($email);?>" placeholder="<?php esc_attr_e('Login or register with this email address', 'updraftplus'); ?>">
				</td>
			</tr>
			<tr class="non_tfa_fields">
				<td><?php esc_html_e('Password', 'updraftplus');?></td>
				<td>
					<input id="password" name="password" type="password">
				</td>
			</tr>
			<tr class="tfa_fields" style="display:none;">
				<td colspan="2"><?php esc_html_e('One Time Password (check your OTP app to get this password)', 'updraftplus');?></td>
			</tr>
			<tr class="tfa_fields" style="display:none;">
				<td colspan="2">
					<input id="two_factor_code" name="two_factor_code" type="text">
				</td>
			</tr>
			<tr>
				<td class="non_tfa_fields"></td>
				<td class="updraftcentral_cloud_form_buttons">
					<span class="form_hidden_fields"></span>
					<div class="non_tfa_fields updraftcentral-data-consent">
						<input type="checkbox" name="i_consent" value="1">
						<label>
							<a href="https://teamupdraft.com/privacy/" target="_blank"><?php echo esc_html__('I consent to teamupdraft.com account terms and policies', 'updraftplus'); ?></a>
						</label>
					</div>
					<button id="updraftcentral_cloud_login" class="btn btn-primary button-primary"><?php esc_html_e('Connect to UpdraftCentral Cloud', 'updraftplus');?></button>
					<span class="updraftplus_spinner spinner"><?php esc_html_e('Processing', 'updraftplus');?>...</span>
					<small><span class="updraftcentral_cloud_messages"></span></small>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
</div>



