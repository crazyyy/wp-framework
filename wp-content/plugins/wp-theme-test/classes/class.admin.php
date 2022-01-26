<?php
class WPTT_Admin extends WPTT_Core {

    /**
     * __construct
     */
    function __construct() {
        add_action( 'admin_menu', array( $this, 'add_pages' ) );

        // プラグインページのみに制限
        if ( isset( $_REQUEST["page"] ) && $_REQUEST["page"] == WPTT_PLUGIN_NAME ) {
            add_action( 'admin_print_styles', array( $this, 'head_css', ) );
            add_action( 'admin_notices', array( $this, 'admin_notices' ) );
            add_action( 'admin_init', array( $this, 'admin_init' ) );
        }
    }

    /**
     * 管理画面に設定ページを追加
     */
    function add_pages() {
        add_theme_page( 'WP Theme Test', 'WP Theme Test', 'edit_theme_options', WPTT_PLUGIN_NAME, array( $this, 'options_page' ) );
    }

    /**
     * 管理画面CSS追加
     */
    public function head_css() {
        wp_enqueue_style( "wptt_css", WPTT_PLUGIN_URL . '/css/styles.css' );
    }

    /**
     * インストールテーマを表示し、テストが有効化されているテーマを表示する
     */
    function the_list_themes() {
        $themes = wp_get_themes();

        if ( count( $themes ) > 1 ) {
            $html = '<select name="theme">';

            foreach ( $themes as $theme ) {
                if ( $this->get_theme() == $theme->get_stylesheet() || ( $this->get_theme() == null && $theme->get_template() == get_stylesheet() ) ) {
                    $html .= '<option value="' . $theme->get_stylesheet() . '" selected="selected">' . $theme->Name . '</option>' . PHP_EOL;
                } else {
                    $html .= '<option value="' . $theme->get_stylesheet() . '">' . $theme->Name . '</option>' . PHP_EOL;
                }
            }
            $html .= '</select>';

            echo $html;
        }
    }


    function admin_init() {
        /**
         * テストテーマのOn/Offを設定
         */
        if ( isset( $_POST['_wpnonce'] ) && $_POST['_wpnonce'] ) {
            $errors = new WP_Error();
            $updates = new WP_Error();

            if ( check_admin_referer( 'wp-theme-test', '_wpnonce' ) ) {

                //オプションを設定
                $theme = esc_html( $_POST['theme'] );
                foreach ( $_POST['capabilities'] as $key => $value ) {
                    $capabilities[] = esc_html( $value );
                }
                $parameter = esc_html( $_POST['parameter'] );
                $ip_list = esc_html( $_POST['ip_list'] );

                $options = get_option( WPTT_PLUGIN_NAME );
                $options['theme'] = $theme;
                $options['capabilities'] = $capabilities;
                $options['parameter'] = $parameter;
                $options['ip_list'] = $ip_list;

                //On/Off設定
                if ( esc_html( $_POST['status'] ) == 1 ) {
                    $options['status'] = 1;
                }else {
                    $options['status'] = 0;
                }

                update_option( WPTT_PLUGIN_NAME, $options );

                $updates->add( 'update', $this->_( 'Saved' ) );
                set_transient( 'wptt-updates', $updates->get_error_messages(), 1 );

                // wp_safe_redirect( menu_page_url( WPTT_PLUGIN_NAME, false ) );
            }else {
                $errors->add( 'error', $this->_( 'An invalid value has been sent' ) );
                set_transient( 'wptt-errors', $errors->get_error_messages(), 1 );
            }

        }
    }


    /**
     * アップデート表示
     */
    function admin_notices() {
?>
    <?php if ( $messages = get_transient( 'wptt-updates' ) ): ?>
    <div class="updated">
        <ul>
            <?php foreach ( $messages as $key => $message ) : ?>
            <li><?php echo esc_html( $message ); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

 <?php if ( $messages = get_transient( 'wptt-errors' ) ): ?>
    <div class="error">
        <ul>
            <?php foreach ( $messages as $key => $message ) : ?>
            <li><?php echo esc_html( $message ); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
<?php
    }


