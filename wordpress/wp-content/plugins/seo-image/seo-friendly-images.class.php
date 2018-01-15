<?php
class SEOFriendlyImages {
	var $local_version;
	var $plugin_url;
	var $key;
	var $name;
	var $cap;
	var $rules;


	var $tree;
	var $process_parameters;
	
	function SEOFriendlyImages() {
		$this->local_version = "3.0.3";
		$this->plugin_url =  trailingslashit(plugins_url(null, __FILE__));
		$this->key = 'seo-friendly-images';
		$this->name = 'SEO Friendly Images';
		$this->cap = 'manage_options';
		
		$domain_name = 'seo-friendly-images';
		$locale_name = get_locale();
		$mofile_name = dirname( __FILE__ ) . '/languages';
		$mofile_name .= "/$domain_name-$locale_name.mo";
		load_textdomain( 'seo-friendly-images', $mofile_name );
		load_plugin_textdomain( 'seo-friendly-images', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		
		
		$this->add_filters_and_hooks();
		$options = $this->get_options();
		$this->rules = $options['rules'];		
		
		$this->tree = null;

	}
	
	function add_filters_and_hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_styles' ) );		
		add_action( 'admin_menu', array( $this, 'seo_friendly_images_add_pages' ) );
		add_filter( 'the_content', array( $this, 'seo_friendly_images' ), 500 );
		add_filter( 'post_thumbnail_html', array( $this, 'seo_friendly_images_featured' ), 500 );
	
	}
	
	function seo_friendly_images_add_pages() {
		$image = $this->plugin_url . '/i/icon.png';
		
		add_menu_page( $this->name, $this->name, $this->cap, 'sfi_settings', array(
			&$this,
			'handle_settings'
		), $image );
		$page_settings = add_submenu_page( 'sfi_settings', $this->name . ' Settings', 'Settings', $this->cap, 'sfi_settings', array(
			&$this,
			'handle_settings'
		) );

		$page_about = add_submenu_page( 'sfi_settings', $this->name . ' About', 'About', $this->cap, 'sfi_about', array(
			&$this,
			'handle_about'
		) );
		
		add_action( 'admin_print_scripts-' . $page_settings, array( $this, 'admin_scripts' ) );
		add_action( 'admin_head-' . $page_settings, array( $this, 'options_head_settings' ) );
		
		add_action( 'admin_head-' . $page_about, array( $this, 'options_head_about' ) );
	}

	function head() {
		
	}
	
	function admin_scripts() {
		if ( ! empty( $_REQUEST['page'] ) ) {
			$page = $_REQUEST['page'];
		} else {
			$page = false;
		}
		if ( $page == 'sfi_settings' ) {
			$script_path = $this->plugin_url . '/javascripts/sfi.js';
			wp_register_script( 'sfi', $script_path );

			wp_enqueue_script( 'sfi' );
		}
	}
	
	function options_head_settings() {
	?>
	<style type="text/css">
	.settings {						
		margin:5px;
	}
	.holder{
		width:750px;
		margin:0 0 10px;
	}
	h4.big{font-size: 18px;margin: 15px 0 10px 0;padding: 0; background:url('<?php echo $this->plugin_url .'/i/arrows.png'; ?>') no-repeat right -37px;}
	h4.big.col{background-position: right 0px;}
	h4#title_global{ background:none;}
	#icon-sfi_settings { background:transparent url( '<?php echo $this->plugin_url .'/i/logo.png'; ?>' ) no-repeat; }
	.line{display:inline-block; width:220px; padding:0 40px 0 0;}
	.line2{display:inline-block; width:190px; padding:0 40px 0 0;}
	#defualt_settings div{margin:0 0 15px;}
	#mainblock .regular-text{border-color: #DFDFDF;background: white; border-radius:3px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px; width:275px;margin: 0;}
	#mainblock .regular-text.small{width:100px;}
	#mainblock .regular-text.smaller{width:130px;margin:4px 0 0;}
	#default_override_div ul li,.rule,ul.lists li{margin-bottom:15px;}
	#default_override_div input[type=checkbox],#global_settings input[type=checkbox]{vertical-align:top;}
	#default_attach_internal_images_div select{margin:0;}
	#rule_buttons{}
	.settings{margin:0;}
	.settingstop{width: 100%;clear: both;float: left;margin-bottom: 20px;}
	.settingstop div{
		display:inline-block;
	}
	.settingssec{display: block;width: 100%;clear: both;}
	.settingssec .settings, .rew{display: inline-block;width: 170px;vertical-align: top;margin:0 0 20px;}
	.radios ul li input[type=radio], ul.lists li input[type=checbox]{vertical-align:top;}
	h4.big:hover{cursor:pointer;}

	</style>
	<script>
		jQuery(document).ready(function($) {
			expand_cbox( 0 );
			
			$('#add_rule').click(function() {
				var temp = 1;
				while ($('#title_rule_' + temp).length != 0) temp = temp + 1;
				var rule = jQuery('#rule_copy').html();
				rule = rule.replace(/number/g, temp );
				$('#rule_buttons').before(rule);
				load_js(temp, false);
				temp = temp + 1;
			});
			$('#remove_rule').click(function() {
				var temp = 1;
				while ($('#title_rule_' + temp).length != 0 ) temp = temp + 1;
				$('#title_rule_' + (temp - 1 )).remove();
				$('#rule_' + (temp - 1) + '_settings_div').remove();
			});
			$('#post-box h4.big').click(function() {
				$(this).toggleClass('col');
				$(this).next().toggle();
			});
		});
	</script>
	<?php		
	}
	
	
	function options_head_about() {
	
	}
	
	function load_scripts() {
	
	}
	
	function load_styles() {
		
	}
	
	function remove_from_domains( $rule, $domain ) {
		if ( isset( $this->rules[$rule]['domains'] ) ) {
			if ( ! empty( $this->rules[$rule]['domains'] ) ) {
				if ( in_array( $domain, $this->rules[$rule]['domains'] ) ) {
					foreach( $this->rules[$rule]['domains'] as $key => $value ) {
						if ( $value == $domain ) {
							unset( $this->rules[$rule]['domains'][$key] );
						}
					}
				}
			}
		}
	}
	
	
	
	function handle_settings() {
		if ( isset( $_POST['submitted'] ) ) {
			if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'seo-friendly-images' ) ) {

     		die( 'Security check' ); 

			} 
			$this->rules[0]['domains'] = array( 'all' );			
			$this->rules[0]['options']['alt'] = strip_tags(( ! isset( $_POST['default_alt'] ) ? '' : $_POST['default_alt'] ));
			$this->rules[0]['options']['title'] = strip_tags(( ! isset( $_POST['default_title'] ) ? '' : $_POST['default_title'] ));
			$this->rules[0]['options']['override_alt'] = ( ! isset( $_POST['default_override_alt'] ) ? 'off' : 'on' );
			$this->rules[0]['options']['override_title'] = ( ! isset( $_POST['default_override_title'] ) ? 'off' : 'on' );
			$this->rules[0]['options']['strip_extension_title'] = ( ! isset( $_POST['default_strip_extension_title'] ) ? 'off' : 'on' );	
			$this->rules[0]['options']['enable'] = 'on';


