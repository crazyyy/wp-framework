<?php
/**
 * Displays review notice.
 *
 * @package SWPTLS
 */

// If direct access than exit the file.
defined( 'ABSPATH' ) || exit;

$rating = WP_NOTIFIER_TO_SLACK_DIR_URL . 'assets/top-banner/rat.png';
?>

<div class="wpnts-ratting-banner">
	<div class="banner-content" data-value="hide_notice">
		<span class="wpnts-ratting-open"></span>
		<div class="wpnts-influencer-image">
			<img class="wpnts-image-icon" src="<?php echo esc_url($rating); ?>" alt="">
		</div>
		<div class="wpnts-influencer-wrapper">
		<h3 class="rating-heading"><?php esc_html_e('Sounds like ', 'wpnts'); ?><span class="wpnts-plugin-title"><?php esc_html_e('WP Notifier To Slack', 'wpnts'); ?></span><?php esc_html_e(' is offering you benefit. 🥳', 'wpnts'); ?></h3>

			<p class="review-notice"><?php esc_html_e( "Hey there! You have been using WP Notifier To Slack for quite some time. Would you consider leaving us a 😍 5-star review? Your feedback will assist us in developing better features and spreading the word.", 'wpnts' ); ?></p>
			<div class="link-wrapper notice-actions">
				<h3><?php esc_attr_e( 'Kindly evaluate us:', 'wpnts' ); ?></h3>
				<div class="bottom-fields">
				<div class="rating-container">
					<span class="ratting-yellow-icon 1"></span>
					<span class="ratting-yellow-icon 2"></span>
					<span class="ratting-yellow-icon 3"></span>
					<span class="ratting-yellow-icon 4"></span>
					<span class="ratting-yellow-icon 5"></span>
				</div> 
				<a href="#" class="hide_notice already-did-hook" data-value="hide_notice"><?php esc_html_e('Already did it', 'wpnts'); ?></a>
				</div>
			</div>
		</div>
	</div>
	<!-- style="display: none;" -->
	<div id="popup1" class="ratting_popup-container" style="display: none;"> 
		<div class="ratting_popup-content">
			<a href="#" target="_blank" class="close ratting_close_button cross_to_close">&times;</a>
			<div class="ratting_first_section2">
				<div class="ratting_popup_wrap">
					<h4><?php esc_html_e('Would you like to be remind in the future?', 'wpnts'); ?></h4>
				</div>
				<div class="ratting_select-wrapper">
					<span class="remind-title"><?php esc_html_e('Remind Me After:', 'wpnts'); ?></span>
					<div class="custom-select">
						<span class="selected-option" data-value="7"><?php esc_html_e('7 Days', 'wpnts'); ?>
						</span>
						<ul class="options-list">
							<li data-value="7"><?php esc_html_e('7 Days', 'wpnts'); ?></li>
							<li data-value="14"><?php esc_html_e('14 Days', 'wpnts'); ?></li>
							<li class="remind-me-text" data-value="hide_notice"><?php esc_html_e('Remind me never', 'wpnts'); ?></li>
						</ul>
					</div>

					<div class="promo_close_btn_submit">
						<button class="ratting_custom-button ratting_submit_button2 promo_close_btn"><?php esc_html_e('Ok', 'wpnts'); ?></button>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>


<script>

