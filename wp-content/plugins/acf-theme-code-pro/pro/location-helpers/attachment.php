<?php
// Attachment

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

echo htmlspecialchars("<?php
// Define attachment ID
// Replace NULL with ID of attachment to be queried
\$attachment_id = NULL;

// Example: Get attachment ID (for use in attachment.php)
// \$attachment_id = \$post->ID;
?>");