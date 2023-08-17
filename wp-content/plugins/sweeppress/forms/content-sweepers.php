<?php

use Dev4Press\Plugin\SweepPress\Table\Sweepers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="d4p-content">
	<?php

	$_grid = new Sweepers();
	$_grid->prepare_items();
	$_grid->display();

	?>
</div>