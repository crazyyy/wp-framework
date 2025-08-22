<?php

class CF7Apps_hCaptcha_App extends CF7Apps_App {

    /**
     * Languages supported by hCaptcha
     * 
     * @since 3.0.0
     */
    public $languages = array();

    /**
     * Selected language
     * 
     * @since 3.0.0
     */
    public $selected_language = '';

    /**
     * Constructor
     * 
     * @since 3.0.0
     */
    public function __construct() {
        $this->languages = array(
            ''          => __( 'Default', 'cf7apps' ),
            'af'        => __( 'Afrikaans', 'cf7apps' ),
            'sq'        => __( 'Albanian', 'cf7apps' ),
            'am'        => __( 'Amharic', 'cf7apps' ),
            'ar'        => __( 'Arabic', 'cf7apps' ),
            'hy'        => __( 'Armenian', 'cf7apps' ),
            'az'        => __( 'Azerbaijani', 'cf7apps' ),
            'eu'        => __( 'Basque', 'cf7apps' ),
            'be'        => __( 'Belarusian', 'cf7apps' ),
            'bn'        => __( 'Bengali', 'cf7apps' ),
            'bg'        => __( 'Bulgarian', 'cf7apps' ),
            'bs'        => __( 'Bosnian', 'cf7apps' ),
            'my'        => __( 'Burmese', 'cf7apps' ),
            'ca'        => __( 'Catalan', 'cf7apps' ),
            'ceb'       => __( 'Cebuano', 'cf7apps' ),
            'zh'        => __( 'Chinese', 'cf7apps' ),
            'zh-CN'     => __( 'Chinese Simplified', 'cf7apps' ),
            'zh-TW'     => __( 'Chinese Traditional', 'cf7apps' ),
            'co'        => __( 'Corsican', 'cf7apps' ),
            'hr'        => __( 'Croatian', 'cf7apps' ),
            'cs'        => __( 'Czech', 'cf7apps' ),
            'da'        => __( 'Danish', 'cf7apps' ),
            'nl'        => __( 'Dutch', 'cf7apps' ),
            'en'        => __( 'English', 'cf7apps' ),
            'eo'        => __( 'Esperanto', 'cf7apps' ),
            'et'        => __( 'Estonian', 'cf7apps' ),
            'fa'        => __( 'Farsi/ Persian', 'cf7apps' ),
            'fi'        => __( 'Finnish', 'cf7apps' ),
            'fr'        => __( 'French', 'cf7apps' ),
            'fy'        => __( 'Frisian', 'cf7apps' ),
            'gd'        => __( 'Gaelic', 'cf7apps' ),
            'gl'        => __( 'Galacian', 'cf7apps' ),
            'ka'        => __( 'Georgian', 'cf7apps' ),
            'de'        => __( 'German', 'cf7apps' ),
            'el'        => __( 'Greek', 'cf7apps' ),
            'gu'        => __( 'Gujurati', 'cf7apps' ),
            'ht'        => __( 'Haitian', 'cf7apps' ),
            'ha'        => __( 'Hausa', 'cf7apps' ),
            'haw'       => __( 'Hawaiian', 'cf7apps' ),
            'he'        => __( 'Hebrew', 'cf7apps' ),
            'hi'        => __( 'Hindi', 'cf7apps' ),
            'hmn'       => __( 'Hmong', 'cf7apps' ),
            'hu'        => __( 'Hungarian', 'cf7apps' ),
            'is'        => __( 'Icelandic', 'cf7apps' ),
            'ig'        => __( 'Igbo', 'cf7apps' ),
            'id'        => __( 'Indonesian', 'cf7apps' ),
            'ga'        => __( 'Irish', 'cf7apps' ),
            'it'        => __( 'Italian', 'cf7apps' ),
            'ja'        => __( 'Japanese', 'cf7apps' ),
            'jw'        => __( 'Javanese', 'cf7apps' ),
            'kn'        => __( 'Kannada', 'cf7apps' ),
            'kk'        => __( 'Kazakh', 'cf7apps' ),
            'km'        => __( 'Khmer', 'cf7apps' ),
            'rw'        => __( 'Kinyarwanda', 'cf7apps' ),
            'ky'        => __( 'Kirghiz', 'cf7apps' ),
            'ko'        => __( 'Korean', 'cf7apps' ),
            'ku'        => __( 'Kurdish', 'cf7apps' ),
            'lo'        => __( 'Lao', 'cf7apps' ),
            'la'        => __( 'Latin', 'cf7apps' ),
            'lv'        => __( 'Latvian', 'cf7apps' ),
            'lt'        => __( 'Lithuanian', 'cf7apps' ),
            'lb'        => __( 'Luxembourgish', 'cf7apps' ),
            'mk'        => __( 'Macedonian', 'cf7apps' ),
            'mg'        => __( 'Malagasy', 'cf7apps' ),
            'ms'        => __( 'Malay', 'cf7apps' ),
            'ml'        => __( 'Malayalam', 'cf7apps' ),
            'mt'        => __( 'Maltese', 'cf7apps' ),
            'mi'        => __( 'Maori', 'cf7apps' ),
            'mr'        => __( 'Marathi', 'cf7apps' ),
            'mn'        => __( 'Mongolian', 'cf7apps' ),
            'me'        => __( 'Montenegrin (as Bosnian)', 'cf7apps' ),
            'ne'        => __( 'Nepali', 'cf7apps' ),
            'no'        => __( 'Norwegian', 'cf7apps' ),
            'ny'        => __( 'Nyanja', 'cf7apps' ),
            'or'        => __( 'Oriya', 'cf7apps' ),
            'pl'        => __( 'Polish', 'cf7apps' ),
            'pt'        => __( 'Portuguese', 'cf7apps' ),
            'ps'        => __( 'Pashto', 'cf7apps' ),
            'pa'        => __( 'Punjabi', 'cf7apps' ),
            'ro'        => __( 'Romanian', 'cf7apps' ),
            'ru'        => __( 'Russian', 'cf7apps' ),
            'sm'        => __( 'Samoan', 'cf7apps' ),
            'sn'        => __( 'Shona', 'cf7apps' ),
            'sd'        => __( 'Sindhi', 'cf7apps' ),
            'si'        => __( 'Sinhalese', 'cf7apps' ),
            'sr'        => __( 'Serbian', 'cf7apps' ),
            'sk'        => __( 'Slovak', 'cf7apps' ),
            'sl'        => __( 'Slovenian', 'cf7apps' ),
            'so'        => __( 'Somali', 'cf7apps' ),
            'st'        => __( 'Southern Sotho', 'cf7apps' ),
            'es'        => __( 'Spanish', 'cf7apps' ),
            'su'        => __( 'Sundanese', 'cf7apps' ),
            'sw'        => __( 'Swahili', 'cf7apps' ),
            'sv'        => __( 'Swedish', 'cf7apps' ),
            'tl'        => __( 'Tagalog', 'cf7apps' ),
            'tg'        => __( 'Tajik', 'cf7apps' ),
            'ta'        => __( 'Tamil', 'cf7apps' ),
            'tt'        => __( 'Tatar', 'cf7apps' ),
            'te'        => __( 'Teluga', 'cf7apps' ),
            'th'        => __( 'Thai', 'cf7apps' ),
            'tr'        => __( 'Turkish', 'cf7apps' ),
            'tk'        => __( 'Turkmen', 'cf7apps' ),
            'ug'        => __( 'Uyghur', 'cf7apps' ),
            'uk'        => __( 'Ukrainian', 'cf7apps' ),
            'ur'        => __( 'Urdu', 'cf7apps' ),
            'uz'        => __( 'Uzbek', 'cf7apps' ),
            'vi'        => __( 'Vietnamese', 'cf7apps' ),
            'cy'        => __( 'Welsh', 'cf7apps' ),
            'xh'        => __( 'Xhosa', 'cf7apps' ),
            'yi'        => __( 'Yiddish', 'cf7apps' ),
            'yo'        => __( 'Yoruba', 'cf7apps' ),
            'zu'        => __( 'Zulu', 'cf7apps' )
        );

        $this->id = 'hcaptcha';
        $this->priority = 2;
        $this->title = __( 'hCaptcha', 'cf7apps' );
        $this->description = __( 'Add hCaptcha to Contact Form 7 for secure, spam-free forms.', 'cf7apps' );
        $this->icon = plugin_dir_url( __FILE__ ) . 'assets/images/logo.png';
        $this->has_admin_settings = true;
        $this->is_pro = false;
        $this->by_default_enabled = false;
        $this->documentation_url = 'https://cf7apps.com/docs/spam-protection/contact-form-7-hcaptcha/';
        $this->parent_menu = __( 'Spam Protection', 'cf7apps' );

        add_action( 'wp_footer', array( $this, 'enqueue_script' ) );
        add_action( 'wpcf7_init', array( $this, 'register_shortcode' ), 10 );
        add_filter( 'wpcf7_validate', array( $this, 'validate_hcaptcha' ), 10, 2 );
        add_action( 'wpcf7_admin_init', array( $this, 'wpcf7_admin_init' ) );
    }
    
