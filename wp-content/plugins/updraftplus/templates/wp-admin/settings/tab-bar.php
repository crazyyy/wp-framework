<?php if (!defined('UPDRAFTPLUS_DIR')) die('No direct access allowed'); ?>

<h2 class="nav-tab-wrapper">
<?php
foreach ($main_tabs as $tab_slug => $tab_label) {
	$tab_slug_as_attr = sanitize_title($tab_slug);
?>
	<a class="updraftplus-nav-tab <?php if ($tabflag == $tab_slug) echo 'nav-tab-active'; ?>" id="updraft-navtab-<?php echo esc_attr($tab_slug_as_attr);?>" href="<?php echo esc_url(UpdraftPlus::get_current_clean_url());?>#updraft-navtab-<?php echo esc_attr($tab_slug_as_attr);?>-content" ><?php echo esc_html($tab_label);?></a>
<?php
}
?>
</h2>
