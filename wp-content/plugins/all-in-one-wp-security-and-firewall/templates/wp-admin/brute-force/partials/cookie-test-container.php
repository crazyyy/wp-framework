<div class="aio_yellow_box">
	<p>
		<?php
		_e('Before using this feature, you must perform a cookie test first.', 'all-in-one-wp-security-and-firewall');
		echo ' ';
		echo htmlspecialchars(__("This ensures that your browser cookie is working correctly and that you won't lock yourself out.", 'all-in-one-wp-security-and-firewall'));
		?>
	</p>
</div>
<?php
submit_button(__('Perform cookie test', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowps_do_cookie_test_for_bfla', true, array('id' => 'aios-perform-cookie-test'));