    /**
     * Register Admin Settings
     * 
     * @since 3.0.0
     */
    public function admin_settings() {
        return array(
            'general'   =>  array(
                'fields'    =>  array(
                    'title'         => __( 'hCaptcha Settings' ),
                    'description'   => __( 'Add hCaptcha to Contact Form 7 for secure, spam-free forms.', 'cf7apps' ),
                    'is_enabled'    => array(
                        'title'         => __( 'Enable hCaptcha App', 'cf7apps' ),
                        'type'          => 'checkbox',
                        'default'       => false,
                    ),
                    'site_key'     =>  array(
                        'title'             => __( 'Site Key', 'cf7apps' ),
                        'type'              => 'text',
                        'required'          => true,
                        'required_message'  => __( 'Site key is required.', 'cf7apps' ),
                        'description'       => __( 'Enter your site key. Don\'t have one? <a href="https://dashboard.hcaptcha.com/sites">Click here</a> to generate a new key.', 'cf7apps' ),
                        'class'             => 'xl'
                    ),
                    'secret_key'  =>  array(
                        'title'             => __( 'Secret Key', 'cf7apps' ),
                        'type'              => 'text',
                        'required'          => true,
                        'required_message'  => __( 'Secret key is required.', 'cf7apps' ),
                        'description'       => __( 'Enter your secret key. Don\'t have one? <a href="https://dashboard.hcaptcha.com/settings/secrets">Click here</a> to generate a new key.', 'cf7apps' ),
                        'class'             => 'xl'
                    ),
                    'invalid_message' =>  array(
                        'title'             => __( 'Invalid Captcha error message', 'cf7apps' ),
                        'type'              => 'text',
                        'placeholder'       => __( 'Invalid Captcha', 'cf7apps' ),
                        'description'       => __( 'Enter a custom message to display when CAPTCHA validation fails.', 'cf7apps' ),
                        'class'             => 'xl'
                    ),
                    'language' =>  array(
                        'title'             => __( 'Force hCaptcha to render in a specific language.', 'cf7apps' ),
                        'type'              => 'select',
                        'default'           => '',
                        'description'       => __( 'Choose a language for your CAPTCHA display.', 'cf7apps' ),
                        'class'             => 'xs',
                        'options'           => $this->languages
                    ),
                    'save_settings'  => array(
                        'type'          => 'save_button',
                        'text'          => __( 'Save Settings', 'cf7apps' ),
                        'class'         => 'button-primary'
                    )
                )
            )
        );
    }

