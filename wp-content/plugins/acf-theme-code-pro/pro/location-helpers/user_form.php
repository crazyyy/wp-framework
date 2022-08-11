<?php
// User Form

/*
 * This file is also included in these location helper partials:
 * current_user.php
 * current_user-role.php
 * user-role.php
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$comment_1 = sprintf(
    /* translators: %s: ID */
    __( 'Define user %s', 'acf-theme-code' ),
    'ID'
);
$comment_2 = sprintf(
    /* translators: 1: NULL 2: ID */
    __( 'Replace %1$s with %2$s of user to be queried', 'acf-theme-code' ),
    'NULL',
    'ID'
);
$comment_3 = sprintf(
    /* translators: %s: ID */
    __( 'Example: Get %s of current user', 'acf-theme-code' ),
    'ID'
);
$comment_4 = sprintf(
    /* translators: %s: ID */
    __( 'Define prefixed user %s', 'acf-theme-code' ),
    'ID'
);

echo htmlspecialchars("<?php
// {$comment_1}
// {$comment_2}
\$user_id = NULL;

// {$comment_3}
// \$user_id = get_current_user_id();

// {$comment_4}
\$user_acf_prefix = 'user_';
\$user_id_prefixed = \$user_acf_prefix . \$user_id;
?>");