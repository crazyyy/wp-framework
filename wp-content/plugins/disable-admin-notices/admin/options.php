<?php
/**
 * Регистрируем поля Html формы в Clearfy на странице "Подолнительно". Если этот плагин загружен, как отдельный плагин
 * то поля будет зарегистрированы для страницы общих настроек этого плагина.
 *
 * Github: https://github.com/alexkovalevv
 *
 * @author        Alexander Kovalev <alex.kovalevv@gmail.com>
 * @copyright (c) 2018 Webraftic Ltd
 * @version       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Регистрируем поля Html формы с настройками плагина.
 *
 * Эта функция используется для общей страницы настроек текущего плагина,
 * а также для раширения настроек в плагине Clearfy.
 *
 * @return array Возвращает группу зарегистрируемых опций
 * @since  1.0
 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
 */
function wbcr_dan_get_plugin_options() {
	$options = [];

	$options[] = [
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header">' . '<strong>' . __( 'Admin notifications, Update nags', 'disable-admin-notices' ) . '</strong>' . '<p>' . __( 'Do you know the situation, when some plugin offers you to update to premium, to collect technical data and shows many annoying notices? You are close these notices every now and again but they newly appears and interfere your work with WordPress. Even worse, some plugin’s authors delete “close” button from notices and they shows in your admin panel forever.', 'disable-admin-notices' ) . '</p>' . '</div>',
	];

	$hide_admin_notices_data = [
			[
					'not_hide',
					__( "Don't hide", 'disable-admin-notices' ),
					__( 'Do not hide notices and do not show “Hide notification forever” link for admin.', 'disable-admin-notices' ),
			],
			[
					'all',
					__( 'All notices', 'disable-admin-notices' ),
					__( 'Hide all notices globally.', 'disable-admin-notices' ) . sprintf( __( 'Watch the <a href="%s" target="_blank">video</a> to find out how it works .', 'disable-admin-notices' ), 'https://youtu.be/_Lv5i4P3Gqs' ),
			],
			[
					'only_selected',
					__( 'Only selected', 'disable-admin-notices' ),
					__( 'Hide selected notices only. You will see the link "Hide notification forever" in each notice. Push it and they will not bother you anymore.', 'disable-admin-notices' ) . sprintf( __( 'Watch the <a href="%s" target="_blank">video</a> to find out how it works .', 'disable-admin-notices' ), 'https://youtu.be/HazI81AsHuY' ),
			],
	];

	if ( ! wbcr_dan_is_active_clearfy_component() ) {
		$hide_admin_notices_data[] = [
				'compact_panel',
				__( 'Compact panel', 'disable-admin-notices' ),
				__( 'Collapse all notifications in one line (panel with notification counters), to see the notifications, you will need to click this panel.', 'disable-admin-notices' ) . sprintf( __( 'Watch the <a href="%s" target="_blank">video</a> to find out how it works .', 'disable-admin-notices' ), 'https://youtu.be/437u1Js2o2M' ),
		];
	}

	$options[] = [
			'type'     => 'dropdown',
			'name'     => 'hide_admin_notices',
			'way'      => 'buttons',
			'title'    => __( 'Hide admin notices', 'disable-admin-notices' ),
			'data'     => $hide_admin_notices_data,
			'layout'   => [ 'hint-type' => 'icon', 'hint-icon-color' => 'green' ],
			'hint'     => __( 'Some plugins shows notifications about premium version, data collecting or promote their services. Even if you push close button (that sometimes are impossible), notices are shows again in some time. This option allows you to control notices. Hide them all or each individually. Some plugins shows notifications about premium version, data collecting or promote their services. Even if you push close button (that sometimes are impossible), notices are shows again in some time. This option allows you to control notices. Hide them all or each individually.', 'disable-admin-notices' ),
			'default'  => 'only_selected',
			'cssClass' => ! ( WDN_Plugin::app()->premium->is_activate() && WDN_Plugin::app()->premium->is_install_package() ) ? [ 'wdanpro-radio-premium-label' ] : [],
			'events'   => [
					'all'           => [
							'show' => '.factory-control-hide_admin_notices_user_roles',
							'hide' => '.factory-control-reset_notices_button',
					],
					'only_selected' => [
							'hide' => '.factory-control-hide_admin_notices_user_roles',
							'show' => '.factory-control-reset_notices_button',
					],
					'not_hide'      => [
							'hide' => '.factory-control-hide_admin_notices_user_roles, .factory-control-reset_notices_button',
					],
			],
	];

	if ( ! wbcr_dan_is_active_clearfy_component() ) {
		$options[] = [
				'type'     => 'checkbox',
				'way'      => 'buttons',
				'name'     => 'disable_updates_nags_for_plugins',
				'title'    => __( 'Disable plugins updates nags', 'disable-admin-notices' ),
				'layout'   => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
				'hint'     => __( 'Disable plugins updates nags', 'disable-admin-notices' ),
				'cssClass' => ! ( WDN_Plugin::app()->premium->is_activate() && WDN_Plugin::app()->premium->is_install_package() ) ? [ 'factory-checkbox-disabled wdanpro-checkbox-premium-label' ] : [],
				'default'  => false,
		];

		$options[] = [
				'type'     => 'checkbox',
				'way'      => 'buttons',
				'name'     => 'disable_updates_nags_for_core',
				'title'    => __( 'Disable core updates nags', 'disable-admin-notices' ),
				'layout'   => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
				'hint'     => __( 'Disable core updates nags', 'disable-admin-notices' ),
				'cssClass' => ! ( WDN_Plugin::app()->premium->is_activate() && WDN_Plugin::app()->premium->is_install_package() ) ? [ 'factory-checkbox-disabled wdanpro-checkbox-premium-label' ] : [],
				'default'  => false,
		];
	}

	/*$options[] = array(
		'type' => 'dropdown',
		'name' => 'hide_admin_notices_for',
		'way' => 'buttons',
		'title' => __('Hide admin notices only for', 'disable-admin-notices'),
		'data' => array(
			array(
				'user',
				__('Current user', 'disable-admin-notices')
			),
			array(
				'all_users',
				__('All users', 'disable-admin-notices')
			)
		),
		'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'green'),
		'hint' => __('Choose who to hide notifications for?', 'disable-admin-notices'),
		'default' => 'user',
		'events' => array(
			'all' => array(
				'show' => '.factory-control-hide_admin_notices_user_roles',
				'hide' => '.factory-control-reset_notices_button'
			),
			'only_selected' => array(
				'hide' => '.factory-control-hide_admin_notices_user_roles',
				'show' => '.factory-control-reset_notices_button'
			),
			'not_hide' => array(
				'hide' => '.factory-control-hide_admin_notices_user_roles, .factory-control-reset_notices_button'
			)
		)
	);*/

	$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'show_notices_in_adminbar',
			'title'   => __( 'Enable hidden notices in adminbar', 'disable-admin-notices' ),
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'green' ],
			'hint'    => __( 'By default, the plugin hides all notices, which you specified. If you enable this option, the plugin will collect all hidden notices and show them into the top admin toolbar. It will not disturb you but will allow to look notices at your convenience.', 'disable-admin-notices' ),
			'default' => false,
	];

	$options[] = [
			'type' => 'html',
			'html' => 'wbcr_dan_reset_notices_button',
	];

	return $options;
}

