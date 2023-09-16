<div class="wrap">
    <h1><?php _e('Samudra Log Settings', 'samudra_log') ?></h1>
    <hr>

    <h2><?php _e('Restrict direct access to log file', 'samudra_log') ?></h2>
    <p><?php printf(__('Your Wordpress site is running on <strong>%s</strong>.', 'samudra_log'), $webServerName) ?></p>

    <p><?php _e('If you are using Nginx, put this code inside your server block.', 'samudra_log') ?></p>

    <textarea class="large-text code" rows="5" readonly>
location ~ /wp-content/plugins/samudra-log/log/.*\.log$ {
    deny all;
    return 404;
}
    </textarea>

    <hr>

    <h2><?php _e('How to Use?', 'samudra_log') ?></h2>
    <p><?php _e('Use this function to write log.', 'samdra_log') ?></p>
    <code>
        // Variable value can be string, array, or object <br>
        $variable = 'Variable value'; <br><br>

        // Log file will be in /wp-content/plugins/samudra-log/log/sd_log.log<br>
        sd_log($variable);<br><br>

        // Log file will be in /wp-content/plugins/samudra-log/log/my-file.log<br>
        sd_log($variable, 'my-file');
    </code>
</div>
