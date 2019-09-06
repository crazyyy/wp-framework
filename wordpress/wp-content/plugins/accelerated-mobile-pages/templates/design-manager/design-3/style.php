<?php
use AMPforWP\AMPVendor\AMP_Post_Template;
//add_action('amp_post_template_css', 'ampforwp_additional_style_input_3');
//function ampforwp_additional_style_input_3( $amp_template ) {
  global $redux_builder_amp;
  global $post;
  $post_id = '';
  $post_id = $post->ID;
  $get_customizer = new AMP_Post_Template( $post_id );
  // Get content width
  $colorscheme    = ampforwp_get_setting('amp-opt-color-rgba-colorscheme','color');
  $font_color     = ampforwp_get_setting('amp-opt-color-rgba-font','color');
  $link_color     = ampforwp_get_setting('amp-opt-color-rgba-link','color');
  $sticky_head    = ampforwp_get_setting('amp-opt-sticky-head');

  $content_max_width       = absint( $get_customizer->get( 'content_max_width' ) );
  // Get template colors
  $header_background_color = $get_customizer->get_customizer_setting( 'header_background_color' );
  $header_color            = $get_customizer->get_customizer_setting( 'header_color' );
  ?>

/* Global Styling */
body{ font: 16px/1.4 Sans-serif; }
a{ color: #312C7E; text-decoration: none }
.clearfix, .cb{ clear: both }
.alignleft{ margin-right: 12px; margin-bottom:5px; float: left; }
.alignright{ float:right; margin-left: 12px; margin-bottom:5px; }
.aligncenter{ text-align:center; margin: 0 auto }
#statcounter{width: 1px;height:1px;}
amp-anim { max-width: 100%; }
amp-wistia-player {margin:5px 0px;}
.amp-wp-content amp-iframe{max-width:100%}
.amp-wp-article amp-addthis{bottom: -20px;}
@media screen and (min-width: 1025px){
.amp-wp-article amp-addthis{margin-left: 150px;}
}
.hide{display:none}
ol, ul {list-style-position: inside;}
@font-face {
    font-family: 'Roboto Slab';
    font-display: swap;
    font-style: normal;
    font-weight: 400;
    src:  local('Roboto Slab Regular'), local('RobotoSlab-Regular'), url('<?php echo esc_url(plugin_dir_url(__FILE__).'fonts/robotoslab/RobotoSlab-Regular.ttf'); ?>');
}
@font-face {
    font-family: 'Roboto Slab';
    font-display: swap;
    font-style: normal;
    font-weight: 700;
    src:  local('Roboto Slab Bold'), local('RobotoSlab-Bold'), url('<?php echo esc_url(plugin_dir_url(__FILE__).'fonts/robotoslab/RobotoSlab-Bold.ttf'); ?>');
}

@font-face {
    font-family: 'PT Serif';
    font-display: swap;
    font-style: normal;
    font-weight: 400;
    src:  local('PT Serif'), local('PTSerif-Regular'), url('<?php echo esc_url(plugin_dir_url(__FILE__).'fonts/ptserif/PT_Serif-Web-Regular.ttf'); ?>');
}
@font-face {
    font-family: 'PT Serif';
    font-display: swap;
    font-style: normal;
    font-weight: 700;
    src:  local('PT Serif Bold'), local('PTSerif-Bold'), url('<?php echo esc_url(plugin_dir_url(__FILE__).'fonts/ptserif/PT_Serif-Web-Bold.ttf'); ?>');
}

/* Template Styles */
.amp-wp-content, .amp-wp-title-bar div {
    <?php if ( $content_max_width > 0 ) : ?>
    max-width: <?php echo esc_attr( sprintf( '%dpx', $content_max_width ) ); ?>;
    margin: 0 auto;
    <?php endif; ?>
}
figure.aligncenter amp-img {
 margin: 0 auto;
 }
/* Slide Navigation code */
<?php
  $headercolor          = ampforwp_get_setting('amp-opt-color-rgba-headercolor','color');
  $headerelements       = ampforwp_get_setting('amp-opt-color-rgba-headerelements','color');
  $menubgcolor          = ampforwp_get_setting('amp-opt-color-rgba-menu-bg-color','color');
  $navmenucolor         = ampforwp_get_setting('amp-opt-color-rgba-menu-elements-color','color');
  $submenucolor         = ampforwp_get_setting('amp-opt-color-rgba-submenu-bgcolor','color');
  $submenuhovercolor    = ampforwp_get_setting('amp-opt-color-rgba-submenu-hover-bgcolor','color');
  $menulblcolor         = ampforwp_get_setting('amp-opt-color-rgba-menu-label-color','color');
  $menubdrcolor         = ampforwp_get_setting('amp-opt-color-rgba-menu-brdr-color','color');

//when the fields are empty default value will load
if(empty($headercolor)){
    $headercolor ='#FFFFFF';
}
if(empty($headerelements)){
    $headerelements ='#F42F42';
}
if(empty($menubgcolor)){
    $menubgcolor ='#131313';
}
if(empty($navmenucolor)){
    $navmenucolor ='#eeeeee';
}
if(empty($submenucolor)){
    $submenucolor ='#666666';
}
if(empty($submenuhovercolor)){
    $submenuhovercolor ='#666666';
}
if(empty($menulblcolor)){
    $menulblcolor ='#aaaaaa';
}
if(empty($menubdrcolor)){
    $menubdrcolor ='#555555';
}
?>
amp-sidebar{ width: 280px;font-family: 'Roboto Slab', serif;background:<?php echo ampforwp_sanitize_color($menubgcolor);?>; }
.amp-sidebar-image{ line-height: 100px; vertical-align:middle; }
.amp-close-image{ top: 15px; left: 225px; cursor: pointer; }
.navigation_heading{ padding: 20px 20px 15px 20px; color: <?php echo ampforwp_sanitize_color($menulblcolor); ?>; font-size: 10px; font-family: sans-serif; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid <?php echo ampforwp_sanitize_color($menubdrcolor); ?>; display: inline-block; width: 100%}
.toggle-navigationv2 ul{ list-style-type: none; margin: 15px 0 0 0; padding: 0}
.toggle-navigationv2 ul.amp-menu li a{ padding: 10px 15px 10px 20px; display: inline-block; font-size: 14px;      color:<?php echo ampforwp_sanitize_color($navmenucolor); ?>; width:100% }
.amp-menu li{position:relative;margin:0;}
.toggle-navigationv2 ul.amp-menu li a:hover{background:<?php echo ampforwp_sanitize_color($submenuhovercolor); ?>;color:<?php echo ampforwp_sanitize_color($navmenucolor); ?>;}
.amp-menu li.menu-item-has-children ul{display:none;margin:0;position:relative;
background:<?php echo ampforwp_sanitize_color($submenucolor);?>;
}
.amp-menu li.menu-item-has-children .sub-menu li a span:before{
    content: '\25b8';
    position: relative;
    left: -6px;
    font-size: 10px;
    color:<?php echo ampforwp_sanitize_color($menulblcolor); ?>;
    top: -2px;
    z-index: 10000;
    line-height: 1;
}
.amp-menu li.menu-item-has-children .sub-menu li a{
      padding: 15px 0px 15px 20px;
}
.amp-menu li.menu-item-has-children .sub-menu .sub-menu li a{
    padding: 15px 0px 15px 33px;
}
.amp-menu li.menu-item-has-children .sub-menu .sub-menu .sub-menu li a{
  padding: 15px 0px 15px 45px;
}
.amp-menu input{display:none}
.amp-menu [id^=drop]:checked + label + ul{ display: block;}
.amp-menu .toggle:after{content:'\25be';position:absolute;padding: 12px 20px 10px 30px;right:0;font-size:13px;color:<?php echo ampforwp_sanitize_color($navmenucolor); ?>;top:6px;z-index:10000;line-height:1}
.toggle-navigationv2 .social_icons{ margin-top: 25px; border-top: 1px solid <?php echo ampforwp_sanitize_color($menubdrcolor); ?>; padding: 25px 0px; color: #fff; width: 100%; }
.menu-all-pages-container:after{ content: ""; clear: both }
.toggle-text{ color: #fff; font-size: 12px; text-transform: uppercase; letter-spacing: 3px; display: inherit; text-align: center; }
.toggle-text:before{ content: "..."; font-size: 32px; position: ; font-family: georgia; line-height: 0px; margin-left: 0px; letter-spacing: 1px; top: -3px; position: relative; padding-right: 10px; }
.toggle-navigation:hover, .toggle-navigation:active, .toggle-navigation:focus{ display: inline-block; width: 100%; }
.toggle-navigationv2{position:relative;}
.cl-btn:after{
    content: "x";
    font-size: 16px;
    color:<?php echo ampforwp_sanitize_color($menulblcolor); ?>;
    position: absolute;
    right: 15px;
    top: 15px;
    font-weight: normal;
}
.cl-btn{background: #131313;border:none;}
<?php if( !ampforwp_woocommerce_conditional_check() ) { ?>
<?php if ( ! is_singular() ) { ?>
/* Pagination */
.amp-wp-content.pagination-holder{ background: none; padding: 0; box-shadow: none; height: auto; min-height: auto; }
#pagination{ width: 100%; margin-top: 20px; }
#pagination .next, #pagination .prev{ margin: 0px 6% 10px 6%; }
#pagination .next a, #pagination .prev a{ opacity:0.9; background: #f42f42; width: 100%; color: #fff; display: inline-block; text-align: center; font-size: 16px; line-height: 1; padding: 18px 0%; border-radius: 4px; }
<?php }
} // AMP Woocommerce CSS Ends 
if ( ampforwp_get_setting('enable-single-social-icons') == true && is_single() || is_page() ) {?>
/* Sticky Social bar in Single */
.sticky_social{ width: 100%; bottom: 0; display: block; left: 0; box-shadow: 0px 4px 7px #000; background: #fff; padding: 7px 0px 0px 0px; position: fixed; margin: 0; z-index: 10; text-align: center; }
.amp-social-icon{ width: 50px; height: 28px; display: inline-block; background: #5cbe4a;position: relative; top: -8px; padding-top: 0px; }
.amp-social-icon amp-img{ top: 4px; }
.amp-social-icon.custom-amp-socialsharing-flipboard amp-img ,.amp-social-icon.amp-social-flipboard amp-img {top: 6px;}
a.amp-social-facebook-messenger,.amp-social-facebookmessenger{background:#d5e1e6;}
.custom-amp-socialsharing-line{background:#00b900}
.custom-amp-socialsharing-mewe{background:#b8d6e6}
.sticky_social .whatsapp-share-icon{ padding: 4px 0px 14px 0px; height: 28px; top: -4px; position: relative; }
.sticky_social .line-share-icon{ padding: 4px 0px 14px 0px; height: 28px; top: -4px; position: relative; }
<?php }?>
/*Sticky Head For Design 3*/
#header{ background: #fff; text-align: center; height:50px; box-shadow:0 0 32px rgba(0,0,0,.15); }
header{ padding-bottom:50px; }
#headerwrap{ position: fixed; z-index:1000; width: 100%; top:0; }
<?php if ( $sticky_head ) { ?>
  header{ padding-bottom:0px; }
#headerwrap{ position: relative;}
<?php } ?>
#header <?php if(is_single()){ ?> h2 <?php } else{?>h1<?php }?>{ text-align: center; font-size: 16px; position: relative; font-weight: bold; line-height: 50px; padding: 0; margin: 0; text-transform: uppercase }
<?php if( !ampforwp_woocommerce_conditional_check() ) { ?>
main .amp-wp-content{ font-size: 18px; line-height: 29px; color:#111 }
.amp-wp-meta.amp-meta-wrapper{list-style-type:none;}
.single-post main .amp-wp-article-content h1{ font-size:2em}
.single-post main .amp-wp-article-content h1, .single-post main .amp-wp-article-content h2, .single-post main .amp-wp-article-content h3, .single-post main .amp-wp-article-content h4, .single-post main .amp-wp-article-content h5, .single-post main .amp-wp-article-content h6{ font-family: 'Roboto Slab', serif; margin: 0px 0px 5px 0px; line-height: 1.6; }
.home-post_image{ float: left; width:33%; padding-right: 2%; overflow:hidden; max-height: 225px }
.amp-wp-title{ margin-top: 0px; }
h2.amp-wp-title , h3.amp-wp-title{ font-family: 'Roboto Slab', serif; font-weight: 700; font-size: 20px; margin-bottom: 7px; line-height: 1.3; }
h2.amp-wp-title a ,h3.amp-wp-title a{ color: #000; }
.amp-wp-tags{ list-style-type: none; padding: 0; margin: 0 0 9px 0; display: inline-flex; }
.amp-wp-tags li{ display: inline; background: #F6F6F6; color: #9e9e9e; line-height: 1; border-radius: 50px; padding: 8px 18px; font-size: 12px; margin-right: 8px; top: -3px; position: relative; }
.amp-wp-tags li a{ color: #9e9e9e; }
.amp-loop-list{ position:relative; border-bottom: 1px solid #ededed; padding: 25px 15px 25px 15px }
body .amp-loop-list-noimg .amp-wp-post-content{ width:100% }
.amp-loop-list .amp-wp-post-content{ float: left; width: 65%; }
.amp-loop-list .featured_time{ color:#b3b3b3; padding-left:0 }
.amp-wp-post-content p{ color: grey; line-height: 1.5; font-size: 14px;word-break: break-word; margin: 8px 0 10px; font-family:'PT Serif', serif }
<?php if ( 1 == ampforwp_get_setting('enable-excerpt-single') ) { ?>
/* For Excerpt */
.amp-wp-post-content .small-screen-excerpt-design-3 {display: none;} .amp-wp-post-content .large-screen-excerpt-design-3 { display: block; }
<?php } ?>
<?php } // AMP Woocommerce CSS ends ?>
/* Footer */
<?php 
$footer_back_color = ampforwp_get_setting('ampforwp-footer-background-color-3','color');
$footer_hdbg_color = ampforwp_get_setting('d3-footer-hdng-color','color');
$footer_text_color = ampforwp_get_setting('d3-footer-txt-color','color');
$footer_link_color = ampforwp_get_setting('d3-footer-link-color','color');
$footer_brdr_color = ampforwp_get_setting('d3-footer-brdr-color','color');
$footer_cpr_color  = ampforwp_get_setting('d3-footer-cpr-color','color');
$footer_pwrd_color = ampforwp_get_setting('d3-footer-pwrd-color','color');

if (empty($footer_back_color)) {
 $footer_back_color = '#151515'; 
}
if (empty($footer_hdbg_color)) {
 $footer_hdbg_color = '#aaaaaa'; 
}  
if (empty($footer_text_color)) {
 $footer_text_color = '#eeeeee'; 
} 
if (empty($footer_link_color)) {
 $footer_link_color = '#ffffff'; 
} 
if (empty($footer_brdr_color)) {
 $footer_brdr_color = '#3c3c3c'; 
} 
if (empty($footer_cpr_color)) {
 $footer_cpr_color = '#ffffff'; 
} 
if (empty($footer_pwrd_color)) {
 $footer_pwrd_color = '#666666'; 
} 
?>
#footer{ background: <?php echo ampforwp_sanitize_color($footer_back_color);?>; color: <?php echo ampforwp_sanitize_color($footer_text_color);?>; font-size: 13px; text-align: center; letter-spacing: 0.2px; padding: 35px 0 35px 0; margin-top: 30px; }
#footer a{ color:<?php echo ampforwp_sanitize_color( $footer_link_color ); ?>; }
#footer p:first-child{ margin-bottom: 12px; }
#footer .social_icons{ margin: 0px 20px 25px 20px; border-bottom: 1px solid <?php echo ampforwp_sanitize_color($footer_brdr_color);?>; padding-bottom: 25px; }
#footer p{ margin: 0 }
.back-to-top{padding-bottom: 8px;}
.rightslink, #footer .rightslink a{ font-size:13px; color: <?php echo ampforwp_sanitize_color($footer_cpr_color);?>; }
.poweredby{ padding-top:10px; font-size:10px; }
#footer .poweredby a{ color:<?php echo ampforwp_sanitize_color( $footer_pwrd_color ); ?>; }
.footer_menu ul{ list-style-type: none; padding: 0; text-align: center; margin: 0px 20px 25px 20px; line-height: 27px; font-size: 13px }
.footer_menu ul li{ display:inline; margin:0 10px; }
.footer_menu ul li:first-child{ margin-left:0 }
.footer_menu ul li:last-child{ margin-right:0 }
.footer_menu ul ul{ display:none }
a.btt:hover {
    cursor: pointer;
}
<?php if( !ampforwp_woocommerce_conditional_check() ) { ?>
<?php if ( is_singular() || true == ampforwp_get_setting('amp-frontpage-select-option') && ampforwp_get_blog_details() == false && !checkAMPforPageBuilderStatus(ampforwp_get_the_ID()) ) { ?>
/* Single */
.single-post main{ margin: 20px 17px 17px 17px; }
.amp-wp-article-content{ font-family:'PT Serif', serif; }
.single-post .post-featured-img{ margin:0 -17px 0px -17px }
.amp-wp-article-featured-image.wp-caption .wp-caption-text, .ampforwp-gallery-item .wp-caption-text{color: #696969; font-size: 11px; line-height: 1.5; background: #eee; margin: 0; padding: .66em .75em; text-align: center; }
.ampforwp-gallery-item.amp-carousel-slide { padding-bottom: 20px;}
.ampforwp-title{ padding: 0px 0px 0px 0px; margin-top: 12px; margin-bottom: 12px; }
.comment-button-wrapper{ margin-bottom: 50px; margin-top: 30px; text-align:center }
.comment-button-wrapper a{ color: #fff; background: #312c7e; font-size: 14px; padding: 12px 22px 12px 22px; font-family: 'Roboto Slab', serif; border-radius: 2px; text-transform: uppercase; letter-spacing: 1px; }
h1.amp-wp-title{ margin: 0; color: #333333; font-size: 48px; line-height: 58px; font-family: 'Roboto Slab', serif; }
.post-pagination-meta{ min-height:75px }
.single-post .post-pagination-meta{ font-size:15px; font-family:sans-serif; min-height:auto; margin-top:-5px; line-height:26px; }
.single-post .post-pagination-meta span{ font-weight:bold }
.single-post .amp_author_area .amp_author_area_wrapper{ display: inline-block; width: 100%; line-height: 1.4; margin-top: 22px; font-size: 16px; color:#333; font-family: sans-serif; }
.single-post .amp_author_area amp-img{ margin: 0; float: left; margin-right: 12px; border-radius: 60px; }
.amp-wp-article-tags .ampforwp-tax-tag, .amp-wp-article-tags .ampforwp-tax-tag a{ font-size: 12px; color: #555; font-family: sans-serif; margin: 20px 0 0 0; }
.amp-wp-article-tags span{ background: #eee; margin-right: 10px; padding: 5px 12px 5px 12px; border-radius: 3px; display: inline-block; margin: 5px; }
.ampforwp-social-icons{ margin-bottom: 70px; margin-top: 25px; min-height: 40px; }
.ampforwp-social-icons amp-social-share{ border-radius:60px; background-size:22px; margin-right:6px; }
.amp-social-icon-rounded{padding: 11px 12px 9px 12px; top: -13px; position: relative; line-height: 1; display: inline-block; height: inherit; border-radius: 60px; }
<?php if ( true == ampforwp_get_setting('enable-single-line-share') ) { ?>
.amp-social-line{background:#00b900}
<?php }
if(ampforwp_get_setting('enable-single-mewe-share') == true)  { ?>
.amp-social-mewe{background:#b8d6e6;}
<?php }
if ( true == ampforwp_get_setting('enable-single-flipboard-share') ) { ?>
.custom-amp-socialsharing-flipboard{background:#f52828;position: relative;
    top: -12px;}
.amp-social-flipboard{background:#f52828;text-align: center;max-width: 18px;
    max-height: 16px;}
<?php }
if ( true == ampforwp_get_setting('enable-single-vk-share') ) { ?>
.amp-social-vk{background:#45668e}
<?php } ?>
<?php if ( true == ampforwp_get_setting('enable-single-odnoklassniki-share') ) { ?>
.amp-social-odnoklassniki{background:#ed812b}
<?php } ?>
<?php if ( true == ampforwp_get_setting('enable-single-reddit-share') ) { ?>
.amp-social-reddit{background:#ff4500}
<?php } ?>
<?php if ( true == ampforwp_get_setting('enable-single-telegram-share') ) { ?>
.amp-social-telegram{background:#61A8DE}
<?php } ?>
<?php if ( true == ampforwp_get_setting('enable-single-tumblr-share') ) { ?>
.amp-social-tumblr{background:#35465c}
<?php } ?>
<?php if ( true == ampforwp_get_setting('enable-single-digg-share') ) { ?>
.amp-social-digg{background:#005be2}
<?php } ?>
<?php if ( true == ampforwp_get_setting('enable-single-stumbleupon-share') ) { ?>
.amp-social-stumbleupon{background:#eb4924}
<?php } ?>
<?php if ( true == ampforwp_get_setting('enable-single-wechat-share') ) { ?>
.amp-social-wechat{background:#7bb32e}
<?php } ?>
<?php if ( true == ampforwp_get_setting('enable-single-viber-share') ) { ?>
.amp-social-viber{background:#8f5db7}
<?php } ?>
<?php if ( true == ampforwp_get_setting('enable-single-hatena-bookmarks') ) { ?>
.amp-social-hatena{background:#00a4de}
<?php } ?>
<?php if ( true == ampforwp_get_setting('enable-single-pocket-share') ) { ?>
.amp-social-pocket{background:#e8e8e8}
<?php } ?>
<?php if ( true == ampforwp_get_setting('enable-single-facebook-share') ) { ?>
.amp-social-facebook{background:#3b5998}
<?php } ?>
<?php if ( true == ampforwp_get_setting('enable-single-twitter-share') ) { ?>
.amp-social-twitter{background:#1da1f2}
<?php } ?>
<?php if ( true == ampforwp_get_setting('enable-single-gplus-share') ) { ?>
.amp-social-gplus{background:#dd4b39}
<?php } ?>
<?php if ( true == ampforwp_get_setting('enable-single-email-share') ) { ?>
.amp-social-email{background:#000000}
<?php } ?>
<?php if ( true == ampforwp_get_setting('enable-single-pinterest-share') ) { ?>
.amp-social-pinterest{background:#bd081c}
<?php } ?>
<?php if ( true == ampforwp_get_setting('enable-single-linkedin-share') ) { ?>
.amp-social-linkedin{background:#0077b5}
<?php } ?>
<?php if ( true == ampforwp_get_setting('enable-single-whatsapp-share') ) { ?>
.amp-social-whatsapp{background:#5cbe4a}
<?php } ?>
.ampforwp-custom-social{display:inline-block; margin-bottom:5px}
.amp-wp-tax-tag { list-style: none; display: inline-block; }
figure{ margin: 0 0 20px 0; }
figure amp-img{ max-width:100%; }
figcaption{ font-size: 11px; line-height: 1.6; margin-bottom: 11px; background: #eee; padding: 6px 8px; }
.amp-wp-byline amp-img{ display: none; }
.amp-wp-author{ margin-right: 1px; }
.amp-wp-meta, .amp-wp-meta a{ font-size: 13px; color: #acacac; margin: 20px 0px 20px 0px; padding: 0; }
.amp-ad-wrapper{ text-align: center }
.the_content p{ margin-top: 0px; margin-bottom: 30px; word-break: break-word; }
.amp-wp-tax-tag{ }
main .amp-wp-content.featured-image-content{ padding: 0px; border: 0; margin-bottom: 0; box-shadow: none }
.amp-wp-content .amp-wp-article-featured-image amp-img {margin: 0 auto;}
.single-post .amp-wp-article-content amp-img{ max-width:100% }
<?php if ( is_single() ) {
 if ( ampforwp_get_setting('ampforwp-single-select-type-of-related') ) { ?>
/* Related Posts */
main .amp-wp-content.relatedpost{ background: none; box-shadow: none; padding:0px 0 0 0; margin:1.8em auto 1.5em auto }
.single-post main,.related-title,.single-post .comments_list h3{ font-size: 20px; color: #777; font-family:'Roboto Slab', serif; border-bottom: 1px solid #eee; font-weight: 400; padding-bottom: 1px; margin-bottom: 10px; }
.related-title {display:block}
.related_posts ol{ list-style-type:none; margin:0; padding:0 }
.related_posts ol li{ display:inline-block; width:100%; margin-bottom: 12px; padding: 0px; }
.related_posts .related_link a{ color: #444; font-size: 16px; font-family: 'Roboto Slab', serif; font-weight: 600; }
.related_posts ol li amp-img{float:left; margin-right:15px }
.related_posts ol li amp-img{ float:left; margin-right:15px }
.related_posts ol li p{ font-size: 12px; color: #999; line-height: 1.2; margin: 12px 0 0 0; }
.no_related_thumbnail{ padding: 15px 18px; }
.no_related_thumbnail .related_link{ margin: 16px 5px 20px 5px; }
.related-post_image{ float: left; padding-right: 2%; width: 31.6%; overflow: hidden; margin-right: 15px; max-height: 122px; max-width: 110px; } 
.related-post_image amp-img{ width: 144%; left: -20%; }
.ampforwp-inline-related-post .related_posts ol li amp-img {width: 100px;float:left;margin-right: 15px;}
.ampforwp-inline-related-post .related_posts ol li{box-shadow: 0 2px 3px rgba(0,0,0,.05);}
<?php }
} ?>
<?php if(!checkAMPforPageBuilderStatus(ampforwp_get_the_ID())){ ?>
/* Comments */
.page-numbers{ padding: 9px 10px; background: #fff; font-size: 14px; }
.comment-body .comment-content{ font-family:'PT Serif', serif; margin-top: 2px; }
main .amp-wp-content.comments_list{ background: none; box-shadow: none; padding:0 }
.comments_list div{ display:inline-block; }
.comments_list ul{ margin:0; padding:0 }
.comments_list ul.children{ padding-bottom:10px; margin-left: 3%; width: 96%; }
.comments_list ul li p{ margin:0; font-size:16px; clear:both; padding-top:5px; word-break: break-word;}
.comments_list ul li{ font-size: 12px; list-style-type: none; margin-bottom: 22px; padding-bottom: 20px; max-width: 1000px; border-bottom: 1px solid #eee; }
.comments_list ul ul li{ border-left: 2px solid #eee; padding-left: 15px; border-bottom: 0; padding-bottom: 0px; }
.comments_list ul li .comment-body .comment-author{ margin-right:5px }
.comment-author{ float:left }
.single-post footer.comment-meta{ color:#666; padding-bottom: 0; line-height: 1.9; }
.comment-author-img{float: left; margin-right: 5px; border-radius: 60px; }
.comment-metadata a{ color:#888 }
.comments_list li li{ margin: 20px 20px 10px 20px; background: #f7f7f7; box-shadow: none; border: 1px solid #eee; }
.comments_list li li li{ margin:20px 20px 10px 20px }
.comment-content amp-img{max-width: 300px;}
<?php } }?>
<?php if ( isset($redux_builder_amp['ampforwp-disqus-comments-support']) && $redux_builder_amp['ampforwp-disqus-comments-support'] ) {?>
.amp-disqus-comments { text-align:center } <?php 
} ?>
<?php } // AMP Woocommerce Condition Ends Here?>
/* ADS */
.amp_ad_1{ margin-top: 15px; margin-bottom: 10px; }
.single-post .amp_ad_1{ margin-bottom: -15px; }
.amp-ad-2{ margin-bottom: -5px;    margin-top: 20px; }
html .single-post .ampforwp-incontent-ad-1 { margin-bottom: 10px; }
.amp-ad-3{ margin-bottom:10px; }
.amp-ad-4{ margin-top:2px; }
.amp-wp-content blockquote{ border-left: 3px solid; margin: 0; padding: 15px 20px; background: #f3f3f3; }
.amp-wp-content blockquote p{ margin-bottom:0 }
pre{ white-space: pre-wrap; }

#designthree{ background-color: #FFF; overflow: visible;
/*    animation: closing .3s normal forwards ease-in-out,closingFix .6s normal forwards ease-in-out;
    -webkit-transform-origin: right center;
    transform-origin: right center;*/
}
/* Sidebar */
#sidebar[open]+#designthree { max-height: 100vh; overflow: hidden; animation: opening .3s normal forwards ease-in-out; -webkit-transform: translate3d(60%, 0, 0) scale(0.8); transform: translate3d(60%, 0, 0) scale(0.8); }
@keyframes opening{ 0% { transform: translate3d(0, 0, 0) scale(1); } 100% { transform: translate3d(60%, 0, 0) scale(0.8); } }
@keyframes closing{ 0% { transform: translate3d(60%, 0, 0) scale(0.8); } 100% { transform: translate3d(0, 0, 0) scale(1); } }
@keyframes closingFix{ 0% { max-height: 100vh; overflow: hidden; } 100% { max-height: none; overflow: visible; } }
.hamburgermenu{ float:left; position:relative; z-index: 9999; }

/* Category 3 */
.amp-category-block{ margin: 30px 0px 10px 0px }
.amp-category-block a{ color:#666}
.amp-category-block ul{ list-style-type:none}
.category-widget-gutter h4{ margin-bottom: 0px;}
.category-widget-gutter ul{ margin-top: 10px; list-style-type:none; padding:0 }
.amp-category-block-btn{ display: block; text-align: center; font-size: 13px; margin-top: 15px; border-bottom: 1px solid #f1f1f1; text-decoration: none; padding-bottom: 8px;}
.design_2_wrapper .amp-category-block{ max-width: 840px; margin: 1.5em auto; }
.amp-category-block ul, .category-widget-wrapper{ max-width: 1000px; margin: 0 auto; padding:0px 15px 5px 15px }
.amp-category-post{ width: 32%; display: inline-block; word-wrap: break-word;float: left;}
.amp-category-post amp-img{ margin-bottom:5px; }
.amp-category-block li:nth-child(3){ margin: 0 1%; }
.searchmenu{ margin-right: 15px; margin-top: 11px; position: absolute; top: 0; right: 0; }
.searchmenu button{ background:transparent; border:none }
.amp-logo amp-img{margin: 0 auto; position:relative;top:9px;max-width:190px;}
.headerlogo{ margin: 0 auto; width: 80%; text-align: center; }
.headerlogo a{ color:#F42; display:inline-block}

/*Navigation Menu*/
.toast { display: block; position: relative; height: 50px; padding-left: 20px; padding-right: 15px; width: 49px; background:none; border:0 }
.toast:after, .toast:before, .toast span{ position: absolute; display: block; width: 19px; height: 2px; border-radius: 2px; background-color: #F42; -webkit-transform: translate3d(0, 0, 0) rotate(0deg); transform: translate3d(0, 0, 0) rotate(0deg); }
.toast:after, .toast:before{ content: ''; left: 20px; -webkit-transition: all ease-in .4s; transition: all ease-in .4s; }
.toast span{ opacity: 1; top: 24px; -webkit-transition: all ease-in-out .4s; transition: all ease-in-out .4s; }
.toast:before{ top: 17px; }
.toast:after{ top: 31px; }
#sidebar[open]+#designthree .toast span{ opacity: 0; -webkit-transform: translate3d(200%, 0, 0); transform: translate3d(200%, 0, 0); }
#sidebar[open]+#designthree .toast:before{ -webkit-transform-origin: left bottom; transform-origin: left bottom; -webkit-transform: rotate(43deg); transform: rotate(43deg); }
#sidebar[open]+#designthree .toast:after{ -webkit-transform-origin: left top; transform-origin: left top; -webkit-transform: rotate(-43deg); transform: rotate(-43deg); }

/* CSS3 icon */
[class*=icono-]{ display: inline-block; vertical-align: middle; position: relative; font-style: normal; color: #f42; text-align: left; text-indent: -9999px; direction: ltr }
[class*=icono-]:after, [class*=icono-]:before{ content: ''; pointer-events: none; }
.icono-search{ -webkit-transform: translateX(-50%); -ms-transform: translateX(-50%); transform: translateX(-50%) }
.icono-share{ height: 9px; position: relative; width: 9px; color: #dadada; border-radius: 50%; box-shadow: inset 0 0 0 32px, 22px -11px 0 0, 22px 11px 0 0; top: -15px; margin-right: 35px; }
.icono-share:after, .icono-share:before{ position: absolute; width: 24px; height: 1px; box-shadow: inset 0 0 0 32px; left: 0; }
.icono-share:before{ top: 0px; -webkit-transform: rotate(-25deg); -ms-transform: rotate(-25deg); transform: rotate(-25deg); }
.icono-share:after{ top: 8px; -webkit-transform: rotate(25deg); -ms-transform: rotate(25deg); transform: rotate(25deg); }
<?php if( true == ampforwp_get_setting('amp-design-3-search-feature') ) {  ?>
.icono-search{ border: 1px solid; width: 10px; height: 10px; border-radius: 50%; -webkit-transform: rotate(45deg); -ms-transform: rotate(45deg); transform: rotate(45deg); margin: 4px 4px 8px 8px; }
.icono-search:before{ position: absolute; left: 50%; -webkit-transform: rotate(270deg); -ms-transform: rotate(270deg); transform: rotate(270deg); width: 2px; height: 9px; box-shadow: inset 0 0 0 32px; top: 0px; border-radius: 0 0 1px 1px; left: 14px; }
.closebutton{ background: transparent; border: 0; color: rgba(255, 255, 255, 0.7); border: 1px solid rgba(255, 255, 255, 0.7); border-radius: 30px; width: 32px; height: 32px; font-size: 12px; text-align: center; position: absolute; top: 12px; right: 20px; outline:none }
amp-lightbox{ background: rgba(0, 0, 0,0.85); }
.searchform label{ color: #f7f7f7; display: block; font-size: 10px; letter-spacing: 0.3px; line-height: 0; opacity:0.6 }
.searchform{ background: transparent; left: 20%; position: absolute; top: 35%; width: 60%; max-width: 100%; transition-delay: 0.5s; }
.searchform input{ background: transparent; border: 1px solid #666; color: #f7f7f7; font-size: 14px; font-weight: 400; line-height: 1; letter-spacing: 0.3px; text-transform: capitalize; padding: 20px 0px 20px 30px; margin-top: 15px; width: 100%; }
#searchsubmit{opacity:0}
<?php } // search condition ends ?>
.archives_body main{ margin-top:20px }
.taxonomy-description p{margin-top: 5px;font-size: 14px;line-height: 1.5;}
.amp-sub-archives li{width: 50%;} .amp-sub-archives ul{padding: 0;list-style: none;display: flex;font-size: 12px;line-height: 1.2;margin: 5px 0 10px 0px;} .author-img amp-img{border-radius: 50%;margin: 0px 12px 10px 0px;display: block; width:50px;}.author-img{float: left;padding-bottom: 25px;}
<?php  if (  ampforwp_is_home() || ampforwp_is_blog() ) {?>
/* AMP carousel */
.amp-carousel-button-prev, .amp-carousel-button-next{ top:30px;border-radius:60px; }
.amp-carousel-button { z-index: 999}
.amp-featured-wrapper{ background:#333 }
.amp-featured-area{ margin: 0 auto; max-width: 450px; max-height: 270px; }
.amp-carousel-slide h2{ font-size: 30px; font-family: 'PT Serif', serif; margin: 0; font-weight: normal; line-height: 38px; color: #fff; padding: 10px 20px 20px 20px; }
.amp-featured-area .amp-carousel-slide amp-img:before{ z-index:100; bottom: 0; content: ""; display: block; height: 100%; position:absolute; width: 100%; background: -webkit-gradient(linear, 50% 0%, 50% 75%, color-stop(0%, rgba(0,0,0,0)), color-stop(150%, #000000)) repeat scroll 0 0 rgba(0,0,0,0.2); background: -webkit-linear-gradient(rgba(0,0,0,0),#000000 75%) repeat scroll 0 0 rgba(0,0,0,0); background: -moz-linear-gradient(rgba(0,0,0,0),#000000 75%) repeat scroll 0 0 rgba(0,0,0,0); background: -o-linear-gradient(rgba(0,0,0,0),#000000 75%) repeat scroll 0 0 rgba(0,0,0,0); background: linear-gradient(rgba(0,0,0,0),#000000 75%) repeat scroll 0 0 rgba(0,0,0,0); }
.featured_title{ position:absolute; z-index:110; bottom:0 }
.featured_meta{ color:#acacac; font-size:12px; margin:0 15px; }
.featured_meta_left{ float:left }
.featured_meta_right{ float:right }
.featured_time{ font-size: 12px; color: #fff; opacity: 0.8; padding-left: 20px;}
<?php }
if( !ampforwp_woocommerce_conditional_check() ) {
if ( is_singular() || is_home() && $redux_builder_amp['amp-frontpage-select-option'] && ampforwp_get_blog_details() == false ) { ?>
/* Tables */
table { display: -webkit-box; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; overflow-x: auto; }
table a:link { font-weight: bold; text-decoration: none; }
table a:visited { color: #999999; font-weight: bold; text-decoration: none; }
table a:active, table a:hover { color: #bd5a35; text-decoration: underline; }
table { font-family: Arial, Helvetica, sans-serif; color: #666; font-size: 12px; text-shadow: 1px 1px 0px #fff; background: #eee; margin: 0px; width: 100%; }
table th { padding: 21px 25px 22px 25px; border-top: 1px solid #fafafa; border-bottom: 1px solid #e0e0e0; background: #ededed; background: -webkit-gradient(linear, left top, left bottom, from(#ededed), to(#ebebeb)); background: -moz-linear-gradient(top, #ededed, #ebebeb); }
table th:first-child { text-align: left; padding-left: 20px; }
table tr:first-child th:first-child { -moz-border-radius-topleft: 3px; -webkit-border-top-left-radius: 3px; border-top-left-radius: 3px; }
table tr:first-child th:last-child { -moz-border-radius-topright: 3px; -webkit-border-top-right-radius: 3px; border-top-right-radius: 3px; }
table tr { text-align: center; padding-left: 20px; }
table td:first-child { text-align: left; padding-left: 20px; border-left: 0; }
table td { padding: 18px; border-top: 1px solid #ffffff; border-bottom: 1px solid #e0e0e0; border-left: 1px solid #e0e0e0; background: #fafafa; background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa)); background: -moz-linear-gradient(top, #fbfbfb, #fafafa); }
table tr.even td { background: #f6f6f6; background: -webkit-gradient(linear, left top, left bottom, from(#f8f8f8), to(#f6f6f6)); background: -moz-linear-gradient(top, #f8f8f8, #f6f6f6); }
table tr:last-child td {border-bottom: 0;}
table tr:last-child td:first-child { -moz-border-radius-bottomleft: 3px; -webkit-border-bottom-left-radius: 3px; border-bottom-left-radius: 3px; }
table tr:last-child td:last-child { -moz-border-radius-bottomright: 3px; -webkit-border-bottom-right-radius: 3px; border-bottom-right-radius: 3px; }
table tr:hover td { background: #f2f2f2; background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0)); background: -moz-linear-gradient(top, #f2f2f2, #f0f0f0); }
<?php } 
} //AMP Woocommerce CSS Ends  ?>
<?php if ( 1 == $redux_builder_amp['amp-enable-notifications'] || isset($redux_builder_amp['ampforwp-cta-subsection-notification-sticky']) && 1 == $redux_builder_amp['ampforwp-cta-subsection-notification-sticky'] ) {?>
/* Notifications */
#amp-user-notification1 p{ display: inline-block; }
amp-user-notification{ padding: 5px; text-align: center; background: #fff; border-top: 1px solid; }
amp-user-notification button{ padding: 8px 10px; background: #000; color: #fff; margin-left: 5px; border: 0; }
amp-user-notification button:hover{ cursor: pointer }
.amp-not-privacy{color:<?php echo ampforwp_get_setting('amp-opt-color-rgba-colorscheme','color','ampforwp_sanitize_color'); ?>;text-decoration: none;font-size: 15px;margin-left: 2px;}
<?php } ?>
.archive-heading,.taxonomy-description{padding: 10px 15px 0 15px;}
/* Responsive */
@media screen and (min-width: 650px) { table {display: inline-table;}  }
@media screen and (max-width: 768px){ .amp-wp-meta{ margin:10px 0px 15px 0px } .home-post_image{ width: 40%; } .amp-loop-list .amp-wp-post-content{ width: 58%; } .amp-loop-list .featured_time{line-height:1} .single-post main .amp-wp-content h1{  line-height:1.4;  font-size: 30px;}  }
@media screen and (max-width: 600px){ .amp-loop-list .amp-wp-tags{display:none} }
@media screen and (max-width: 530px){ .home-post_image{ width: 35%; } .amp-loop-list .amp-wp-post-content{ width: 63%; } .amp-wp-post-content p { font-size: 12px; } .related_posts ol li p { line-height: 1.6; margin: 7px 0 0 0;} .comments_list ul li .comment-body {width:auto} .amp-category-block li:nth-child(3) {margin:0} }
@media screen and (max-width: 425px){ .home-post_image{ /*    width: 125px;*/ width: 31.6%; overflow: hidden; /* margin-right: 13px; */ margin-right: 3%; max-height: 122px } .home-post_image amp-img{ width: 144%; left: -20%; } h2.amp-wp-title{    margin-bottom: 7px;  line-height: 1.31578947; font-size: 19px; position:relative;top:-3px } h2.amp-wp-title a{ color:#262626} .amp-loop-list{padding:25px 15px 22px 15px} .amp-loop-list .amp-wp-post-content{ width: 63%; } .related_posts .amp-loop-list .amp-wp-post-content .small-screen-excerpt-design-3 { display: block; } .related_posts .related_link a{ font-size: 18px; line-height: 1.7; } .ampforwp-tax-category{ padding-bottom:0 } .amp-wp-byline{ padding:0 } .related_posts .related_link a{ font-size: 17px; line-height: 1.5; } .single-post main .amp-wp-content h1{ line-height: 1.3; font-size: 26px;} .icono-share{display:none} .ampforwp-social-icons amp-social-share{ margin-right: 3px;} main .amp-wp-content{ font-size: 16px; line-height: 26px;} .single-post .amp_author_area .amp_author_area_wrapper{font-size:13px;} .amp-category-post{ font-size:12px; color:#666 } .large-screen-excerpt-design-3{ display:none;}.ampforwp-inline-related-post .related_posts ol li{padding:0px 0px 10px 0px;} }
@media screen and (max-width: 400px){ .amp-wp-title{ font-size: 19px; } }
@media screen and (max-width: 375px){ .single-post main .amp-wp-content h1{ line-height: 1.3; font-size: 24px;} .amp-carousel-slide h2{ font-size: 22px; line-height: 32px; } #pagination .next a, #pagination .prev a{ color: #666; font-size: 14px; padding: 15px 0px; margin-top: -5px; }.related-title,.comments_list h3{ margin-top:15px; } #pagination .next{ margin-bottom:15px; } .related_posts .related_link {line-height: 1; } }
@media screen and (max-width: 340px){ .single-post main .amp-wp-content h1{ line-height: 1.3; font-size: 22px;} h2.amp-wp-title{ line-height: 1.31578947; font-size: 17px; } .the_content .amp-ad-wrapper{ text-align: center; margin-left: -13px; } }
@media screen and (max-width: 320px){ .ampforwp-social-icons amp-social-share{ margin-right: 1px; } }
.entry-content amp-anim{display:table-cell;}
<?php if ( true == $redux_builder_amp['amp-rtl-select-option'] ) { ?>
.amp-carousel-slide h2{ direction: rtl; }
.featured_time{ text-align: right; padding-right: 20px; }
main .amp-wp-content{ direction: rtl; }
.home-post_image{ float: right; padding-right: 0%; padding-left: 2%; margin-right: 0%; overflow: hidden;}
.searchmenu{ margin-right: 15px; margin-top: 11px; position: absolute; top: 0; right: inherit; }
.searchform label{ text-align: right; right: -30px; position: relative; }
.searchform input{ text-align: right; padding: 15px; }
.closebutton{ left:20px; }
.hamburgermenu{ float: right; }
.toast{ display: block; position: relative; height: 50px; padding-left: 20px; padding-right: 15px; width: 60px; background: none; border: 0; }
.amp-ad-wrapper, .amp-wp-article amp-ad{ direction: ltr; }
.related_posts ol li amp-img{ float: right; margin-left: 15px; }
.single-post .amp_author_area amp-img{ float: right; margin-left: 12px; }
.amp-wp-article, .footer_wrapper container{ direction: rtl; }
.single-post .post-pagination-meta span{ float: right; }
.amp-wp-article-tags span{ background: #eee; margin-right: 10px; padding: 5px 12px 5px 12px; border-radius: 3px; display: inline-block; margin: 5px; }
.amp_author_area_wrapper strong{ float: right; }
.amp-menu li.menu-item-has-children:after { left: 0; right: auto; }
amp-sidebar { direction: rtl; }
amp-carousel{direction: ltr;}

/** Sidebar RTL CSS ***/
#sidebar[open]+#designthree {
    max-height: 100vh;
    overflow: hidden;
    animation: opening .3s normal forwards ease-in-out;
    -webkit-transform: translate3d(-60%, 0, 0) scale(0.8);
    transform: translate3d(-60%, 0, 0) scale(0.8);
}
@keyframes opening{ 0% { transform: translate3d(0, 0, 0) scale(1); } 100% { transform: translate3d(-60%, 0, 0) scale(0.8); } }
@keyframes closing{ 0% { transform: translate3d(-60%, 0, 0) scale(0.8); } 100% { transform: translate3d(0, 0, 0) scale(1); } }
@keyframes closingFix{ 0% { max-height: 100vh; overflow: hidden; } 100% { max-height: none; overflow: visible; } }
.amp-wp-content.widget-wrapper{margin:20px auto;}
.amp_widget_above_the_footer{direction:rtl;}
@media(max-width:768px){
.amp-wp-content.widget-wrapper{margin: 15px;}
}
<?php } ?>

a {  color: <?php echo ampforwp_get_setting('amp-opt-color-rgba-colorscheme','color','ampforwp_sanitize_color'); ?> }
body a {  color: <?php echo ampforwp_get_setting('amp-opt-color-rgba-link','color','ampforwp_sanitize_color'); ?> }

.amp-wp-content blockquote { border-color:  <?php echo ampforwp_sanitize_color( $header_background_color ); ?>; }
amp-user-notification { border-color:  <?php echo ampforwp_get_setting('amp-opt-color-rgba-colorscheme','color','ampforwp_sanitize_color'); ?>;}
amp-user-notification button { background-color:  <?php echo ampforwp_get_setting('amp-opt-color-rgba-colorscheme','color','ampforwp_sanitize_color'); ?>;}
<?php if ( true == ampforwp_get_setting('enable-single-social-icons') && is_socialshare_or_socialsticky_enabled_in_ampforwp() && is_single() ) { ?>
.single-post footer { padding-bottom: 41px;}
.body.single-post .sticky_social{z-index:99999;}
.body.single-post .adsforwp-stick-ad, .body.single-post amp-sticky-ad{padding-top:3px;padding-bottom:48px;}
.body.single-post .ampforwp-sticky-custom-ad{
  bottom: 43px;
  padding: 4px 0px 0px;
}
.body.single-post .afw a{line-height:0;}
.body.single-post amp-sticky-ad amp-sticky-ad-top-padding{height:0px;}
<?php } 
if( ampforwp_get_setting('ampforwp-advertisement-sticky-type') == 3) {?>
  .btt{z-index:9999;}
<?php } // advanced ads type 3 ends here ?>
.amp-wp-author:before{ content: " <?php global $redux_builder_amp; echo esc_attr(ampforwp_translation($redux_builder_amp['amp-translator-published-by'], 'Published by' ));?>  ";}
.ampforwp-tax-category span:last-child:after { content: ' ';}
.ampforwp-tax-category span:after{ content: ', ';}
.amp-wp-article-content img { max-width: 100%;}
@font-face {
  font-family: 'icomoon';
  font-display: swap;
  src:  url('<?php echo esc_url(plugin_dir_url(__FILE__) .'fonts/icomoon.eot'); ?>');
  src:  url('<?php echo esc_url(plugin_dir_url(__FILE__) .'fonts/icomoon.eot'); ?>') format('embedded-opentype'),
    url('<?php echo esc_url(plugin_dir_url(__FILE__) .'fonts/icomoon.ttf'); ?>') format('truetype'),
    url('<?php echo esc_url(plugin_dir_url(__FILE__) .'fonts/icomoon.woff'); ?>') format('woff'),
    url('<?php echo esc_url(plugin_dir_url(__FILE__) .'fonts/icomoon.svg'); ?>') format('svg');
  font-weight: normal;
  font-style: normal;
}
[class^="icon-"], [class*=" icon-"]{ font-family: 'icomoon'; speak: none; font-style: normal; font-weight: normal; font-variant: normal; text-transform: none; line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
.icon-twitter a:before{ content: "\f099";background:#1da1f2 }
.icon-facebook a:before{ content: "\f09a";background:#3b5998 }
.icon-facebook-f a:before{ content: "\f09a";background:#3b5998 }
.icon-pinterest a:before{ content: "\f0d2";background:#bd081c }
.icon-google-plus a:before{ content: "\f0d5";background:#dd4b39 }
.icon-linkedin a:before{ content: "\f0e1";background:#0077b5 }
.icon-youtube-play a:before{ content: "\f16a";background:#cd201f }
.icon-instagram a:before{ content: "\f16d";background:#c13584 }
.icon-tumblr a:before{ content: "\f173";background:#35465c }
.icon-vk a:before{ content: "\f189";background:#45668e }
.icon-whatsapp a:before{ content: "\f232";background:#075e54 }
.icon-reddit-alien a:before{ content: "\f281";background:#ff4500 }
.icon-snapchat-ghost a:before{ content: "\f2ac"; background:#fffc00 }
.social_icons{ font-size: 15px; display: inline-block; }
.social_icons ul{ list-style-type:none; padding:0;margin:0; text-align:center }
.social_icons li{ box-sizing: initial; display:inline-block; margin:5px; }
.social_icons li a:before{ box-sizing: initial; color:#fff; padding: 10px; display: inline-block; border-radius: 70px; width: 18px; height: 18px; line-height: 20px; text-align: center; }
#ampforwp_search_query_item { display: none; }
#header, .headerlogo a{ background:<?php echo ampforwp_sanitize_color($headercolor); ?>  }
.comment-button-wrapper a, #pagination .next a, #pagination .prev a{ background: <?php echo ampforwp_get_setting('amp-opt-color-rgba-colorscheme','color','ampforwp_sanitize_color'); ?> ; }
.toast:after, .toast:before, .toast span{ background: <?php echo ampforwp_sanitize_color($headerelements);?>; }
[class*=icono-], .headerlogo a{ color: <?php echo ampforwp_sanitize_color($headerelements);?>; }
#pagination .next a, #pagination .prev a , #pagination .next a, #pagination .prev a ,.comment-button-wrapper a{ color:  <?php echo ampforwp_get_setting('amp-opt-color-rgba-font','color','ampforwp_sanitize_color'); ?> ;}
<?php if ( ! has_nav_menu( 'amp-menu' ) ) { ?>
.toggle-navigationv2 .social_icons { border-top: 0px; }
.toggle-navigationv2 a { color:#fff; }
<?php } ?>
<?php if ( ampforwp_get_setting('ampforwp-callnow-button') ) { ?>
.callnow{ position: absolute; top: 15px; right: 20px }
.callnow a:before { content: ""; position: absolute; right: 23px; width: 4px; height: 8px; border-width: 6px 0 6px 3px; border-style: solid; border-color:<?php echo ampforwp_get_setting('amp-opt-color-rgba-colorscheme-call','color','ampforwp_sanitize_color'); ?>; background: transparent; transform: rotate(-30deg); box-sizing: initial; border-top-left-radius: 3px 5px; border-bottom-left-radius: 3px 5px; }
<?php } ?>
<?php
if ( class_exists('TablePress') ) { ?>
.tablepress-table-description{ clear: both; display: block; }
.tablepress{ border-collapse: collapse; border-spacing: 0; width: 100%; margin-bottom: 1em; border: none; }
.tablepress th, .tablepress td{ padding: 8px; border: none; background: none; text-align: left; }
.tablepress tbody td{ vertical-align: top; }
.tablepress tbody td, .tablepress tfoot th{ border-top: 1px solid #dddddd; }
.tablepress tbody tr:first-child td{ border-top: 0; }
.tablepress thead th{ border-bottom: 1px solid #dddddd; }
.tablepress thead th, .tablepress tfoot th{ background-color: #d9edf7; font-weight: bold; vertical-align: middle; }
.tablepress .odd td{ background-color: #f9f9f9; }
.tablepress .even td{ background-color: #ffffff; }
.tablepress .row-hover tr:hover td{ background-color: #f3f3f3; }
@media (min-width: 768px) and (max-width: 1600px){ .tablepress{ overflow-x: none; } }
@media (min-width: 320px) and (max-width: 767px){ .tablepress{ display: inline-block; overflow-x: scroll; } }
<?php }  
if(!is_home() && ((is_single() && true == ampforwp_get_setting('ampforwp-bread-crumb') ) || (is_page() && ampforwp_get_setting('ampforwp_pages_breadcrumbs')) ) && !checkAMPforPageBuilderStatus(ampforwp_get_the_ID()) ) { ?>
.breadcrumb{width: 100%;}
.breadcrumb ul, .category-single ul{ padding:0; margin:0;}
.breadcrumb ul li{display:inline;}
.breadcrumb ul li a, .breadcrumb ul li span, .breadcrumbs span{ font-size:12px;}
.breadcrumb .bread-post{color: #acacac;}
.breadcrumb ul li a::after, .breadcrumbs span a:after {content: "►";display: inline-block;font-size: 8px;padding: 0 6px 0 7px;vertical-align: middle;opacity: 0.5;position:relative;top:-1px}
.breadcrumb ul li:hover a::after{color:#c3c3c3;}
.breadcrumb ul li:last-child a::after{display:none;}
<?php } ?> 
.amp-menu > li > a > amp-img, .sub-menu > li > a > amp-img { display: inline-block; margin-right: 4px; }
.menu-item amp-img {width: 16px; height: 11px; display: inline-block; margin-right: 5px; }
.amp-carousel-container {position: relative;width: 100%;height: 100%;} 
.amp-carousel-img img {object-fit: contain;}
.amp-ad-wrapper span { display: inherit; font-size: 12px; line-height: 1;}
<?php // Ads (sitewide)
if ( (isset($redux_builder_amp['enable-amp-ads-1'] ) && $redux_builder_amp['enable-amp-ads-1']) || (isset($redux_builder_amp['enable-amp-ads-2'] ) && $redux_builder_amp['enable-amp-ads-2']) ) { ?> .amp-ad-wrapper{ text-align: center } .amp_ad_1{ margin-top: 15px; margin-bottom: 10px; } .single-post .amp_ad_1{ margin-bottom: -15px; } .amp-ad-2{ margin-bottom: -5px; margin-top: 20px; } .amp-ad-wrapper{ text-align: center; margin-left: -13px; } <?php }
if ( true == $redux_builder_amp['amp-pagination'] ) { ?>
.ampforwp_post_pagination{width:100%;text-align:center;display:inline-block;}
<?php }  
$custom_css = ampforwp_get_setting('css_editor');
$custom_css = str_replace(array('.accordion-mod'), array('.apac'), $custom_css);
$sanitized_css = ampforwp_sanitize_i_amphtml($custom_css);
echo $sanitized_css; // sanitized above
//} ?>
<?php 
if (ampforwp_get_setting('enable-amp-ads-resp-1')){?>
.amp-ad-1 {
    max-width: 1000px;
}
<?php } ?>
<?php 
if (ampforwp_get_setting('enable-amp-ads-resp-2')){?>
.amp-ad-2 {
    max-width: 1000px;
}
<?php } ?>
<?php 
if (ampforwp_get_setting('enable-amp-ads-resp-3')){?>
.amp-ad-3 {
    max-width: 1000px;
}
<?php } ?>
<?php 
if (ampforwp_get_setting('enable-amp-ads-resp-4')){?>
.amp-ad-4 {
    max-width: 1000px;
}
<?php } ?>
<?php 
if (ampforwp_get_setting('enable-amp-ads-resp-5')){?>
.amp-ad-5 {
    max-width: 1000px;
}
<?php } ?>
<?php 
if (ampforwp_get_setting('enable-amp-ads-resp-6')){?>
.amp-ad-6 {
    max-width: 1000px;
}
<?php } ?>
<?php // Widgets CSS
if ( is_active_sidebar( 'ampforwp-above-footer'  ) || is_active_sidebar( 'ampforwp-below-header'  ) || is_active_sidebar( 'ampforwp-above-loop'  ) || is_active_sidebar( 'ampforwp-below-loop'  ) ) : ?>
.f-w{display: inline-flex;width:100%;flex-wrap:wrap;}
.w-bl{margin-left: 0;display: flex;flex-direction: column;position: relative;flex: 1 0 22%;margin:0 15px 15px;line-height:1.5;font-size:14px;}
.w-bl h4{font-size: <?php echo ampforwp_get_setting('swift-head-size'); ?>;font-weight: <?php echo ampforwp_get_setting('swift-head-fntwgth'); ?>;margin-bottom: 20px;text-transform: uppercase;letter-spacing: 1px;padding-bottom: 4px;}
.w-bl ul{padding:0;margin:0;}
.w-bl ul li{list-style-type: none;margin-bottom: 15px;}
.w-bl ul li:last-child{margin-bottom:0;}
.w-bl ul li a{text-decoration: none;}
.w-bl .menu li .sub-menu, .w-bl .lb-x{display:none;}
.w-bl table {
    border-collapse: collapse;
    margin: 0 0 1.5em;
    width: 100%;
}
.w-bl tr {
    border-bottom: 1px solid #eee;
}
.w-bl th, .w-bl td {
    text-align: center;
}
.w-bl td {
  padding: 0.4em;
}
.w-bl th:first-child, .w-bl td:first-child {
    padding-left: 0;
}
.w-bl thead th {
    border-bottom: 2px solid #bbb;
    padding-bottom: 0.5em;
    padding: 0.4em;
}
.w-bl .calendar_wrap caption{
  font-size: 14px;
    margin-bottom: 10px;
}
.w-bl form{
  display:inline-flex;
  flex-wrap:wrap;
  align-items: center;
}
.w-bl .search-submit{
  text-indent: -9999px;
    padding: 0;
    margin: 0;
    background: transparent;
    line-height: 0;
    display: inline-block;
    opacity: 0;
}
.w-bl .search-button{
    border: 1px solid;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
    margin: 4px 4px 8px 8px;
    position: relative;
    cursor: pointer;
}
.w-bl .search-button:after{
    content: "";
    position: absolute;
    left: 50%;
    -webkit-transform: rotate(270deg);
    -ms-transform: rotate(270deg);
    transform: rotate(270deg);
    width: 2px;
    height: 9px;
    box-shadow: inset 0 0 0 32px;
    top: 0px;
    border-radius: 0 0 1px 1px;
    left: 14px;
}
.w-bl .search-field{
  border: 1px solid #ccc;
    padding: 6px 10px;
}
<?php endif; ?>
@media(max-width:480px){
  <?php if ( is_active_sidebar( 'ampforwp-above-footer'  ) || is_active_sidebar( 'ampforwp-below-header'  ) || is_active_sidebar( 'ampforwp-above-loop'  ) || is_active_sidebar( 'ampforwp-below-loop'  ) ) : ?>
    .f-w{ display: inline-block;}
    .w-bl{flex:1 0 100%;}
  <?php endif; ?>
}
<?php // Back to Top CSS //
if(true == ampforwp_get_setting('ampforwp-footer-top')){?>
  .btt{
      position: fixed;
      <?php if( (is_single() && true == ampforwp_get_setting('enable-single-social-icons') ) || (is_page() && true == ampforwp_get_setting('ampforwp-page-sticky-social') ) ){ ?>
      bottom: 55px;
      <?php } else { ?>
        bottom: 20px;
      <?php } ?>
      right: 20px;
      background: rgba(71, 71, 71, 0.5);
      color: #fff;
      border-radius: 100%;
      width: 50px;
      height: 50px;
  }
  .btt:hover{color:#fff;background:#474747;}
  .btt:before{
    content: '\25be';
    display: block;
    font-size: 35px;
    font-weight: 600;
    color:#fff;
    transform: rotate(180deg);
    text-align: center;
    line-height: 1.4;
  }
<?php } ?>
<?php if(true == ampforwp_get_setting('ampforwp-smooth-scrolling-for-links')){?>
    html {
   scroll-behavior: smooth;
  }
<?php }
// Infinate Scroll Home & Archive page CSS
if( true == ampforwp_get_setting('ampforwp-infinite-scroll') && ampforwp_get_setting('ampforwp-infinite-scroll-home') ){?>
  .amp_home_body .amp-next-page-default-separator {border:none;}
  #headerwrap{position:relative;}
  header{padding:0;}
<?php } 
// image floats removed in mobile view #2525
if(is_singular() || ampforwp_is_front_page()){?>
@media(max-width:480px){
.amp-wp-content .alignright , .amp-wp-content .alignleft {
  float:none;
  margin:0 auto;
}
}
<?php } ?> 
.amp_widget_below_the_header.f-w amp-img {
    margin: 0 auto;
    margin-top: 8px;
}
@media (min-width: 768px){
.wp-block-columns {
    display:flex;
}
.wp-block-column {
    max-width:50%;
    margin: 0px 10px;
}
}
<?php
if ( is_singular() && false == ampforwp_get_setting('amp-opt-sticky-head') ){?>
.amp-wp-content *[id]:before { 
  display: block; 
  content: " "; 
  margin-top: -75px; 
  height: 75px; 
  visibility: hidden;}
<?php } ?>

<?php  // H1 - H6 Font Sizes 
if(ampforwp_get_setting('swift_cnt') && ampforwp_get_setting('swift_cnt_h1') ){ ?>
  .single-post main .amp-wp-article-content h1{font-size:<?php echo esc_html( ampforwp_get_setting('swift_h1_sz') )?>;}
<?php } else { ?>
  .single-post main .amp-wp-article-content h1 {font-size: 32px;}
<?php } //H1 ends
if(ampforwp_get_setting('swift_cnt') && ampforwp_get_setting('swift_cnt_h2') ){ ?>
  .single-post main .amp-wp-article-content h2{font-size:<?php echo esc_html( ampforwp_get_setting('swift_h2_sz') )?>;}
<?php } else { ?>
  .single-post main .amp-wp-article-content h2 {font-size: 32px;}
<?php } // H2 Ends
if(ampforwp_get_setting('swift_cnt') && ampforwp_get_setting('swift_cnt_h3') ){ ?>
  .single-post main .amp-wp-article-content h3{font-size:<?php echo esc_html( ampforwp_get_setting('swift_h3_sz') )?>;}
<?php } else { ?>
  .single-post main .amp-wp-article-content h3 {font-size: 24px;}
<?php } // H3 Ends
if(ampforwp_get_setting('swift_cnt') && ampforwp_get_setting('swift_cnt_h4') ){ ?> 
  .single-post main .amp-wp-article-content h4{font-size:<?php echo esc_html( ampforwp_get_setting('swift_h4_sz') )?>;}
<?php } else { ?>
  .single-post main .amp-wp-article-content h4 {font-size: 20px;}
<?php } // H4 Ends
if(ampforwp_get_setting('swift_cnt') && ampforwp_get_setting('swift_cnt_h5') ){ ?>
  .single-post main .amp-wp-article-content h5{font-size:<?php echo esc_html( ampforwp_get_setting('swift_h5_sz') )?>;}
<?php } else { ?>
  .single-post main .amp-wp-article-content h5 {font-size: 17px;}
<?php } // H5 Ends
if(ampforwp_get_setting('swift_cnt') && ampforwp_get_setting('swift_cnt_h6') ){ ?>
  .single-post main .amp-wp-article-content h6{font-size:<?php echo esc_html( ampforwp_get_setting('swift_h6_sz') )?>;}
<?php } else { ?>
  .single-post main .amp-wp-article-content h6 {font-size: 15px;}
<?php } // H6 Ends
// swift Content Heading Sizes Ends
if(class_exists('MCI_Footnotes')){ ?>
  div#footnote_references_container{
    display: unset;
  }
  .footnote_container_prepare p span:last-child {
    display:none;
  }
<?php } ?>
<?php // Footer Widget Satyling
if ( is_active_sidebar( 'swift-footer-widget-area'  ) ) : ?>
.f-w-blk {
    max-width: 1100px;
    margin:0 auto;
    border-bottom: 1px solid <?php echo ampforwp_sanitize_color($footer_brdr_color);?>;
    margin-bottom: 30px;
}
.d3f-w .w-bl h4 {
    font-size: 12px;
    font-weight: 500;
    margin:0px 0px 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding-bottom: 4px;
    color:<?php echo ampforwp_sanitize_color( $footer_hdbg_color ); ?>
}
.d3f-w .w-bl ul{
    margin:0;
    padding:0;
}
.d3f-w .w-bl ul li {
    list-style-type: none;
    margin-bottom: 15px;
}
.d3f-w {
    display: inline-flex;
    width: 100%;
    flex-wrap: wrap;
    text-align: left;
}
.d3f-w .w-bl {
    display: flex;
    flex-direction: column;
    position: relative;
    flex: 1 0 22%;
    margin: 0 15px 30px;
    line-height: 1.5;
    font-size: 14px;
}
@media (max-width: 1000px){
  .f-w-blk{ 
      max-width:100%;
      padding:0px 10px;
  }
  .d3f-w .f-w {
    margin: 0;
  }
  .d3f-w .w-bl{
    flex: 1 0 18%;
    margin:0px 10px 20px;
  }
}
@media (max-width: 480px){
  .d3f-w .w-bl {
      flex: 100%;
  }
}
<?php endif; ?>
<?php // Notification CSS
if( ampforwp_get_setting('amp-enable-notifications') && ampforwp_get_setting('enable-single-social-icons') && is_single() ) { ?>
amp-user-notification{
  bottom:41px;
  z-index: 999999;
}
<?php } //amp-enable-notifications Condition Ends Here ?>  