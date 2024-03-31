<?php
/* Template Name: Maintenance Mode */

include 'header-maintenance.php';

// Handle form submission
// if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_query']) && wp_verify_nonce($_POST['_wpnonce'], 'maintenance_query_nonce') ) { .
if ( isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_query']) && isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'maintenance_query_nonce') ) {

	// $user_email = sanitize_email($_POST['user_email']);  .
	// $user_message = sanitize_text_field($_POST['user_message']);  .

	$user_email = isset($_POST['user_email']) ? sanitize_email(wp_unslash($_POST['user_email'])) : '';
    $user_message = isset($_POST['user_message']) ? sanitize_text_field(wp_unslash($_POST['user_message'])) : '';
    

	// Additional validation if needed
	if ( empty($user_email) || ! is_email($user_email) || empty($user_message) ) {
		// Handle validation errors
		wp_die('Invalid input. Please check your information and try again.');
	}

	// Get existing queries
	$existing_queries = get_option('maintenance_mode_queries', array());

	// Add or update the user's query
	$existing_queries[ $user_email ] = $user_message;

	// Update the option in the database
	update_option('maintenance_mode_queries', $existing_queries);

	// Display success message
	echo '<script>alert("Form submitted successfully!");</script>';
}
?>

<style>
	body {
		display: flex;
		align-items: center;
		justify-content: center;
		height: 100vh;
		margin: 0;
		font-family: Arial, sans-serif;
	}

	#maintenance-mode-container {
		text-align: center;
	}

	h1 {
		font-size: 2em;
		color: #333;
	}

	p {
		font-size: 1.2em;
		color: #666;
	}

	form {
		margin-top: 20px;
		max-width: 400px;
		margin-left: auto;
		margin-right: auto;
	}

	label {
		display: block;
		margin-bottom: 5px;
		font-weight: bold;
		text-align: left;
		color: #666;
	}

	input[type="email"],
	textarea {
		width: 100%;
		padding: 8px;
		margin-bottom: 10px;
		box-sizing: border-box;
	}

	input[type="submit"] {
		background-color: #4caf50;
		color: white;
		padding: 10px;
		border: none;
		cursor: pointer;
	}

	input[type="submit"]:hover {
		background-color: #45a049;
	}
</style>

<div id="maintenance-mode-container">
	<h1>Site is Under Maintenance</h1>
	<p>We are currently performing maintenance on our website. Please check back shortly.</p>

	<!-- <h4>Have urgent Query? Submit the form</h4> -->

	<form method="post">
	   <!--  <?php wp_nonce_field('maintenance_query_nonce', '_wpnonce'); ?>
		<label for="user_email">Your Email:</label>
		<input type="email" name="user_email" required>
		<label for="user_message">Your Message:</label>
		<textarea name="user_message" rows="4" required></textarea>
		<input type="submit" name="submit_query" value="Submit Query"> -->
	</form>
</div>

<?php
// Include the WordPress footer
wp_footer();
?>
