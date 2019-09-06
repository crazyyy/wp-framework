<?php
	/**
	 * The page Themes.
	 *
	 * @since 1.0.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	class WUPM_ThemesPage extends Wbcr_FactoryClearfy206_PageBase {

		/**
		 * The id of the page in the admin menu.
		 *
		 * Mainly used to navigate between pages.
		 * @see FactoryPages410_AdminPage
		 *
		 * @since 1.0.0
		 * @var string
		 */
		public $id = "themes";

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
		private $themes_update_filters = array();

		/**
		 * @param Wbcr_Factory409_Plugin $plugin
		 */
		public function __construct(Wbcr_Factory409_Plugin $plugin)
		{
			$this->menu_title = __('Themes', 'webcraftic-updates-manager');

			parent::__construct($plugin);

			$updates_mode = $this->getPopulateOption('theme_updates');

			$this->is_disable_updates = $updates_mode == 'disable_theme_updates';
			$this->is_auto_updates = $updates_mode == 'enable_theme_auto_updates';
			$this->is_disable_translation_updates = $this->getPopulateOption('auto_tran_update');
			$this->themes_update_filters = $this->getPopulateOption('themes_update_filters');
		}

		public function warningNotice()
		{
			parent::warningNotice();

			$concat = '';

			if( $this->is_disable_updates ) {
				$concat .= __('- To disable updates individually choose the “Manual or automatic theme updates” option then save settings and comeback to this page.', 'webcraftic-updates-manager') . '<br>';
			}

			if( !$this->is_auto_updates ) {
				$concat .= __('- To configure theme auto updates individually, choose the “Enable auto updates” option then save settings and comeback to this page.', 'webcraftic-updates-manager');
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

		public function saveThemesUpdateFilters()
		{
			$this->plugin->updateOption('themes_update_filters', $this->themes_update_filters);
		}

		public function disableThemeUpdatesAction()
		{
			if( !$this->is_disable_updates ) {
				$theme_slug = $this->request->get('theme_slug', null, true);

				check_admin_referer($this->getResultId() . '_' . $theme_slug);

				if( !empty($theme_slug) ) {
					if( isset($this->themes_update_filters['disable_updates']) ) {
						if( !isset($this->themes_update_filters['disable_updates'][$theme_slug]) ) {
							$this->themes_update_filters['disable_updates'][$theme_slug] = true;
						}
					} else {
						$this->themes_update_filters['disable_updates'] = array();
						$this->themes_update_filters['disable_updates'][$theme_slug] = true;
					}

					$this->saveThemesUpdateFilters();
				}
			}

			$this->redirectToAction('index');
		}

		public function enableThemeUpdatesAction()
		{
			if( !$this->is_disable_updates ) {
				$theme_slug = $this->request->get('theme_slug', null, true);

				check_admin_referer($this->getResultId() . '_' . $theme_slug);

				if( !empty($theme_slug) ) {
					if( isset($this->themes_update_filters['disable_updates']) && isset($this->themes_update_filters['disable_updates'][$theme_slug]) ) {
						unset($this->themes_update_filters['disable_updates'][$theme_slug]);
						$this->saveThemesUpdateFilters();
					}
				}
			}

			$this->redirectToAction('index');
		}

		public function disableThemeAutoupdatesAction()
		{
			if( $this->is_auto_updates ) {
				$theme_slug = $this->request->get('theme_slug', null, true);

				check_admin_referer($this->getResultId() . '_' . $theme_slug);

				if( !empty($theme_slug) ) {
					if( isset($this->themes_update_filters['disable_auto_updates']) ) {
						if( !isset($this->themes_update_filters['disable_auto_updates'][$theme_slug]) ) {
							$this->themes_update_filters['disable_auto_updates'][$theme_slug] = true;
						}
					} else {
						$this->themes_update_filters['disable_auto_updates'] = array();
						$this->themes_update_filters['disable_auto_updates'][$theme_slug] = true;
					}
					$this->saveThemesUpdateFilters();
				}
			}
			$this->redirectToAction('index');
		}

		public function enableThemeAutoupdatesAction()
		{
			if( $this->is_auto_updates ) {
				$theme_slug = $this->request->get('theme_slug', null, true);

				check_admin_referer($this->getResultId() . '_' . $theme_slug);

				if( !empty($theme_slug) ) {
					if( isset($this->themes_update_filters['disable_auto_updates']) && isset($this->themes_update_filters['disable_auto_updates'][$theme_slug]) ) {
						unset($this->themes_update_filters['disable_auto_updates'][$theme_slug]);
						$this->saveThemesUpdateFilters();
					}
				}
			}
			$this->redirectToAction('index');
		}

		public function disableThemeTranslationUpdatesAction()
		{
			$theme_slug = $this->request->get('theme_slug', null, true);
			check_admin_referer($this->getResultId() . '_' . $theme_slug);

			if( !empty($theme_slug) ) {
				if( !isset($this->themes_update_filters['disable_translation_updates']) ) {
					$this->themes_update_filters['disable_translation_updates'] = array();
				}
				$this->themes_update_filters['disable_translation_updates'][$theme_slug] = true;
				$this->saveThemesUpdateFilters();
			}

			$this->redirectToAction('index');
		}

		public function enableThemeTranslationUpdatesAction()
		{
			$theme_slug = $this->request->get('theme_slug', null, true);
			check_admin_referer($this->getResultId() . '_' . $theme_slug);

			if( !empty($theme_slug) ) {
				if( isset($this->themes_update_filters['disable_translation_updates']) && isset($this->themes_update_filters['disable_translation_updates'][$theme_slug]) ) {
					unset($this->themes_update_filters['disable_translation_updates'][$theme_slug]);
					$this->saveThemesUpdateFilters();
				}
			}
			$this->redirectToAction('index');
		}


		public function showPageContent()
		{
			if( isset($_POST['wbcr_upm_apply']) ) {

				$bulk_action = $this->request->post('wbcr_upm_bulk_actions', null, true);
				$theme_slugs = $this->request->post('theme_slugs', array(), true);

				$theme_slugs = array_map('strip_tags', $theme_slugs);

				check_admin_referer($this->getResultId() . '_form');
				// validate $bulk_action
				if( !empty($bulk_action) and !in_array($bulk_action, array(
						'disable_updates',
						'enable_updates',
						'enable_auto_updates',
						'disable_auto_updates',
						'disable_translation_updates',
						'enable_translation_updates',
					))
				) {
					$bulk_action = null;
				}

				if( !$this->is_disable_updates ) {
					if( !empty($bulk_action) && !empty($theme_slugs) && is_array($theme_slugs) ) {
						foreach((array)$theme_slugs as $slug) {

							if( $bulk_action == 'enable_updates' && isset($this->themes_update_filters['disable_updates']) && isset($this->themes_update_filters['disable_updates'][$slug]) ) {
								unset($this->themes_update_filters['disable_updates'][$slug]);
							}

							if( $bulk_action == 'enable_auto_updates' ) {
								if( $this->is_auto_updates ) {
									if( isset($this->themes_update_filters['disable_auto_updates']) && isset($this->themes_update_filters['disable_auto_updates'][$slug]) ) {
										unset($this->themes_update_filters['disable_auto_updates'][$slug]);
									}
								}
							} else {
								if( $bulk_action == 'disable_auto_updates' && !$this->is_auto_updates ) {
									continue;
								}

								$this->themes_update_filters[$bulk_action][$slug] = true;
							}

							if( $bulk_action == 'disable_translation_updates' ) {
								if( !$this->is_disable_translation_updates ) {
									$this->themes_update_filters['disable_translation_updates'][$slug] = true;
								}
							}
							if( $bulk_action == 'enable_translation_updates' && array_key_exists($slug, $this->themes_update_filters['disable_translation_updates']) ) {
								if( !$this->is_disable_translation_updates ) {
									unset($this->themes_update_filters['disable_translation_updates'][$slug]);
								}
							}
						}

						$this->saveThemesUpdateFilters();
					}
				}
			}
			$is_premium = defined('WUPMP_PLUGIN_ACTIVE');

			?>
			<div class="wbcr-factory-page-group-header">
				<strong<?= (!$is_premium ? ' class="wbcr-upm-group-header-pro"' : ''); ?>><?php _e('Themes list', 'webcraftic-updates-manager') ?></strong>

				<p>
					<?php _e('This page you can individually disable theme updates and auto updates.', 'webcraftic-updates-manager') ?>
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
					<select name="wbcr_upm_bulk_actions" id="wbcr_upm_bulk_actions" <?= (!$is_premium ? 'disabled' : ''); ?>>
						<option value="0"><?php _e('Bulk actions', 'webcraftic-updates-manager'); ?></option>
						<option value="disable_updates"><?php _e('Disable updates', 'webcraftic-updates-manager'); ?></option>
						<option value="enable_updates"><?php _e('Enable updates', 'webcraftic-updates-manager'); ?></option>
						<option value="enable_auto_updates"><?php _e('Enable auto-updates', 'webcraftic-updates-manager'); ?></option>
						<option value="disable_auto_updates"><?php _e('Disable auto-updates', 'webcraftic-updates-manager'); ?></option>
						<option value="disable_translation_updates"><?php _e('Disable translation updates', 'webcraftic-updates-manager'); ?></option>
						<option value="enable_translation_updates"><?php _e('Enable translation updates', 'webcraftic-updates-manager'); ?></option>
					</select>
					<input type="submit" name="wbcr_upm_apply" id="wbcr_upm_apply" class='button button-alt' value='<?php _e("Apply", "webcraftic-updates-manager"); ?>' <?= (!$is_premium) ? 'disabled' : ''; ?>>
				</p>
				<table class="wp-list-table wbcr-upm-list-table-pro widefat autoupdate striped plugins <?= (!$is_premium ? "wbcr-upm-column-premium" : ""); ?>">
					<thead>
					<tr>
						<th id='cb' class='manage-column column-cb check-column'>
                            <input class="wbcr_um_select_all" type="checkbox">
                        </th>
						<th id='name' class='manage-column column-name column-primary'>
							<strong><?php _e('Theme', 'webcraftic-updates-manager'); ?></strong></th>
						<th id="disable_updates">
							<strong><?php _e('Disable updates', 'webcraftic-updates-manager');?></strong>
						</th>
						<th id="disable_auto_updates">
							<strong><?php _e('Auto-updates', 'webcraftic-updates-manager'); ?></strong>
						</th>
						<th id="disable_translation_updates">
							<strong><?php _e('Translation updates', 'webcraftic-updates-manager'); ?></strong>
						</th>
					</tr>
					</thead>
					<tbody id="the-list">
					<?php
						$prefix = $this->plugin->getPrefix();
						foreach(wp_get_themes() as $key => $value):

							$actual_slug = $key;
							$slug_hash = md5($actual_slug);
							$description = $name = 'Empty';

							if( $value->Name ) {
								$name = $value->Name;
							}
							if( $value->Description ) {
								$description = $value->Description;
							}

							$class = 'active';
							$is_disable_updates = false;
							$is_auto_updates = true;
							$is_disable_translation_update = false;

							if( !empty($this->themes_update_filters) ) {

								if( isset($this->themes_update_filters['disable_auto_updates']) && isset($this->themes_update_filters['disable_auto_updates'][$actual_slug]) ) {
									$is_auto_updates = false;
								}
								if( (isset($this->themes_update_filters['disable_updates']) && isset($this->themes_update_filters['disable_updates'][$actual_slug])) ) {
									$class = 'inactive';
									$is_disable_updates = true;
								}
							}

							if( $this->is_disable_updates ) {
								$class = 'inactive row-global-disabled';
								$is_disable_updates = true;
							}

							if( !empty($this->themes_update_filters) ) {
								if( isset($this->themes_update_filters['disable_translation_updates']) && isset($this->themes_update_filters['disable_translation_updates'][$actual_slug]) ) {
									$is_disable_translation_update = true;
								}
							}

							?>
							<tr id="post-<?= esc_attr($slug_hash) ?>" class="<?= $class ?>">
								<td scope="row" class="check-column">
									<label class="screen-reader-text" for="cb-select-<?= esc_attr($slug_hash) ?>"><?php _e('Select', 'webcraftic-updates-manager') ?><?= esc_html($name) ?></label>
									<input id="cb-select-<?= esc_attr($slug_hash) ?>" class="wbcr_um_select_item" type="checkbox" name="theme_slugs[]" value="<?= esc_attr($actual_slug) ?>" <?= (!$is_premium ? 'disabled' : ''); ?>>
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
									<div class="factory-checkbox factory-from-control-checkbox factory-buttons-way btn-group">
										<?php
											$disabled = $this->is_disable_updates;
											$checked = false;
											if( $is_disable_updates ) {
												$checked = true;
											}
											if( !$is_premium ) {
												$disabled = true;
											}
										?>
										<button type="button" class="btn btn-default btn-small btn-sm factory-on <?= ($checked ? 'active' : ''); ?>"  <?= ($disabled ? 'disabled' : ''); ?>><?php _e('On', 'webcraftic-updates-manager'); ?></button>
										<button type="button" class="btn btn-default btn-small btn-sm factory-off <?= (!$checked) ? 'active' : ''; ?>" data-value="0"  <?= ($disabled ? 'disabled' : ''); ?>><?php _e('Off', 'webcraftic-updates-manager'); ?></button>
										<input type="checkbox" style="display: none" id="wbcr_updates_manager_disable_updates" class="factory-result factory-ajax-checkbox"
										       data-disable-group="<?= 'group-' . $slug_hash; ?>" data-action="Updates" data-theme-slug="<?= $actual_slug ?>" value="<?= (int)$checked ?>" <?= ($checked ? 'checked' : ''); ?>  <?= ($disabled ? 'disabled' : ''); ?>>
									</div>
								</td>
								<!-- отключить авто-обновления -->
								<td class="column-flags">
									<div class="factory-checkbox factory-from-control-checkbox factory-buttons-way btn-group <?= 'group-' . $slug_hash; ?>  <?= (!$is_premium or !$this->is_auto_updates) ? 'global-disabled' : ''; ?>">
										<?php
											$disabled = false;
											if( !$is_premium or !$this->is_auto_updates or $is_disable_updates ) {
												$disabled = true;
											}
											$checked = false;
											if( $is_auto_updates ) {
												$checked = true;
											}
										?>
										<button type="button" class="btn btn-default btn-small btn-sm factory-on <?= ($checked ? 'active' : ''); ?>"  <?= ($disabled ? 'disabled' : ''); ?>><?php _e('On', 'webcraftic-updates-manager'); ?></button>
										<button type="button" class="btn btn-default btn-small btn-sm factory-off <?= (!$checked) ? 'active' : ''; ?>" data-value="0"  <?= ($disabled ? 'disabled' : ''); ?>><?php _e('Off', 'webcraftic-updates-manager'); ?></button>
										<input type="checkbox" style="display: none" id="wbcr_updates_manager_disable_auto_updates" class="factory-result factory-ajax-checkbox"
										       data-action="AutoUpdates"  data-inverse="1" data-theme-slug="<?= $actual_slug ?>" value="<?= (int)$checked ?>" <?= ($checked ? 'checked' : ''); ?>  <?= ($disabled ? 'disabled' : ''); ?>>
									</div>
								</td>
								<!-- отключить обновления переводов -->
								<td class="column-flags">
									<div class="factory-checkbox factory-from-control-checkbox factory-buttons-way btn-group <?= 'group-' . $slug_hash; ?> <?= (!$is_premium or $this->is_disable_translation_updates) ? 'global-disabled' : ''; ?>">
										<?php
											$disabled = false;
											if( !$is_premium or $is_disable_updates or $this->is_disable_translation_updates ) {
												$disabled = true;
											}
											$checked = false;
											if( !$is_disable_translation_update ) {
												$checked = true;
											}
										?>
										<button type="button" class="btn btn-default btn-small btn-sm factory-on <?= ($checked ? 'active' : ''); ?>"  <?= ($disabled ? 'disabled' : ''); ?>><?php _e('On', 'webcraftic-updates-manager'); ?></button>
										<button type="button" class="btn btn-default btn-small btn-sm factory-off <?= (!$checked) ? 'active' : ''; ?>" data-value="0"  <?= ($disabled ? 'disabled' : ''); ?>><?php _e('Off', 'webcraftic-updates-manager'); ?></button>
										<input type="checkbox" style="display: none" id="wbcr_updates_manager_disable_translation_updates" class="factory-result factory-ajax-checkbox"
										       data-action="TranslationUpdates"  data-inverse="1"  data-theme-slug="<?= $actual_slug ?>" value="<?= (int)$checked ?>" <?= ($checked ? 'checked' : ''); ?>  <?= ($disabled ? 'disabled' : ''); ?>>
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