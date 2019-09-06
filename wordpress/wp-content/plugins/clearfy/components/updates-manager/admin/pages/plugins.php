<?php

	/**
	 * The page Settings.
	 *
	 * @since 1.0.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}


	class WUPM_PluginsPage extends Wbcr_FactoryClearfy206_PageBase {

		/**
		 * The id of the page in the admin menu.
		 *
		 * Mainly used to navigate between pages.
		 * @see FactoryPages410_AdminPage
		 *
		 * @since 1.0.0
		 * @var string
		 */
		public $id = "plugins";

		/**
		 * @var string
		 */
		public $type = "page";

		/**
		 * @var string
		 */
		public $page_parent_page = 'updates';

		/**
		 * @var string
		 */
		public $page_menu_dashicon = 'dashicons-cloud';


		/**
		 * Доступена для мультисайтов
		 * @var bool
		 */
		public $available_for_multisite = true;

		/**
		 * @var
		 */
		private $is_disable_updates;

		/**
		 * @var
		 */
		private $is_auto_updates;

		private $is_disable_translation_updates;

		/**
		 * @var array
		 */
		private $plugins_update_filters = array();

		/**
		 * @param Wbcr_Factory409_Plugin $plugin
		 */
		public function __construct(Wbcr_Factory409_Plugin $plugin)
		{
			$this->menu_title = __('Plugins', 'webcraftic-updates-manager');

			parent::__construct($plugin);

			$updates_mode = $this->getPopulateOption('plugin_updates');

			$this->is_disable_updates = $updates_mode == 'disable_plugin_updates';
			$this->is_auto_updates = $updates_mode == 'enable_plugin_auto_updates';
			$this->is_disable_translation_updates = $this->getPopulateOption('auto_tran_update');
			$this->plugins_update_filters = $this->getPopulateOption('plugins_update_filters');
		}

		public function warningNotice()
		{
			parent::warningNotice();

			$concat = '';

			if( $this->is_disable_updates ) {
				$concat .= __('- To disable updates individually choose the “Manual or automatic plugin updates” option then save settings and comeback to this page.', 'webcraftic-updates-manager') . '<br>';
			}

			if( !$this->is_auto_updates ) {
				$concat .= __('- To configure plugin auto updates individually, choose the “Enable auto updates” option then save settings and comeback to this page.', 'webcraftic-updates-manager');
			}

			if( !empty($concat) ) {
				$this->printWarningNotice($concat);
			}
		}

		/**
		 * Requests assets (js and css) for the page.
		 *
		 * @see FactoryPages410_AdminPage
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function assets($scripts, $styles)
		{
			parent::assets($scripts, $styles);
			$this->styles->add(WUPM_PLUGIN_URL . '/admin/assets/css/general.css');
			$this->scripts->add(WUPM_PLUGIN_URL . '/admin/assets/js/ajax-components.js');

			// Add Clearfy styles for HMWP pages
			if( defined('WBCR_CLEARFY_PLUGIN_ACTIVE') ) {
				$this->styles->add(WCL_PLUGIN_URL . '/admin/assets/css/general.css');
			}
		}

		public function savePluginsUpdateFilters()
		{
			$this->plugin->updatePopulateOption('plugins_update_filters', $this->plugins_update_filters);
		}

		public function disablePluginUpdatesAction()
		{
			if( !$this->is_disable_updates ) {
				$plugin_slug = $this->request->get('plugin_slug', null, true);

				check_admin_referer($this->getResultId() . '_' . $plugin_slug);

				if( !empty($plugin_slug) ) {
					if( isset($this->plugins_update_filters['disable_updates']) ) {
						if( !isset($this->plugins_update_filters['disable_updates'][$plugin_slug]) ) {
							$this->plugins_update_filters['disable_updates'][$plugin_slug] = true;
						}
					} else {
						$this->plugins_update_filters['disable_updates'] = array();
						$this->plugins_update_filters['disable_updates'][$plugin_slug] = true;
					}

					$this->savePluginsUpdateFilters();
				}
			}

			$this->redirectToAction('index');
		}

		public function enablePluginUpdatesAction()
		{
			if( !$this->is_disable_updates ) {
				$plugin_slug = $this->request->get('plugin_slug', null, true);

				check_admin_referer($this->getResultId() . '_' . $plugin_slug);

				if( !empty($plugin_slug) ) {
					if( isset($this->plugins_update_filters['disable_updates']) && isset($this->plugins_update_filters['disable_updates'][$plugin_slug]) ) {
						unset($this->plugins_update_filters['disable_updates'][$plugin_slug]);
						$this->savePluginsUpdateFilters();
					}
				}
			}

			$this->redirectToAction('index');
		}

		public function disablePluginAutoupdatesAction()
		{
			if( $this->is_auto_updates ) {
				$plugin_slug = $this->request->get('plugin_slug', null, true);

				check_admin_referer($this->getResultId() . '_' . $plugin_slug);

				if( !empty($plugin_slug) ) {
					if( isset($this->plugins_update_filters['disable_auto_updates']) ) {
						if( !isset($this->plugins_update_filters['disable_auto_updates'][$plugin_slug]) ) {
							$this->plugins_update_filters['disable_auto_updates'][$plugin_slug] = true;
						}
					} else {
						$this->plugins_update_filters['disable_auto_updates'] = array();
						$this->plugins_update_filters['disable_auto_updates'][$plugin_slug] = true;
					}
					$this->savePluginsUpdateFilters();
				}
			}
			$this->redirectToAction('index');
		}

		public function enablePluginAutoupdatesAction()
		{
			if( $this->is_auto_updates ) {
				$plugin_slug = $this->request->get('plugin_slug', null, true);

				check_admin_referer($this->getResultId() . '_' . $plugin_slug);

				if( !empty($plugin_slug) ) {
					if( isset($this->plugins_update_filters['disable_auto_updates']) && isset($this->plugins_update_filters['disable_auto_updates'][$plugin_slug]) ) {
						unset($this->plugins_update_filters['disable_auto_updates'][$plugin_slug]);
						$this->savePluginsUpdateFilters();
					}
				}
			}
			$this->redirectToAction('index');
		}

		public function enablePluginTranslationUpdatesAction()
		{
			if( !$this->is_disable_translation_updates ) {
				$plugin_slug = $this->request->get('plugin_slug', null, true);
				check_admin_referer($this->getResultId() . '_' . $plugin_slug);

				if( !empty($plugin_slug) ) {
					if( isset($this->plugins_update_filters['disable_translation_updates']) && isset($this->plugins_update_filters['disable_translation_updates'][$plugin_slug]) ) {
						unset($this->plugins_update_filters['disable_translation_updates'][$plugin_slug]);
						$this->savePluginsUpdateFilters();
					}
				}
			}
			$this->redirectToAction('index');
		}

		public function disablePluginTranslationUpdatesAction()
		{
			if( !$this->is_disable_translation_updates ) {
				$plugin_slug = $this->request->get('plugin_slug', null, true);
				check_admin_referer($this->getResultId() . '_' . $plugin_slug);

				if( !empty($plugin_slug) ) {
					if( !isset($this->plugins_update_filters['disable_translation_updates']) ) {
						$this->plugins_update_filters['disable_translation_updates'] = array();
					}
					$this->plugins_update_filters['disable_translation_updates'][$plugin_slug] = true;
					$this->savePluginsUpdateFilters();
				}
			}

			$this->redirectToAction('index');
		}

		public function showPageContent()
		{
			if( isset($_POST['wbcr_upm_apply']) ) {

				$bulk_action = $this->request->post('wbcr_upm_bulk_actions', null, true);
				$plugin_slugs = $this->request->post('plugin_slugs', array(), true);

				$plugin_slugs = array_map('strip_tags', $plugin_slugs);

				check_admin_referer($this->getResultId() . '_form');
				// validate $bulk_action
				if( !empty($bulk_action) and !in_array($bulk_action, array(
						'disable_updates',
						'enable_updates',
						'enable_auto_updates',
						'disable_auto_updates',
						'disable_translation_updates',
						'enable_translation_updates',
						'disable_display',
						'enable_display'
					))
				) {
					$bulk_action = null;
				}
				if( !$this->is_disable_updates ) {
					if( !empty($bulk_action) && !empty($plugin_slugs) && is_array($plugin_slugs) ) {
						foreach((array)$plugin_slugs as $slug) {

							if( $bulk_action == 'enable_updates' && isset($this->plugins_update_filters['disable_updates']) && isset($this->plugins_update_filters['disable_updates'][$slug]) ) {
								unset($this->plugins_update_filters['disable_updates'][$slug]);
							}

							if( $bulk_action == 'enable_auto_updates' ) {
								if( $this->is_auto_updates ) {
									if( isset($this->plugins_update_filters['disable_auto_updates']) && isset($this->plugins_update_filters['disable_auto_updates'][$slug]) ) {
										unset($this->plugins_update_filters['disable_auto_updates'][$slug]);
									}
								}
							} else {
								if( $bulk_action == 'disable_auto_updates' && !$this->is_auto_updates ) {
									continue;
								}

								$this->plugins_update_filters[$bulk_action][$slug] = true;
							}

							if( $bulk_action == 'disable_translation_updates' ) {
								if( !$this->is_disable_translation_updates ) {
									$this->plugins_update_filters['disable_translation_updates'][$slug] = true;
								}
							}
							if( $bulk_action == 'enable_translation_updates' && array_key_exists($slug, $this->plugins_update_filters['disable_translation_updates']) ) {
								if( !$this->is_disable_translation_updates ) {
									unset($this->plugins_update_filters['disable_translation_updates'][$slug]);
								}
							}
						}
					}
				}

				if( !empty($bulk_action) && !empty($plugin_slugs) && is_array($plugin_slugs) ) {
					foreach((array)$plugin_slugs as $slug) {
						if( $bulk_action == 'disable_display' ) {
							if( !isset($this->plugins_update_filters['disable_display']) ) {
								$this->plugins_update_filters['disable_display'] = array();
							}
							$this->plugins_update_filters['disable_display'][$slug] = true;
						}

						if( $bulk_action == 'enable_display' && isset($this->plugins_update_filters['disable_display']) && isset($this->plugins_update_filters['disable_display'][$slug]) ) {
							unset($this->plugins_update_filters['disable_display'][$slug]);
						}
					}
				}

				$this->savePluginsUpdateFilters();
			}

			$is_premium = defined('WUPMP_PLUGIN_ACTIVE');

			?>

			<div class="wbcr-factory-page-group-header">
				<strong><?php _e('Plugins list', 'webcraftic-updates-manager') ?></strong>

				<p>
					<?php _e('This page you can individually disable plugin updates and auto updates.', 'webcraftic-updates-manager') ?>
				</p>
			</div>
			<style>
				#the-list tr.inactive .check-column {
					border-left: 3px solid #D54E21;
				}

				#the-list tr.inactive {
					background: #FEF7F1;
				}
			</style>
			<form method="post" style="padding: 20px;">
				<?php wp_nonce_field($this->getResultId() . '_form') ?>
				<p>
					<select name="wbcr_upm_bulk_actions" id="wbcr_upm_bulk_actions">
						<option value="0"><?php _e('Bulk actions', 'webcraftic-updates-manager'); ?></option>
						<option value="disable_updates"><?php _e('Disable updates', 'webcraftic-updates-manager'); ?></option>
						<option value="enable_updates"><?php _e('Enable updates', 'webcraftic-updates-manager'); ?></option>
						<option value="enable_auto_updates"><?php _e('Enable auto-updates', 'webcraftic-updates-manager'); ?></option>
						<option value="disable_auto_updates"><?php _e('Disable auto-updates', 'webcraftic-updates-manager'); ?></option>
						<option value="disable_translation_updates"<?= (!$is_premium ? ' disabled' : '') ?>><?php _e('Disable translation updates', 'webcraftic-updates-manager'); ?></option>
						<option value="enable_translation_updates"<?= (!$is_premium ? ' disabled' : '') ?>><?php _e('Enable translation updates', 'webcraftic-updates-manager'); ?></option>
						<option value="disable_display"<?= (!$is_premium ? ' disabled' : '') ?>><?php _e('Hide plugin', 'webcraftic-updates-manager'); ?></option>
						<option value="enable_display"<?= (!$is_premium ? ' disabled' : '') ?>><?php _e('Show plugin', 'webcraftic-updates-manager'); ?></option>
					</select>
					<input type="submit" name="wbcr_upm_apply" id="wbcr_upm_apply" class='button button-alt' value='<?php _e("Apply", "webcraftic-updates-manager"); ?>'>
				</p>
				<table class="wp-list-table widefat autoupdate striped plugins wp-list-table__plugins">
					<thead>
					<tr>
						<th id='cb' class='manage-column column-cb check-column'>
                            <input class="wbcr_um_select_all" type="checkbox">
                        </th>
						<th id='name' class='manage-column column-name column-primary'>
							<strong><?php _e('Plugin', 'webcraftic-updates-manager'); ?></strong></th>
						<th id="disable_updates">
							<strong><?php _e('Disable updates', 'webcraftic-updates-manager');?></strong>
						</th>
						<th id="disable_auto_updates">
							<strong><?php _e('Auto-updates', 'webcraftic-updates-manager'); ?></strong>
						</th>
						<th id="disable_translation_updates"<?= (!$is_premium ? ' class="wbcr-upm-column-pro"' : '') ?>>
							<strong><?php _e('Translation updates', 'webcraftic-updates-manager'); ?></strong>
						</th>
						<th id="hide_item"<?= (!$is_premium ? ' class="wbcr-upm-column-pro"' : '') ?>>
							<strong><?php _e('Hide plugin', 'webcraftic-updates-manager'); ?></strong>
						</th>
					</tr>
					</thead>
					<tbody id="the-list">
					<?php
						$prefix = $this->plugin->getPrefix();
						foreach(get_plugins() as $key => $value):

							$slug = $key;
							$slug_parts = explode('/', $slug);
							$actual_slug = array_shift($slug_parts);
							$slug_hash = md5($slug);
							$description = $name = 'Empty';

							foreach((array)$value as $k => $v) {

								if( $k == "Name" ) {
									$name = $v;
								}
								if( $k == "Description" ) {
									$description = $v;
								}
							}

							$class = 'active';
							$is_disable_updates = false;
							$is_auto_updates = true;
							$is_disable_translation_update = false;
							$is_disable_display = false;

							if( !empty($this->plugins_update_filters) ) {

								if( isset($this->plugins_update_filters['disable_auto_updates']) && isset($this->plugins_update_filters['disable_auto_updates'][$actual_slug]) ) {
									$is_auto_updates = false;
								}
								if( (isset($this->plugins_update_filters['disable_updates']) && isset($this->plugins_update_filters['disable_updates'][$actual_slug])) ) {
									$is_disable_updates = true;
								}
							}

                            if( $this->is_disable_updates ) {
                                $is_disable_updates = true;
                            }

							if( !empty($this->plugins_update_filters) ) {
								if( isset($this->plugins_update_filters['disable_translation_updates']) && isset($this->plugins_update_filters['disable_translation_updates'][$actual_slug]) ) {
									$is_disable_translation_update = true;
								}
							}

							if( isset($this->plugins_update_filters['disable_display']) && isset($this->plugins_update_filters['disable_display'][$actual_slug]) ) {
								$is_disable_display = true;
							}
                            if($is_disable_display or $is_disable_updates){
                                $class = 'inactive';
                            }

                            if( $this->is_disable_updates ) {
                                $class = 'inactive row-global-disabled';
                            }


							?>
							<tr id="post-<?= esc_attr($slug_hash) ?>" class="<?= $class ?>">
								<td scope="row" class="check-column">
									<label class="screen-reader-text" for="cb-select-<?= esc_attr($slug_hash) ?>"><?php _e('Select', 'webcraftic-updates-manager') ?><?= esc_html($name) ?></label>
									<input id="cb-select-<?= esc_attr($slug_hash) ?>" type="checkbox" name="plugin_slugs[]" value="<?= esc_attr($actual_slug) ?>">
									<label></label>

									<div class="locked-indicator"></div>
								</td>
								<td class="plugin-title column-primary">
									<strong class="plugin-name">
										<?= esc_html($name) ?>
									</strong>
								</td>
								<!-- отключить все обновления -->
								<td class="column-flags">
									<div class="factory-checkbox factory-from-control-checkbox factory-buttons-way btn-group <?= 'group-all-' . $slug_hash; ?>">
										<?php
											$disabled = $this->is_disable_updates;
											if($is_disable_display){
                                                $disabled = true;
                                            }
											$checked = false;
											if( $is_disable_updates ) {
												$checked = true;
											}
                                            if(in_array($key, WUPM_PluginFilters::getPersistentPlugins())){
                                                // deny disable update for update manager
                                                $disabled = true;
                                            }
										?>
										<button type="button" class="btn btn-default btn-small btn-sm factory-on <?= ($checked ? 'active' : ''); ?>"  <?= ($disabled ? 'disabled' : ''); ?>><?php _e('On', 'webcraftic-updates-manager'); ?></button>
										<button type="button" class="btn btn-default btn-small btn-sm factory-off <?= (!$checked ? 'active' : ''); ?>" data-value="0"  <?= ($disabled ? 'disabled' : ''); ?>><?php _e('Off', 'webcraftic-updates-manager'); ?></button>
										<input type="checkbox" style="display: none" id="wbcr_updates_manager_disable_updates" class="factory-result factory-ajax-checkbox"
										       data-disable-group="<?= 'group-' . $slug_hash; ?>" data-action="Updates" data-plugin-slug="<?= $actual_slug ?>" value="<?= (int)$checked ?>" <?= ($checked ? 'checked' : ''); ?>  <?= ($disabled ? 'disabled' : ''); ?>>
									</div>
								</td>
								<!-- отключить авто-обновления -->
								<td class="column-flags">
									<div class="factory-checkbox factory-from-control-checkbox factory-buttons-way btn-group <?= 'group-' . $slug_hash; ?> <?= 'group-all-' . $slug_hash; ?> <?= (!$this->is_auto_updates) ? 'global-disabled' : ''; ?> ">
										<?php
											$disabled = false;
											if( !$this->is_auto_updates or $is_disable_updates or $is_disable_display) {
												$disabled = true;
											}
											$checked = $is_auto_updates;

										?>
										<button type="button" class="btn btn-default btn-small btn-sm factory-on <?= ($checked ? 'active' : ''); ?>" <?= ($disabled) ? 'disabled' : ''; ?>><?php _e('On', 'webcraftic-updates-manager'); ?></button>
										<button type="button" class="btn btn-default btn-small btn-sm factory-off <?= (!$checked ? 'active' : ''); ?>" <?= ($disabled ? 'disabled' : ''); ?>><?php _e('Off', 'webcraftic-updates-manager'); ?></button>
										<input type="checkbox" style="display: none" id="wbcr_updates_manager_disable_auto_updates" class="factory-result factory-ajax-checkbox"
										       data-action="AutoUpdates" data-inverse="1" data-plugin-slug="<?= $actual_slug ?>" value="<?= (int)$checked ?>" <?= ($checked ? 'checked' : ''); ?>  <?= ($disabled ? 'disabled' : ''); ?>>
									</div>
								</td>
								<!-- отключить обновления переводов -->
								<td class="column-flags <?= (!$is_premium) ? "wbcr-upm-column-premium" : ""; ?>">
									<div class="factory-checkbox factory-from-control-checkbox factory-buttons-way btn-group <?= 'group-' . $slug_hash; ?>  <?= 'group-all-' . $slug_hash; ?>  <?= (!$is_premium or $this->is_disable_translation_updates ? 'global-disabled' : ''); ?>">
										<?php
											$disabled = false;
											if( !$is_premium or $is_disable_updates or $this->is_disable_translation_updates  or $is_disable_display) {
												$disabled = true;
											}
											$checked = !$is_disable_translation_update;
										?>
										<button type="button" class="btn btn-default btn-small btn-sm factory-on <?= ($checked) ? 'active' : ''; ?>"  <?= ($disabled) ? 'disabled' : ''; ?>><?php _e('On', 'webcraftic-updates-manager'); ?></button>
										<button type="button" class="btn btn-default btn-small btn-sm factory-off <?= (!$checked) ? 'active' : ''; ?>" data-value="0"  <?= ($disabled ? 'disabled' : ''); ?>><?php _e('Off', 'webcraftic-updates-manager'); ?></button>
										<input type="checkbox" style="display: none" id="wbcr_updates_manager_disable_translation_updates" class="factory-result factory-ajax-checkbox"
										       data-action="TranslationUpdates"  data-inverse="1"  data-plugin-slug="<?= $actual_slug ?>" value="<?= (int)$checked ?>" <?= ($checked ? 'checked' : ''); ?>  <?= ($disabled ? 'disabled' : ''); ?>>
									</div>
								</td>
								<!-- скрыть плагин -->
								<td class="column-flags <?= (!$is_premium ? "wbcr-upm-column-premium" : ""); ?>">
									<div class="factory-checkbox factory-from-control-checkbox factory-buttons-way btn-group <?= (!$is_premium ? 'global-disabled' : ''); ?>">
										<?php
											$checked = $is_disable_display;
											$disabled = false;
											if( !$is_premium ) {
												$disabled = true;
											}
										?>
										<button type="button" class="btn btn-default btn-small btn-sm factory-on <?= ($checked ? 'active' : ''); ?>"  <?= ($disabled ? 'disabled' : ''); ?>><?php _e('On', 'webcraftic-updates-manager'); ?></button>
										<button type="button" class="btn btn-default btn-small btn-sm factory-off <?= (!$checked ? 'active' : ''); ?>" data-value="0"  <?= ($disabled ? 'disabled' : ''); ?>><?php _e('Off', 'webcraftic-updates-manager'); ?></button>
										<input type="checkbox" style="display: none" id="wbcr_updates_manager_hide_item" class="factory-result factory-ajax-checkbox"
                                               data-disable-group="<?= 'group-all-' . $slug_hash; ?>"  data-action="Display" data-plugin-slug="<?= $actual_slug ?>" value="<?= (int)$checked ?>" <?= ($checked ? 'checked' : ''); ?>  <?= ($disabled ? 'disabled' : ''); ?>>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</form>
		<?php
		}
	}