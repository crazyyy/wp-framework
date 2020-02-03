<?php
/*100% match*/

defined('ABSPATH') or die("you do not have acces to this page!");

if (!class_exists("cmplz_review")) {
    class cmplz_review
    {
        private static $_this;


        function __construct()
        {
            if (isset(self::$_this))
	            wp_die(sprintf('%s is a singleton class and you cannot create a second instance.', get_class($this)));

            self::$_this = $this;
            //show review notice, only to free users
            if (!defined("cmplz_premium") && !is_multisite()) {
               if (!get_option('cmplz_review_notice_shown') && get_option('cmplz_activation_time') && get_option('cmplz_activation_time') < strtotime("-1 month")){
                        add_action('wp_ajax_dismiss_review_notice', array($this, 'dismiss_review_notice_callback'));

                        add_action('admin_notices', array($this, 'show_leave_review_notice'));
                        add_action('admin_print_footer_scripts', array($this, 'insert_dismiss_review'));
                }

                //set a time for users who didn't have it set yet.
                if (!get_option('cmplz_activation_time')){
                    update_option('cmplz_activation_time', time());
                }
              }

        }

        static function this()
        {
            return self::$_this;
        }

        public function show_leave_review_notice()
        {

            /*
             * Prevent notice from being shown on Gutenberg page, as it strips off the class we need for the ajax callback.
             *
             * */
            $screen = get_current_screen();
            if ( $screen->parent_base === 'edit' ) return;

                ?>


            <style>
                .cmplz-container {
                    display: flex;
                    padding:12px;
                }
                .cmplz-container .dashicons {
                    margin-left:10px;
                    margin-right:5px;
                }
                .cmplz-review-image img{
                    margin-top:0.5em;
                }
                .cmplz-buttons-row {
                    margin-top:10px;
                    display: flex;
                    align-items: center;
                }
            </style>
            <div id="message" class="updated fade notice is-dismissible cmplz-review really-simple-plugins" style="border-left:4px solid #333">
                <div class="cmplz-container">
                    <div class="cmplz-review-image"><img width=80px" src="<?php echo cmplz_url?>/core/assets/images/icon-128x128.png" alt="review-logo"></div>
                    <div style="margin-left:30px">
                        <p><?php printf(__('Hi, you have been using Complianz | GDPR cookie consent for a month now, awesome! If you have a moment, please consider leaving a review on WordPress.org to spread the word. We greatly appreciate it! If you have any questions or feedback, leave us a %smessage%s.', 'complianz-gdpr'), '<a href="https://complianz.io/contact" target="_blank">', '</a>'); ?></p>
                        <i>- Rogier</i>
                        <div class="cmplz-buttons-row">
                            <a class="button button-primary" target="_blank"
                               href="https://wordpress.org/support/plugin/complianz-gdpr/reviews/#new-post"><?php _e('Leave a review', 'complianz-gdpr'); ?></a>

                            <div class="dashicons dashicons-calendar"></div><a href="#" id="maybe-later"><?php _e('Maybe later', 'complianz-gdpr'); ?></a>

                            <div class="dashicons dashicons-no-alt"></div><a href="#" class="review-dismiss"><?php _e('Don\'t show again', 'complianz-gdpr'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
                <?php

        }

        /**
         * Insert some ajax script to dismiss the review notice, and stop nagging about it
         *
         * @since  2.0
         *
         * @access public
         *
         * type: dismiss, later
         *
         */

        public function insert_dismiss_review()
        {
            $ajax_nonce = wp_create_nonce("cmplz_dismiss_review");
            ?>
            <script type='text/javascript'>
                jQuery(document).ready(function ($) {
                    $(".cmplz-review.notice.is-dismissible").on("click", ".notice-dismiss", function (event) {
                        rsssl_dismiss_review('dismiss');
                    });
                    $(".cmplz-review.notice.is-dismissible").on("click", "#maybe-later", function (event) {
                        rsssl_dismiss_review('later');
                        $(this).closest('.cmplz-review').remove();
                    });
                    $(".cmplz-review.notice.is-dismissible").on("click", ".review-dismiss", function (event) {
                        rsssl_dismiss_review('dismiss');
                        $(this).closest('.cmplz-review').remove();
                    });

                    function rsssl_dismiss_review(type) {
                        var data = {
                            'action': 'dismiss_review_notice',
                            'type': type,
                            'token': '<?php echo $ajax_nonce; ?>'
                        };
                        $.post(ajaxurl, data, function (response) {
                        });
                    }
                });
            </script>
            <?php
        }

        /**
         * Process the ajax dismissal of the review message.
         *
         * @since  2.1
         *
         * @access public
         *
         */

        public function dismiss_review_notice_callback()
        {
            check_ajax_referer('cmplz_dismiss_review', 'token');

            $type = isset($_POST['type']) ? $_POST['type'] : false;

            if ($type === 'dismiss') {
                update_option('cmplz_review_notice_shown',true);
            }
            if ($type === 'later') {
                //Reset activation timestamp, notice will show again in one month.
                update_option('cmplz_activation_time', time());
            }

            wp_die(); // this is required to terminate immediately and return a proper response
        }
    }
}