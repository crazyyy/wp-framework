<?php
    if(!defined('ABSPATH')){
        exit();
    }
    
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $tab == 'test'){
        if(!$_POST['settings_test_nonce'] 
            || !wp_verify_nonce($_POST['settings_test_nonce'], 'wpreroute_test_settings')
            || $_POST['_wp_http_referer'] != '/wp-admin/admin.php?page=wp-reroute-email%2Fsettings.php&tab=test') {
            print esc_html__('Unauthorized access.');
            exit;
        }
        $to = sanitize_text_field(filter_input(INPUT_POST, 'to_email'));
        $subject = sanitize_text_field(filter_input(INPUT_POST, 'subject'));
        $message = sanitize_textarea_field(filter_input(INPUT_POST, 'message'));
        
        if($to && $subject && $message){
            wp_mail($to, $subject, $message);
            print '<div id="message" class="updated fade"><p>'. esc_html__('Email sent.', 'wp-reroute-email') . '</p></div>';
        }
    }
?>    
<p><?php esc_html_e('You may test your settings by sending an email using this form.', 'wp-reroute-email');?></p>    
<form action="" method="POST">
    <?php wp_nonce_field( 'wpreroute_test_settings', 'settings_test_nonce' ); ?>
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row"><?php  esc_html_e('To', 'wp-reroute-email'); ?></th>
                <td><input type="email" name="to_email" size="60" value="<?php esc_attr_e('test@example.com');?>"></td>
            </tr>
            <tr>
                <th scope="row"><?php  esc_html_e('Subject', 'wp-reroute-email'); ?></th>
                <td><input type="text" name="subject" size="60" value="<?php esc_attr_e('WP Reroute Email Test Message');?>"></td>
            </tr>
            <tr>
                <th scope="row"><?php  esc_html_e('Message', 'wp-reroute-email'); ?></th>
                <td><textarea name="message" rows="5" cols="70"><?php esc_attr_e('This is a test message from WP Reroute Email.');?></textarea></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value=" <?php esc_attr_e('Send', 'wp-reroute-email'); ?> " class="button blue"></td>
            </tr>
        </tbody>
    </table>
</form>