<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );


class ScriptHandler {
	/**
	 * Enqueue scripts
	 */


	public function __construct() {
		add_action( 'wp_footer', [ $this, 'sit_scripts' ], 5 );
	}

	public function sit_scripts() { ?>

		<?php

		global $sit_settings;
		$sit_settings = (array) get_option( 'sit_settings' );
		$key          = 'disable_clientside_script';
		$name         = $_SERVER['SERVER_NAME'];
		//var_dump($name);
		//var_dump($sit_settings[$key]);//$var = get_option('wc_bom_option'); ?>

		<?php if ( null === $sit_settings[ $key ] ) ://$ke//if (is_null($sit_settings[$key])) { echo 'is_null';?>
            <script type="text/javascript">

                //jQuery(document).ready(function($) {
                jQuery(document).ready(function ($) {
                    var count = 0;
                    var pathname = window.location.pathname; // Returns path only
                    var url = window.location.href;
                    var pdf;

                    $("a").each(function () {


                        if (($(this).attr('href') !== '#') && ($(this).attr('href') != null)) {

                            var url = $(this).attr('href');

							<?php $key2 = 'enable_pdf_ext';

							if (! ( null === $sit_settings[ $key2 ] )): ?>

                            var pos = url.indexOf('.pdf');
                            //console.log(pos);
                            if (pos !== -1) {
                                $(this).attr('target', '_blank');
                            }


							<?php endif;

							$key3 = 'enable_seo_links';

							if (! ( null === $sit_settings[ $key3 ] )): ?>

                            var host = window.location.host;
                            var pos = url.indexOf(host);
                            //console.log(host);
                            if (pos === -1) {
                                $(this).attr('target', '_blank');
                            }

							<?php endif; ?>

                        }

                    }); //each


                });

            </script>

		<?php endif;
	}
}

$ss = new ScriptHandler();