<?php

if (!defined('UPDRAFTPLUS_DIR')) die('No direct access allowed.');

updraft_try_include_file('methods/s3.php', 'require_once');

/**
 * Converted to multi-options (Feb 2017-) and previous options conversion removed: Yes
 */
class UpdraftPlus_BackupModule_dreamobjects extends UpdraftPlus_BackupModule_s3 {

	protected $provider_can_use_aws_sdk = false;
	
	protected $provider_has_regions = true;

	/**
	 * Regex for validating custom endpoint in the format `s3.<region>.dream.io`.
	 *
	 * @var string
	 */
	const ENDPOINT_REGEX = '^s3\.[0-9a-z_-]+\.dream\.io$';

	/**
	 * Class constructor
	 */
	public function __construct() {
		add_action('updraftplus_admin_enqueue_scripts', array($this, 'updraftplus_admin_enqueue_scripts'));
	}

	/**
	 * Enqueue scripts on UpdraftPlus settings page.
	 *
	 * @return void
	 */
	public function updraftplus_admin_enqueue_scripts() {
		global $updraftplus;
		$updraftplus->enqueue_select2();
	}

	/**
	 * Returns endpoint options.
	 *
	 * @return array
	 */
	public static function get_endpoints() {
		// When new endpoint introduced in future, Please add it here and also add it as hard coded option for endpoint dropdown in self::get_partial_configuration_template_for_endpoint()
		// Put the default first
		return array(
			// Endpoint, then the label
			's3.us-east-005.dream.io'    => 's3.us-east-005.dream.io',
			'objects-us-east-1.dream.io' => 'objects-us-east-1.dream.io',
			'objects-us-west-1.dream.io' => 'objects-us-west-1.dream.io ('.__('Closing 1st October 2018', 'updraftplus').')',
		);
	}
	
	protected $use_v4 = false;

	/**
	 * Given an S3 object, possibly set the region on it
	 *
	 * @param Object $obj		  - like UpdraftPlus_S3
	 * @param String $region	  - or empty to fetch one from saved configuration
	 * @param String $bucket_name
	 */
	protected function set_region($obj, $region = '', $bucket_name = '') {// phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable -- $bucket_name

		$config = $this->get_config();
		$endpoint = ('' != $region && 'n/a' != $region) ? $region : $config['endpoint'];
		global $updraftplus;
		if ($updraftplus->backup_time) {
			$updraftplus->log("Set endpoint (".get_class($obj)."): $endpoint");
		
			// Warning for objects-us-west-1 shutdown in Oct 2018
			if ('objects-us-west-1.dream.io' == $endpoint) {
				$updraftplus->log("The objects-us-west-1.dream.io endpoint shut down on the 1st October 2018. The upload is expected to fail. Please see the following article for more information https://help.dreamhost.com/hc/en-us/articles/360002135871-Cluster-migration-procedure", 'warning', 'dreamobjects_west_shutdown');
			}
		}
		
		$obj->setEndpoint($endpoint);
	}

	/**
	 * This method overrides the parent method and lists the supported features of this remote storage option.
	 *
	 * @return Array - an array of supported features (any features not mentioned are asuumed to not be supported)
	 */
	public function get_supported_features() {
		// This options format is handled via only accessing options via $this->get_options()
		return array('multi_options', 'config_templates', 'multi_storage', 'conditional_logic');
	}

	/**
	 * Retrieve default options for this remote storage module.
	 *
	 * @return Array - an array of options
	 */
	public function get_default_options() {
		return array(
			'accesskey' => '',
			'secretkey' => '',
			'path' => '',
		);
	}

	/**
	 * Retrieve specific options for this remote storage module
	 *
	 * @param Boolean $force_refresh - if set, and if relevant, don't use cached credentials, but get them afresh
	 *
	 * @return Array - an array of options
	 */
	protected function get_config($force_refresh = false) {// phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable -- $force_refresh unused
		$opts = $this->get_options();
		$opts['whoweare'] = 'DreamObjects';
		$opts['whoweare_long'] = 'DreamObjects';
		$opts['key'] = 'dreamobjects';
		if (empty($opts['endpoint'])) {
			$endpoints = array_keys(self::get_endpoints());
			$opts['endpoint'] = $endpoints[0];
		}
		return $opts;
	}