    /**
     * options_page
     */
    function options_page() {
        // 保存されている情報を取得
        $options = get_option( WPTT_PLUGIN_NAME );
        // print_r($options);
?>
<div class="plugin-wrap">
<div class="plugin-main">
<h1>WP Theme Test</h1>
<p><?php $this->e( 'The theme can be changed and displayed to only logged in users.' ) ?></p>

<form method="post" action="">
<?php wp_nonce_field( 'wp-theme-test', '_wpnonce' ); ?>

<table class="form-table">

<tr>
<th><?php $this->e('Test Theme') ?></th>
<td>
<?php $this->the_list_themes(); ?>
<p class="description">
<?php $this->e('Display the selected theme to the user logged in.') ?>
</p>
</td>
</tr>
</table>

<hr>

<table class="form-table">
<tr>
<th><?php $this->e( 'Current state' ) ?></th>
<td>
<label><input type='radio' name='status' value='1' <?php if ( $this->is_test_enabled() ): ?>checked='checked'<?php endif; ?> /> <?php if ( $this->is_test_enabled() ): ?><strong><?php endif; ?>On<?php if ( $this->is_test_enabled() ): ?></strong><?php endif; ?></label>
<label style="margin-left:20px;"><input type='radio' name='status' value='0' <?php if ( !$this->is_test_enabled() ): ?>checked='checked'<?php endif; ?> /> <?php if ( ! $this->is_test_enabled() ): ?><strong><?php endif; ?>Off<?php if ( ! $this->is_test_enabled() ): ?></strong><?php endif; ?></label>
</td>
</tr>

<tr>
<th><?php $this->e('Roles') ?></th>
<td>
<?php
        //権限グループを表示
        $editable_roles = array_reverse( get_editable_roles() );
?>
<select name="capabilities[]" size="<?php echo count( $editable_roles ); ?>" multiple>
<?php
        foreach ( $editable_roles as $key => $value ) {
            $name = translate_user_role( $value['name'] );
            if ( in_array( $key, $options['capabilities'] ) ) {
                echo '<option value="' . esc_attr( $key ) . '" selected="selected">'.$name.'</option>'.PHP_EOL;
            }else {
                echo '<option value="' . esc_attr( $key ) . '">'.$name.'</option>'.PHP_EOL;
            }
        }
?>
</select>
<p class="description">
<?php $this->e('User permission group for display of test themes. You can select more than one.') ?>
</p>
</td>
</tr>
</table>

<hr>

<table class="form-table">
<tr>
    <th><?php $this->e('Parameter Function') ?></th>
    <td>
<select name="parameter">
<option value="1" <?php if ( $this->get_parameter() ): ?>selected='selected'<?php endif; ?>><?php $this->e('Enable') ?></option>
<option value="0" <?php if ( !$this->get_parameter() ): ?>selected='selected'<?php endif; ?>><?php $this->e('Disable') ?></option>
</select>
<p class="description">
<?php $this->e('When this function is enable the test theme can be displayed even when the current state is "Off."') ?>
</p>
<p class="description">
<?php $example_url = home_url('/') . '?theme=' . $this->get_theme(); ?>
Ex: <a href="<?php echo $example_url; ?>" target="_blank"><?php echo $example_url; ?></a>
</p>
    </td>
</tr>
</table>

<hr>

<table class="form-table">
<tr>
<th>
  <?php $this->e('IP Address') ?>
</th>
<td>
<textarea name="ip_list" rows="4" cols="60" placeholder="123.45.678.90&#13;&#10;<?php echo $_SERVER['REMOTE_ADDR']; ?>">
<?php echo $options['ip_list'] ?>
</textarea>
<p class="description">
<?php $this->e('These IP address users can display the test theme.') ?><br>
<?php $this->e('Your current IP is:'); echo $_SERVER['REMOTE_ADDR']; ?>
</p>
</td>
</tr>

</table>

<p class="submit"><input type="submit" name="submit" value="<?php $this->e('Save') ?>" class="button-primary" /></p>

</form>
</div><!-- /.plugin-main -->


<div class="plugin-side">
    <div class="plugin-side-inner">
    <h3>Support</h3>

<div class="box">
<p>
<strong>Twitter</strong>:
<a class="twitter-follow-button" href="https://twitter.com/kanakogi" data-show-count="false">
Follow @kanakogi</a>
</p>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>


<p>
<strong>BLOG</strong>:<br>
<?php $this->e( 'The detailed explanation of this plugin.(Japanese Only)' );?><br>
<a href="http://www.kigurumi.asia/imake/4716/" target="_blank">http://www.kigurumi.asia/imake/4716/</a>
</p>

<p>
<strong>GitHub</strong>:<br>
<a href="https://github.com/kanakogi/WP-Theme-Test" target="_blank">WP Theme Test</a>
</p>
</div>

    </div><!-- /.plugin-side-inner -->
</div><!-- /.plugin-side -->

</div><!-- /.plugin-wrap -->
<?php
    }
}
new WPTT_Admin();
