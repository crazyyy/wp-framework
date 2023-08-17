<?php

use Dev4Press\v42\API\Languages;
use function Dev4Press\v42\Functions\panel;

$plugin = panel()->a()->settings()->i();
$sysreq = $plugin->system_requirements();

$translations = panel()->a()->settings()->i()->translations;
$translations = Languages::instance()->plugin_translations( $translations );

?>

<div class="d4p-info-block">
    <h3>
		<?php esc_html_e( "Current Version", "d4plib" ); ?>
    </h3>
    <div>
        <ul class="d4p-info-list">
            <li>
                <span><?php esc_html_e( "Version", "d4plib" ); ?>:</span><strong><?php echo esc_html( $plugin->version ); ?></strong>
            </li>
            <li>
                <span><?php esc_html_e( "Build", "d4plib" ); ?>:</span><strong><?php echo esc_html( $plugin->build ); ?></strong>
            </li>
            <li>
                <span><?php esc_html_e( "Status", "d4plib" ); ?>:</span><strong><?php echo esc_html( ucfirst( $plugin->status ) ); ?></strong>
            </li>
            <li>
                <span><?php esc_html_e( "Edition", "d4plib" ); ?>:</span><strong><?php echo esc_html( ucfirst( $plugin->edition ) ); ?></strong>
            </li>
            <li>
                <span><?php esc_html_e( "Date", "d4plib" ); ?>:</span><strong><?php echo esc_html( $plugin->updated ); ?></strong>
            </li>
        </ul>
        <hr style="margin: 1em 0 .7em; border-top: 1px solid #eee"/>
        <ul class="d4p-info-list">
            <li>
                <span><?php esc_html_e( "First released", "d4plib" ); ?>:</span><strong><?php echo esc_html( $plugin->released ); ?></strong>
            </li>
        </ul>
    </div>
</div>

<div class="d4p-info-block">
    <h3>
		<?php esc_html_e( "System Requirements", "d4plib" ); ?>
    </h3>
    <div>
        <ul class="d4p-info-list">
			<?php

			foreach ( $sysreq as $name => $version ) {
				echo '<li><span>' . esc_html( $name ) . ':</span><strong>' . esc_html( $version ) . '</strong></li>';
			}

			?>
        </ul>
    </div>
</div>

<div class="d4p-info-block">
    <h3>
		<?php esc_html_e( "List of included Languages", "d4plib" ); ?>
    </h3>
    <div>
		<?php

		$translations = panel()->a()->settings()->i()->translations;
		$translations = Languages::instance()->plugin_translations( $translations );

		foreach ( $translations as $code => $obj ) {
			$_lang = $code . ': ' . $obj[ 'native' ] . ' / ' . $obj[ 'english' ];

			echo '<div class="d4p-block-language"><h4>' . esc_html( $_lang ) . '</h4>';
			echo '<p>' . esc_html__( "Plugin Version", "d4plib" ) . ': ' . esc_html( $obj[ 'version' ] ) . '</p>';

			if ( ! empty( $obj[ 'contributors' ] ) ) {
				$contributors = array();

				foreach ( $obj[ 'contributors' ] as $c ) {
					$contributors[] = '<a href="' . $c[ 'url' ] . '" target="_blank" rel="noopener">' . esc_html( $c[ 'name' ] ) . '</a>';
				}

				echo '<p>' . esc_html__( "Contributors", "d4plib" ) . ': ' . join( ', ', $contributors ) . '</p>';
			}

			echo '</div>';
		}

		?>
    </div>
</div>