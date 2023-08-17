<?php

use Dev4Press\v42\Core\Options\Render;
use function Dev4Press\v42\Functions\panel;

?>

<div class="d4p-content">
	<?php

	panel()->settings_fields();

	$class   = panel()->settings_class;
	$options = $class::instance();

	foreach ( panel()->subpanels() as $subpanel => $obj ) {
		if ( $subpanel == 'index' || $subpanel == 'full' ) {
			continue;
		}

		if ( isset( $obj[ 'break' ] ) ) {
			echo panel()->r()->settings_break( $obj[ 'break' ], $obj[ 'break-icon' ] );
		}

		echo panel()->r()->settings_group_break( $obj[ 'title' ], $obj[ 'icon' ] );

		$groups = $options->get( $subpanel );

		Render::instance( panel()->a()->n(), panel()->a()->plugin_prefix )->prepare( $subpanel, $groups )->render();
	}

	?>

	<?php panel()->include_accessibility_control(); ?>
</div>