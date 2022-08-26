<?php
if (!defined('ABSPATH')) {
     exit();
}
?>
<div class="wrap">
    <h2><?php _e('Debug Settings','debug');?></h2>
    <?php debug_save_setting();
    $debug_settings = debug_get_options();
    ?>
    <form method="post" action="">
        <table class="form-table">
            <tbody>
                <tr>
                    <th><?php _e('Get "wp-config.php" for Backup','debug');?></th>
                    <td>
                        <input type="submit" name="downloadconfig" id="downloadconfig" class="button button-primary" value="<?php _e('Download','debug');?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Debug settings','debug');?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">
                                <span>
                                    <?php _e('Error Reporting','debug');?>
                                </span>
                            </legend>
                            <label for="enable_notification">
                                <input name="enable_notification" type="checkbox" id="enable_notification" value="1" <?php if (isset($debug_settings['enable']) && $debug_settings['enable']==1) { ?>checked="checked"<?php } ?>>
                                <?php _e('Enable Email Notification','debug');?>
                            </label>
                            <br>
                            <div class="emailnotification">
                                <label for="email_notification">
                                    <input placeholder="<?php _e('Email Address','debug');?>" name="email_notification" type="text" id="email_notification" value="<?php if (isset($debug_settings['email'])) { echo $debug_settings['email']; }else{echo $user_email;} ?>">
                                </label>
                                <br>
                            </div>
                            <div class="noemailnotification">
                            <label for="error_reporting">
                                <input name="error_reporting" type="checkbox" id="error_reporting" value="1" <?php if (defined('WP_DEBUG') && WP_DEBUG == true) { ?>checked="checked"<?php } ?>>
                                <?php _e('Enable error Reporting','debug');?>
                            </label>
                            </div>
                            <div class="noemailnotification">
                            <label for="error_log">
                                <input name="error_log" type="checkbox" id="error_log" value="1" <?php if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG == true) { ?>checked="checked"<?php } ?>>
                                <?php _e('Create Error Log in File','debug');?> /wp-content/debug.log {define('WP_DEBUG_LOG',true);}
                            </label>
                            </div>
                            <div>
                            <label for="display_error">
                                <input name="display_error" type="checkbox" id="display_error" value="1" <?php if (defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY == true) { ?>checked="checked"<?php } ?>>
                                <?php _e('Enable Display Errors at on all website','debug');?> {define('WP_DEBUG_DISPLAY',true);}
                            </label>
                            </div>
                            <div class="noemailnotification">
                            <label for="error_script">
                                <input name="error_script" type="checkbox" id="error_script" value="1" <?php if (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG == true) { ?>checked="checked"<?php } ?>>
                                <?php _e('Enable Script Debug','debug');?> {define('SCRIPT_DEBUG',true);}
                            </label>
                            </div>
                            <div class="noemailnotification">
                            <label for="error_savequery">
                                <input name="error_savequery" type="checkbox" id="error_savequery" value="1" <?php if (defined('SAVEQUERIES') && SAVEQUERIES == true) { ?>checked="checked"<?php } ?>>
                                <?php _e('Enable Save Queries','debug');?> {define('SAVEQUERIES',true);}
                            </label>
                            </div>
                            <p class="description">
                                <?php _e('(These settings will overwrite wp-config.php file. Please make sure to backup first.)','debug');?>
                            </p>
                        </fieldset>
                        <p class="submit">
                            <input type="submit" name="debugsetting" id="submit" class="button button-primary" value="<?php _e('Save Changes','debug');?>">
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        
    </form>
    <?php echo debug_footer_link();
    ?>
</div>
