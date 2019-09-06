<?php

	/**
	 * Общий класс прослойка для страниц Clearfy и его компоннетов.
	 * В этом классе добавляются общие ресурсы и элементы, необходимые для всех связанных плагинов.
	 *
	 * Author: Webcraftic <wordpress.webraftic@gmail.com>
	 * Version: 1.1.0
	 * @since 2.0.5
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	/**
	 * Class Wbcr_FactoryPages410_ImpressiveThemplate
	 *
	 * @method string getInfoWidget() - get widget content information
	 * @method string getRatingWidget(array $args = array()) - get widget content rating
	 * @method string getDonateWidget() - get widget content donate
	 * @method string getBusinessSuggetionWidget()
	 */

	if( !class_exists('Wbcr_FactoryClearfy206_PageBase') && class_exists('Wbcr_FactoryPages410_ImpressiveThemplate') ) {

		class Wbcr_FactoryClearfy206_PageBase extends Wbcr_FactoryPages410_ImpressiveThemplate {

			/**
			 * Показывать правый сайдбар?
			 * Сайдбар будет показан на внутренних страницах шаблона.
			 *
			 * @var bool
			 */
			public $show_right_sidebar_in_options = true;

			/**
			 * Страница доступна в меню суперадмнистратора (режим мультисайтов)
			 *
			 * @var bool
			 */
			public $available_for_multisite = true;

			/**
			 * Показывать нижний сайдбар?
			 * Сайдбар будет показан на внутренних страницах шаблона.
			 *
			 * @var bool
			 */
			//public $show_bottom_sidebar = false;

			/**
			 * @param Wbcr_Factory409_Plugin $plugin
			 */
			public function __construct(Wbcr_Factory409_Plugin $plugin)
			{
				parent::__construct($plugin);
			}

			/**
			 * @param $name
			 * @param $arguments
			 * @return null|string
			 */
			public function __call($name, $arguments)
			{
				if( substr($name, 0, 3) == 'get' ) {
					$called_method_name = 'show' . substr($name, 3);
					if( method_exists($this, $called_method_name) ) {
						ob_start();

						$this->$called_method_name($arguments);
						$content = ob_get_contents();
						ob_end_clean();

						return $content;
					}
				}

				return null;
			}

			/**
			 * Requests assets (js and css) for the page.
			 *
			 * @see Wbcr_FactoryPages410_AdminPage
			 *
			 * @param Wbcr_Factory409_ScriptList $scripts
			 * @param Wbcr_Factory409_StyleList $styles
			 * @return void
			 */
			public function assets($scripts, $styles)
			{
				parent::assets($scripts, $styles);

				$this->styles->add(FACTORY_CLEARFY_206_URL . '/assets/css/clearfy-base.css');

				// todo: вынести все общие скрипты и стили фреймворка, продумать совместимость с другими плагинами
				if( defined('WCL_PLUGIN_URL') ) {
					$this->styles->add(WCL_PLUGIN_URL . '/admin/assets/css/general.css');
				}

				wbcr_factory_409_do_action_deprecated('wbcr_clearfy_page_enqueue_scripts', array(
					$this->getResultId(),
					$scripts,
					$styles
				), '1.4.0', 'wbcr/clearfy/page_assets');

				/**
				 * Allows you to enqueue scripts to the internal pages of the plugin.
				 * $this->getResultId() - page id + plugin name = quick_start-wbcr_clearfy
				 * @since 2.0.5
				 */
				do_action('wbcr/clearfy/page_assets', $this->getResultId(), $scripts, $styles);
			}

			/**
			 * @return Wbcr_Factory409_Request
			 */
			public function request()
			{
				return $this->plugin->request;
			}

			/**
			 * @since 2.0.5
			 * @param $option_name
			 * @param bool $default *
			 * @return mixed|void
			 */
			public function getPopulateOption($option_name, $default = false)
			{
				return $this->plugin->getPopulateOption($option_name, $default);
			}

			/**
			 * @param $option_name
			 * @param bool $default
			 * @return mixed|void
			 */
			public function getOption($option_name, $default = false)
			{
				return $this->plugin->getOption($option_name, $default);
			}

			/**
			 * @param $option_name
			 * @param $value
			 * @return void
			 */
			public function updatePopulateOption($option_name, $value)
			{
				$this->plugin->updatePopulateOption($option_name, $value);
			}

			/**
			 * @param $option_name
			 * @param $value
			 * @return void
			 */
			public function updateOption($option_name, $value)
			{
				$this->plugin->updateOption($option_name, $value);
			}

			/**
			 * @param $option_name
			 * @return void
			 */
			public function deletePopulateOption($option_name)
			{
				$this->plugin->deletePopulateOption($option_name);
			}

			/**
			 * @param $option_name
			 * @return void
			 */
			public function deleteOption($option_name)
			{
				$this->plugin->deleteOption($option_name);
			}


			/**
			 * Действие выполняется для всех страниц Clearfy и его компонентах.
			 * Это простое предложение перейти на PRO версию.
			 */
			public function multisiteProAction()
			{
				if( is_multisite() && $this->plugin->isNetworkActive() ) {

					$license_page_url = $this->getBaseUrl('license');
					$upgrade_url = WbcrFactoryClearfy206_Helpers::getWebcrafticSitePageUrl($this->plugin->getPluginName(), 'pricing', 'multisite_save_settings');
					$upgrade_price = WbcrFactoryClearfy206_Helpers::getClearfyBusinessPrice();

					$html = '<div class="wbcr-factory-clearfy-206-multisite-suggetion">';
					$html .= '<div class="wbcr-factory-inner-contanier">';
					$html .= '<h3>' . __('Upgrade to Clearfy Business', 'wbcr_factory_clearfy_206') . '</h3>';
					$html .= '<p>' . __('Oops... Sorry for the inconvenience caused!', 'wbcr_factory_clearfy_206') . '</p>';
					$html .= '<p>' . __('Complete multisite support is available in Clearfy Business and Clearfy Business Revolution packages only!', 'wbcr_factory_clearfy_206') . '</p>';
					$html .= '<p>' . __('You can activate the plugin on each website and use it with zero limitations. But you can’t save the plugin’s settings under the Super Administrator role!', 'wbcr_factory_clearfy_206') . '</p>';
					$html .= '<p style="margin-top:20px">';
					$html .= '<a href="' . $license_page_url . '" class="wbcr-factory-activate-premium" rel="noopener">' . __('Activate license ', 'wbcr_factory_clearfy_206') . '</a> ';
					$html .= '<a href="' . $upgrade_url . '" class="wbcr-factory-purchase-premium" target="_blank" rel="noopener">' . sprintf(__('Upgrade to Clearfy Business for $%d', 'wbcr_factory_clearfy_206'), $upgrade_price) . '</a>';
					$html .= '</p>';
					$html .= '</div>';
					$html .= '</div>';

					$this->showPage($html);

					return;
				}

				$this->redirectToAction('index');
			}

			/**
			 * @param string $position
			 * @return mixed|void
			 */
			protected function getPageWidgets($position = 'bottom')
			{
				$widgets = array();

				if( $position == 'bottom' ) {
					$widgets['info_widget'] = $this->getInfoWidget();
					$widgets['rating_widget'] = $this->getRatingWidget();
					$widgets['donate_widget'] = $this->getDonateWidget();
				} else if( $position == 'right' ) {
					$widgets['businnes_suggetion'] = $this->getBusinessSuggetionWidget();
					$widgets['info_widget'] = $this->getInfoWidget();
					$widgets['rating_widget'] = $this->getRatingWidget();
				}

				/**
				 * @since 4.0.9 - является устаревшим
				 */
				$widgets = wbcr_factory_409_apply_filters_deprecated('wbcr_factory_pages_410_imppage_get_widgets', array(
					$widgets,
					$position,
					$this->plugin,
					$this
				), '4.0.9', 'wbcr/factory/pages/impressive/widgets');

				/**
				 * @since 4.0.1 - добавлен
				 * @since 4.0.9 - изменено имя
				 */
				$widgets = apply_filters('wbcr/factory/pages/impressive/widgets', $widgets, $position, $this->plugin, $this);

				return $widgets;
			}

			public function showBusinessSuggetionWidget()
			{
				$upgrade_price = WbcrFactoryClearfy206_Helpers::getClearfyBusinessPrice();

				$features = array(
					'4_premium' => __('4 premium components now;', 'wbcr_factory_clearfy_206'),
					'40_premium' => __('40 new premium components within a year for the single price;', 'wbcr_factory_clearfy_206'),
					'multisite_support' => __('Multisite support;', 'wbcr_factory_clearfy_206'),
					'advance_settings' => __('Advanced settings;', 'wbcr_factory_clearfy_206'),
					'no_ads' => __('No ads;', 'wbcr_factory_clearfy_206'),
					'perfect_support' => __('Perfect support.', 'wbcr_factory_clearfy_206')
				);

				/**
				 * @since 2.0.6
				 */
				$features = apply_filters('wbcr/clearfy/page_bussines_suggetion_features', $features, $this->plugin->getPluginName(), $this->id);

				?>
				<div class="wbcr-factory-sidebar-widget wbcr-factory-clearfy-206-pro-suggettion">
					<h3><?php _e('MORE IN CLEARFY <span>BUSINESS</span>', 'wbcr_factory_clearfy_206')?></h3>
					<ul>
						<?php if( !empty($features) ): ?>
							<?php foreach($features as $feature): ?>
								<li><?= $feature ?></li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>
					<a href="<?= WbcrFactoryClearfy206_Helpers::getWebcrafticSitePageUrl($this->plugin->getPluginName(), 'pricing', 'right_sidebar_ads') ?>" class="wbcr-factory-purchase-premium" target="_blank" rel="noopener">
						<?php printf(__('Upgrade for $%s', 'wbcr_factory_clearfy_206'), $upgrade_price) ?>
					</a>
				</div>
			<?php
			}

			public function showInfoWidget()
			{
				?>
				<div class="wbcr-factory-sidebar-widget">
					<ul>
						<li>
						<span class="wbcr-factory-hint-icon-simple wbcr-factory-simple-red">
							<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAQAAABKmM6bAAAAUUlEQVQIHU3BsQ1AQABA0X/komIrnQHYwyhqQ1hBo9KZRKL9CBfeAwy2ri42JA4mPQ9rJ6OVt0BisFM3Po7qbEliru7m/FkY+TN64ZVxEzh4ndrMN7+Z+jXCAAAAAElFTkSuQmCC" alt=""/>
						</span>
							- <?php _e('A neutral setting that can not harm your site, but you must be sure that you need to use it.', 'wbcr_factory_clearfy_206'); ?>
						</li>
						<li>
						<span class="wbcr-factory-hint-icon-simple wbcr-factory-simple-grey">
							<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAQAAABKmM6bAAAAUUlEQVQIHU3BsQ1AQABA0X/komIrnQHYwyhqQ1hBo9KZRKL9CBfeAwy2ri42JA4mPQ9rJ6OVt0BisFM3Po7qbEliru7m/FkY+TN64ZVxEzh4ndrMN7+Z+jXCAAAAAElFTkSuQmCC" alt=""/>
						</span>
							- <?php _e('When set this option, you must be careful. Plugins and themes may depend on this function. You must be sure that you can disable this feature for the site.', 'wbcr_factory_clearfy_206'); ?>
						</li>
						<li>
						<span class="wbcr-factory-hint-icon-simple wbcr-factory-simple-green">
							<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAQAAABKmM6bAAAAUUlEQVQIHU3BsQ1AQABA0X/komIrnQHYwyhqQ1hBo9KZRKL9CBfeAwy2ri42JA4mPQ9rJ6OVt0BisFM3Po7qbEliru7m/FkY+TN64ZVxEzh4ndrMN7+Z+jXCAAAAAElFTkSuQmCC" alt=""/>
						</span>
							- <?php _e('Absolutely safe setting, We recommend to use.', 'wbcr_factory_clearfy_206'); ?>
						</li>
					</ul>
					----------<br>

					<p><?php _e('Hover to the icon to get help for the feature you selected.', 'wbcr_factory_clearfy_206'); ?></p>
				</div>
			<?php
			}

			public function showRatingWidget(array $args)
			{
				if( !isset($args[0]) || empty($args[0]) ) {
					$page_url = "https://goo.gl/tETE2X";
				} else {
					$page_url = $args[0];
				}

				$page_url = apply_filters('wbcr_factory_pages_410_imppage_rating_widget_url', $page_url, $this->plugin->getPluginName(), $this->getResultId());

				?>
				<div class="wbcr-factory-sidebar-widget">
					<p>
						<strong><?php _e('Do you want the plugin to improved and update?', 'wbcr_factory_clearfy_206'); ?></strong>
					</p>

					<p><?php _e('Help the author, leave a review on wordpress.org. Thanks to feedback, I will know that the plugin is really useful to you and is needed.', 'wbcr_factory_clearfy_206'); ?></p>

					<p><?php _e('And also write your ideas on how to extend or improve the plugin.', 'wbcr_factory_clearfy_206'); ?></p>

					<p>
						<i class="wbcr-factory-icon-5stars"></i>
						<a href="<?= $page_url ?>" title="Go rate us" target="_blank">
							<strong><?php _e('Go rate us and push ideas', 'wbcr_factory_clearfy_206'); ?></strong>
						</a>
					</p>
				</div>
			<?php
			}

			public function showDonateWidget()
			{
				?>
				<div class="wbcr-factory-sidebar-widget">
					<p>
						<strong><?php _e('Donation for plugin development', 'wbcr_factory_clearfy_206'); ?></strong>
					</p>

					<?php if( get_locale() !== 'ru_RU' ): ?>
						<form id="wbcr-factory-paypal-donation-form" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="VDX7JNTQPNPFW">

							<div class="wbcr-factory-donation-price">5$</div>
							<input type="image" src="<?= FACTORY_PAGES_410_URL ?>/templates/assets/img/paypal-donate.png" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
						</form>
					<?php else: ?>
						<iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/donate.xml?account=410011242846510&quickpay=donate&payment-type-choice=on&mobile-payment-type-choice=on&default-sum=300&targets=%D0%9D%D0%B0+%D0%BF%D0%BE%D0%B4%D0%B4%D0%B5%D1%80%D0%B6%D0%BA%D1%83+%D0%BF%D0%BB%D0%B0%D0%B3%D0%B8%D0%BD%D0%B0+%D0%B8+%D1%80%D0%B0%D0%B7%D1%80%D0%B0%D0%B1%D0%BE%D1%82%D0%BA%D1%83+%D0%BD%D0%BE%D0%B2%D1%8B%D1%85+%D1%84%D1%83%D0%BD%D0%BA%D1%86%D0%B8%D0%B9.+&target-visibility=on&project-name=Webcraftic&project-site=&button-text=05&comment=on&hint=%D0%9A%D0%B0%D0%BA%D1%83%D1%8E+%D1%84%D1%83%D0%BD%D0%BA%D1%86%D0%B8%D1%8E+%D0%BD%D1%83%D0%B6%D0%BD%D0%BE+%D0%B4%D0%BE%D0%B1%D0%B0%D0%B2%D0%B8%D1%82%D1%8C+%D0%B2+%D0%BF%D0%BB%D0%B0%D0%B3%D0%B8%D0%BD%3F&mail=on&successURL=" width="508" height="187"></iframe>
					<?php endif; ?>
				</div>
			<?php
			}
		}
	}

