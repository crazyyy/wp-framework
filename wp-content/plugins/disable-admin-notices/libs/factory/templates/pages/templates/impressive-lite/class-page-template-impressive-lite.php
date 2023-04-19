<?php

namespace WBCR\Factory_Templates_116;

/**
 * Impressive lite page template class
 *
 * @author        Alex Kovalev <alex.kovalevv@gmail.com>
 * @author        Artem Prikhodko <webtemyk@yandex.ru>
 * @since         1.0.0
 * @package       factory-pages
 * @copyright (c) 2021, Webcraftic Ltd
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WBCR\Factory_Templates_116\ImpressiveLite' ) ) {
	/**
	 * Class Wbcr_FactoryPages466_ImpressiveLiteTemplate
	 */
	abstract class ImpressiveLite extends \WBCR\Factory_Templates_116\Pages\PageBase {

		/**
		 * Requests assets (js and css) for the page.
		 *
		 * @return void
		 * @since 1.0.0
		 *
		 */
		public function assets( $scripts, $styles ) {

			$this->scripts->request( 'jquery' );

			$this->scripts->request( [
				'control.checkbox',
				'control.dropdown',
				'bootstrap.tooltip',
				'holder.more-link'
			], 'bootstrap' );

			$this->styles->request( [
				'bootstrap.core',
				'bootstrap.form-group',
				'bootstrap.separator',
				'control.dropdown',
				'control.checkbox',
				'holder.more-link'
			], 'bootstrap' );

			$this->styles->add( FACTORY_TEMPLATES_116_URL . '/pages/templates/impressive-lite/assets/css/impressive-lite.page.template.css' );
		}

		public function getPluginTitle() {
			$plugin_title = apply_filters( 'wbcr/factory/pages/impressiveLite/plugin_title', $this->plugin->getPluginTitle(), $this->plugin->getPluginName() );

			return $plugin_title;
		}

		/**
		 * @param int $a
		 * @param int $b
		 *
		 * @return bool
		 */
		protected function pageMenuSort( $a, $b ) {
			return $a['position'] <=> $b['position'];
		}

		/**
		 * Set page menu item
		 */
		public function setPageMenu() {
			global $factory_impressive_page_menu;

			$dashicon          = ( ! empty( $this->page_menu_dashicon ) ) ? ' ' . $this->page_menu_dashicon : '';
			$short_description = ( ! empty( $this->page_menu_short_description ) ) ? ' ' . $this->page_menu_short_description : '';

			if ( is_multisite() && is_network_admin() && ! $this->network ) {
				return;
			}

			$factory_impressive_page_menu[ $this->getMenuScope() ][ $this->getResultId() ] = [
				'type'              => $this->type, // page, options
				'url'               => $this->getBaseUrl(),
				'title'             => $this->getMenuSubTitle(),
				'icon'              => "<span class='dashicons {$dashicon}'></span>",
				'short_description' => $short_description,
				'position'          => $this->page_menu_position,
				'parent'            => $this->page_parent_page,
				'show_tab'          => $this->show_menu_tab,
			];
		}

		protected function showHeader() {
			?>
            <style>
                .updated, .notice, .error
                {
                    display: none !important;
                }
            </style>

            <div class="wbcr-factory-page-header">
                <div class="wbcr-factory-header-logo"><?php echo $this->getPluginTitle(); ?>
                    <span class="version"><?php echo $this->plugin->getPluginVersion() ?> </span>
					<?php if ( $this->show_page_title ): ?>
                        <span class="dash">/</span>
                        <div class="wbcr-factory-header-title">
                            <h2><?php echo $this->getPageTitle() ?></h2>
                        </div>
					<?php endif; ?>
                </div>
                <div class="wbcr-factory-control">
					<?php do_action( 'wbcr/factory/pages/impressive_lite/header', $this->plugin->getPluginName() ) ?>
                </div>
            </div>
			<?php $this->showPageSubMenu(); ?>

			<?php
		}

		protected function showPageSubMenu() {
			$page_menu    = $this->getPageMenu();
			$self_page_id = $this->plugin->getPrefix() . $this->getResultId();
			$current_page = isset( $page_menu[ $self_page_id ] ) ? $page_menu[ $self_page_id ] : null;

			$parent_page_id = ! empty( $current_page['parent'] ) ? $this->getResultId( $current_page['parent'] ) : null;

			uasort( $page_menu, [ $this, 'pageMenuSort' ] );

			?>
            <div class="w-factory-templates-116-horizontal-menu wp-clearfix">
				<?php foreach ( (array) $page_menu as $page_screen => $page ): ?>
					<?php
					if ( ! $page['show_tab'] ) {
						continue;
					}
					$active_tab = '';
					if ( $page_screen == $this->getResultId() ) {
						$active_tab = ' w-factory-templates-116-horizontal-menu__nav-tab-active';
					}
					?>
                    <a href="<?php echo $page['url'] ?>" id="<?php echo esc_attr( $page_screen ) ?>-tab"
                       class="w-factory-templates-116-horizontal-menu__nav-tab<?php echo esc_attr( $active_tab ) ?>">
                        <span><?php echo $page['icon']; ?></span>
                        <span class="wbcr-nav-tab-title"><?php echo $page['title']; ?></span>
                    </a>
				<?php endforeach; ?>
            </div>
			<?php
		}

		protected function showBottomSidebar() {
			$widgets = $this->getPageWidgets( 'bottom' );

			if ( empty( $widgets ) ) {
				return;
			}
			?>
            <div class="row">
                <div class="wbcr-factory-bottom-sidebar">
					<?php foreach ( $widgets as $widget_content ): ?>
                        <div class="wbcr-factory-bottom-sidebar-widget">
							<?php echo $widget_content ?>
                        </div>
					<?php endforeach; ?>
                </div>
            </div>
			<?php
		}

		protected function showOptions() {
			$form = new \Wbcr_FactoryForms463_Form( [
				'scope' => rtrim( $this->plugin->getPrefix(), '_' ),
				'name'  => $this->getResultId() . "-options"
			], $this->plugin );

			$form->setProvider( new \Wbcr_FactoryForms463_OptionsValueProvider( $this->plugin ) );

			$options = $this->getPageOptions();

			if ( isset( $options[0] ) && isset( $options[0]['items'] ) && is_array( $options[0]['items'] ) ) {
				foreach ( $options[0]['items'] as $key => $value ) {

					if ( $value['type'] == 'div' || $value['type'] == 'more-link' ) {
						if ( isset( $options[0]['items'][ $key ]['items'] ) && ! empty( $options[0]['items'][ $key ]['items'] ) ) {
							foreach ( $options[0]['items'][ $key ]['items'] as $group_key => $group_value ) {
								$options[0]['items'][ $key ]['items'][ $group_key ]['layout']['column-left']  = '4';
								$options[0]['items'][ $key ]['items'][ $group_key ]['layout']['column-right'] = '8';
							}

							continue;
						}
					}

					if ( in_array( $value['type'], [
						'checkbox',
						'textarea',
						'integer',
						'textbox',
						'dropdown',
						'list',
						'wp-editor'
					] ) ) {
						$options[0]['items'][ $key ]['layout']['column-left']  = '4';
						$options[0]['items'][ $key ]['layout']['column-right'] = '8';
					}
				}
			}

			$form->add( $options );

			if ( isset( $_POST[ $this->plugin->getPluginName() . '_save_action' ] ) ) {

				check_admin_referer( 'wbcr_factory_' . $this->getResultId() . '_save_action' );

				if ( ! current_user_can( 'administrator' ) && ! current_user_can( $this->capabilitiy ) ) {
					wp_die( __( 'You do not have permission to edit page.', 'wbcr_factory_pages_466' ) );
				}

				/**
				 * @since 4.0.1 - добавлен
				 * @since 4.0.9 - изменено имя
				 */
				do_action( 'wbcr/factory/pages/impressive_lite/before_form_save', $form, $this->plugin, $this );

				$this->beforeFormSave();

				$form->save();

				/**
				 * @since 4.0.1 - добавлен
				 * @since 4.0.9 - изменено имя
				 */
				do_action( 'wbcr/factory/pages/impressive_lite/form_saved', $form, $this->plugin, $this );

				$this->formSaved();

				$this->redirectToAction( 'flush-cache-and-rules', [
					'_wpnonce' => wp_create_nonce( 'wbcr_factory_' . $this->getResultId() . '_flush_action' )
				] );
			}

			?>
            <div id="WBCR" class="wrap">
                <div class="wbcr-factory-templates-116-impressive-lite-page-template factory-bootstrap-467 factory-fontawesome-000">
                    <div class="wbcr-factory-options wbcr-factory-options-<?php echo esc_attr( $this->id ) ?>">
						<?php $this->showHeader(); ?>
                        <div class="wbcr-factory-page-inner-wrap">
                            <div class="wbcr-factory-content-section<?php if ( ! $this->isShowRightSidebar() ): echo ' wbcr-fullwidth'; endif ?>">
								<?php //$this->showPageSubMenu()
								?>
                                <div class="wbcr-factory-content">
                                    <form method="post" class="form-horizontal">
										<?php
										if ( $this->type == 'options' ) {
											wp_nonce_field( 'wbcr_factory_' . $this->getResultId() . '_save_action' );
											$submit_button = "<input name='{$this->plugin->getPluginName()}_save_action'
                                                   class='wbcr-factory-button wbcr-save-button' type='submit'
                                                   value='" . __( 'Save', 'wbcr_factory_pages_466' ) . "'>";
										}
										?>
										<?php $this->printAllNotices(); ?>
										<?php $form->html(); ?>
										<?php echo $submit_button; ?>
                                    </form>
                                </div>
                            </div>
							<?php if ( $this->isShowRightSidebar() ): ?>
                                <div class="wbcr-factory-right-sidebar-section">
									<?php $this->showRightSidebar(); ?>
                                </div>
							<?php endif; ?>
                        </div>
                    </div>
					<?php
					if ( $this->show_bottom_sidebar ) {
						$this->showBottomSidebar();
					}
					?>
                    <div class="clearfix"></div>
                </div>
            </div>

			<?php
		}

		protected function showPage( $content = null ) { ?>
            <div id="WBCR" class="wrap">
                <div class="wbcr-factory-templates-116-impressive-lite-page-template factory-bootstrap-467 factory-fontawesome-000">
                    <div class="wbcr-factory-page wbcr-factory-page-<?php echo $this->id ?>">
						<?php $this->showHeader(); ?>
						<?php
						$min_height = 0;
						foreach ( $this->getPageMenu() as $page ) {
							if ( ! isset( $page['parent'] ) || empty( $page['parent'] ) ) {
								$min_height += 77;
							}
						}
						?>
                        <div class="wbcr-factory-page-inner-wrap">
                            <div class="wbcr-factory-content-section<?php if ( ! $this->isShowRightSidebar() ): echo ' wbcr-fullwidth'; endif ?>">
								<?php //$this->showPageSubMenu();
								?>
                                <div class="wbcr-factory-content" style="min-height:<?php echo $min_height ?>px">
									<?php $this->printAllNotices(); ?>
									<?php if ( empty( $content ) ): ?>
										<?php $this->showPageContent() ?>
									<?php else: ?>
										<?php echo $content; ?>
									<?php endif; ?>
                                </div>
                            </div>
							<?php if ( $this->isShowRightSidebar() ): ?>
                                <div class="wbcr-factory-right-sidebar-section" style="min-height:<?php echo $min_height ?>px">
									<?php $this->showRightSidebar(); ?>
                                </div>
							<?php endif; ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
					<?php $this->showBottomSidebar(); ?>
                </div>
            </div>
			<?php
		}
	}
}

