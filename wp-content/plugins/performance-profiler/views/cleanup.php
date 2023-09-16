<div class = "postbox">
    <div class = "inside">

        <h3>Cleanup database</h3>

        <p>
            Cleaning up the database means deleting all resouce usage data collected by the plugin and starting from scratch. This will free space from your database, but will lose all plugin statistics.
        </p>
        <p>
            <a href = "options-general.php?page=<?php echo $plugin->get_slug(); ?>&view=cleanup&action=cleanup&_wpnonce=<?php echo wp_create_nonce( $plugin->get_slug() . 'cleanup' ); ?>" class="button button-primary">
                Cleanup database
            </a>
        </p>

    </div> <!-- .inside -->
</div> <!-- .postbox -->

<?php $db = Nevma_Performance_Profiler_Plugin_DB::get_instance(); ?>

<div class = "postbox">
    <div class = "inside">
        <h3>Database size</h3>

        <p>
            Total number of requests logged in the database: <?php echo $db->get_record_count(); ?> <br />
            Total size of log database (table and indexes): <?php echo $db->get_table_size(); ?>
        </p>

    </div> <!-- .inside -->
</div> <!-- .postbox -->