			$options['rules'] = $this->rules;
			$this->tree = null;
			update_option( $this->key, $options );			
			
			$msg_status = __( 'SEO Friendly Images settings saved.', 'seo-friendly-images' );
			
			// Show message
			echo '<div id="message" class="updated fade"><p>' . $msg_status . '</p></div>';
		}
		
		// Fetch code from DB
		if (isset($this->rules))
		foreach ( $this->rules as $key => $rule ) {
			$form[$key]['domains'] = $rule['domains'];
			$form[$key]['options'] = $rule['options'];
			$form[$key]['options']['enable'] = ( $rule['options']['enable'] == 'on' ) ? 'checked' : '';
			if ( $key == 0 || $rule['options']['enable'] == 'on' ) {
				$form[$key]['options']['override_alt'] = ( $rule['options']['override_alt'] == 'on' ) ? 'checked' : '';
				$form[$key]['options']['override_title'] = ( $rule['options']['override_title'] == 'on' ) ?'checked' : '';
				$form[$key]['options']['strip_extension_title'] = ( $rule['options']['strip_extension_title'] == 'on' ) ?'checked' : '';
			}
		}
	
		$imgpath = $this->plugin_url . '/i';
		$actionurl = esc_url($_SERVER['REQUEST_URI']);
		$nonce = wp_create_nonce( 'seo-friendly-images' );
		// Configuration Page
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php _e( 'SEO Friendly Images', 'seo-friendly-images' ); echo '&nbsp;' . $this->local_version; ?></h2>
		<a href="admin.php?page=sfi_settings"><?php _e( 'Settings', 'seo-friendly-images' ); ?></a> &nbsp; | &nbsp; <a href="admin.php?page=sfi_about"><?php _e( 'About', 'seo-friendly-images' ); ?></a>
		<div id="poststuff" style="margin-top:10px;">
		
			<div id="sideblock" style="float:right;width:270px;margin-left:10px;">		  
				<div class="ad">
					<a href="https://managewp.com/?utm_source=Plugins&amp;utm_medium=Banner&amp;utm_content=mwp250_2&amp;utm_campaign=SEOFriendlyImages" title="ManageWP.com - Manage your sites from one dashboard"><img src="<?php echo $imgpath ?>/mwp250_2.png" alt="ManageWP.com - Manage Multiple WordPress Sites"></a>
					</div><br>
				<div class="ad">
					<a target="_blank" href="http://www.prelovac.com/products/seo-smart-links"><img src="<?php echo $imgpath ?>/seosmart125.png" title="SEO Smart Links Premium" alt="SEO Smart Links Premium"></a>                                                                                                                      
					<a target="_blank" href="http://www.prelovac.com/products/seo-friendly-images"><img src="<?php echo $imgpath ?>/seoimages125_v2.jpg" title="SEO Friendly Images Premium" alt="SEO Friendly Images Premium"></a>                                                                                                                      
				</div> 
			</div>
		</div>
		<div id="mainblock" class="submit">
			<div class="dbx-content">
				<form name="sfiform" action="<?php echo $actionurl; ?>" method="post">
					<input type="hidden" name="submitted" value="1" />	
					<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo $nonce ?>" />	 
					<p><?php _e( 'SEO Friendly Images automatically adds ALT and Title attributes to all your images in all your posts. Default options are usually good but you can change them below.', 'seo-friendly-images' ); ?></p>						 
				<p><strong>Note: The plugin works by modyfying the image HTML output on the frontend of your site, no changes are made to images in your media library or while editing the post. See <a href="https://wordpress.org/support/topic/it-does-work-you-just-wont-see-it-in-the-backend">more info here</a>.</strong></p>
					<p><?php _e( 'Plugin supports several special tags:', 'seo-friendly-images' ); ?></p>
					<ul>
						<li><b>%title</b> - <?php _e( 'replaces post title', 'seo-friendly-images' ); ?></li>
						<li><b>%desc</b> - <?php _e( 'replaces post excerpt', 'seo-friendly-images' ); ?></li>
						<li><b>%name</b> - <?php _e( 'replaces image file name ( without extension )', 'seo-friendly-images' ); ?></li>
						<li><b>%category</b> - <?php _e( 'replaces post category', 'seo-friendly-images' ); ?></li>
						<li><b>%tags</b> - <?php _e( 'replaces post tags', 'seo-friendly-images' ); ?></li>
					</ul>
					<p>
						<strong><?php _e( 'Example:', 'seo-friendly-images' ); ?></strong>
						<?php _e( 'In a post titled Car Pictures there is a picture named Ferrari.jpg', 'seo-friendly-images' ); ?><br /><br />
						<?php _e( 'Setting alt attribute to <b>"%name %title"</b> will produce alt="Ferrari Car Pictures"', 'seo-friendly-images' ); ?><br />
						<?php _e( 'Setting title attribute to <b>"%name photo"</b> will produce title="Ferrari photo"', 'seo-friendly-images' ); ?>
					</p>
					<div id="poststuff" class="postbox holder">
					<h3 class="hndle"><span><?php _e( 'Settings', 'seo-friendly-images' ); ?></span></h3>
					<div class="inside">
					
				
					<div id="defualt_settings" style="width:710px;" class="settings">
						<div id="default_alt_div">
							<label class="line" for="default_alt"><?php _e( 'Image <b>ALT</b> attribute:', 'seo-friendly-images' ); ?></label>
							<input class="regular-text" type="text" id="default_alt" name="default_alt" value="<?php echo htmlspecialchars($form[0]['options']['alt']); ?>" />
							<span class="description"><?php _e( 'example: %name %title', 'seo-friendly-images' ); ?></span>
						</div>
						<div id="default_title_div">
							<label class="line" for="default_title"><?php _e( 'Image <b>TITLE</b> attribute:', 'seo-friendly-images' ); ?></label>
							<input class="regular-text" type="text" id="default_title" name="default_title" value="<?php echo htmlspecialchars($form[0]['options']['title']); ?>" />
							<span class="description"><?php _e( 'example: %name photo', 'seo-friendly-images' ); ?></span>
						</div>
						<div id="default_override_div">
						<ul>
						<li>
							<label class="line" for="default_override_alt"><?php _e( 'Override default image alt tag', 'seo-friendly-images' ); ?></label>
							<input type="checkbox" id="default_override_alt" name="default_override_alt" <?php echo $form[0]['options']['override_alt']; ?> />
							<?php _e( '<span class="description">( recommended )</span>', 'seo-friendly-images' ); ?>
						</li>
						<li>
						<label class="line" for="default_override_title"><?php _e( 'Override default image title tag', 'seo-friendly-images' ); ?></label>
						<input type="checkbox" id="default_override_title" name="default_override_title" <?php echo $form[0]['options']['override_title']; ?> />
						</li>
						<li>
					<label class="line" for="default_strip_extension_title"><?php _e( 'Strip extension and delimiter characters (like dot dash etc) from the title tag', 'seo-friendly-images' ); ?></label>
					<input type="checkbox" id="default_strip_extension_title" name="default_strip_extension_title" <?php echo $form[0]['options']['strip_extension_title']; ?> />
						</li>
						
						</ul>
						</div>
					
					</div>
				</div>
				</div>
					<?php if (isset($form))
					for ( $i = 1; $i < count( $form ) - 1; $i++ ): ?>
					<script type="text/javascript">
					jQuery( document ).ready( function( $){
						load_js(<?php echo $i; ?>, true );
					});
					</script>
					<div id="post-box" class="postbox holder">
					<div class="inside">
					<h4 class="big" id="title_rule_<?php echo $i; ?>"><?php echo __( 'Rule', 'seo-friendly-images' ) . ' ' . $i; ?></h4>
					<div id="rule_<?php echo $i; ?>_settings_div" style="width:710px;" class="settings">
						<div id="rule_<?php echo $i; ?>_domains_div" class="settings">
							<div id="rule_<?php echo $i; ?>_domain_main_all_div" class="settings settingstop">
								<div id="rule_<?php echo $i; ?>_domain_main_div" class="rew">
									<input type="checkbox" id="rule_<?php echo $i; ?>_domain_main" name="rule_<?php echo $i; ?>_domain_main" <?php echo ( in_array( 'main', $form[$i]['domains'] ) ) ? 'checked' : ''; ?> />
									<label for="rule_<?php echo $i; ?>_domain_main"><?php _e( 'Main Pages', 'seo-friendly-images' ); ?></label>
								</div>
								<div id="rule_<?php echo $i; ?>_subdomains_main_div">
									<input type="checkbox" id="rule_<?php echo $i; ?>_domain_home" name="rule_<?php echo $i; ?>_domain_home" <?php echo ( in_array( 'main', $form[$i]['domains'] ) || in_array( 'home', $form[$i]['domains'] ) ) ? 'checked' : ''; ?> <?php echo ( in_array( 'main', $form[$i]['domains'] ) ) ? 'disabled' : ''; ?> />
									<label for="rule_<?php echo $i; ?>_domain_home"><?php _e( 'Home Pages', 'seo-friendly-images' ); ?></label>
									<br />
									<input type="checkbox" id="rule_<?php echo $i; ?>_domain_front" name="rule_<?php echo $i; ?>_domain_front" <?php echo ( in_array( 'main', $form[$i]['domains'] ) || in_array( 'front', $form[$i]['domains'] ) ) ? 'checked' : ''; ?> <?php echo ( in_array( 'main', $form[$i]['domains'] ) ) ? 'disabled' : ''; ?> />
									<label for="rule_<?php echo $i; ?>_domain_front"><?php _e( 'Front Pages', 'seo-friendly-images' ); ?></label>
								</div>
								<div style="clear:both">
								</div>
							</div>
							<div id="rule_<?php echo $i; ?>_domain_archive_all_div" class="settings settingssec">
								<div id="rule_<?php echo $i; ?>_domain_archive_div">
									<input type="checkbox" id="rule_<?php echo $i; ?>_domain_archive" name="rule_<?php echo $i; ?>_domain_archive" <?php echo ( in_array( 'archive', $form[$i]['domains'] ) ) ? 'checked' : ''; ?> />
									<label for="rule_<?php echo $i; ?>_domain_archive"><?php _e( 'Archive Pages', 'seo-friendly-images' ); ?></label>
								</div>
								<br />
								<div id="rule_<?php echo $i; ?>_subdomains_archive_div">
									<div id="rule_<?php echo $i; ?>_domain_category_all_div" class="settings">
										<input type="checkbox" id="rule_<?php echo $i; ?>_domain_category" name="rule_<?php echo $i; ?>_domain_category" <?php echo ( in_array( 'archive', $form[$i]['domains'] ) || in_array( 'category', $form[$i]['domains'] ) ) ? 'checked' : ''; ?> <?php echo ( in_array( 'archive', $form[$i]['domains'] ) ) ? 'disabled' : ''; ?> />
										<label for="rule_<?php echo $i; ?>_domain_category"><?php _e( 'All Categories', 'seo-friendly-images' ); ?></label>
										<br />
										<div id="rule_<?php echo $i; ?>_domain_category_ids_div">
											<?php _e( 'or specify by IDs:', 'seo-friendly-images' ); ?>
											<br />
											<input class="regular-text smaller" type="text" id="rule_<?php echo $i; ?>_domain_category_ids" name="rule_<?php echo $i; ?>_domain_category_ids" value="<?php echo ( isset( $form[$i]['domains']['category'] ) ) ? implode( ',', $form[$i]['domains']['category'] ) : ''; ?>" />
										</div>
									</div>
									<div id="rule_<?php echo $i; ?>_domain_tag_all_div" class="settings">
										<input type="checkbox" id="rule_<?php echo $i; ?>_domain_tag" name="rule_<?php echo $i; ?>_domain_tag" <?php echo ( in_array( 'archive', $form[$i]['domains'] ) || in_array( 'tag', $form[$i]['domains'] ) ) ? 'checked' : ''; ?> <?php echo ( in_array( 'archive', $form[$i]['domains'] ) ) ? 'disabled' : ''; ?> />
										<label for="rule_<?php echo $i; ?>_domain_tag"><?php _e( 'All Tags', 'seo-friendly-images' ); ?></label>
										<br />
										<div id="rule_<?php echo $i; ?>_domain_tag_ids_div">
											<?php _e( 'or specify by IDs:', 'seo-friendly-images' ); ?>
											<br />
											<input class="regular-text smaller" type="text" id="rule_<?php echo $i; ?>_domain_tag_ids" name="rule_<?php echo $i; ?>_domain_tag_ids" value="<?php echo ( isset( $form[$i]['domains']['tag'] ) ) ? implode( ',', $form[$i]['domains']['tag'] ) : ''; ?>" />
										</div>
									</div>
									<div id="rule_<?php echo $i; ?>_domain_taxonomy_all_div" class="settings">
										<input type="checkbox" id="rule_<?php echo $i; ?>_domain_taxonomy" name="rule_<?php echo $i; ?>_domain_taxonomy" <?php echo ( in_array( 'archive', $form[$i]['domains'] ) || in_array( 'taxonomy', $form[$i]['domains'] ) ) ? 'checked' : ''; ?> <?php echo ( in_array( 'archive', $form[$i]['domains'] ) ) ? 'disabled' : ''; ?> />
										<label for="rule_<?php echo $i; ?>_domain_taxonomy"><?php _e( 'All Taxonomies', 'seo-friendly-images' ); ?></label>
										<br />
										<div id="rule_<?php echo $i; ?>_domain_taxonomy_ids_div">
											<?php _e( 'or specify by IDs:', 'seo-friendly-images' ); ?>
											<br />
											<input class="regular-text smaller" type="text" id="rule_<?php echo $i; ?>_domain_taxonomy_ids" name="rule_<?php echo $i; ?>_domain_taxonomy_ids"  value="<?php echo ( isset( $form[$i]['domains']['taxonomy'] ) ) ? implode( ',', $form[$i]['domains']['taxonomy'] ) : ''; ?>" />
										</div>
									</div>
									<div id="rule_<?php echo $i; ?>_domain_author_all_div" class="settings">
										<input type="checkbox" id="rule_<?php echo $i; ?>_domain_author" name="rule_<?php echo $i; ?>_domain_author" <?php echo ( in_array( 'archive', $form[$i]['domains'] ) || in_array( 'author', $form[$i]['domains'] ) ) ? 'checked' : ''; ?> <?php echo ( in_array( 'archive', $form[$i]['domains'] ) ) ? 'disabled' : ''; ?> />
										<label for="rule_<?php echo $i; ?>_domain_Author"><?php _e( 'All Authors', 'seo-friendly-images' ); ?></label>
										<br />
										<div id="rule_<?php echo $i; ?>_domain_author_ids_div">
											<?php _e( 'or specify by IDs:', 'seo-friendly-images' ); ?>
											<br />
											<input class="regular-text smaller" type="text" id="rule_<?php echo $i; ?>_domain_author_ids" name="rule_<?php echo $i; ?>_domain_author_ids"  value="<?php echo ( isset( $form[$i]['domains']['author'] ) ) ? implode( ',', $form[$i]['domains']['author'] ) : ''; ?>" />
										</div>
									</div>
									<div id="rule_<?php echo $i; ?>_domain_date_all_div" class="settings settingssec">
										<div id="rule_<?php echo $i; ?>_subdomains_date_div">
											<input type="checkbox" id="rule_<?php echo $i; ?>_domain_date" name="rule_<?php echo $i; ?>_domain_date" <?php echo ( in_array( 'archive', $form[$i]['domains'] ) || in_array( 'date', $form[$i]['domains'] ) ) ? 'checked' : ''; ?> <?php echo ( in_array( 'archive', $form[$i]['domains'] ) ) ? 'disabled' : ''; ?> />
											<label for="rule_<?php echo $i; ?>_domain_date"><?php _e( 'Date Pages', 'seo-friendly-images' ); ?></label>
										</div>
										<div id="rule_<?php echo $i; ?>_subdomains_date_div" class="settings">
											<input type="checkbox" id="rule_<?php echo $i; ?>_domain_year" name="rule_<?php echo $i; ?>_domain_year" <?php echo ( in_array( 'archive', $form[$i]['domains'] ) || in_array( 'date', $form[$i]['domains'] ) || in_array( 'year', $form[$i]['domains'] ) ) ? 'checked' : ''; ?> <?php echo ( in_array( 'archive', $form[$i]['domains'] ) || in_array( 'date', $form[$i]['domains'] ) ) ? 'disabled' : ''; ?> />
											<label for="rule_<?php echo $i; ?>_domain_year"><?php _e( 'Year Pages', 'seo-friendly-images' ); ?></label>
											<br />
											<input type="checkbox" id="rule_<?php echo $i; ?>_domain_month" name="rule_<?php echo $i; ?>_domain_month" <?php echo ( in_array( 'archive', $form[$i]['domains'] ) || in_array( 'date', $form[$i]['domains'] ) || in_array( 'month', $form[$i]['domains'] ) ) ? 'checked' : ''; ?> <?php echo ( in_array( 'archive', $form[$i]['domains'] ) || in_array( 'date', $form[$i]['domains'] ) ) ? 'disabled' : ''; ?> />
											<label for="rule_<?php echo $i; ?>_domain_month"><?php _e( 'Month Pages', 'seo-friendly-images' ); ?></label>
											<br />
											<input type="checkbox" id="rule_<?php echo $i; ?>_domain_day" name="rule_<?php echo $i; ?>_domain_day" <?php echo ( in_array( 'archive', $form[$i]['domains'] ) || in_array( 'date', $form[$i]['domains'] ) || in_array( 'day', $form[$i]['domains'] ) ) ? 'checked' : ''; ?> <?php echo ( in_array( 'archive', $form[$i]['domains'] ) || in_array( 'date', $form[$i]['domains'] ) ) ? 'disabled' : ''; ?> />
											<label for="rule_<?php echo $i; ?>_domain_day"><?php _e( 'Day Pages', 'seo-friendly-images' ); ?></label>
											<br />
											<input type="checkbox" id="rule_<?php echo $i; ?>_domain_time" name="rule_<?php echo $i; ?>_domain_time" <?php echo ( in_array( 'archive', $form[$i]['domains'] ) || in_array( 'date', $form[$i]['domains'] ) || in_array( 'time', $form[$i]['domains'] ) ) ? 'checked' : ''; ?> <?php echo ( in_array( 'archive', $form[$i]['domains'] ) || in_array( 'date', $form[$i]['domains'] ) ) ? 'disabled' : ''; ?> />
											<label for="rule_<?php echo $i; ?>_domain_time"><?php _e( 'Time Pages', 'seo-friendly-images' ); ?></label>
										</div>
										<div style="clear:both">
										</div>
									</div>
								</div>
								<div style="clear:both">
								</div>
							</div>
							<div id="rule_<?php echo $i; ?>_domain_singular_all_div" class="settings settingssec">
								<div id="rule_<?php echo $i; ?>_domain_singular_div">
									<input type="checkbox" id="rule_<?php echo $i; ?>_domain_singular" name="rule_<?php echo $i; ?>_domain_singular" <?php echo ( in_array( 'singular', $form[$i]['domains'] ) ) ? 'checked' : ''; ?> />
									<label for="rule_<?php echo $i; ?>_domain_singular"><?php _e( 'Singular Pages', 'seo-friendly-images' ); ?></label>
								</div>
								<br />
								<div id="rule_<?php echo $i; ?>_subdomains_singular_div">
									<div id="rule_<?php echo $i; ?>_domain_post_all_div" class="settings settingssec">
										<input type="checkbox" id="rule_<?php echo $i; ?>_domain_post" name="rule_<?php echo $i; ?>_domain_post" <?php echo ( in_array( 'singular', $form[$i]['domains'] ) || in_array( 'post', $form[$i]['domains'] ) ) ? 'checked' : ''; ?> />
										<label for="rule_<?php echo $i; ?>_domain_post"><?php _e( 'All Posts', 'seo-friendly-images' ); ?></label>
										<br />
										<div id="rule_<?php echo $i; ?>_domain_post_ids_div">
											<?php _e( 'or specify by IDs:', 'seo-friendly-images' ); ?>
											<br />
											<input class="regular-text smaller" type="text" id="rule_<?php echo $i; ?>_domain_post_ids" name="rule_<?php echo $i; ?>_domain_post_ids"  value="<?php echo ( isset( $form[$i]['domains']['post'] ) ) ? implode( ',', $form[$i]['domains']['post'] ) : ''; ?>" />
										</div>
									</div>
									<div id="rule_<?php echo $i; ?>_domain_page_all_div" class="settings settingssec">
										<input type="checkbox" id="rule_<?php echo $i; ?>_domain_page" name="rule_<?php echo $i; ?>_domain_page" <?php echo ( in_array( 'singular', $form[$i]['domains'] ) || in_array( 'page', $form[$i]['domains'] ) ) ? 'checked' : ''; ?> />
										<label for="rule_<?php echo $i; ?>_domain_page"><?php _e( 'All Pages', 'seo-friendly-images' ); ?></label>
										<br />
										<div id="rule_<?php echo $i; ?>_domain_page_ids_div">
											<?php _e( 'or specify by IDs:', 'seo-friendly-images' ); ?>
											<br />
											<input class="regular-text smaller" type="text" id="rule_<?php echo $i; ?>_domain_page_ids" name="rule_<?php echo $i; ?>_domain_page_ids" value="<?php echo ( isset( $form[$i]['domains']['page'] ) ) ? implode( ',', $form[$i]['domains']['page'] ) : ''; ?>" />
										</div>
									</div>
									<div id="rule_<?php echo $i; ?>_domain_attachment_all_div" class="settings settingssec">
										<input type="checkbox" id="rule_<?php echo $i; ?>_domain_attachment" name="rule_<?php echo $i; ?>_domain_attachment" <?php echo ( in_array( 'singular', $form[$i]['domains'] ) || in_array( 'attachment', $form[$i]['domains'] ) ) ? 'checked' : ''; ?> />
										<label for="rule_<?php echo $i; ?>_domain_attachment"><?php _e( 'All Attachments', 'seo-friendly-images' ); ?></label>
										<br />
										<div id="rule_<?php echo $i; ?>_domain_attachment_ids_div">
											<?php _e( 'or specify by IDs:', 'seo-friendly-images' ); ?>
											<br />
											<input class="regular-text smaller" type="text" id="rule_<?php echo $i; ?>_domain_attachment_ids" name="rule_<?php echo $i; ?>_domain_attachment_ids" value="<?php echo ( isset( $form[$i]['domains']['attachment'] ) ) ? implode( ',', $form[$i]['domains']['attachment'] ) : ''; ?>" />
										</div>
									</div>
								</div>
								<div style="clear:both">
								</div>
							</div>
						</div>
						<input type="hidden" id="rule_<?php echo $i; ?>_hidden" name="rule_<?php echo $i; ?>_hidden" value="1" />
						<br />
					   <ul class="radios">
					   <li>
						<input type="radio" id="rule_<?php echo $i; ?>_enable" name="rule_<?php echo $i; ?>_enable" value="enabled" <?php echo $form[$i]['options']['enable']; ?> /> <label>Enable plugin for the above rules</label>
						</li>
						<li>
						<input type="radio" id="rule_<?php echo $i; ?>_enable" name="rule_<?php echo $i; ?>_enable" value="disabled" <?php echo ( ( $form[$i]['options']['enable'] == "" ) ? "checked" : "" ); ?> /> <label>Disable plugin for the above rules</label></li>
						</ul>
						<br />
						
						<div id="rule_<?php echo $i; ?>_rules_div" <?php echo ( ( $form[$i]['options']['enable'] == 'checked' ) ? "" : "style='display:none;'" ); ?> >
							<div id="rule_<?php echo $i; ?>_alt_div" class="rule">
								<label class="line2" for="rule_<?php echo $i; ?>_alt"><?php _e( 'Image <b>ALT</b> attribute:', 'seo-friendly-images' ); ?></label>
								<input class="regular-text" type="text" id="rule_<?php echo $i; ?>_alt" name="rule_<?php echo $i; ?>_alt" value="<?php echo ( isset( $form[$i]['options']['alt'] ) ) ? $form[$i]['options']['alt'] : '%name %title'; ?>" />
								<span class="description"><?php _e( 'example: %name %title', 'seo-friendly-images' ); ?></span>
							</div>
							<div id="rule_<?php echo $i; ?>_title_div" class="rule">
								<label class="line2" for="rule_<?php echo $i; ?>_title"><?php _e( 'Image <b>TITLE</b> attribute:', 'seo-friendly-images' ); ?></label>
								<input class="regular-text" type="text" id="rule_<?php echo $i; ?>_title" name="rule_<?php echo $i; ?>_title" value="<?php echo ( isset( $form[$i]['options']['title'] ) ) ? $form[$i]['options']['title'] : '%name photo'; ?>" />
								<span class="description"><?php _e( 'example: %name photo', 'seo-friendly-images' ); ?></span>
							</div>
							<div id="rule_<?php echo $i; ?>_override_div" class="rule">
							<ul class="lists">
							<li>
								<label class="line2" for="rule_<?php echo $i; ?>_override_alt"><?php _e( 'Override default image alt tag', 'seo-friendly-images' ); ?></label>
								<input type="checkbox" id="rule_<?php echo $i; ?>_override_alt" name="rule_<?php echo $i; ?>_override_alt" <?php echo ( isset( $form[$i]['options']['override_alt'] ) ) ? $form[$i]['options']['override_alt'] : 'checked'; ?> />
								<span class="description"><?php _e( '( recommended )', 'seo-friendly-images' ); ?></span>
							</li>
							<li>
								<label class="line2" for="rule_<?php echo $i; ?>_override_title"><?php _e( 'Override default image title tag', 'seo-friendly-images' ); ?></label>
								<input type="checkbox" name="rule_<?php echo $i; ?>_override_title" id="rule_<?php echo $i; ?>_override_title" <?php echo ( isset( $form[$i]['options']['override_title'] ) ? $form[$i]['options']['override_title'] : '' ); ?> />
							</li>
							<li>
								<label class="line2" for="rule_<?php echo $i; ?>_strip_extension_title"><?php _e( 'Strip extension and delimiter characters from title tag', 'seo-friendly-images' ); ?></label>
								<input type="checkbox" name="rule_<?php echo $i; ?>_strip_extension_title" id="rule_<?php echo $i; ?>_strip_extension_title" <?php echo ( isset( $form[$i]['options']['strip_extension_title'] ) ? $form[$i]['options']['strip_extension_title'] : '' ); ?> />

							</li>
							
							</ul>								
							</div>
							<br />
							
						</div>
					</div>
				</div>
				</div>
					<?php endfor; ?>
					
					<div style="padding: 1.5em 0;margin: 5px 0;">
						<input type="submit" name="Submit" value="<?php _e( 'Update options', 'seo-friendly-images' ); ?>" />
					</div>
				</form>				
			</div> 
		</div>
		<h5><?php _e( 'Another fine WordPress plugin by', 'seo-friendly-images' ); ?> <a href="http://www.prelovac.com/vladimir/">Vladimir Prelovac</a></h5>
	</div>
	<?php	
	}
		
	function handle_about() {
		global $wp_version;
		
		$upd_msg = "";
		
		
		
		
		$imgpath = $this->plugin_url . '/i';
		$lic_msg = '<p>Welcome to ' . $this->name . '.</p><p>Thank you for using my plugin, if you find it useful please <a href="https://wordpress.org/plugins/seo-image/">rate it</a>.</p>';
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php _e( 'SEO Friendly Images', 'seo-friendly-images' ); echo '&nbsp;' . $this->local_version; ?></h2>
		<a href="admin.php?page=sfi_settings"><?php _e( 'Settings', 'seo-friendly-images' ); ?></a> &nbsp;|&nbsp; <a href="admin.php?page=sfi_about"><?php _e( 'About', 'seo-friendly-images' ); ?></a>
		<div id="poststuff" style="margin-top:10px;">
		
			<div id="sideblock" style="float:right;width:270px;margin-left:10px;">		  
					<div class="ad">
					<a href="https://managewp.com/?utm_source=Plugins&amp;utm_medium=Banner&amp;utm_content=mwp250_2&amp;utm_campaign=SEOFriendlyImages" title="ManageWP.com - Manage your sites from one dashboard"><img src="<?php echo $imgpath ?>/mwp250_2.png" alt="ManageWP.com - Manage Multiple WordPress Sites"></a>
					</div><br>
				<div class="ad">
					<a target="_blank" href="http://www.prelovac.com/products/seo-smart-links"><img src="<?php echo $imgpath ?>/seosmart125.png" title="SEO Smart Links Premium" alt="SEO Smart Links Premium"></a>                                                                                                                      
					<a target="_blank" href="http://www.prelovac.com/products/seo-friendly-images"><img src="<?php echo $imgpath ?>/seoimages125_v2.jpg" title="SEO Friendly Images Premium" alt="SEO Friendly Images Premium"></a>                                                                                                                      
				</div> 
			</div>
		</div>
		<div id="mainblock" class="submit">
			<div class="dbx-content">				
				<h2><?php _e( 'About', 'seo-friendly-images' ); ?></h2>
				<br />
					<?php echo $lic_msg; ?>
					<?php echo __( 'Version:', 'seo-friendly-images' ) . $this->local_version; ?> <?php echo $upd_msg; ?>
			</div>   
		</div>
		<h5><?php _e( 'Another fine WordPress plugin by', 'seo-friendly-images' ); ?> <a href="http://www.prelovac.com/vladimir/">Vladimir Prelovac</a></h5>
	</div>
	<?php
	}
	
	function remove_extension( $name ) {
		return preg_replace( '/(.+)\..*$/', '$1', $name );
	}
	
	function seo_friendly_images_process( $matches ) {
		global $post;
		
		$alttext_rep = $this->process_parameters["alt"];
		$titletext_rep = $this->process_parameters["title"];
		$override_alt = $this->process_parameters["override_alt"];
		$override_title = $this->process_parameters["override_title"];
		$strip_extension_title = $this->process_parameters["strip_extension_title"];
		
		$title = $post->post_title;
		
		# take care of unusual endings
		$matches[0] = preg_replace( '|([\'"])[/ ]*$|', '\1 /', $matches[0] );
		
		### Normalize spacing around attributes.
		$matches[0] = preg_replace( '/\s*=\s*/', '=', substr( $matches[0], 0, strlen( $matches[0] ) - 2 ) );
		### Get source.
		
		preg_match( '/src\s*=\s*([\'"])?((?(1).+?|[^\s>]+))(?(1)\1)/', $matches[0], $source );
		
		$saved = $source[2];
		
		### Swap with file's base name.
		preg_match( '%[^/]+(?=\.[a-z]{3}(\z|(?=\?)))%', $source[2], $source );
		### Separate URL by attributes.
		$pieces = preg_split( '/(\w+=)/', $matches[0], -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );
		### Add missing pieces.
		
		$tags = "";
		if ( strrpos( $alttext_rep, "%tags" ) !== false || strrpos( $titletext_rep, "%tags" ) !== false ) {
			$posttags = get_the_tags();		
			
			if ( $posttags ) {
				$i = 0;
				foreach ( $posttags as $tag ) {
					if ( $i == 0 ) {
						$tags = $tag->name . $tags;
					} else {
						$tags = $tag->name . ' ' . $tags;
					}
					++$i;
				}
			}
		}
		
		$cats = "";
		if ( strrpos( $alttext_rep, "%category" ) !== false || strrpos( $titletext_rep, "%category" ) !== false ) {
			$categories = get_the_category();
			
			if ( $categories ) {
				$i = 0;
				foreach ( $categories as $cat ) {
					if ( $i == 0 ) {
						$cats = $cat->slug . $cats;
					} else {
						$cats = $cat->slug . ' ' . $cats;
					}
					++$i;
				}
			}
		}
		
		if ( $override_title == "on" || !in_array('alt=', $pieces)) {
			$titletext_rep = str_replace("%title", $post->post_title, $titletext_rep );
			$titletext_rep = str_replace("%name", $source[0], $titletext_rep );
			$titletext_rep = str_replace("%category", $cats, $titletext_rep );
			$titletext_rep = str_replace("%tags", $tags, $titletext_rep );
			$titletext_rep = str_replace("%desc", $post->post_excerpt, $titletext_rep);
			
			if ( $strip_extension_title == "on" ) {
				$titletext_rep = str_replace( '"', '', $titletext_rep );
				$titletext_rep = str_replace("'", "", $titletext_rep );			
				$titletext_rep = str_replace("_", " ", $titletext_rep );
				$titletext_rep = str_replace("-", " ", $titletext_rep );
			}
			
			//$titletext_rep = ucwords( strtolower( $titletext_rep ) );
			if ( ! in_array( 'title=', $pieces ) ) {
				array_push( $pieces, ' title="' . $titletext_rep . '"' );
			} else {
				$index			  = array_search( 'title=', $pieces );
				$pieces[$index + 1] = '"' . $titletext_rep . '" ';
			}
		}
		if ( $override_alt == "on" || !in_array('alt=', $pieces)) {
			$alttext_rep = str_replace("%title", $post->post_title, $alttext_rep );
			$alttext_rep = str_replace("%name", $source[0], $alttext_rep );
			$alttext_rep = str_replace("%category", $cats, $alttext_rep );
			$alttext_rep = str_replace("%tags", $tags, $alttext_rep );
			$alttext_rep = str_replace("%desc", $post->post_excerpt, $alttext_rep);
			$alttext_rep = str_replace("\"", "", $alttext_rep );
			$alttext_rep = str_replace("'", "", $alttext_rep );
			
			$alttext_rep = ( str_replace("-", " ", $alttext_rep ) );
			$alttext_rep = ( str_replace("_", " ", $alttext_rep ) );
			
			if ( ! in_array( 'alt=', $pieces ) ) {
				array_push( $pieces, ' alt="' . $alttext_rep . '"' );
			} else {
				$index			  = array_search( 'alt=', $pieces );
				$pieces[$index + 1] = '"' . $alttext_rep . '" ';
			}
		}
		
		return implode( '', $pieces ) . ' /';
	}   
	
	function get_proper_options() {
		$options = null;
		
		if ( is_home() ) {
			if ( $this->tree["main"]["home"]["options"] != null ) {
				$options = $this->tree["main"]["home"]["options"];
			} elseif ( $this->tree["main"]["options"] != null ) {
				$options = $this->tree["main"]["options"];
			} else {
				$options = $this->tree["all"]["options"];
			}
		} elseif ( is_front_page() ) {
			if ( $this->tree["main"]["front"]["options"] != null ) {
				$options = $this->tree["main"]["front"]["options"];
			} elseif ( $this->tree["main"]["options"] != null ) {
				$options = $this->tree["main"]["options"];
			} else {
				$options = $this->tree["all"]["options"];
			}
		} elseif ( is_category() ) {
			$cur_category_id = get_cat_id( single_cat_title("",false ) );
			$found = false;
			$found_group = null;
			if (isset( $this->tree["archive"]["category"])) 
			foreach ( $this->tree["archive"]["category"] as $key => $group ) {
				if ( $key != 'options' ) {
					$found = $found || in_array( $cur_category_id, $group["ids"] );
					if ( in_array( $cur_category_id, $group["ids"] ) ) {
						$found_group = $key;
					}
				}
			}
			if ( $found ) {
				$options = $this->tree["archive"]["category"][$found_group]["options"];
			} elseif ( $this->tree["archive"]["category"]["options"] != null ) {
				$options = $this->tree["archive"]["category"]["options"];
			} elseif ( $this->tree["archive"]["options"] != null ) {
				$options = $this->tree["archive"]["options"];
			} else {
				$options = $this->tree["all"]["options"];
			}
		} elseif ( is_tag() ) {
			$cur_tag_title = single_tag_title("",false );
			$tag = get_term_by( 'name', $cur_tag_title, 'post_tag' );
			if ( $tag ) {
				$cur_tag_id = $tag->term_id;
			} else {
				$cur_tag_id = 0;
			}
			$found = false;
			$found_group = null;
			if (isset($this->tree["archive"]["tag"]))
			foreach ( $this->tree["archive"]["tag"] as $key => $group ) {
				if ( $key != 'options' ) {
					$found = $found || in_array( $cur_tag_id, $group["ids"] );
					if ( in_array( $cur_tag_id, $group["ids"] ) ) {
						$found_group = $key;
					}
				}
			}
			if ( $found ) {
				$options = $this->tree["archive"]["tag"][$found_group]["options"];
			} elseif ( $this->tree["archive"]["tag"]["options"] != null ) {
				$options = $this->tree["archive"]["tag"]["options"];
			} elseif ( $this->tree["archive"]["options"] != null ) {
				$options = $this->tree["archive"]["options"];
			} else {
				$options = $this->tree["all"]["options"];
			}
		} elseif ( is_tax() ) {
			$term = get_queried_object();
			$cur_taxonomy_id = $term->term_id;
			$found = false;
			$found_group = null;
			if (isset( $this->tree["archive"]["taxonomy"]))
			foreach ( $this->tree["archive"]["taxonomy"] as $key => $group ) {
				if ( $key != 'options' ) {
					$found = $found || in_array( $cur_taxonomy_id, $group["ids"] );
					if ( in_array( $cur_taxonomy_id, $group["ids"] ) ) {
						$found_group = $key;
					}
				}
			}
			if ( $found ) {
				$options = $this->tree["archive"]["taxonomy"][$found_group]["options"];
			} elseif ( $this->tree["archive"]["taxonomy"]["options"] != null ) {
				$options = $this->tree["archive"]["taxonomy"]["options"];
			} elseif ( $this->tree["archive"]["options"] != null ) {
				$options = $this->tree["archive"]["options"];
			} else {
				$options = $this->tree["all"]["options"];
			}
		} elseif ( is_author() ) {
			$term = get_queried_object();
			$cur_author_id = $term->ID;
			$found = false;
			$found_group = null;
			if (isset($this->tree["archive"]["author"]))
			foreach ( $this->tree["archive"]["author"] as $key => $group ) {
				if ( $key != 'options' ) {
					$found = $found || in_array( $cur_author_id, $group["ids"] );
					if ( in_array( $cur_author_id, $group["ids"] ) ) {
						$found_group = $key;
					}
				}
			}
			if ( $found ) {
				$options = $this->tree["archive"]["author"][$found_group]["options"];
			} elseif ( $this->tree["archive"]["author"]["options"] != null ) {
				$options = $this->tree["archive"]["author"]["options"];
			} elseif ( $this->tree["archive"]["options"] != null ) {
				$options = $this->tree["archive"]["options"];
			} else {
				$options = $this->tree["all"]["options"];
			}
		} elseif ( is_year() ) {
			if ( $this->tree["archive"]["date"]["year"]["options"] != null ) {
				$options = $this->tree["archive"]["date"]["year"]["options"];
			} elseif ( $this->tree["archive"]["date"]["options"] != null ) {
				$options = $this->tree["archive"]["date"]["options"];
			} elseif ( $this->tree["archive"]["options"] != null ) {
				$options = $this->tree["archive"]["options"];
			} else {
				$options = $this->tree["all"]["options"];
			}
		} elseif ( is_month() ) {
			if ( $this->tree["archive"]["date"]["month"]["options"] != null ) {
				$options = $this->tree["archive"]["date"]["month"]["options"];
			} elseif ( $this->tree["archive"]["date"]["options"] != null ) {
				$options = $this->tree["archive"]["date"]["options"];
			} elseif ( $this->tree["archive"]["options"] != null ) {
				$options = $this->tree["archive"]["options"];
			} else {
				$options = $this->tree["all"]["options"];
			}
		} elseif ( is_day() ) {
			if ( $this->tree["archive"]["date"]["day"]["options"] != null ) {
				$options = $this->tree["archive"]["date"]["day"]["options"];
			} elseif ( $this->tree["archive"]["date"]["options"] != null ) {
				$options = $this->tree["archive"]["date"]["options"];
			} elseif ( $this->tree["archive"]["options"] != null ) {
				$options = $this->tree["archive"]["options"];
			} else {
				$options = $this->tree["all"]["options"];
			}
		} elseif ( is_time() ) {
			if ( $this->tree["archive"]["date"]["time"]["options"] != null ) {
				$options = $this->tree["archive"]["date"]["time"]["options"];
			} elseif ( $this->tree["archive"]["date"]["options"] != null ) {
				$options = $this->tree["archive"]["date"]["options"];
			} elseif ( $this->tree["archive"]["options"] != null ) {
				$options = $this->tree["archive"]["options"];
			} else {
				$options = $this->tree["all"]["options"];
			}
		} elseif ( is_attachment() ) {
			global $post;
			$cur_attachment_id = $post->ID;
			$found = false;
			$found_group = null;
			if (isset( $this->tree["singular"]["attachment"]))
			foreach ( $this->tree["singular"]["attachment"] as $key => $group ) {
				if ( $key != 'options' ) {
					$found = $found || in_array( $cur_attachment_id, $group["ids"] );
					if ( in_array( $cur_attachment_id, $group["ids"] ) ) {
						$found_group = $key;
					}
				}
			}
			if ( $found ) {
				$options = $this->tree["singular"]["attachment"][$found_group]["options"];
			} elseif ( $this->tree["singular"]["attachment"]["options"] != null ) {
				$options = $this->tree["singular"]["attachment"]["options"];
			} elseif ( $this->tree["singular"]["options"] != null ) {
				$options = $this->tree["singular"]["options"];
			} else {
				$options = $this->tree["all"]["options"];
			}
		} elseif ( is_page() ) {
			global $post;
			$cur_page_id = $post->ID;
			$found = false;
			$found_group = null;
			if (isset( $this->tree["singular"]["page"] )) 
			foreach ( $this->tree["singular"]["page"] as $key => $group ) {
				if ( $key != 'options' ) {
					$found = $found || in_array( $cur_page_id, $group["ids"] );
					if ( in_array( $cur_page_id, $group["ids"] ) ) {
						$found_group = $key;
					}
				}
			}
			if ( $found ) {
				$options = $this->tree["singular"]["page"][$found_group]["options"];
			} elseif ( $this->tree["singular"]["page"]["options"] != null ) {
				$options = $this->tree["singular"]["page"]["options"];
			} elseif ( $this->tree["singular"]["options"] != null ) {
				$options = $this->tree["singular"]["options"];
			} else {
				$options = $this->tree["all"]["options"];
			}
		}
		elseif ( is_single() ) {
			global $post;
			$cur_post_id = $post->ID;
			$found = false;
			$found_group = null;
			if (isset( $this->tree["singular"]["post"] )) 
			foreach ( $this->tree["singular"]["post"] as $key => $group ) {
				if ( $key != 'options' ) {
					$found = $found || in_array( $cur_post_id, $group["ids"] );
					if ( in_array( $cur_post_id, $group["ids"] ) ) {
						$found_group = $key;
					}
				}
			}
			if ( $found ) {
				$options = $this->tree["singular"]["post"][$found_group]["options"];
			} elseif ( $this->tree["singular"]["post"]["options"] != null ) {
				$options = $this->tree["singular"]["post"]["options"];
			} elseif ( $this->tree["singular"]["options"] != null ) {
				$options = $this->tree["singular"]["options"];
			} else {
				$options = $this->tree["all"]["options"];
			}
		}
		
		return $options;
	}
	
	function seo_friendly_images( $content ) {
		$options = $this->get_proper_options();
		

			$this->process_parameters['alt'] = $options['alt'];
			$this->process_parameters['title'] = $options['title'];
			$this->process_parameters['override_alt'] = $options['override_alt'];
			$this->process_parameters['override_title'] = $options['override_title'];
			$this->process_parameters['strip_extension_title'] = $options['strip_extension_title'];
			$replaced = preg_replace_callback( '/<img[^>]+/', array( $this, 'seo_friendly_images_process' ), $content, 20 );
			
			return $replaced;
	
		
		return $content;
	}
	
	function seo_friendly_images_featured( $html ) {
		$options = $this->get_proper_options();

			$this->process_parameters['alt'] = $options['alt'];
			$this->process_parameters['title'] = $options['title'];
			$this->process_parameters['override_alt'] = $options['override_alt'];
			$this->process_parameters['override_title'] = $options['override_title'];
			$this->process_parameters['strip_extension_title'] = $options['strip_extension_title'];
			$replaced = preg_replace_callback( '/<img[^>]+/', array( $this, 'seo_friendly_images_process' ), $html );
			return $replaced;
		
		return $html;
	}
	

	
	//this function removes 640x480 like dimension information from image URLs which is added by wordpress when generating multiple images for the uploaded one 
	function fix_img_url( $url ) {
		$url = preg_replace( '/-([0-9]{1,5})x([0-9]{1,5})\./i', '.', $url );
		return $url;
	}
	
	
	function get_options() {
		$options = array(
			
			'rules' => array(
				0 => array(
					'domains' => array(
						'all'
					),
					'options' => array(
						'alt' => '%name %title',
						'title' => '%name photo',
						'override_alt' => 'on',
						'override_title' => 'off',
						'strip_extension_title' => 'on',
						
						'attach_internal_images' => 'def',
						
						'attach_external_images' => 'def',
					
						'external_links' => 'on',
						'enable' => true
					)
				)
			),
		
		);
		
		$saved = get_option( $this->key );
		
		if (!empty($options['rules'])) {
			foreach ($options['rules'] as $key => $option)
				if (!isset($saved['rules'][$key]))
					$saved['rules'][$key] = $option;
		}
		
		if ( $saved != $options ) {
			update_option( $this->key, $saved );
		}
		
		return $saved;
	}
}
?>