jQuery(document).ready(function($) {
	/**
	 * Custom select
	 */
	$(document).ready(function() {

		function adjustButtonMargin() {
			var isOpen = $('.custom-select').hasClass('open');
			if (isOpen) {
				var isVisible = $('.options-list').is(':visible');
				if (isVisible) {
					$('.ratting_custom-button').css('margin-top', '185px');
				} else {
					$('.ratting_custom-button').css('margin-top', 'unset');
				}
			} else {
				$('.ratting_custom-button').css('margin-top', 'unset');
			}
		}

		$('.selected-option').click(function() {
			$('.options-list').toggle();
			$('.custom-select').toggleClass('open');
			adjustButtonMargin();
		});

		$('.options-list li').click(function() {
			var selectedValue = $(this).attr('data-value');

			// Update the data-value attribute of the selected-option span
			$('.selected-option').attr('data-value', selectedValue);
			// Update the text content of the selected-option span
			$('.selected-option').text($(this).text());
			$('.options-list').hide();
			$('.custom-select').removeClass('open');
			$('.ratting_custom-button').css('margin-top', 'unset');

		});

		// Close the dropdown when clicking outside of it
		$(document).click(function(event) {
			if (!$(event.target).closest('.custom-select').length) {
				$('.options-list').hide();
				$('.custom-select').removeClass('open');
				adjustButtonMargin();
			}
		});

		// Handle adjustment when the options-list is toggled
		$('.options-list').on('toggle', function() {
			adjustButtonMargin();
		});
	});


	// I already did button .
	$('.wpnts-ratting-banner .hide_notice').click(e => {
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: "<?php echo esc_url(admin_url( 'admin-ajax.php' )); ?>",
			data: {
				action: 'gswpts_notice_action',
				nonce: '<?php echo esc_attr( wp_create_nonce( 'notifier_notices_nonce' ) ); ?>',
				info: {
					type: 'hide_notice'
				},
				actionType: 'review_notice'
			},
			success: response => {
				if (response.data.response_type === 'success') {
					$('.wpnts-ratting-banner').slideUp();
				}
			}
		});
		
	})

	/* Open popup when click the X icon*/
	$('.wpnts-ratting-open').click(function(e) {
		// Prevent the event from reaching the document.
		e.stopPropagation(); 
		$('#popup1').show();
	});

	// Close the popup when clicking outside of ratting_popup-content.
	$(document).on('click', function(event) {
		if (!$(event.target).closest('.ratting_popup-content').length && !$(event.target).is('.cross_to_close')) {
			// Check if the click is outside the popup content and not on the close button
			$('#popup1').hide();
		}
	});

	// Close the popup when clicking on the close button.
	$('.cross_to_close').click(function(e) {
		e.preventDefault();
		$('#popup1').hide();
	});

	// When click in popup ok or X icon. 
	$('.ratting_popup-container .promo_close_btn').click(e => {
		e.preventDefault();
		// Get the selected option value from the dropdown.
		dataValue = $('.selected-option').attr('data-value');

		// Perform AJAX request.
		$.ajax({
			type: "POST",
			url: "<?php echo esc_url(admin_url( 'admin-ajax.php' )); ?>",
			data: {
				action: 'gswpts_notice_action',
				nonce: '<?php echo esc_attr( wp_create_nonce( 'notifier_notices_nonce' ) ); ?>',
				info: {
					type: 'reminder',
					value: dataValue
				},
				actionType: 'review_notice'
			},
			success: response => {
				if (response.data.response_type === 'success') {
					$('.wpnts-ratting-banner').slideUp();
				}
			}
		});
	});


	// Ratting 
	$('.ratting-yellow-icon').hover(
		function() {
			// Remove existing orange and gray classes
			$('.ratting-yellow-icon').removeClass('ratting-orange-icon ratting-gray-icon');
			
			// Get the index of the hovered star
			var currentIndex = $(this).index() + 1;

			// Add orange class to stars up to the hovered one
			$('.ratting-yellow-icon:lt(' + currentIndex + ')').addClass('ratting-orange-icon');

			// Add gray class to the remaining stars
			$('.ratting-yellow-icon:gt(' + (currentIndex - 1) + ')').addClass('ratting-gray-icon');
		},
		function() {
			// Remove all hover-related classes and set to yellow
			$('.ratting-yellow-icon').removeClass('ratting-orange-icon ratting-gray-icon').addClass('ratting-yellow-icon');
		}
	);

	// Add click event to stars
	$('.ratting-yellow-icon').click(function() {
		// Add 'rated' class to the clicked stars
		$(this).addClass('rated');
	});

	// Click event for the rating container
	$('.rating-container').click(function() {
		var orangeIcons = $('.ratting-orange-icon').length;

		if (orangeIcons === 5) {
			window.open('https://wordpress.org/support/plugin/notifier-to-slack/reviews/?filter=5', '_blank');
		} else {
			window.open('https://wpxperties.com/support/', '_blank');
		}
	});

});
</script>
