<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>     
<div class="wrap wp-filemanager-wrap">
<?php $fm_nonce = wp_create_nonce( 'wp-file-manager' ); 
$wp_fm_lang = get_transient( 'wp_fm_lang' );
$wp_fm_theme = get_transient( 'wp_fm_theme' );
$current_user = wp_get_current_user(); 
$vle_nonce = wp_create_nonce( 'verify-filemanager-email' );
$syntax_checker = get_option('wp_file_manager_settings');
?>
<script src="<?php echo plugins_url( 'codemirror/lib/codemirror.js', __FILE__ ); ?>"></script>
<link rel="stylesheet" href="<?php echo plugins_url( 'codemirror/lib/codemirror.css', __FILE__ ); ?>">
<link rel="stylesheet" href="<?php echo plugins_url( 'codemirror/theme/3024-day.css', __FILE__ ); ?>">
<link rel="stylesheet" href="<?php echo plugins_url( 'codemirror/addons/lint.css', __FILE__ ); ?>">
<script>
var security_key = "<?php echo $fm_nonce;?>";
var fmlang = "<?php echo isset($_GET['lang']) ? sanitize_text_field($_GET['lang']) : ($wp_fm_lang !== false) ? $wp_fm_lang : 'en';?>";
var vle_nonce = "<?php echo $vle_nonce;?>";
jQuery(document).ready(function() {	
var ajaxurl = "<?php echo admin_url('admin-ajax.php');?>"
				jQuery('#wp_file_manager').elfinder({
					url : ajaxurl,
					customData : {action: 'mk_file_folder_manager', _wpnonce: security_key },
					uploadMaxChunkSize : 1048576000000,
					defaultView : 'list',
					height: 500,
					lang : fmlang,
					/* Start */
					handlers : {},
					commandsOptions: {
									edit : {
						
											mimes : [],
											
											editors : [{
											
											mimes : ['text/plain', 'text/html', 'text/javascript', 'text/css', 'text/x-php', 'application/x-php'],
											
											load : function(textarea) {																							
					
										         var mimeType = this.file.mime;
												  return CodeMirror.fromTextArea(textarea, {
													//mode: 'css',
													indentUnit: 4,
													lineNumbers: true,													
													theme: "3024-day",
													viewportMargin: Infinity,
													lineWrapping: true,
													//gutters: ["CodeMirror-lint-markers"],
													lint: true
												  });
					
												
											},										
											close : function(textarea, instance) {
					                        this.myCodeMirror = null;
					                        },				
											
											save: function(textarea, editor) {												
												   // check syntax errors												   
											<?php if(isset($syntax_checker['fm_syntax_checker']) && !empty($syntax_checker['fm_syntax_checker']) && $syntax_checker['fm_syntax_checker'] == 1) { ?>
											        var filename = this.file.name;
												   	var data = {
														'action': 'mk_check_filemanager_php_syntax',
														'code': editor.getValue(),
														'filename': filename,
														'filemime': this.file.mime,
													};
													//syntax checker
													jQuery.post(ajaxurl, data, function(response) {
														if(response == '1') {															
															jQuery(textarea).val(editor.getValue());
														} else {
															jQuery('.fm_msg_popup').fadeIn();
															jQuery('.fm_msg_text').html(response);
														}
													});
													<?php } else { ?>
													jQuery(textarea).val(editor.getValue());
													<?php } ?>							  					  
												}
											
											} ]
											},
											
							}
											
					/* END */
				}).elfinder('instance');	
});				
</script>
<?php
$this->load_custom_assets();
$this->load_help_desk();
?>

<link href="https://fonts.googleapis.com/css?family=Raleway:400,700,900" rel="stylesheet"> 

<div class="wp_fm_lang" style="float:left">
<h3 class="fm_heading"><span class="fm_head_icon"><img src="<?php echo plugins_url( 'images/wp_file_manager-color.png', dirname(__FILE__) ); ?>"></span> <span class="fm_head_txt"> <?php  _e('WP File Manager', 'wp-file-manager'); ?> </span> <a href="https://filemanagerpro.io/product/file-manager" class="button button-primary fm_pro_btn" target="_blank" title="Click to Buy PRO"><?php  _e('Buy PRO', 'wp-file-manager'); ?></a></h3>
</div>