function wbcr_dan_is_active_clearfy_component() {
	if ( defined( 'WCL_PLUGIN_ACTIVE' ) && class_exists( 'WCL_Plugin' ) ) {
		$deactivate_components = WCL_Plugin::app()->getPopulateOption( 'deactive_preinstall_components', [] );
		if ( ! in_array( 'disable_notices', $deactivate_components ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Расширяем опции html формы страницы "Дополнительно" в плагине Clearfy
 *
 * Это необходимо для того, чтобы не создавать отдельную страницу в плагине Clearfy, \
 * с настройками этого плагина, потому что это ухудшает юзабилити.
 *
 * @param array $form Массив с группой настроек, страницы "Дополнительно" в плагине Clearfy
 * @param Wbcr_FactoryPages466_ImpressiveThemplate $page Экземпляр страницы
 *
 * @return mixed Отсортированный массив с группой опций
 */
function wbcr_dan_additionally_form_options( $form, $page ) {
	if ( empty( $form ) ) {
		return $form;
	}

	$options = wbcr_dan_get_plugin_options();

	foreach ( array_reverse( $options ) as $option ) {
		array_unshift( $form[0]['items'], $option );
	}

	return $form;
}

add_filter( 'wbcr_clr_additionally_form_options', 'wbcr_dan_additionally_form_options', 10, 2 );

/**
 * Реализует кнопку сброса скрытых уведомлений.
 *
 * Вы можете выбрать для какой группы пользователей сбросить уведомления.
 * Эта модикация является не стандартной, поэтому мы не можете реалировать ее
 * через фреймворк.
 *
 * @param  @param $html_builder Wbcr_FactoryForms463_Html
 *
 * @since  1.0
 *
 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
 */
function wbcr_dan_reset_notices_button( $html_builder ) {
	global $wpdb;

	$form_name = $html_builder->getFormName();
	$reseted   = false;

	if ( isset( $_POST['wbcr_dan_reset_action'] ) ) {
		check_admin_referer( $form_name, 'wbcr_dan_reset_nonce' );
		$reset_for_users = WDN_Plugin::app()->request->post( 'wbcr_dan_reset_for_users', 'current_user', true );

		if ( $reset_for_users == 'current_user' ) {
			delete_user_meta( get_current_user_id(), WDN_Plugin::app()->getOptionName( 'hidden_notices' ) );
		} else {
			$meta_key = sanitize_key( WDN_Plugin::app()->getOptionName( 'hidden_notices' ) );
			$wpdb->query( "DELETE FROM {$wpdb->usermeta} WHERE meta_key = '{$meta_key}'" );
		}

		$reseted = true;
	}

	?>
	<div class="form-group form-group-checkbox factory-control-reset_notices_button">
		<label for="wbcr_clearfy_reset_notices_button" class="col-sm-4 control-label">
			<?= __( 'Reset hidden notices for', 'disable-admin-notices' ); ?>
			<span class="factory-hint-icon factory-hint-icon-grey" data-toggle="factory-tooltip" data-placement="right"
			      title=""
			      data-original-title="<?php _e( 'Push reset hidden notices if you need to show hidden notices again.', 'disable-admin-notices' ) ?>">
					<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAQAAABKmM6bAAAAUUlEQVQIHU3BsQ1AQABA0X/komIrnQHYwyhqQ1hBo9KZRKL9CBfeAwy2ri42JA4mPQ9rJ6OVt0BisFM3Po7qbEliru7m/FkY+TN64ZVxEzh4ndrMN7+Z+jXCAAAAAElFTkSuQmCC"
					     alt="">
				</span>
		</label>
		<div class="control-group col-sm-8">
			<div class="factory-checkbox factory-from-control-checkbox factory-buttons-way btn-group">
				<form method="post">
					<?php wp_nonce_field( $form_name, 'wbcr_dan_reset_nonce' ); ?>
					<p>
						<input type="radio" name="wbcr_dan_reset_for_users" value="current_user"
						       checked/> <?= __( 'current user', 'disable-admin-notices' ); ?>
					</p>
					<p>
						<input type="radio" name="wbcr_dan_reset_for_users"
						       value="all"/> <?= __( 'all users', 'disable-admin-notices' ); ?>
					</p>
					<p>
						<input type="submit" name="wbcr_dan_reset_action"
						       value="<?= __( 'Reset notices', 'disable-admin-notices' ); ?>"
						       class="button button-default"/>
					</p>
					<?php if ( $reseted ): ?>
						<div style="color:green;margin-top:5px;"><?php _e( 'Hidden notices are successfully reset, now you can see them again!', 'disable-admin-notices' ) ?></div>
					<?php endif; ?>
				</form>
			</div>
		</div>
	</div>
	<?php
}

