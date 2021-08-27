<?php
// Comment

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

echo htmlspecialchars("<?php
// Define comment ID
// Replace NULL with ID of comment to be queried
\$comment_id = NULL;

// Define prefixed comment ID
\$comment_acf_prefix = 'comment_';
\$comment_id_prefixed = \$comment_acf_prefix . \$comment_id;
?>");