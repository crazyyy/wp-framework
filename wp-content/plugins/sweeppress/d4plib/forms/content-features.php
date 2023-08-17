<?php

use Dev4Press\v42\Core\Options\Render;
use function Dev4Press\v42\Functions\panel;

?>

<div class="d4p-content">
	<?php

	panel()->settings_fields();

	$subpanel = panel()->a()->subpanel;
	$class    = panel()->settings_class;
	$options  = $class::instance( $subpanel );
	$groups   = $options->get();

	Render::instance( panel()->a()->n(), panel()->a()->plugin_prefix )->prepare( $subpanel, $groups )->render();

	?>

	<?php panel()->include_accessibility_control(); ?>
</div>