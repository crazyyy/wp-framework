<?php echo <<<HEREDOC
// Add Quicktags
function {{function_name}}() {

	if ( wp_script_is( 'quicktags' ) ) {
	?>
	<script type="text/javascript">

HEREDOC;
if ( ! empty ( $wpg_id1 ) ) { ?>
	QTags.addButton( '{{id1}}', '{{display1}}', '{{arg11}}', '{{arg21}}', '{{access_key1}}', '{{title1}}', {{priority1}}, '{{instance1}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_id2 ) ) { ?>
	QTags.addButton( '{{id2}}', '{{display2}}', '{{arg12}}', '{{arg22}}', '{{access_key2}}', '{{title2}}', {{priority2}}, '{{instance2}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_id3 ) ) { ?>
	QTags.addButton( '{{id3}}', '{{display3}}', '{{arg13}}', '{{arg23}}', '{{access_key3}}', '{{title3}}', {{priority3}}, '{{instance3}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_id4 ) ) { ?>
	QTags.addButton( '{{id4}}', '{{display4}}', '{{arg14}}', '{{arg24}}', '{{access_key4}}', '{{title4}}', {{priority4}}, '{{instance4}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_id5 ) ) { ?>
	QTags.addButton( '{{id5}}', '{{display5}}', '{{arg15}}', '{{arg25}}', '{{access_key5}}', '{{title5}}', {{priority5}}, '{{instance5}}' );
<?php } ?>
<?php echo <<<HEREDOC
	</script>
	<?php
	}

}
add_action( 'admin_print_footer_scripts', '{{function_name}}' );
HEREDOC;
