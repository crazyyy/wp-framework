<?php
    if(!defined('ABSPATH')){
        exit();
    }
    
    require_once( ABSPATH . PLUGINDIR . '/wp-reroute-email/includes/db_log_list.class.php' );

    $table = new DBLogList();
    $logId = filter_input(INPUT_GET, 'logid', FILTER_VALIDATE_INT);

    if($tab == 'details' && !empty($logId)){
        $item = $table->get_item($logId);

        if($item){
?>
    <div class="message_details">
        <table class="message-table">
            <tr>
                <th><?php esc_html_e('Sent On', 'wp-reroute-email'); ?>:</th>
                <td><?php esc_html_e(get_date_from_gmt( $item->sent_on, 'j F, Y H:i:s' )); ?></td>
            </tr>
            <tr>
                <th><?php esc_html_e('To', 'wp-reroute-email'); ?>:</th>
                <td><?php esc_html_e($item->recipients_to); ?></td>
            </tr>
            <tr>
                <th><?php esc_html_e('CC', 'wp-reroute-email'); ?>:</th>
                <td><?php esc_html_e($item->recipients_cc); ?></td>
            </tr>
            <tr>
                <th><?php esc_html_e('BCC', 'wp-reroute-email'); ?>:</th>
                <td><?php esc_html_e($item->recipients_bcc); ?></td>
            </tr>
            <tr>
                <th><?php esc_html_e('Subject', 'wp-reroute-email'); ?>:</th>
                <td><?php esc_html_e($item->subject); ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><a href="javascript:;" id="view-original" class="orgview"><?php esc_html_e('View Original Message', 'wp-reroute-email');?></a></td>
            </tr>
            <tr>
                <td colspan="2" class="message_body">
                    <div id="processed-message">
                    <?php
                        $is_only_html = preg_match("/<[^<]+>/",  $item->message, $m) != 0;
                        echo $is_only_html ? wp_kses_post($item->message) : wp_kses_post(nl2br($item->message));
                    ?>
                    </div>   
                    <pre id="original-message"><?php echo htmlentities($item->message); ?></pre>
                </td>
            </tr>
        </table>
    </div>
<?php
        }
    }
    else{
?>
    <form action="" method="POST">
<?php
        $table->prepare_items();
        $table->display();
?>
    </form>
<?php
    }
?>