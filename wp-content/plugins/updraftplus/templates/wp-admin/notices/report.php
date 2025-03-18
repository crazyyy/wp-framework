<?php if (!defined('UPDRAFTPLUS_DIR')) die('No direct access allowed'); ?>
<div style="max-width: 700px; border: 1px solid; border-radius: 4px; font-size:110%; line-height: 110%; padding:8px; margin: 6px 0 12px; clear:left;">
<strong><?php
	if (!empty($prefix)) echo esc_html($prefix).' ';
	echo esc_html($title);
?></strong>: 
<?php
	echo wp_kses_post($text);

	if (isset($discount_code)) echo ' <b>'.esc_html($discount_code).'</b>';
	
	if (!empty($button_link) && !empty($button_meta)) {
?>
<a class="updraft_notice_link" href="<?php echo esc_attr(apply_filters('updraftplus_com_link', $button_link));?>"><?php
if ('updraftcentral' ==$button_meta) {
	esc_html_e('Get UpdraftCentral', 'updraftplus');
} elseif ('review' == $button_meta) {
	esc_html_e('Review UpdraftPlus', 'updraftplus');
} elseif ('updraftplus' == $button_meta) {
	esc_html_e('Get Premium', 'updraftplus');
} elseif ('signup' == $button_meta) {
	esc_html_e('Sign up', 'updraftplus');
} elseif ('go_there' == $button_meta) {
	esc_html_e('Go there', 'updraftplus');
} else {
	esc_html_e('Read more', 'updraftplus');
}
?></a><br><br>
	<?php }
?>
</div>