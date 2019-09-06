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

class WCL_DefencePage extends Wbcr_FactoryClearfy206_PageBase {
	
	/**
	 * The id of the page in the admin menu.
	 *
	 * Mainly used to navigate between pages.
	 * @see FactoryPages410_AdminPage
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $id = "defence";
	
	public $page_menu_dashicon = 'dashicons-shield-alt';
	
	public $available_for_multisite = true;
	
	/**
	 * @param WCL_Plugin $plugin
	 */
	public function __construct( WCL_Plugin $plugin ) {
		$this->menu_title                  = __( 'Defence', 'clearfy' );
		$this->page_menu_short_description = __( 'Protective hacks, privacy', 'clearfy' );
		
		parent::__construct( $plugin );
		
		$this->plugin = $plugin;
	}
	
	/**
	 * Permalinks options.
	 *
	 * @since 1.0.0
	 * @return mixed[]
	 */
	public function getPageOptions() {
		$options = array();
		
		$options[] = array(
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header">' . __( '<strong>Base settings</strong>.', 'clearfy' ) . '<p>' . __( 'Basic recommended security settings.', 'clearfy' ) . '</p></div>'
		);
		
		$options[] = array(
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'protect_author_get',
			'title'   => __( 'Hide author login', 'clearfy' ),
			'layout'  => array( 'hint-type' => 'icon' ),
			'hint'    => __( 'An attacker can find out the author\'s login, using a similar request to get your site. mysite.com/?author=1', 'clearfy' ) . '<br><b>Clearfy: </b>' . __( 'Sets the redirect to exclude the possibility of obtaining a login.', 'clearfy' ),
			'default' => false
		);
		
		$options[] = array(
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'change_login_errors',
			'title'   => __( 'Hide errors when logging into the site', 'clearfy' ),
			'layout'  => array( 'hint-type' => 'icon' ),
			'hint'    => __( 'WP by default shows whether you entered a wrong login or incorrect password, which allows attackers to understand if there is a certain user on the site, and then start searching through the passwords.', 'clearfy' ) . '<br><b>Clearfy: </b>' . __( 'Changes in the text of the error so that attackers could not find the login.', 'clearfy' ),
			'default' => false
		);
		
		$options[] = array(
			'type'      => 'checkbox',
			'way'       => 'buttons',
			'name'      => 'remove_x_pingback',
			'title'     => __( 'Disable XML-RPC', 'clearfy' ),
			'layout'    => array( 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ),
			'hint'      => __( 'A pingback is basically an automated comment that gets created when another blog links to you. A self-pingback is created when you link to an article within your own blog. Pingbacks are essentially nothing more than spam and simply waste resources.', 'clearfy' ) . '<br><b>Clearfy: </b>' . __( 'Removes the server responses a reference to the xmlrpc file.', 'clearfy' ),
			'default'   => false,
			'eventsOn'  => array(
				'show' => '#wbcr-clearfy-xml-rpc-danger-message'
			),
			'eventsOff' => array(
				'hide' => '#wbcr-clearfy-xml-rpc-danger-message'
			)
		);
		
		$options[] = array(
			'type' => 'html',
			'html' => array( $this, 'xmlRpcDangerMessage' )
		);
		
		//block_xml_rpc
		//disable_xml_rpc_auth
		//remove_xml_rpc_tag
		
		$options[] = array(
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header">' . __( '<strong>Hide WordPress versions</strong>', 'clearfy' ) . '<p>' . __( 'WordPress itself and many plugins shows their version at the public areas of your site. An attacker received this information may be aware of the vulnerabilities found in the version of the WordPress core or plugins.', 'clearfy' ) . '</p></div>'
		);
		
		$options[] = array(
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'remove_html_comments',
			'title'   => __( 'Remove html comments', 'clearfy' ),
			'layout'  => array( 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ),
			'hint'    => __( 'This function will remove all html comments in the source code, except for special and hidden comments. This is necessary to hide the version of installed plugins.', 'clearfy' ) . '<br><br><b>Clearfy: </b>' . __( 'Remove html comments in source code.', 'clearfy' ),
			'default' => false
		);
		
		$options[] = array(
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'remove_meta_generator',
			'title'   => __( 'Remove meta generator', 'clearfy' ) . ' <span class="wbcr-clearfy-recomended-text">(' . __( 'Recommended', 'clearfy' ) . ')</span>',
			'layout'  => array( 'hint-type' => 'icon' ),
			'hint'    => __( 'Allows attacker to learn the version of WP installed on the site. This meta tag has no useful function.', 'clearfy' ) . '<br><b>Clearfy: </b>' . sprintf( __( 'Removes the meta tag from the %s section', 'clearfy' ), '&lt;head&gt;' ),
			'default' => false
		);

		$form_options = array();
		
		$form_options[] = array(
			'type'  => 'form-group',
			'items' => apply_filters( 'wbcr_clearfy_defence_form_options', $options, $this ),
			//'cssClass' => 'postbox'
		);
		
		return wbcr_factory_409_apply_filters_deprecated( 'wbcr_clr_defence_form_options', array(
			$form_options,
			$this
		), '1.3.1', 'wbcr_clearfy_defence_form_options' );
	}
	
	/**
	 * Adds an html warning notification html markup.
	 */
	public function xmlRpcDangerMessage() {
		?>
        <div class="form-group">
            <label class="col-sm-4 control-label"></label>
            <div class="control-group col-sm-8">
                <div id="wbcr-clearfy-xml-rpc-danger-message" class="wbcr-clearfy-danger-message">
					<?php _e( '<b>Use this option carefully!</b><br> Plugins like jetpack may have problems using this option.', 'clearfy' ) ?>
                </div>
            </div>
        </div>
		<?php
	}
}
