<?php
	/**
	 * A group of classes and methods to create and manage notices.
	 *
	 * @author Alex Kovalev <alex.kovalevv@gmail.com>
	 * @copyright (c) 2018 Webcraftic Ltd
	 *
	 * @package factory-notices
	 * @since 1.0.0
	 */
	
	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}
	
	/**
	 * A class to manage notices.
	 *
	 * @since 1.0.0
	 */
	if( !class_exists('Wbcr_FactoryNotices410') ) {

		class Wbcr_FactoryNotices410 {

			/**
			 * @var Wbcr_Factory457_Plugin
			 */
			protected $plugin;
			/**
			 * @var array
			 */
			protected $notices = array();

			/**
			 * @var array
			 */
			protected $default_where = array(
				'plugins',
				'themes',
				'dashboard',
				'edit',
				'settings',
				'dashboard-network',
				'plugins-network',
				'themes-network',
				'settings-network',
			);

			/**
			 * @var array
			 */
			private $dissmised_notices;
			
			/**
			 * Инициализируем уведомлений сразу после загрузки модуля уведомлений
			 */
			public function __construct()
			{
				add_action('wbcr_factory_notices_410_plugin_created', array($this, 'init'));
			}

			/**
			 * @param Wbcr_Factory457_Plugin $plugin
			 */
			public function init(Wbcr_Factory457_Plugin $plugin)
			{
				//default notices
				//---

				$this->plugin = $plugin;
				$this->dissmised_notices = $this->plugin->getPopulateOption('factory_dismissed_notices', array());

				add_action('current_screen', array($this, 'currentScreenAction'));

				if( defined('DOING_AJAX') && DOING_AJAX ) {
					add_action('wp_ajax_' . $this->plugin->getPluginName() . '_dismiss_notice', array(
						$this,
						'dismissNotice'
					));
				}
			}

			/**
			 * Регистрирует экшены для работы с уведомлениями на текущем экране странице.
			 * Уведомления собираются через фильтр wbcr_factory_admin_notices, если в массиве уведомлений,
			 * хотя бы одно, соответствует условиям в параметре $notice['where'], то метод печает вспомогательные скрипты и уведомления.
			 */
			public function currentScreenAction()
			{
				$this->notices = apply_filters('wbcr_factory_notices_410_list', $this->notices, $this->plugin->getPluginName());

				$this->notices = wbcr_factory_457_apply_filters_deprecated('wbcr_factory_admin_notices', array(
					$this->notices,
					$this->plugin->getPluginName()
				), '4.0.5', 'wbcr_factory_notices_410_list');

				if( count($this->notices) == 0 ) {
					return;
				}

				$screen = get_current_screen();

				$has_notices = false;
				foreach($this->notices as $notice) {

					if( !isset($notice['id']) ) {
						continue;
					}

					$where = !isset($notice['where']) || empty($notice['where']) ? $this->default_where : $notice['where'];

					if( in_array($screen->base, $where) && !$this->isDissmissed($notice['id']) ) {
						$has_notices = true;
						break;
					};
				}

				if( $has_notices ) {
					add_action('admin_footer', array($this, 'printNoticesScripts'));

					if( $this->plugin->isNetworkActive() ) {
						if( current_user_can('manage_network') ) {
							add_action('network_admin_notices', array($this, 'showNotices'));
							add_action('admin_notices', array($this, 'showNotices'));
						}
					} else {
						add_action('admin_notices', array($this, 'showNotices'));
					}
				}
			}

			/**
			 * Показывает все зарегистрированные уведомления для текущего плагина.
			 * Уведомления показываются только на определенных страницах через параметр $notice['where'],
			 * если уведомление ранее было скрыто или не соотвествует правилам $notice['where'], оно не будет показано!
			 */
			public function showNotices()
			{
				if( count($this->notices) == 0 ) {
					return;
				}

				if( !current_user_can('activate_plugins') || !current_user_can('edit_plugins') || !current_user_can('install_plugins') ) {
					return;
				}

				$screen = get_current_screen();

				foreach($this->notices as $notice) {

					if( !isset($notice['id']) ) {
						continue;
					}

					$where = !isset($notice['where']) || empty($notice['where']) ? $this->default_where : $notice['where'];

					if( in_array($screen->base, $where) && !$this->isDissmissed($notice['id']) ) {
						$this->showNotice($notice);
					};
				}
			}

			/**
			 * Показывает уведомление, по переданным параметрам
			 * @param array $data - Параметры уведомления
			 * $data['id']    - Индентификатор уведомления
			 * $data['type'] - Тип уведомления (error, warning, success)
			 * $notice['where'] - На каких страницах показывать уведомление ('plugins', 'dashboard', 'edit')
			 * $data['text'] - Текст уведомления
			 * $data['dismissible'] - Если true, уведомление будет с кнопкой закрыть
			 * $data['dismiss_expires'] - Когда снова показать уведомление, нужно указывать время в unix timestamp.
			 * Пример time() + 3600 (1ч), уведомление будет скрыто на 1 час.
			 * $data['classes'] - Произвольный классы для контейнера уведомления.
			 */
			public function showNotice($data)
			{
				if( !isset($data['id']) || empty($data['id']) ) {
					return;
				}

				if( !isset($data['text']) || empty($data['text']) ) {
					return;
				}

				$type = !isset($data['type']) || empty($data['type']) ? 'error' : $data['type'];

				$dismissible = !isset($data['dismissible']) || empty($data['dismissible']) ? false : $data['dismissible'];

				$dismiss_expires = !isset($data['dismiss_expires']) || empty($data['dismiss_expires']) ? 0 : $data['dismiss_expires'];

				$classes = !isset($data['classes']) || empty($data['classes']) ? array() : $data['classes'];

				$plugin_name = str_replace('_', '-', $this->plugin->getPluginName());

				$classes = array_merge(array(
					'notice',
					'notice-' . $type,
					$plugin_name . '-factory-notice'
				), $classes);

				if( $dismissible ) {
					$classes[] = 'is-dismissible';
					$classes[] = $plugin_name . '-factory-notice-dismiss';
				}
				?>
				<div data-name="wbcr_factory_notice_<?= esc_attr($data['id']) ?>" data-expires="<?= esc_attr($dismiss_expires) ?>" data-nonce="<?= esc_attr(wp_create_nonce($this->plugin->getPluginName() . '_factory_dismiss_notice')); ?>" class="<?= esc_attr(implode(' ', $classes)) ?>">
					<?= $data['text'] ?>
				</div>
			<?php
			}

			/**
			 * Когда пользователь нажимает кнопку закрыть уведомление,
			 * отправляется ajax запрос с вызовом текущего метода
			 */
			public function dismissNotice()
			{
				check_admin_referer($this->plugin->getPluginName() . '_factory_dismiss_notice', 'nonce');

				// Имя уведомления (идентификатор)
				$name = empty($_POST['name']) ? null : sanitize_text_field($_POST['name']);

				// Время в Unix timestamp, по истечению, которого уведомление снова будет показано
				// Если передан 0, то уведомление будет скрыто навсегда
				$expires = !isset($_POST['expires']) || empty($_POST['expires']) ? 0 : (int)$_POST['expires'];

				if( empty($name) ) {
					echo json_encode(array('error' => 'Attribute name is empty!'));
					exit;
				}

				$notices = $this->plugin->getPopulateOption("factory_dismissed_notices", array());

				if( !empty($notices) ) {
					foreach((array)$notices as $notice_id => $notice_expires) {
						if( $notice_expires !== 0 && $notice_expires < time() ) {
							unset($notices[$notice_id]);
						}
					}
				}

				$notices[$name] = $expires;

				$this->plugin->updatePopulateOption('factory_dismissed_notices', $notices);

				echo json_encode(array('success' => 'ok'));
				exit;
			}

			/**
			 * Javascript code
			 * Печает в подвале страницы код, для взаимодействия с сервером через ajax,
			 * код используется при нажатии на кнопку закрыть уведомление.             *
			 */
			public function printNoticesScripts()
			{
				$plugin_name = str_replace('_', '-', $this->plugin->getPluginName());

				?>
				<script type="text/javascript">
					jQuery(function($) {

						$(document).on('click', '.<?php echo $plugin_name; ?>-factory-notice-dismiss .notice-dismiss', function() {
							$.post(ajaxurl, {
								'action': '<?php echo $this->plugin->getPluginName(); ?>_dismiss_notice',
								'name': $(this).parent().data('name'),
								'expires': $(this).parent().data('expires'),
								'nonce': $(this).parent().attr('data-nonce')
							});
						});

					});
				</script>
			<?php
			}


			/**
			 * Проверяет скрыто уведоление или нет
			 *
			 * @param string $notice_id - имя уведомления
			 * @return bool
			 */
			protected function isDissmissed($notice_id)
			{
				if( !empty($this->dissmised_notices) && isset($this->dissmised_notices['wbcr_factory_notice_' . $notice_id]) ) {
					$expires = (int)$this->dissmised_notices['wbcr_factory_notice_' . $notice_id];

					return $expires === 0 || $expires > time();
				}

				return false;
			}
		}

		new Wbcr_FactoryNotices410();
	}