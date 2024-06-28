<?php
// Taxonomy 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$comment_1 = sprintf(
    /* translators: %s: 'category' */
    __( 'Define taxonomy prefix eg %s', 'acf-theme-code' ),
    'category'
);
$comment_2 = sprintf(
    /* translators: %s: 'term' */
    __( 'Use %s for all taxonomies', 'acf-theme-code' ),
    'term'
);
$comment_3 = sprintf(
    /* translators: %s: ID */
    __( 'Define term %s', 'acf-theme-code' ),
    'ID'
);
$comment_4 = sprintf(
    /* translators: 1: NULL 2: ID 3: '123' */
    __( 'Replace %1$s with %2$s of term to be queried eg %3$s', 'acf-theme-code' ),
    'NULL',
    'ID',
    "'123'"
);
$comment_5 = sprintf(
    /* translators: %s: ID */
    __( 'Example: Get the term %s in a term archive template', 'acf-theme-code' ),
    'ID'
);
$comment_6 = sprintf(
    /* translators: %s: ID */
    __( 'Define prefixed term %s', 'acf-theme-code' ),
    'ID'
);

$taxonomy = $location_rule['value'];

if ( empty( $taxonomy ) || $taxonomy == 'all' ) {
    $taxonomy = 'term';
}

echo htmlspecialchars("<?php
// {$comment_1}
// {$comment_2}
\$taxonomy_prefix = '" . $taxonomy . "';

// {$comment_3}
// {$comment_4}
\$term_id = NULL;

// {$comment_5}
// \$term_id = get_queried_object_id();

// {$comment_6}
\$term_id_prefixed = \$taxonomy_prefix .'_'. \$term_id;
?>");
