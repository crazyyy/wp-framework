// jQuery doc ready
(function($) {
	$(document).ready(function() {

		// set the new block code
		var newblockcode = $('.acf-block-code-hidden').html();
		$('#acftc-block-code-output-code').html(newblockcode);

		// set the new options code
		var newoptionscode = $('.acf-option-code-hidden').html();
		$('#acftc-option-code-output-code').html(newoptionscode);

		// On toggle of the registration location
		$( "#acftc-registration-option" ).change(function( event ) {

			// get the selected value
			var activediv = $(this).val();

			// hide all the divs
			$('.registration-wrap').slideUp();

			// remove the active class from all the divs
			$('.registration-wrap').removeClass('registration-wrap--active');

			// slide down the one we want
			$('#' + activediv ).slideDown();

			// add the active class to the active div
			$('#' + activediv ).addClass('registration-wrap--active');

		});

		// watch the block name input for changes
		$("#acf_block_name").bind("change paste keyup", function() {

			// set some vars to the value of the input
			var block_name_raw = $(this).val().replace(/[^a-zA-Z0-9 _-]/g, '');
			var block_name_lower_dashes = block_name_raw.toLowerCase().replace(/[ _]/g, '-');
			var block_name_lower_underscores = block_name_raw.toLowerCase().replace(/[ -]/g, '_');
			var block_name_lower_keywords = block_name_raw.toLowerCase().replace(/([_ -])+/g, "', '");

			// as long as the block isn't empty
			if(block_name_raw != ''){
				$('.acf-tc-block-name--raw').text(block_name_raw);
				$('.acf-tc-block-name--lower-dashes').text(block_name_lower_dashes);
				$('.acf-tc-block-name--lower-underscores').text(block_name_lower_underscores);
				$('.acf-tc-block-name--lower-keywords').text(block_name_lower_keywords);
			} else {
				$('.acf-tc-block-name--raw').text('Example');
				$('.acf-tc-block-name--lower-dashes').text('example');
				$('.acf-tc-block-name--lower-underscores').text('blocks');
				$('.acf-tc-block-name--lower-keywords').text('example');
			}

			$('#acftc-block-code-output-code').empty();
			var newcontent = $('.acf-block-code-hidden').html();
			$('#acftc-block-code-output-code').html(newcontent);
			Prism.highlightElement($('#acftc-block-code-output-code')[0]);

		});

		// watch the option name input for changes
		$("#acf_option_name").bind("change paste keyup", function() {

			// set some vars to the value of the input
			var option_name_raw = $(this).val().replace(/[^a-zA-Z0-9 ]/g,'');
			var option_name_lower_dashes = option_name_raw.toLowerCase().split(' ').join('-');

			// as long as the block isn't empty
			if(option_name_raw != ''){
				$('.acf-tc-option-name--raw').text(option_name_raw);
				$('.acf-tc-option-name--lower-dashes').text(option_name_lower_dashes);
			} else {
				$('.acf-tc-option-name--raw').text('Options');
				$('.acf-tc-option-name--lower-dashes').text('options');
			}

			$('#acftc-option-code-output-code').empty();
			var newcontent = $('.acf-option-code-hidden').html();
			$('#acftc-option-code-output-code').html(newcontent);
			Prism.highlightElement($('#acftc-option-code-output-code')[0]);

		});

	});
} )( jQuery );