    /**
     * Register Shortcode | Action Callback
     * 
     * @since 3.0.0
     */
    public function register_shortcode() {
        if ( function_exists( 'wpcf7_add_form_tag' ) ) {
            wpcf7_add_form_tag( 'cf7apps_hcaptcha', array( $this, 'render_cf7apps_hcaptcha' ), array( 'name-attr' => true ) );
        } else {
            wpcf7_add_shortcode( 'cf7apps_hcaptcha', array( $this, 'render_cf7apps_hcaptcha' ), true );
        }
    }

    /**
     * Renders hCaptcha
     * 
     * @param mixed $tag
     * @return string
     * 
     * @since 3.0.0
     */
    public function render_cf7apps_hcaptcha( $tag ) {
        // Support both WPCF7_FormTag (CF7 4.6+) and WPCF7_Shortcode (older)
        $tag = ( class_exists( 'WPCF7_FormTag' ) ) ? new WPCF7_FormTag( $tag ) : new WPCF7_Shortcode( $tag );

        $site_key = $this->get_option( 'site_key' );
        $global_selected_language = $this->get_option( 'language' );
        
        $this->selected_language = ! empty( $tag->get_option( 'language' )[0] ) ? $tag->get_option( 'language' )[0] : '';
        $this->selected_language = empty( $this->selected_language ) ? $global_selected_language : $this->selected_language;

        // Get options from tag
        $size = !empty($tag->get_option('size')[0]) ? $tag->get_option('size')[0] : 'normal';
        $theme = !empty($tag->get_option('theme')[0]) ? $tag->get_option('theme')[0] : 'light';
        $custom_css = !empty($tag->get_option('custom-css')[0]) ? $tag->get_option('custom-css')[0] : '';

        // Build hCaptcha attributes
        $attr = array(
            'class' => 'h-captcha' . ($custom_css ? ' ' . esc_attr($custom_css) : ''),
            'data-sitekey' => esc_attr($site_key),
            'data-size' => esc_attr($size),
            'data-theme' => esc_attr($theme),
        );
        if ($this->selected_language) {
            $attr['data-lang'] = esc_attr($this->selected_language);
        }

        // Build attribute string
        $attr_str = '';
        foreach ($attr as $k => $v) {
            $attr_str .= sprintf(' %s="%s"', $k, $v);
        }

        return '<div' . $attr_str . '></div><span class="wpcf7-form-control-wrap cf7apps-hcaptcha" data-name="cf7apps-hcaptcha"><input type="hidden" name="cf7apps-hcaptcha" value="" class="wpcf7-form-control"></span>';
    }

