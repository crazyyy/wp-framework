jQuery(function($) {
	// antibot keys are expired then add new keys to comment form
	if ($('.comment-form-aios-antibot-keys').length && $('#aios_antibot_keys_expiry').length) {
		if ($('#aios_antibot_keys_expiry').val() < Math.floor(Date.now() / 1000)) {
			jQuery.ajax({
				url: AIOS_FRONT.ajaxurl,
				type: 'post',
				dataType: 'json',
				cache: false,
				data: {
					action: 'get_antibot_keys',
					nonce: AIOS_FRONT.ajax_nonce
				},
				success: function(resp) {
					if (resp.hasOwnProperty('error_code')) {
						console.log("ERROR: " + resp.error_message);
					} else if (resp.hasOwnProperty('data')) {
						for (var indx in resp.data) {
							var input = $("<input>").attr("type", "hidden");
							input.attr("name", resp.data[indx][0]);
							input.attr("value", resp.data[indx][1]);
							$('.comment-form-aios-antibot-keys').append(input);
						}
					}
				},
				error: function(xhr, text_status, error_thrown) {
					console.log("ERROR: " + text_status + " : " + error_thrown);
				}
			});
		}
	}
});