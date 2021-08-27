<?php
// Taxonomy 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$taxonomy = $location_rule['value'];

if ( empty( $taxonomy ) || $taxonomy == 'all' ) {
    $taxonomy = 'term';
}

echo htmlspecialchars("<?php
// Define taxonomy prefix eg. 'category'
// Use 'term' for all taxonomies
\$taxonomy_prefix = '" . $taxonomy . "';

// Define term ID
// Replace NULL with ID of term to be queried eg '123' 
\$term_id = NULL;

// Example: Get the term ID in a term archive template 
// \$term_id = get_queried_object_id();

// Define prefixed term ID
\$term_id_prefixed = \$taxonomy_prefix .'_'. \$term_id;
?>");
