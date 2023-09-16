function {{function_name}}( {{args_list}} ) {
	{{hook_code}}
}
<?php if ( empty ( $wpg_hook_type ) || 'add_filter' === $wpg_hook_type ) { ?>
add_filter( '{{filter_name}}'<?php } else { ?>
add_action( '{{hook_name}}'<?php }
?>, '{{function_name}}'<?php
	if ( '' !== $wpg_priority ) { ?>, {{priority}}<?php } ?><?php
	if ( '' !== $wpg_accepted_args ) { ?><?php
		if ( '' === $wpg_priority ) { ?>, 10<?php }
	?>, {{accepted_args}}<?php } ?> );