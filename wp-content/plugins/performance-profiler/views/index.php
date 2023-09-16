 <div class = "wrap">

    <?php
        $plugin = Nevma_Performance_Profiler_Plugin::get_instance();

        $view = 'home';

        if ( isset( $_GET['view'] ) ) {

            $view = trim( $_GET['view'] );

        }
    ?>

    <h2>
        <?php echo $plugin->get_title(); ?>
    </h2>

    <ul class = "subsubsub">
        <li><a class = "<?php echo $view == 'home'       ? 'nppp-selected' : '' ?>" href = "options-general.php?page=<?php echo $plugin->get_slug(); ?>&view=home">Home page</a> &bull; </li>
        <li><a class = "<?php echo $view == 'statistics' ? 'nppp-selected' : '' ?>" href = "options-general.php?page=<?php echo $plugin->get_slug(); ?>&view=statistics">Performance statistics</a> &bull; </li>
        <li><a class = "<?php echo $view == 'cleanup'    ? 'nppp-selected' : '' ?>" href = "options-general.php?page=<?php echo $plugin->get_slug(); ?>&view=cleanup">Cleanup database</a> &bull; </li>
        <li><a class = "<?php echo $view == 'info'       ? 'nppp-selected' : '' ?>" href = "options-general.php?page=<?php echo $plugin->get_slug(); ?>&view=info">Information</a></li>
    </ul>

    <div id = "poststuff">

        <div id = "post-body" class = "metabox-holder columns-2">

            <?php include "sidebar.php"; ?>

            <div id = "post-body-content" style = "position: relative;">

                <?php 
                    if ( $view == 'home' ) {
                        
                        include "home.php";

                    } else if ( $view == 'statistics' ) {

                        include "statistics.php";

                    } else if ( $view == 'cleanup' ) {

                        include "cleanup.php";

                    } else if ( $view == 'info' ) {

                        include "info.php";

                    }
                ?>

                <?php include "footer.php"; ?>

            </div> <!-- #post-body-content -->
                            
        </div> <!-- post-body -->

    </div> <!-- #poststuff -->

</div> <!-- .wrap -->