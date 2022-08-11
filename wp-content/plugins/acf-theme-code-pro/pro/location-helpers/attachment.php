<?php
// Attachment

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$comment_1 = sprintf(
    /* translators: %s: ID */
    __( 'Define attachment %s', 'acf-theme-code' ),
    'ID'
);
$comment_2 = sprintf(
    /* translators: 1: NULL 2: ID */
    __( 'Replace %1$s with %2$s of attachment to be queried', 'acf-theme-code' ),
    'NULL',
    'ID'
);
$comment_3 = sprintf(
    /* translators: 1: ID 2: attachment.php */
    __( 'Example: Get attachment %1$s (for use in %2$s)', 'acf-theme-code' ),
    'ID',
    'attachment.php'
);

echo htmlspecialchars("<?php
// {$comment_1}
// {$comment_2}
\$attachment_id = NULL;

// {$comment_3}
// \$attachment_id = \$post->ID;
?>");