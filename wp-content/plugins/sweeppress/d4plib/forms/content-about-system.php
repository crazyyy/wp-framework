<?php

use Dev4Press\v42\Library;
use Dev4Press\v42\WordPress;
use function Dev4Press\v42\Functions\panel;

?>
<div class="d4p-info-block">
    <h3>
		<?php esc_html_e( "System Information", "d4plib" ); ?>
    </h3>
    <div>
        <ul class="d4p-info-list">
            <li>
                <span><?php esc_html_e( "PHP Version", "d4plib" ); ?>:</span><strong><?php echo Library::instance()->php_version(); ?></strong>
            </li>
            <li>
                <span><?php echo sprintf( __( "%s Version", "d4plib" ), WordPress::instance()->cms_title() ); ?>:</span><strong><?php echo WordPress::instance()->version(); ?></strong>
            </li>
        </ul>
        <hr/>
        <ul class="d4p-info-list">
            <li>
                <span><?php esc_html_e( "Debug Mode", "d4plib" ); ?>:</span><strong><?php echo WordPress::instance()->is_debug() ? esc_html__( "ON", "d4plib" ) : esc_html__( "OFF", "d4plib" ); ?></strong>
            </li>
            <li>
                <span><?php esc_html_e( "Script Debug", "d4plib" ); ?>:</span><strong><?php echo WordPress::instance()->is_script_debug() ? esc_html__( "ON", "d4plib" ) : esc_html__( "OFF", "d4plib" ); ?></strong>
            </li>
        </ul>
    </div>
</div>

<div class="d4p-info-block">
    <h3>
		<?php esc_html_e( "Plugin Information", "d4plib" ); ?>
    </h3>
    <div>
        <ul class="d4p-info-list">
            <li>
                <span><?php esc_html_e( "Path", "d4plib" ); ?>:</span><strong><?php echo esc_html( panel()->a()->path ); ?></strong>
            </li>
            <li>
                <span><?php esc_html_e( "URL", "d4plib" ); ?>:</span><strong><?php echo esc_html( panel()->a()->url ); ?></strong>
            </li>
        </ul>
    </div>
</div>


<div class="d4p-info-block">
    <h3>
		<?php esc_html_e( "Shared Library", "d4plib" ); ?>
    </h3>
    <div>
        <ul class="d4p-info-list">
            <li>
                <span><?php esc_html_e( "Version", "d4plib" ); ?>:</span><strong><?php echo Library::instance()->version(); ?></strong>
            </li>
            <li>
                <span><?php esc_html_e( "Build", "d4plib" ); ?>:</span><strong><?php echo Library::instance()->build(); ?></strong>
            </li>
        </ul>
        <hr/>
        <ul class="d4p-info-list">
            <li>
                <span><?php esc_html_e( "Path", "d4plib" ); ?>:</span><strong><?php echo Library::instance()->path(); ?></strong>
            </li>
            <li>
                <span><?php esc_html_e( "URL", "d4plib" ); ?>:</span><strong><?php echo Library::instance()->url(); ?></strong>
            </li>
        </ul>
    </div>
</div>
