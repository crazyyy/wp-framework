<?php
/* 
 * Plugins Garbage Collector main form
 * 
 */

if ( !defined( 'PGC_PLUGIN_URL' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;  // Silence is golden, direct call is prohibited
}

pgc_show_message($mess);

?>
<div class="wrap">
    <div class="icon32" id="icon-options-general"><br/></div>
    <h2><?php echo PGC_PLUGIN_NAME .'  (Plugins Garbage Collector)'; ?></h2>
    <form method="post" action="tools.php?page=plugins-garbage-collector.php" onsubmit="return pgc_onsubmit();">
<?php
    settings_fields( 'pgc_options' );
?>
        <div id="poststuff" class="metabox-holder">					
            <div class="has-sidebar" >
                <div id="post-body-content" class="has-sidebar-content">
                    <div class="postbox" style="float: left; width: 100%;">
                        <div class="inside">
                            <div class="submit" style="padding-top: 10px; text-align:center;">
                                <div class="pgc_lm30">
                                  <input type="radio" name="search_criteria[]" id="search_nonewp_tables" checked="checked" value="1" title="<?php esc_html_e('Search DB for tables created by plugins', 'plugins-garbage-collector'); ?>"/>
                                  <label for="search_nonewp_tables"><?php esc_html_e('Search none-WP tables', 'plugins-garbage-collector'); ?></label>
                                </div>
                                <div class="pgc_lm30">
                                  <input type="radio" name="search_criteria[]" id="search_wptables_structure_changes" value="2" title="<?php esc_html_e('Search DB for changes which plugins made to the original WP tables structure', 'plugins-garbage-collector'); ?>"/>
                                  <label for="search_wptables_structure_changes"><?php esc_html_e('Search WP tables structure changes (beta - experimental)', 'plugins-garbage-collector'); ?></label>
                                </div>
                                <div class="pgc_lm30">
                                  <input type="checkbox" name="show_hidden_tables" id="show_hidden_tables" title="<?php esc_html_e('Include tables which are hidden by your request to the search results', 'plugins-garbage-collector'); ?>"/>
                                  <label for="show_hidden_tables"><?php esc_html_e('Show hidden tables', 'plugins-garbage-collector'); ?></label>
                                </div>
                                <div style="float: left; display: inline; margin: -5px 0 10px 0;">
                                  <input type="button" class="button button-priamry" name="scan_db" value="<?php esc_html_e('Scan Database', 'plugins-garbage-collector'); ?>" title="<?php esc_html_e('Click this button to gather information how plugins use your WordPress database', 'plugins-garbage-collector'); ?>" onclick="pgc_actions('scan');"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="progressbar"><div id="progress_label">Starting...</div></div>      
                    <div id="statusbar"></div>
                    <div id="scanresults"></div>
                </div>
            </div>
        </div>
    </form>
</div>  <!-- wrap -->
