<?php
// Widget

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$comment_1 = sprintf(
    /* translators: %s: ID */
    __( 'Define widget  %s', 'acf-theme-code' ),
    'ID'
);
$comment_2 = sprintf(
    /* translators: 1: NULL 2: ID 3: 'pages-2' 4: $args['widget_id'] */
    __( 'Replace %1$s with %2$s of widget to be queried eg %3$s or %4$s', 'acf-theme-code' ),
    'NULL',
    'ID',
    "'pages-2'",
    "\$args['widget_id']"
);
$comment_3 = sprintf(
    /* translators: %s: ID */
    __( 'Define prefixed widget %s', 'acf-theme-code' ),
    'ID'
);

echo htmlspecialchars("<?php
// {$comment_1}
// {$comment_2}
\$widget_id = NULL;

// {$comment_3}
\$widget_acf_prefix = 'widget_';
\$widget_id_prefixed = \$widget_acf_prefix . \$widget_id;
?>");