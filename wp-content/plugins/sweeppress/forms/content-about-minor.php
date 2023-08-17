<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use function Dev4Press\v42\Functions\panel;

?>
<div class="d4p-about-minor">
    <h3><?php esc_html_e( "Maintenance and Security Releases", "sweeppress" ); ?></h3>
    <p>
        <strong><?php esc_html_e( "Version", "sweeppress" ); ?> <span>2.3</span></strong> &minus;
        Performance related changes.
    </p>
    <p>
        <strong><?php esc_html_e( "Version", "sweeppress" ); ?> <span>2.2</span></strong> &minus;
        New sweepers. Updated Dev4Press Library.
    </p>
    <p>
        <strong><?php esc_html_e( "Version", "sweeppress" ); ?> <span>2.1.1</span></strong> &minus;
        Few updates and fixes.
    </p>
    <p>
        <strong><?php esc_html_e( "Version", "sweeppress" ); ?> <span>2.1</span></strong> &minus;
        New sweepers. Various updates and improvements.
    </p>
    <p>
        <strong><?php esc_html_e( "Version", "sweeppress" ); ?> <span>2.0</span></strong> &minus;
        New sweeper. Various updates. WP-CLI and REST API updates and fixes.
    </p>
    <p>
        <strong><?php esc_html_e( "Version", "sweeppress" ); ?> <span>1.8</span></strong> &minus;
        Few updates and fixes.
    </p>
    <p>
        <strong><?php esc_html_e( "Version", "sweeppress" ); ?> <span>1.7</span></strong> &minus;
        Few updates and changes.
    </p>
    <p>
        <strong><?php esc_html_e( "Version", "sweeppress" ); ?> <span>1.6</span></strong> &minus;
        Few database optimization updates and other changes.
    </p>
    <p>
        <strong><?php esc_html_e( "Version", "sweeppress" ); ?> <span>1.5</span></strong> &minus;
        Various fixes and updates.
    </p>
    <p>
        <strong><?php esc_html_e( "Version", "sweeppress" ); ?> <span>1.4.1</span></strong> &minus;
        Missing sweepers.
    </p>
    <p>
        <strong><?php esc_html_e( "Version", "sweeppress" ); ?> <span>1.4</span></strong> &minus;
        Various improvements.
    </p>
    <p>
        <strong><?php esc_html_e( "Version", "sweeppress" ); ?> <span>1.3</span></strong> &minus;
        List of all Sweepers panel. Various improvements.
    </p>
    <p>
        <strong><?php esc_html_e( "Version", "sweeppress" ); ?> <span>1.2</span></strong> &minus;
        Various enhancements and improvements.
    </p>
    <p>
        <strong><?php esc_html_e( "Version", "sweeppress" ); ?> <span>1.1</span></strong> &minus;
        Akismet Meta removal sweeper.
    </p>
    <p>
		<?php printf( __( "For more information, see <a href='%s'>the changelog</a>.", "sweeppress" ), panel()->a()->panel_url( 'about', 'changelog' ) ); ?>
    </p>
</div>