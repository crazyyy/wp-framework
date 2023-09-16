jQuery(document).ready(function($){
	$( "#test-button" ).on( "click", function() {
		$("#test-button").text("Sending...");
		$("#test-button").attr('disabled', true);

		var data = {
			'action'	: 'test_error'
		};

		$.post(ajaxurl, data);

		setTimeout(function() {
			$("#test-button").text("Send Test");
			$("#test-button").removeAttr('disabled',true);
		}, 1000 );

	});
});