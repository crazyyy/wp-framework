<div class = "postbox">
    <div class = "inside">

        <h3>General resource usage information</h3>

        <p>
            Maximum and average values of recorded resource usage for the period in which the plugin is enabled.
        </p>

        <?php $db = Nevma_Performance_Profiler_Plugin_DB::get_instance(); ?>

        <table class = "wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th></th>
                    <th>
                        Theme <br/ > <small>(frontend requests)</small>
                    </th>
                    <th>
                        <br/ > <small>(of which AJAX)</small>
                    </th>
                    <th>
                        Admin <br/ > <small>(backend requests)</small>
                    </th>
                    <th>
                        <br/ > <small>(of which AJAX)</small>
                    </th>
                    <th>
                        Cron <br/ > <small>(wp cron requests)</small>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Total requests</th>
                    <td>
                        <?php echo $db->get_count_by_type( 'theme' ); ?>
                    </td>
                    <td>
                        <small><?php echo $db->get_count_by_type( 'theme', TRUE ) ?: '-'; ?></small>
                    </td>
                    <td>
                        <?php echo $db->get_count_by_type( 'admin' ); ?>
                    </td>
                    <td>
                        <?php echo $db->get_count_by_type( 'admin', TRUE ) ?: '-'; ?>
                    </td>
                    <td>
                        <?php echo $db->get_count_by_type( 'cron' ); ?>
                    </td>
                </tr>
                <tr>
                    <th>Max request duration</th>
                    <td>
                        <?php $value = $db->get_max_resource_by_type( 'duration', 'theme' ); ?>
                        <?php echo $value ? $value . 'ms' : '-' ; ?>
                    </td>
                    <td>
                        <?php $value = $db->get_max_resource_by_type( 'duration', 'theme', TRUE ); ?>
                        <?php echo $value ? $value . 'ms' : '-' ; ?>
                    </td>
                    <td>
                        <?php $value = $db->get_max_resource_by_type( 'duration', 'admin' ); ?>
                        <?php echo $value ? $value . 'ms' : '-' ; ?>
                    </td>
                    <td>
                        <?php $value = $db->get_max_resource_by_type( 'duration', 'admin', TRUE ); ?>
                        <?php echo $value ? $value . 'ms' : '-' ; ?>
                    </td>
                    <td>
                        <?php $value = $db->get_max_resource_by_type( 'duration', 'cron' ); ?>
                        <?php echo $value ? $value . 'ms' : '-' ; ?>
                    </td>
                </tr>
                <tr>
                    <th>Max request RAM</th>
                    <td>
                        <?php $value = $db->get_max_resource_by_type( 'RAM', 'theme' ); ?>
                        <?php echo $value ? $value . 'mb' : '-'; ?>
                    </td>
                    <td>
                        <small>
                            <?php $value = $db->get_max_resource_by_type( 'RAM', 'theme', TRUE ); ?>
                            <?php echo $value ? $value . 'mb' : '-'; ?>
                        </small>
                    </td>
                    <td>
                        <?php $value = $db->get_max_resource_by_type( 'RAM', 'admin' ); ?>
                        <?php echo $value ? $value . 'mb' : '-'; ?>
                    </td>
                    <td>
                        <small>
                            <?php $value = $db->get_max_resource_by_type( 'RAM', 'admin', TRUE ); ?>
                            <?php echo $value ? $value . 'mb' : '-'; ?>
                        </small>
                    </td>
                    <td>
                        <?php $value = $db->get_max_resource_by_type( 'RAM', 'cron' ); ?>
                        <?php echo $value ? $value . 'mb' : '-'; ?>
                    </td>
                </tr>
                <tr>
                    <th>Max request queries</th>
                    <td>
                        <?php $value = $db->get_max_resource_by_type( 'queries', 'theme' ); ?>
                        <?php echo $value ? $value : '-' ; ?>
                    </td>
                    <td>
                        <small>
                            <?php $value = $db->get_max_resource_by_type( 'queries', 'theme', TRUE ); ?>
                            <?php echo $value ? $value : '-' ; ?>
                        </small>
                    </td>
                    <td>
                        <?php $value = $db->get_max_resource_by_type( 'queries', 'admin' ); ?>
                        <?php echo $value ? $value : '-' ; ?>
                    </td>
                    <td>
                        <small>
                            <?php $value = $db->get_max_resource_by_type( 'queries', 'admin', TRUE ); ?>
                            <?php echo $value ? $value : '-' ; ?>
                        </small>
                    </td>
                    <td>
                        <?php $value = $db->get_max_resource_by_type( 'queries', 'cron' ); ?>
                        <?php echo $value ? $value : '-' ; ?>
                    </td>
                </tr>
                <tr>
                    <th>Avg request duration</th>
                    <td>
                        <?php $value = $db->get_average_resource_by_type( 'duration', 'theme' ); ?>
                        <?php echo $value ? $value . 'ms'  : '-'; ?>
                    </td>
                    <td>
                        <small>
                            <?php $value = $db->get_average_resource_by_type( 'duration', 'theme', TRUE ); ?>
                            <?php echo $value ? $value . 'ms'  : '-'; ?>
                        </small>
                    </td>
                    <td>
                        <?php $value = $db->get_average_resource_by_type( 'duration', 'admin' ); ?>
                        <?php echo $value ? $value . 'ms'  : '-'; ?>
                    </td>
                    <td>
                        <small>
                            <?php $value = $db->get_average_resource_by_type( 'duration', 'admin', TRUE ); ?>
                            <?php echo $value ? $value . 'ms'  : '-'; ?>
                        </small>
                    </td>
                    <td>
                        <?php $value = $db->get_average_resource_by_type( 'duration', 'cron' ); ?>
                        <?php echo $value ? $value . 'ms'  : '-'; ?>
                    </td>
                </tr>
                <tr>
                    <th>Avg request RAM</th>
                    <td>
                        <?php $value = $db->get_average_resource_by_type( 'RAM', 'theme' ); ?>
                        <?php echo $value ? $value . 'mb' : '-'; ?>
                    </td>
                    <td>
                        <small>
                            <?php $value = $db->get_average_resource_by_type( 'RAM', 'theme', TRUE ); ?>
                            <?php echo $value ? $value . 'mb' : '-'; ?>
                        </small>
                    </td>
                    <td>
                        <?php $value = $db->get_average_resource_by_type( 'RAM', 'admin' ); ?>
                        <?php echo $value ? $value . 'mb' : '-'; ?>
                    </td>
                    <td>
                        <small>
                            <?php $value = $db->get_average_resource_by_type( 'RAM', 'admin', TRUE ); ?>
                            <?php echo $value ? $value . 'mb' : '-'; ?>
                        </small>
                    </td>
                    <td>
                        <?php $value = $db->get_average_resource_by_type( 'RAM', 'cron' ); ?>
                        <?php echo $value ? $value . 'mb' : '-'; ?>
                    </td>
                </tr>
                <tr>
                    <th>Avg request queries</th>
                    <td>
                        <?php echo $db->get_average_resource_by_type( 'queries', 'theme' ); ?>
                    </td>
                    <td>
                        <small>
                            <?php echo $db->get_average_resource_by_type( 'queries', 'theme', TRUE ) ?: '-'; ?>
                        </small>
                    </td>
                    <td>
                        <?php echo $db->get_average_resource_by_type( 'queries', 'admin' ); ?>
                    </td>
                    <td>
                        <small>
                            <?php echo $db->get_average_resource_by_type( 'queries', 'admin', TRUE ) ?: '-'; ?>
                        </small>
                    </td>
                    <td>
                        <?php $value = $db->get_average_resource_by_type( 'queries', 'cron' ); ?>
                        <?php echo $value ? $value : '-' ; ?>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan = "6" class = "text-right">
                        <?php $window = $db->get_time_window(); ?>
                        <small>Period: <?php echo $window['min'] ?> &mdash; <?php echo $window['max'] ?></small>
                    </td>
                </tr>
            </tfoot>
        </table>

    </div> <!-- .inside -->
</div> <!-- .postbox -->