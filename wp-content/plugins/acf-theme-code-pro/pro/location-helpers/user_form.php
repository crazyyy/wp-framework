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

echo htmlspecialchars("<?php
// Define user ID
// Replace NULL with ID of user to be queried
\$user_id = NULL;

// Example: Get ID of current user
// \$user_id = get_current_user_id();

// Define prefixed user ID
\$user_acf_prefix = 'user_';
\$user_id_prefixed = \$user_acf_prefix . \$user_id;
?>");