<div class="wp_fm_lang" style="float:right">
<h3 class="fm-topoption">

<span class="switch_txt_theme">Change Theme Here:</span>

<select name="theme" id="fm_theme">
<option value="default" <?php echo (isset($_GET['theme']) && $_GET['theme'] == 'default') ? 'selected="selected"' : ($wp_fm_theme !== false) && $wp_fm_theme == 'default' ? 'selected="selected"' : '';?>><?php  _e('Default', 'wp-file-manager'); ?></option>
<option value="dark" <?php echo (isset($_GET['theme']) && $_GET['theme'] == 'dark') ? 'selected="selected"' : ($wp_fm_theme !== false) && $wp_fm_theme == 'dark' ? 'selected="selected"' : '';?>><?php  _e('Dark', 'wp-file-manager'); ?></option>
<option value="light" <?php echo (isset($_GET['theme']) && $_GET['theme'] == 'light') ? 'selected="selected"' : ($wp_fm_theme !== false) && $wp_fm_theme == 'light' ? 'selected="selected"' : '';?>><?php  _e('Light', 'wp-file-manager'); ?></option>
<option value="gray" <?php echo (isset($_GET['theme']) && $_GET['theme'] == 'gray') ? 'selected="selected"' : ($wp_fm_theme !== false) && $wp_fm_theme == 'gray' ? 'selected="selected"' : '';?>><?php  _e('Gray', 'wp-file-manager'); ?></option>
<option value="windows - 10" <?php echo (isset($_GET['theme']) && $_GET['theme'] == 'windows - 10') ? 'selected="selected"' : ($wp_fm_theme !== false) && $wp_fm_theme == 'windows - 10' ? 'selected="selected"' : '';?>><?php  _e('Windows - 10', 'wp-file-manager'); ?></option>
</select>
<select name="lang" id="fm_lang">
<?php foreach($this->fm_languages() as $name => $lang) { ?>
<option value="<?php echo $lang;?>" <?php echo (isset($_GET['lang']) && $_GET['lang'] == $lang) ? 'selected="selected"' : ($wp_fm_lang !== false) && $wp_fm_lang == $lang ? 'selected="selected"' : '';?>><?php echo $name;?></option>
<?php } ?>
</select></h3>
</div><div style="clear:both"></div>
<div id="wp_file_manager"><center><img src="<?php echo plugins_url( 'images/loading.gif', dirname(__FILE__) ); ?>" class="wp_fm_loader" /></center></div>


