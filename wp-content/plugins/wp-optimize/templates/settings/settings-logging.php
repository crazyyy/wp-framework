<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>
<div id="wpo_logging_settings">
	<h3><?php esc_html_e('Logging settings', 'wp-optimize'); ?></h3>

	<div id="wp-optimize-logger-settings" class="wpo-fieldgroup">
		<p>
			<a href="#" id="wpo_add_logger_link" class="wpo-repeater__add"><span class="dashicons dashicons-plus"></span> <?php esc_html_e('Add logging destination', 'wp-optimize'); ?></a>

		</p>

		<div class="save_settings_reminder"><?php esc_html_e('Remember to save your settings so that your changes take effect.', 'wp-optimize');?></div>

		<?php
		
		$loggers = $wp_optimize->wpo_loggers();

		if (count($loggers) > 0) {

		?>
			<div id="wp-optimize-logging-options">
				<div class="wpo_logging_header">
					<div class="wpo_logging_logger_title"><?php esc_html_e('Destination', 'wp-optimize'); ?></div>
					<div class="wpo_logging_options_title"><?php esc_html_e('Options', 'wp-optimize'); ?></div>
					<div class="wpo_logging_status_title"><?php esc_html_e('Status', 'wp-optimize'); ?></div>
					<div class="wpo_logging_actions_title"><?php esc_html_e('Actions', 'wp-optimize'); ?></div>
				</div>
				<?php

				foreach ($loggers as $logger) {
					$logger_id = strtolower(get_class($logger));

					?>

					<div class="wpo_logging_row" data-id="<?php echo esc_attr($logger_id); ?>">
						<div class="wpo_logging_logger_row"><span
									class="dashicons dashicons-arrow-right"></span><?php echo esc_html($logger->get_description()); ?>
						</div>
						<div class="wpo_logging_options_row"><?php echo esc_html($logger->get_options_text()); ?></div>
						<?php
							$status = '';
							$status = ($logger->is_enabled() && $logger->is_available()) ? 'active' : 'inactive';
							$status_text = ($logger->is_enabled() && $logger->is_available()) ? __('Active', 'wp-optimize') : __('Inactive', 'wp-optimize');
						?>
						<div class="wpo_logging_status_row <?php echo esc_attr($status); ?>"><?php echo esc_html($status_text); ?></div>

						<div class="wpo_logging_actions_row">
							<span class="wpo_edit_logger" title="<?php esc_attr_e('Edit', 'wp-optimize'); ?>"><?php esc_html_e('Edit', 'wp-optimize'); ?></span>
							<span class="wpo_delete_logger" title="<?php esc_attr_e('Delete', 'wp-optimize'); ?>"><?php esc_html_e('Delete', 'wp-optimize'); ?></span>
						</div>

						<div class="wpo_logging_edit_row">
							<span class="wpo_cancel_logging button button-secondary" title="<?php esc_attr_e('Cancel', 'wp-optimize'); ?>"><?php esc_html_e('Cancel', 'wp-optimize'); ?></span>
							<span class="wpo_save_logging button button-primary" title="<?php esc_attr_e('Apply', 'wp-optimize'); ?>"><?php esc_html_e('Apply', 'wp-optimize'); ?></span>
						</div>

						<div class="wpo_additional_logger_options wpo_hidden">
							<input class="wpo_hidden" type="hidden" name="wpo-logger-type[]"
									value="<?php echo esc_attr($logger_id); ?>"/>
							
							<?php
							$options_list = $logger->get_options_list();
							$options_values = $logger->get_options_values();

							if (!empty($options_list)) {
								foreach ($options_list as $option_name => $placeholder) {
									// check if settings item defined as array.
									if (is_array($placeholder)) {
										$validate = $placeholder[1];
										$placeholder = $placeholder[0];
									} else {
										$validate = '';
									}

									$data_validate_attr = ('' !== $validate ? 'data-validate="'.esc_attr($validate).'"' : '');

									?>
									<input class="wpo_logger_addition_option" type="text"
											name="wpo-logger-options[<?php echo esc_attr($option_name); ?>][]"
											value="<?php echo esc_attr($options_values[$option_name]); ?>"
											placeholder="<?php echo esc_attr($placeholder); ?>"
										<?php echo $data_validate_attr; ?> "/>
									<?php
								}
							}
							?>
							<label>
								<input class="wpo_logger_active_checkbox"
										type="checkbox" <?php checked($logger->is_enabled() && $logger->is_available()); ?> <?php disabled($logger->is_available(), false); ?>>
								<input type="hidden" name="wpo-logger-options[active][]"
										value="<?php echo $logger->is_enabled() ? '1' : '0'; ?>"/>
								<?php esc_html_e('Active', 'wp-optimize'); ?>
							</label>
						</div>

					</div>
					<?php
				}
				?>
			</div><!-- End #wp-optimize-logging-options -->	
			<?php
		}
		?>	
	</div><!-- End #wp-optimize-logger-settings -->
</div>