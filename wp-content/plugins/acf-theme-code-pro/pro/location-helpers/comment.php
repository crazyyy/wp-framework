<?php
// Comment

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$comment_1 = sprintf(
    /* translators: %s: ID */
    __( 'Define comment %s', 'acf-theme-code' ),
    'ID'
);
$comment_2 = sprintf(
    /* translators: 1: NULL 2: ID */
    __( 'Replace %1$s with %2$s of comment to be queried', 'acf-theme-code' ),
    'NULL',
    'ID'
);
$comment_3 = sprintf(
    /* translators: %s: ID */
    __( 'Define prefixed comment %s', 'acf-theme-code' ),
    'ID'
);

echo htmlspecialchars("<?php
// {$comment_1}
// {$comment_2}
\$comment_id = NULL;

// {$comment_3}
\$comment_acf_prefix = 'comment_';
\$comment_id_prefixed = \$comment_acf_prefix . \$comment_id;
?>");