<?php ///***** Verify Lokhal Popup Start *****/// 
//delete_transient( 'filemanager_cancel_lk_popup_'.$current_user->ID );
?>
<?php if(false === get_option( 'filemanager_email_verified_'.$current_user->ID ) && ( false === ( get_transient( 'filemanager_cancel_lk_popup_'.$current_user->ID ) ) ) ) { ?>
<div id="lokhal_verify_email_popup" class="lokhal_verify_email_popup">
<div class="lokhal_verify_email_popup_overlay"></div>
<div class="lokhal_verify_email_popup_tbl">
<div class="lokhal_verify_email_popup_cel">
<div class="lokhal_verify_email_popup_content">
<a href="javascript:void(0)" class="lokhal_cancel"> <img src="<?php echo plugins_url( 'lib/img/fm_close_icon.png', dirname(__FILE__) ); ?>" class="wp_fm_loader" /></a>
<div class="popup_inner_lokhal">
<h3><?php  _e('Welcome to File Manager', 'wp-file-manager'); ?></h3>
<p class="lokhal_desc"><?php  _e('We love making new friends! Subscribe below and we promise to  
keep you up-to-date with our latest new plugins, updates,
awesome deals and a few special offers.', 'wp-file-manager'); ?></p>
<form>
<div class="form_grp">
<div class="form_twocol">
<input name="verify_lokhal_fname" id="verify_lokhal_fname" class="regular-text" type="text" value="<?php echo (null == get_option('verify_filemanager_fname_'.$current_user->ID)) ? $current_user->user_firstname : get_option('verify_filemanager_fname_'.$current_user->ID);?>" placeholder="First Name" />
<span id="fname_error" class="error_msg"><?php  _e('Please Enter First Name.', 'wp-file-manager'); ?></span>
</div>
<div class="form_twocol">
<input name="verify_lokhal_lname" id="verify_lokhal_lname" class="regular-text" type="text" value="<?php echo (null == 
get_option('verify_filemanager_lname_'.$current_user->ID)) ? $current_user->user_lastname : get_option('verify_filemanager_lname_'.$current_user->ID);?>" placeholder="Last Name" />
<span id="lname_error" class="error_msg"><?php  _e('Please Enter Last Name.', 'wp-file-manager'); ?></span>
</div>
</div>
<div class="form_grp">
<div class="form_onecol">
<input name="verify_lokhal_email" id="verify_lokhal_email" class="regular-text" type="text" value="<?php echo (null == get_option('filemanager_email_address_'.$current_user->ID)) ? $current_user->user_email :  get_option('filemanager_email_address_'.$current_user->ID);?>" placeholder="Email Address" />
<span id="email_error" class="error_msg"><?php  _e('Please Enter Email Address.', 'wp-file-manager'); ?></span>
</div>
</div>
<div class="btn_dv">
<button class="verify verify_local_email button button-primary "><span class="btn-text">Verify
          </span>
          <span class="btn-text-icon">
            <img src="<?php echo plugins_url( 'images/btn-arrow-icon.png', dirname(__FILE__) ); ?>"/>
          </span></button>
<button class="lokhal_cancel button"><?php  _e('No Thanks', 'wp-file-manager'); ?></button>
</div>
</form>
</div>
<div class="fm_bot_links">
  <a href="http://ikon.digital/terms.html" target="_blank"><?php  _e('Terms of Service', 'wp-file-manager'); ?></a>   <a href="http://ikon.digital/privacy.html" target="_blank"><?php  _e('Privacy Policy', 'wp-file-manager'); ?></a>
</div>

</div>
</div>
</div>
</div>

<?php } ///***** Verify Lokhal Popup End *****/// ?>


</div>

<div class="fm_msg_popup">
    <div class="fm_msg_popup_tbl">
        <div class="fm_msg_popup_cell">
            <div class="fm_msg_popup_inner">
            <div class="fm_msg_text">
            	Saving...
            </div>
            <div class="fm_msg_btn_dv"><a href="javascript:void(0)" class="fm_close_msg button button-primary">OK</a></div>
            </div>
        </div>
    </div>
</div>

<style>
.fm_msg_popup{
	display: none;
	position:fixed;
	top:0;
	left:0;
	right:0;
	bottom:0;
	z-index: 9999;
	background:rgba(0,0,0,0.7);
}
.fm_msg_popup .fm_msg_popup_tbl{
	display:table;
	width:100%;
	height:100%;
}
.fm_msg_popup .fm_msg_popup_tbl .fm_msg_popup_cell{
	display:table-cell;
	vertical-align:middle;
}
.fm_msg_popup .fm_msg_popup_tbl .fm_msg_popup_cell .fm_msg_popup_inner {
	max-width: 400px;
	margin: 0 auto;
	background: #fff;
	padding: 30px;
	text-align:center;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	box-shadow: 10px 10px 5px rgba(0,0,0,0.4);
}
.fm_msg_popup .fm_msg_popup_tbl .fm_msg_popup_cell .fm_msg_popup_inner .fm_msg_text{
	margin-bottom:25px;
	font-size:15px;
	color: #ff2400;
}
.fm_msg_popup .fm_msg_popup_tbl .fm_msg_popup_cell .fm_msg_popup_inner .fm_msg_btn_dv a {
	/*border: 6px double #FFF;
	border-radius: 30px;
	display: inline-block;	
	font-size: 14px;
	line-height: 14px;
	text-decoration: none;
	background: #06F;
	color: #fff;
	outline:none !important;
	box-shadow:none !important;*/
	padding: 0px 30px;	
}
</style>

<script>
jQuery(document).ready(function(e) {
    jQuery('.fm_close_msg').click(function(e) {
        jQuery('.fm_msg_popup').fadeOut();
    });
});
</script>