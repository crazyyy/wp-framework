<?php

/**
 * The page Settings.
 *
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WMAC_MinifyAndCombineSettingsPage extends Wbcr_FactoryClearfy206_PageBase {
	
	/**
	 * The id of the page in the admin menu.
	 *
	 * Mainly used to navigate between pages.
	 * @see Wbcr_FactoryPages410_AdminPage
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $id = "minify_and_combine"; // Уникальный идентификатор страницы
	public $page_menu_dashicon = 'dashicons-testimonial'; // Иконка для закладки страницы, дашикон
	public $page_parent_page = "performance"; // Уникальный идентификатор родительской страницы
	/**
	 * Доступена для мультисайтов
	 * @var bool
	 */
	public $available_for_multisite = true;
	
	/**
	 * @param Wbcr_Factory409_Plugin $plugin
	 */
	public function __construct( Wbcr_Factory409_Plugin $plugin ) {
		// Заголовок страницы
		$this->menu_title = __( 'Minify (JS/CSS)', 'minify-and-combine' );
		
		// Если плагин загружен, как самостоятельный, то мы меняем настройки страницы и делаем ее внешней,
		// а не внутренней страницей родительского плагина. Внешнии страницы добавляются в Wordpress меню "Общие"
		
		if ( ! defined( 'LOADING_MINIFY_AND_COMBINE_AS_ADDON' ) ) {
			// true - внутреняя, false- внешняя страница
			$this->internal = false;
			// меню к которому, нужно прикрепить ссылку на страницу
			$this->menu_target = 'options-general.php';
			// Если true, добавляет ссылку "Настройки", рядом с действиями активации, деактивации плагина, на странице плагинов.
			$this->add_link_to_plugin_actions = true;
			
			$this->page_parent_page = null;
		}
		
		parent::__construct( $plugin );
	}
	
	// Метод позволяет менять заголовок меню, в зависимости от сборки плагина.
	public function getMenuTitle() {
		return defined( 'LOADING_MINIFY_AND_COMBINE_AS_ADDON' ) ? __( 'Minify (Html/JS/CSS)', 'minify-and-combine' ) : __( 'General', 'minify-and-combine' );
	}
	
	/**
	 * Регистрируем уведомления для страницы
	 *
	 * @see libs\factory\pages\templates\FactoryPages410_ImpressiveThemplate
	 *
	 * @param $notices
	 *
	 * @return array
	 */
	public function getActionNotices( $notices ) {
		$notices[] = array(
			'conditions' => array(
				'wbcr_mac_clear_cache_success' => 1
			),
			'type'       => 'success',
			'message'    => __( 'The cache has been successfully cleaned.', 'minify-and-combine' )
		);
		
		return $notices;
	}
	
	/**
	 * Метод должен передать массив опций для создания формы с полями.
	 * Созданием страницы и формы занимается фреймворк
	 *
	 * @since 1.0.0
	 * @return mixed[]
	 */
	public function getPageOptions() {
		$options = array();
		
		$options[] = array(
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header"><strong>' . __( 'JavaScript Options', 'minify-and-combine' ) . '</strong><p></p></div>'
		);
		
		$options[] = array(
			'type'      => 'checkbox',
			'way'       => 'buttons',
			'name'      => 'js_optimize',
			'title'     => __( 'Optimize JavaScript Code?', 'minify-and-combine' ),
			'layout'    => array( 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ),
			//'hint' => __('Optimize JavaScript Code.', 'minify-and-combine'),
			'default'   => false,
			'eventsOn'  => array(
				'show' => '#wbcr-mac-optimize-js-fields,#wbcr-mac-optimization-danger-message-1'
			),
			'eventsOff' => array(
				'hide' => '#wbcr-mac-optimize-js-fields,#wbcr-mac-optimization-danger-message-1'
			)
		);
		
		/*$options[] = array(
			'type' => 'html',
			'html' => array( $this, 'optimizationDangerMessage1' )
		);*/
		
		$js_options[] = array(
			'type'      => 'checkbox',
			'way'       => 'buttons',
			'name'      => 'js_aggregate',
			'title'     => __( 'Aggregate JS-files?', 'minify-and-combine' ),
			'layout'    => array( 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ),
			'hint'      => __( 'Aggregate all linked JS-files to have them loaded non-render blocking? If this option is off, the individual JS-files will remain in place but will be minified.', 'minify-and-combine' ),
			'default'   => false,
			'eventsOn'  => array(
				'show' => '#wbcr-mac-optimization-danger-message-2'
			),
			'eventsOff' => array(
				'hide' => '#wbcr-mac-optimization-danger-message-2'
			)
		);
		
		$js_options[] = array(
			'type' => 'html',
			'html' => array( $this, 'optimizationDangerMessage2' )
		);
		
		$js_options[] = array(
			'type'      => 'checkbox',
			'way'       => 'buttons',
			'name'      => 'js_include_inline',
			'title'     => __( 'Also aggregate inline JS?', 'minify-and-combine' ),
			'layout'    => array( 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ),
			'hint'      => __( 'Let Мinify And Combine also extract JS from the HTML. Warning: this can make Мinify And Combine\'s cache size grow quickly, so only enable this if you know what you\'re doing.', 'minify-and-combine' ),
			'default'   => false,
			'eventsOn'  => array(
				'show' => '#wbcr-mac-optimization-danger-message-3'
			),
			'eventsOff' => array(
				'hide' => '#wbcr-mac-optimization-danger-message-3'
			)
		);
		
		$js_options[] = array(
			'type' => 'html',
			'html' => array( $this, 'optimizationDangerMessage3' )
		);
		
		$js_options[] = array(
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'js_forcehead',
			'title'   => __( 'Force JavaScript in &lt;head&gt;?', 'minify-and-combine' ),
			'layout'  => array( 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ),
			'hint'    => __( 'Load JavaScript early, this can potentially fix some JS-errors, but makes the JS render blocking.', 'minify-and-combine' ),
			'default' => false
		);
		
		$js_options[] = array(
			'type'    => 'textarea',
			'name'    => 'js_exclude',
			'title'   => __( 'Exclude scripts from Мinify And Combine:', 'minify-and-combine' ),
			//'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
			'hint'    => __( 'A comma-separated list of scripts you want to exclude from being optimized, for example \'whatever.js, another.js\' (without the quotes) to exclude those scripts from being aggregated and minimized by Мinify And Combine.', 'minify-and-combine' ),
			'default' => 'seal.js, js/jquery/jquery.js'
		);
		
		$js_options[] = array(
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'js_trycatch',
			'title'   => __( 'Add try-catch wrapping?', 'minify-and-combine' ),
			'layout'  => array( 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ),
			'hint'    => __( 'If your scripts break because of a JS-error, you might want to try this.', 'minify-and-combine' ),
			'default' => false
		);
		
		$options[] = array(
			'type'  => 'div',
			'id'    => 'wbcr-mac-optimize-js-fields',
			'items' => $js_options
		);
		
		$options[] = array(
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header"><strong>' . __( 'CSS Options', 'minify-and-combine' ) . '</strong><p></p></div>'
		);
		
		$options[] = array(
			'type'      => 'checkbox',
			'way'       => 'buttons',
			'name'      => 'css_optimize',
			'title'     => __( 'Optimize CSS Code?', 'minify-and-combine' ),
			'layout'    => array( 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ),
			'hint'      => __( 'If your scripts break because of a JS-error, you might want to try this.', 'minify-and-combine' ),
			'default'   => false,
			'eventsOn'  => array(
				'show' => '#wbcr-clr-optimize-css-fields'
			),
			'eventsOff' => array(
				'hide' => '#wbcr-clr-optimize-css-fields'
			)
		);
		
		$css_options[] = array(
			'type'      => 'checkbox',
			'way'       => 'buttons',
			'name'      => 'css_aggregate',
			'title'     => __( 'Aggregate CSS-files?', 'minify-and-combine' ),
			'layout'    => array( 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ),
			'hint'      => __( 'Aggregate all linked CSS-files? If this option is off, the individual CSS-files will remain in place but will be minified.', 'minify-and-combine' ),
			'default'   => false,
			'eventsOn'  => array(
				'show' => '#wbcr-mac-optimization-danger-message-4'
			),
			'eventsOff' => array(
				'hide' => '#wbcr-mac-optimization-danger-message-4'
			)
		);
		
		$css_options[] = array(
			'type' => 'html',
			'html' => array( $this, 'optimizationDangerMessage4' )
		);
		
		$css_options[] = array(
			'type'      => 'checkbox',
			'way'       => 'buttons',
			'name'      => 'css_include_inline',
			'title'     => __( 'Also aggregate inline CSS?', 'minify-and-combine' ),
			'layout'    => array( 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ),
			'hint'      => __( 'Check this option for Мinify And Combine to also aggregate CSS in the HTML.', 'minify-and-combine' ),
			'default'   => false,
			'eventsOn'  => array(
				'show' => '#wbcr-mac-optimization-danger-message-5'
			),
			'eventsOff' => array(
				'hide' => '#wbcr-mac-optimization-danger-message-5'
			)
		);
		
		$css_options[] = array(
			'type' => 'html',
			'html' => array( $this, 'optimizationDangerMessage5' )
		);
		
		$css_options[] = array(
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'css_datauris',
			'title'   => __( 'Generate data: URIs for images?', 'minify-and-combine' ),
			'layout'  => array( 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ),
			'hint'    => __( 'Enable this to include small background-images in the CSS itself instead of as separate downloads.', 'minify-and-combine' ),
			'default' => false
		);
		
		$css_options[] = array(
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'css_defer',
			'title'   => __( 'Inline and Defer CSS?', 'minify-and-combine' ),
			'layout'  => array( 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ),
			'hint'    => __( 'Inline "above the fold CSS" while loading the main auto optimized CSS only after page load. Check the FAQ for more info.
This can be fully automated for different types of pages with the Мinify And Combine CriticalCSS Power-Up.', 'minify-and-combine' ),
			'default' => false
		);
		
		$css_options[] = array(
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'css_inline',
			'title'   => __( 'Inline all CSS?', 'minify-and-combine' ),
			'layout'  => array( 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ),
			'hint'    => __( 'Inlining all CSS can improve performance for sites with a low pageviews/ visitor-rate, but may slow down performance otherwise.', 'minify-and-combine' ),
			'default' => false
		);
		
		$css_options[] = array(
			'type'    => 'textarea',
			'name'    => 'css_exclude',
			'title'   => __( 'Exclude CSS from Мinify And Combine:', 'minify-and-combine' ),
			//'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
			'hint'    => __( 'A comma-separated list of CSS you want to exclude from being optimized.', 'minify-and-combine' ),
			'default' => 'wp-content/cache/, wp-content/uploads/, admin-bar.min.css, dashicons.min.css'
		);
		
		$options[] = array(
			'type'  => 'div',
			'id'    => 'wbcr-clr-optimize-css-fields',
			'items' => $css_options
		);
		
		$options[] = array(
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header"><strong>' . __( 'Cache Info', 'minify-and-combine' ) . '</strong><p></p></div>'
		);
		
		// Произвольный html код
		$options[] = array(
			'type' => 'html',
			'html' => array( $this, 'cacheInfo' )
		);
		
		$formOptions = array();
		
		$formOptions[] = array(
			'type'  => 'form-group',
			'items' => $options,
			//'cssClass' => 'postbox'
		);
		
		return apply_filters( 'wbcr_mac_settings_form_options', $formOptions );
	}
	
	public function cacheInfo() {
		$is_network = is_network_admin();
		
		$cache = $is_network ? WMAC_PluginCache::getUsedCacheMultisite() : WMAC_PluginCache::getUsedCache();
		?>
        <div class="form-group">
            <label for="wbcr_mac_css_optimize" class="col-sm-4 control-label">
                Cache folder<?php echo $is_network ? 's' : '' ?>
            </label>
            <div class="control-group col-sm-8">
				<?php echo $is_network ? WP_CONTENT_DIR . WMAC_CACHE_CHILD_DIR . '[...]/' : WMAC_PluginCache::getCacheDir() ?>
            </div>
        </div>
        <div class="form-group">
            <label for="wbcr_mac_css_optimize" class="col-sm-4 control-label">
                Can we write?
            </label>
            <div class="control-group col-sm-8">
                Yes
            </div>
        </div>
        <div class="form-group">
            <label for="wbcr_mac_css_optimize" class="col-sm-4 control-label">
                Cached styles and scripts<?php echo $is_network ? ' (all sites)' : '' ?>
            </label>
            <div class="control-group col-sm-8">
				<?php if ( $is_network ) : ?>
					<?php echo $cache['files'] ?> files, totalling <?php echo $cache['size'] ?> (calculated
                    at <?php echo gmdate( 'H:i' ) ?> UTC)
				<?php else: ?>
					<?php echo $cache['percent'] . '%, ' . $cache['files'] ?> files,
                    totalling <?php echo $cache['size'] ?> (calculated at <?php echo gmdate( 'H:i' ) ?> UTC)
				<?php endif; ?>
            </div>
        </div>
        <div class="form-group">
            <label for="wbcr_mac_css_optimize" class="col-sm-4 control-label">
            </label>
            <div class="control-group col-sm-8">
                <a class="btn btn-default" href="<?= wp_nonce_url( $this->getActionUrl( 'clear-cache' ), 'clear_cache_' . $this->getResultId() ); ?>">
					<?php _e( 'Clear cache', 'minify-and-combine' ) ?>
                </a>
            </div>
        </div>
		<?php
	}
	
	/**
	 * Adds an html warning notification html markup.
	 *
	 * @param int $selector_id
	 */
	public function optimizationDangerMessage( $selector_id = 1 ) {
		?>
        <div class="form-group">
            <label class="col-sm-4 control-label"></label>
            <div class="control-group col-sm-8">
                <div id="wbcr-mac-optimization-danger-message-<?= $selector_id ?>" class="wbcr-clearfy-danger-message">
					<?php _e( '<b>This could break things!</b><br>If you notice any errors on your website after having activated this setting, just deactivate it again, and your site will be back to normal.', 'clearfy' ) ?>
                </div>
            </div>
        </div>
		<?php
	}
	
	public function optimizationDangerMessage1() {
		$this->optimizationDangerMessage( 1 );
	}
	
	public function optimizationDangerMessage2() {
		$this->optimizationDangerMessage( 2 );
	}
	
	public function optimizationDangerMessage3() {
		$this->optimizationDangerMessage( 3 );
	}
	
	public function optimizationDangerMessage4() {
		$this->optimizationDangerMessage( 4 );
	}
	
	public function optimizationDangerMessage5() {
		$this->optimizationDangerMessage( 5 );
	}
	
	/**
	 * Действие rollback
	 * Если мы перейдем по ссылке, которую мы создали для кнопки "Восстановить" для метода rollbackButton,
	 * То выполнится это действие
	 */
	public function clearCacheAction() {
		check_admin_referer( 'clear_cache_' . $this->getResultId() );
		
		if ( is_network_admin() ) {
			WMAC_PluginCache::clearAllMultisite();
		} else {
			WMAC_PluginCache::clearAll();
		}
		
		// редирект с выводом уведомления
		$this->redirectToAction( 'index', array( 'wbcr_mac_clear_cache_success' => 1 ) );
	}
}