	/**
	 * Get the pre configuration template
	 */
	public function get_pre_configuration_template() {
		?>
		<tr class="{{get_template_css_classes false}} {{method_display_name}}_pre_config_container">
			<td colspan="2">
				<a href="https://dreamhost.com/cloud/dreamobjects/" target="_blank"><img alt="{{method_display_name}}" src="{{storage_image_url}}"></a>
				<br>
				{{{xmlwriter_existence_label}}}
				{{{simplexmlelement_existence_label}}}
				{{{curl_existence_label}}}
				<br>
				{{{console_url_text}}}
				<p>
					<a href="{{updraftplus_com_link}}" target="_blank">{{ssl_error_text}}</a>
				</p>
			</td>
		</tr>
		<?php
	}

	/**
	 * Get the configuration template
	 *
	 * @return String - the template, ready for substitutions to be carried out
	 */
	public function get_configuration_template() {
		// return $this->get_configuration_template_engine('dreamobjects', 'DreamObjects', 'DreamObjects', 'DreamObjects', 'https://panel.dreamhost.com/index.cgi?tree=storage.dreamhostobjects', '<a href="https://dreamhost.com/cloud/dreamobjects/" target="_blank"><img alt="DreamObjects" src="'.UPDRAFTPLUS_URL.'/images/dreamobjects_logo-horiz-2013.png"></a>');
		ob_start();
		?>
		<tr class="{{get_template_css_classes true}}">
			<th>{{input_accesskey_label}}:</th>
			<td><input class="updraft_input--wide udc-wd-600" data-updraft_settings_test="accesskey" type="text" autocomplete="off" id="{{get_template_input_attribute_value "id" "accesskey"}}" name="{{get_template_input_attribute_value "name" "accesskey"}}" value="{{accesskey}}" /></td>
		</tr>
		<tr class="{{get_template_css_classes true}}">
			<th>{{input_secretkey_label}}:</th>
			<td><input class="updraft_input--wide udc-wd-600" data-updraft_settings_test="secretkey" type="{{input_secretkey_type}}" autocomplete="off" id="{{get_template_input_attribute_value "id" "secretkey"}}" name="{{get_template_input_attribute_value "name" "secretkey"}}" value="{{secretkey}}" /></td>
		</tr>
		<tr class="{{get_template_css_classes true}}">
			<th>{{input_location_label}}:</th>
			<td>{{method_id}}://<input class="updraft_input--wide  udc-wd-600" data-updraft_settings_test="path" title="{{input_location_title}}" type="text" id="{{get_template_input_attribute_value "id" "path"}}" name="{{get_template_input_attribute_value "name" "path"}}" value="{{path}}" /></td>
		</tr>
		<tr class="{{get_template_css_classes true}}">
			<th>{{input_endpoint_label}}</th>
			<td>
				<select class="select2-storage-config dreamobjects-endpoints" data-field-id="endpoint" data-storage-id="{{method_id}}" data-updraft_settings_test="endpoint" id="{{get_template_input_attribute_value "id" "endpoint"}}" name="{{get_template_input_attribute_value "name" "endpoint"}}" style="width: 360px">
					{{#each dreamobjects_endpoints as |description endpoint|}}
						<option value="{{endpoint}}" {{#ifeq ../endpoint endpoint}}selected="selected"{{/ifeq}}>{{description}}</option>
					{{/each}}
				</select>
				<span class="updraft-input-error-message">{{invalid_endpoint_error_message}}</span>
			</td>
		</tr>
		{{{get_template_test_button_html "DreamObjects"}}}
		<?php
		return ob_get_clean();
	}
	
	/**
	 * Modifies handerbar template options
	 *
	 * @param array $opts
	 * @return Array - Modified handerbar template options
	 */
	public function transform_options_for_template($opts) {
		$opts['endpoint'] = empty($opts['endpoint']) ? '' : $opts['endpoint'];
		$opts['dreamobjects_endpoints'] = self::get_endpoints();
		// Add custom endpoint in dropdown.
		if (!empty($opts['endpoint']) && !isset($opts['dreamobjects_endpoints'][$opts['endpoint']])) {
			$opts['dreamobjects_endpoints'][$opts['endpoint']] = $opts['endpoint'];
		}
		return $opts;
	}

	/**
	 * Retrieve a list of template properties by taking all the persistent variables and methods of the parent class and combining them with the ones that are unique to this module, also the necessary HTML element attributes and texts which are also unique only to this backup module
	 * NOTE: Please sanitise all strings that are required to be shown as HTML content on the frontend side (i.e. wp_kses()), or any other technique to prevent XSS attacks that could come via WP hooks
	 *
	 * @return Array an associative array keyed by names that describe themselves as they are
	 */
	public function get_template_properties() {
		global $updraftplus, $updraftplus_admin;
		$properties = array(
			'storage_image_url' => UPDRAFTPLUS_URL."/images/dreamobjects_logo-horiz-2013.png",
			'curl_existence_label' => wp_kses($updraftplus_admin->curl_check($updraftplus->backup_methods[$this->get_id()], false, $this->get_id()." hidden-in-updraftcentral", false), $this->allowed_html_for_content_sanitisation()),
			'simplexmlelement_existence_label' => !apply_filters('updraftplus_dreamobjects_simplexmlelement_exists', class_exists('SimpleXMLElement')) ? wp_kses($updraftplus_admin->show_double_warning('<strong>'.__('Warning', 'updraftplus').':</strong> '.sprintf(__("Your web server's PHP installation does not included a required module (%s).", 'updraftplus'), 'SimpleXMLElement').' '.__("Please contact your web hosting provider's support.", 'updraftplus').' '.sprintf(__("UpdraftPlus's %s module <strong>requires</strong> %s.", 'updraftplus'), $updraftplus->backup_methods[$this->get_id()], 'SimpleXMLElement').' '.__('Please do not file any support requests; there is no alternative.', 'updraftplus'), $this->get_id(), false), $this->allowed_html_for_content_sanitisation()) : '',
			'xmlwriter_existence_label' => !apply_filters('updraftplus_dreamobjects_xmlwriter_exists', 'UpdraftPlus_S3_Compat' != $this->indicate_s3_class() || !class_exists('XMLWriter')) ? wp_kses($updraftplus_admin->show_double_warning('<strong>'.__('Warning', 'updraftplus').':</strong> '. sprintf(__("Your web server's PHP installation does not included a required module (%s).", 'updraftplus'), 'XMLWriter').' '.__("Please contact your web hosting provider's support and ask for them to enable it.", 'updraftplus'), $this->get_id(), false), $this->allowed_html_for_content_sanitisation()) : '',
			'console_url_text' => sprintf(__('Get your access key and secret key from your <a href="%s">%s console</a>, then pick a (globally unique - all %s users) bucket name (letters and numbers) (and optionally a path) to use for storage.', 'updraftplus'), 'https://panel.dreamhost.com/index.cgi?tree=storage.dreamhostobjects', $updraftplus->backup_methods[$this->get_id()], $updraftplus->backup_methods[$this->get_id()]).' '.__('This bucket will be created for you if it does not already exist.', 'updraftplus'),
			'updraftplus_com_link' => apply_filters("updraftplus_com_link", "https://teamupdraft.com/documentation/updraftplus/topics/backing-up/troubleshooting/i-get-ssl-certificate-errors-when-backing-up-and-or-restoring/?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=dreamobjects-ssl-certificates&utm_creative_format=text"),
			'ssl_error_text' => __('If you see errors about SSL certificates, then please go here for help.', 'updraftplus'),
			'credentials_creation_link_text' => __('Create Azure credentials in your Azure developer console.', 'updraftplus'),
			'configuration_helper_link_text' => __('For more detailed instructions, follow this link.', 'updraftplus'),
			'input_accesskey_label' => sprintf(__('%s access key', 'updraftplus'), $updraftplus->backup_methods[$this->get_id()]),
			'input_secretkey_label' => sprintf(__('%s secret key', 'updraftplus'), $updraftplus->backup_methods[$this->get_id()]),
			'input_secretkey_type' => apply_filters('updraftplus_admin_secret_field_type', 'password'),
			'input_location_label' => sprintf(__('%s location', 'updraftplus'), $updraftplus->backup_methods[$this->get_id()]),
			'input_location_title' => __('Enter only a bucket name or a bucket and path.', 'updraftplus').' '.__('Examples: mybucket, mybucket/mypath', 'updraftplus'),
			'input_endpoint_label' => sprintf(__('%s end-point', 'updraftplus'), $updraftplus->backup_methods[$this->get_id()]),
			'input_test_label' => sprintf(__('Test %s Settings', 'updraftplus'), $updraftplus->backup_methods[$this->get_id()]),
			/* translators: %s: Desired endpoint format.*/
			'invalid_endpoint_error_message' => sprintf(__('Custom endpoint should be in the following format "%s".', 'updraftplus'), 's3.<region>.dream.io'),
		);
		return wp_parse_args($properties, $this->get_persistent_variables_and_methods());
	}

	/**
	 * Ensure that only the DreamObjects endpoints (objects-<region>.dream.io and s3.<region>.dream.io) are allowed and that signature header version 4 must exclusively be used for s3.<region>.dream.io enpoint
	 *
	 * @param Object $storage S3 name
	 * @param Array  $config  array of config details; if the provider does not have the concept of regions, then the key 'endpoint' is required to be set
	 * @param String $bucket  S3 Bucket
	 * @param String $path    S3 Path
	 *
	 * @return Array - N.B. May contain updated versions of $storage and $config
	 */
	protected function get_bucket_access($storage, $config, $bucket, $path) {
		if (empty($config['endpoint']) || !self::is_valid_endpoint($config['endpoint'])) throw new Exception('Invalid DreamObjects endpoint: '.$config['endpoint']); // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- The escaping should happen when the exception is caught and printed
		if (preg_match('/'.self::ENDPOINT_REGEX.'/i', trim($config['endpoint']))) {
			$this->use_v4 = true;
			$storage->setSignatureVersion('v4');
			$storage->useDNSBucketName(false);
		}
		return parent::get_bucket_access($storage, $config, $bucket, $path);
	}

	/**
	 * Perform a test of user-supplied credentials, and echo the result.
	 *
	 * @param array $posted_settings Settings to test.
	 *
	 * @return void Echo the result of credentials test.
	 */
	public function credentials_test($posted_settings) {
		if (!empty($posted_settings['endpoint']) && !self::is_valid_endpoint($posted_settings['endpoint'])) {
			/* translators: %s: Invalid custom endpoint*/
			echo sprintf(esc_html__('Failure: Custom endpoint "%s" is not in the desired format "%s".', 'updraftplus'), $posted_settings['endpoint'], 's3.<region>.dream.io'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Prevent escaping '<' & '>' in endpoint as this message is shown in alert.
			return;
		}
		parent::credentials_test($posted_settings);
	}

	/**
	 * Sanitization filter for saving DreamObjects settings.
	 *
	 * @param  array $new_settings New settings passed by user.
	 *
	 * @return array Sanitized settings to be saved in DB.
	 */
	public function options_filter($new_settings) {
		$current_settings = UpdraftPlus_Options::get_updraft_option('updraft_dreamobjects', array());
		// Previous settings would be empty on initial load.
		if (empty($current_settings)) return parent::options_filter($new_settings);

		$current_settings = $current_settings['settings'];
		// Check if endpoint is updated to an invalid format, then log it.
		foreach ($new_settings['settings'] as $instance_id => $new_storage_options) {
			if (isset($current_settings[$instance_id]['endpoint'], $new_storage_options['endpoint'])
				&& $current_settings[$instance_id]['endpoint'] !== $new_storage_options['endpoint']
				&& !self::is_valid_endpoint($new_storage_options['endpoint'])
			) {
				$msg = sprintf('Custom endpoint "%s" is not in the format "s3.<region>.dream.io".', esc_html($new_storage_options['endpoint']));
				$this->log($msg, 'error');
				error_log('UpdraftPlus: DreamObjects: '.$msg);
			}
		}
		return parent::options_filter($new_settings);
	}

	/**
	 * Check if valid endpoint.
	 *
	 * @param string $endpoint DreamObjects endpoint provided by user.
	 *
	 * @return bool True for valid endpoint else false.
	 */
	public static function is_valid_endpoint($endpoint) {
		$endpoint  = trim($endpoint);
		$endpoints = self::get_endpoints();
		if (isset($endpoints[$endpoint]) || preg_match('/'.self::ENDPOINT_REGEX.'/i', $endpoint)) return true;
		return false;
	}
}
