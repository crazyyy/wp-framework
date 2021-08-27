<div class="wrap pb-wp-app-wrapper">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

    <?php
    if( isset($_GET['clear_cache']) && $_GET['clear_cache'] === 'true' ) {
        $cache = new pbsfi_cache();
        $clear_cache = $cache->clear_cache();

        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php echo sprintf(__( '<strong>Cache cleared!</strong> %d elements are removed from transient cache.', 'pb-seo-friendly-images' ), $clear_cache); ?></p>
        </div>
        <?php
    }
    ?>

    <div class="pb-wrapper">
        <div class="pb-main">
            <form action="<?php echo admin_url('options.php') ?>" method="post" target="_self">
                <?php
                settings_fields('pb-seo-friendly-images');
                $this->settingsFramework->doSettingsSections('pb-seo-friendly-images');
                submit_button();
                ?>
            </form>
        </div>
        <div class="pb-sidebar">
            <h3><?php esc_html_e('Plugins & Support', 'pb-seo-friendly-images') ?></h3>

            <?php if (strstr(get_locale(), 'de')): ?>
                <div class="pb-support-box">
                    <h4>
                        <span class="icon">
                            <img src="<?php echo plugins_url('assets/img/check.png', $this->pbSEOFriendlyImages->plugin['file']); ?>"
                                 alt="<?php _e('WordPress Kurs', 'pb-seo-friendly-images') ?>"/>
                        </span>
                        <span class="text"><?php _e('Recommendation', 'pb-seo-friendly-images'); ?>:<br /><?php _e('WordPress Kurs', 'pb-seo-friendly-images') ?></span>
                    </h4>
                    <p><?php _e('Möchtest du mit WordPress richtig durchstarten? In meinem WordPress Kurs erfährst du spannende Tipps und Tricks zu WordPress und SEO!', 'pb-seo-friendly-images') ?></p>

                    <p>
                        <a href="https://www.bajorat-media.com/lp/wordpress-kurs/?utm_source=pb-seo-friendly-images&utm_medium=banner&utm_campaign=pb-seo-friendly-images" class="button"
                           target="_blank"><?php _e('Jetzt Kurs ansehen', 'pb-seo-friendly-images') ?></a>
                    </p>
                </div>
            <?php endif; ?>

            <div class="pb-support-box">
                <h4>
                    <span class="icon">
                        <img src="<?php echo plugins_url('assets/img/check.png', $this->pbSEOFriendlyImages->plugin['file']); ?>"
                             alt="<?php _e('WordPress Kurs', 'pb-seo-friendly-images') ?>"/>
                    </span>
                    <span class="text"><?php _e('Recommendation', 'pb-seo-friendly-images'); ?>:<br /><?php _e('WordPress Performance', 'pb-seo-friendly-images'); ?></h4></span>
                <p><?php _e('Do you want a professional and individual performance optimization for your website? Increase your Google Pagespeed and SEO traffic with our high performance optimization.', 'pb-seo-friendly-images') ?></p>

                <p>
                    <a href="<?php echo esc_url(__('https://www.pascal-bajorat.com/en/lp/wordpress-performance-optimization/', 'pb-seo-friendly-images')); ?>?utm_source=pb-seo-friendly-images&utm_medium=banner&utm_campaign=pb-seo-friendly-images" class="button"
                       target="_blank"><?php _e('Get a free quote', 'pb-seo-friendly-images') ?></a>
                </p>
            </div>

            <div class="pb-plugin-box">
                <h4>
                                <span class="icon">
                                    <img src="<?php echo plugins_url('assets/img/mailcrypt.png', $this->pbSEOFriendlyImages->plugin['file']); ?>"
                                         alt="<?php _e('MailCrypt - AntiSpam Email Encryption', 'pb-seo-friendly-images') ?>"/>
                                </span>
                    <span class="text"><?php _e('MailCrypt - AntiSpam Email Encryption', 'pb-seo-friendly-images') ?></span>
                </h4>
                <div class="desc">
                    <p><?php _e('This Plugin provides a Shortcode to encrypt email addresses / links and protect them against spam.', 'pb-seo-friendly-images') ?></p>
                    <p>
                        <a href="<?php echo admin_url('plugin-install.php?s=PB+MailCrypt+-+AntiSpam+Email+Encryption&tab=search&type=term') ?>"
                           class="button"><?php _e('Install Plugin', 'pb-seo-friendly-images') ?></a></p>
                </div>
            </div>

            <div class="pb-support-box">
                <h4><?php _e('Support', 'pb-seo-friendly-images') ?></h4>
                <p><?php _e('Do you need some help with this plugin? I am here to help you. Get in touch:', 'pb-seo-friendly-images') ?></p>

                <p>
                    <?php if (!$this->pbSEOFriendlyImages->isProVersion()): ?>
                        <a href="https://wordpress.org/support/plugin/pb-seo-friendly-images" class="button"
                           target="_blank"><?php _e('Support Forum', 'pb-seo-friendly-images') ?></a>
                    <?php else: ?>
                        <a href="https://codecanyon.net/item/seo-friendly-images-pro-for-wordpress/19296704/support?ref=Pascal-Bajorat"
                           class="button" target="_blank"><?php _e('Contact Support', 'pb-seo-friendly-images') ?></a>
                    <?php endif; ?>
                    &nbsp;<a href="https://wordpress.org/plugins/pb-seo-friendly-images/#developers" class="button"
                             target="_blank"><?php _e('Changelog', 'pb-seo-friendly-images') ?></a>
                </p>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function () {

        var $wc_setting_elements = jQuery('#pbsfi_wc_sync_method, label[for="pbsfi_wc_sync_method"], #pbsfi_wc_override_alt, label[for="pbsfi_wc_override_alt"], #pbsfi_wc_override_title, label[for="pbsfi_wc_override_title"], #pbsfi_wc_alt_scheme, label[for="pbsfi_wc_alt_scheme"], #pbsfi_wc_title_scheme, label[for="pbsfi_wc_title_scheme"]');

        if (jQuery('#pbsfi_wc_title').is(':checked')) {
            console.log('fade out');
            $wc_setting_elements.css('opacity', .4);
        }

        jQuery('#pbsfi_wc_title').on('change', function (e) {
            if (jQuery(this).is(':checked')) {
                $wc_setting_elements.css('opacity', .4);
            } else {
                $wc_setting_elements.css('opacity', 1);
            }
        });
    });
</script>