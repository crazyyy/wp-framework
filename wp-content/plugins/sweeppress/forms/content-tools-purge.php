<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="d4p-content">
	<div class="d4p-group d4p-group-information">
		<h3><?php esc_html_e( "Important", "sweeppress" ); ?></h3>
		<div class="d4p-group-inner">
			<?php esc_html_e( "These tools will remove all the data cached by the plugin. Right now that includes estimated sweeping results for every sweeper. These results are cached for 2 hours only, and have auto purge implemented, but you can always run this purge manually, if you are doing some tests or making changes to the database that can impact results change.", "sweeppress" ); ?>
		</div>
	</div>
</div>