    /**
     * Enqueue Script
     * 
     * @since 3.0.0
     */
    public function enqueue_script() {
        if( $this->get_option( 'is_enabled' ) ) {
            $site_key = $this->get_option( 'site_key' );
            $script_url = 'https://js.hcaptcha.com/1/api.js?onload=CF7AppsLoadhCaptcha';
            
            if( ! empty( $this->selected_language ) ) {
                $script_url .= "&hl={$this->selected_language}";
            }

            ?>
            <script type="text/javascript">
                var CF7AppsLoadhCaptcha = function() {
                    var hcaptcha = document.querySelectorAll( '.h-captcha' );
                    for (var i = 0; i < hcaptcha.length; i++) {
                        hcaptcha[i].setAttribute( 'data-sitekey', '<?php echo esc_js( $site_key ); ?>' );
                        hcaptcha[i].setAttribute( 'data-callback', 'cf7apps_hcaptcha_callback' );
                    }
                };
            </script>
            <script 
                src="<?php echo esc_url( $script_url ); ?>" 
                async 
                defer
            ></script>
            <?php
        }
    }

    /**
     * Validate hCaptcha
     * 
     * @since 3.0.0
     */
    public function validate_hcaptcha( $result, $tags ) { 
        if( $this->get_option( 'is_enabled' ) ) {
            $has_tag = false;

            foreach ( $tags as $tag ) {
                if ( $tag->type === 'cf7apps_hcaptcha' ) {
                    $has_tag = true;
                    $invalid_message = $tag->get_option( 'invalid-message' );
                    if ( is_array( $invalid_message ) ) {
                        $invalid_message = implode( ' ', $invalid_message );
                    }
                    $invalid_message = $invalid_message ?: $this->get_option( 'invalid_message' );
                    break;
                }
            }

            if( ! $has_tag ) {
                // No hCaptcha tag found, skip validation
                return $result;
            }

            $invalid_message = $invalid_message ? $invalid_message : __( 'Invalid Captcha', 'cf7apps' );
            $secret_key = $this->get_option( 'secret_key' );
            $hcaptcha_response = ! empty( $_POST['h-captcha-response'] ) ? $_POST['h-captcha-response'] : false;

            if( $hcaptcha_response ) {
                $response = wp_remote_post( 'https://api.hcaptcha.com/siteverify', array(
                    'body' => array(
                        'secret'    => $secret_key,
                        'response'  => $hcaptcha_response
                    )
                ) );
                $response_code = wp_remote_retrieve_response_code( $response );
                $response_body = json_decode( wp_remote_retrieve_body( $response ), true );
                $invalid_message = ( ! empty( $response_body['error-codes'][0] ) && $response_body['error-codes'][0] == 'sitekey-secret-mismatch' ) ? $response_body['error-codes'][0] : $invalid_message;

                if( ! isset( $response_body['success'] ) || ! $response_body['success'] ) {
                    $result->invalidate(
                        array(
                            'type'  => 'hcaptcha',
                            'name'  => 'cf7apps-hcaptcha'
                        ),
                        $invalid_message
                    );
                }
                
            }
            else {
                $result->invalidate( 
                    array(
                        'type'  => 'hcaptcha',
                        'name'  => 'cf7apps-hcaptcha'
                    ),
                    $invalid_message
                );
            }
        }

        return $result;
    }

