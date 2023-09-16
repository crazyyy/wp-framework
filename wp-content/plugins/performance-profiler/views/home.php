<div class = "postbox">
    <div class = "inside">

        <form method = "post" action = "options.php">

            <h3>Plugin settings</h3>

            <?php 
                // Print plugin settings form.

                // settings_fields( $plugin->get_slug() ); 
                // do_settings_sections( $plugin->get_slug() ); 
                // submit_button( 'Save plugin settings' ); 
            ?>

            <p>
                Plugin is enabled and monitoring.
            </p>

            <?php // Override default referer because it might contain other GET data on it. ?>

            <input type = "hidden" name = "_wp_http_referer" value = "options-general.php?page=performance-profiler" />

        </form>

    </div> <!-- .inside -->
</div> <!-- .postbox -->