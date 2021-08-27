<?php
// Widget

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

echo htmlspecialchars("<?php
// Define widget ID
// Replace NULL with ID of widget to be queried eg 'pages-2' or \$args['widget_id']
\$widget_id = NULL;

// Define prefixed widget ID
\$widget_acf_prefix = 'widget_';
\$widget_id_prefixed = \$widget_acf_prefix . \$widget_id;
?>");