<?php

class EHSSL_Settings_Menu_Old extends EHSSL_Admin_Menu
{
    public $menu_page_slug = EHSSL_SETTINGS_MENU_SLUG;

    public function __construct()
    {
        $this->render_menu_page();
    }

    public function render_menu_page()
    {
        ?>
        <div class="wrap">
            <h2><?php _e("HTTPS Redirection Settings", 'https-redirection') ?></h2>
			<div class="notice notice-warning">
				<p>
				<?php _e('The HTTPS Redirection settings have been upgraded and relocated to a new menu page titled <strong>Easy HTTPS & SSL</strong>. We have also added new features to enhance the plugin. Click the link below to access the new settings page.','https-redirection');?>
				<br>
				<br>
				<a class="button-primary" href="admin.php?page=ehssl_settings"><?php _e('Go to the New Settings Page','https-redirection');?></a>
				</p>
			</div>
        </div>
        <?php
    }
}