    /**
     * Renders button on form | Action Callback
     * 
     * @since 3.0.0
     */
    public function wpcf7_admin_init(){
        if( $this->get_option( 'is_enabled' ) ) {
            $tag_generator = WPCF7_TagGenerator::get_instance();
            $tag_generator->add( 'cf7apps_hcaptcha', __( 'hCaptcha', 'cf7apps' ), array( $this, 'render_tag_generator' ), array( 'version' => 2 ) );
        }
    }

    /**
     * Render Tag Generator | Callback
     * 
     * @since 3.0.0
     */
    public function render_tag_generator( $contact_form, $args = '' ) {
        $args = wp_parse_args( $args, array() );
        // Get current values if available
        $error_message = $this->get_option( 'invalid_message' );
        $language = $this->get_option( 'language' );
        $size = isset( $args['size'] ) ? $args['size'] : 'normal';
        $custom_css = isset( $args['custom_css'] ) ? $args['custom_css'] : '';

        ?>
        <header class="description-box">
            <h3><?php echo $this->title; ?></h3>
            <div style="border-left: 4px solid #3399ff; background: #e6f4ff; padding: 1px 14px; margin-bottom: 10px; border-radius: 5px;">
                <p style="margin: 7px auto;"><?php 
                    printf( 
                        '%s <a href="%s" target="_blank">%s</a>',
                    esc_html__( 'Need help setting this up? Check out our' ),
                        esc_url( $this->documentation_url ),
                        esc_html__( 'Documentation', 'cf7apps' )
                    ) 
                ?></p>
            </div>
        </header>
        <div class="control-box">
            <?php
                if (class_exists('WPCF7_TagGeneratorGenerator')) {
                    $tag = new WPCF7_TagGeneratorGenerator( $args['content'] );
                    $tag->print(
                        'field_type',
                        array(
                            'select_options'    => array(
                                "cf7apps_{$this->id}"   => $this->title
                            )
                        )
                    );
                    $tag->print( 'field_name' );
                }
            ?>
            <fieldset>
                <legend id="<?php echo esc_attr( $args['content'] ); ?>-invalid-message-legend">
                    <?php esc_html_e( 'Error message', 'cf7apps' ); ?>
                </legend>
                <input type="text" value="<?php echo esc_attr( $error_message ); ?>" data-tag-option="invalid-message:" data-tag-part="option" name="invalid-message" class="invalid-message-value oneline option" id="<?php echo esc_attr( $args['content'] . '-invalid-message' ); ?>" />
                <br />
                <label><?php esc_html_e( 'Enter a custom message to display when CAPTCHA validation fails.', 'cf7apps' ); ?></label>
            </fieldset>
            <fieldset>
                <legend id="<?php echo esc_attr( $args['content'] ); ?>-language-legend">
                    <?php esc_html_e( 'Language', 'cf7apps' ); ?>
                </legend>
                <select name="language" class="widefat" data-tag-option="language:" data-tag-part="option" id="<?php echo esc_attr( $args['content'] . '-language' ); ?>">
                    <?php
                    foreach ( $this->languages as $lang_code => $lang_name ) {
                        printf(
                            '<option value="%s"%s>%s</option>',
                            esc_attr( $lang_code ),
                            selected( $language, $lang_code, false ),
                            esc_html( $lang_name )
                        );
                    }
                    ?>
                </select>
                <br />
                <label><?php esc_html_e( 'Choose a language for your CAPTCHA display.', 'cf7apps' ); ?></label>
            </fieldset>
            <!-- New Size Field -->
            <fieldset>
                <legend id="<?php echo esc_attr( $args['content'] ); ?>-size-legend">
                    <?php esc_html_e( 'Size', 'cf7apps' ); ?>
                </legend>
                <select name="size" class="widefat" data-tag-option="size:" data-tag-part="option" id="<?php echo esc_attr( $args['content'] . '-size' ); ?>">
                    <option value="normal" <?php selected( $size, 'normal' ); ?>><?php esc_html_e( 'Normal', 'cf7apps' ); ?></option>
                    <option value="compact" <?php selected( $size, 'compact' ); ?>><?php esc_html_e( 'Compact', 'cf7apps' ); ?></option>
                </select>
                <br />
                <label><?php esc_html_e( 'Choose the size of the hCaptcha widget.', 'cf7apps' ); ?></label>
            </fieldset>
            <!-- New Custom CSS Field -->
            <fieldset>
                <legend id="<?php echo esc_attr( $args['content'] ); ?>-custom-css-legend">
                    <?php esc_html_e( 'Custom CSS', 'cf7apps' ); ?>
                </legend>
                <input type="text" value="<?php echo esc_attr( $custom_css ); ?>" data-tag-option="custom-css:" data-tag-part="option" name="custom-css" class="custom-css-value oneline option" id="<?php echo esc_attr( $args['content'] . '-custom-css' ); ?>" />
                <br />
                <label><?php esc_html_e( 'Add custom CSS classes to the hCaptcha widget.', 'cf7apps' ); ?></label>
            </fieldset>
            <!-- New Theme Field -->
            <fieldset>
                <legend id="<?php echo esc_attr( $args['content'] ); ?>-theme-legend">
                    <?php esc_html_e( 'Theme', 'cf7apps' ); ?>
                </legend>
                <select name="theme" class="widefat" data-tag-option="theme:" data-tag-part="option" id="<?php echo esc_attr( $args['content'] . '-theme' ); ?>">
                    <option value="light" <?php selected( isset($args['theme']) ? $args['theme'] : 'light', 'light' ); ?>><?php esc_html_e( 'Light', 'cf7apps' ); ?></option>
                    <option value="dark" <?php selected( isset($args['theme']) ? $args['theme'] : 'light', 'dark' ); ?>><?php esc_html_e( 'Dark', 'cf7apps' ); ?></option>
                </select>
                <br />
                <label><?php esc_html_e( 'Choose the theme for the hCaptcha widget.', 'cf7apps' ); ?></label>
            </fieldset>
            <!-- End Theme Field -->
        </div>
        <footer class="insert-box">
            <?php
                if (isset($tag)) {
                    $tag->print( 'insert_box_content' );
                }
            ?>
        </footer>
        <?php
    }
}

/**
 * Register hCpatcha App
 * 
 * @since 3.0.0
 */
if( ! function_exists( 'cf7apps_register_hcaptcha' ) ):
function cf7apps_register_hcaptcha( $apps ) {
    $apps[] = 'CF7Apps_hCaptcha_App';

    return $apps;
}
endif;

add_filter( 'cf7apps_apps', 'cf7apps_register_hcaptcha' );