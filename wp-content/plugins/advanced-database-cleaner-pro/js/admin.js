jQuery(document).ready(function(){

	// Prevent submitting forms via Enter key to prevent any unexpected form submission
	jQuery(window).keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});

	// x10: After upgrading to WP 5.5, the button of #doaction2 at the button does not work anymore
	// This is because when submitting the form below via 'jQuery("#aDBc_form").submit()', the form is sent without the action selected at bottom
	// We make sure that both dropdowns have the same values so that the form is sent without issues
	jQuery('#bulk-action-selector-bottom').on("change", function(e) {
		var abdc_action = jQuery('#bulk-action-selector-bottom').val();
		jQuery('#bulk-action-selector-top').val(abdc_action);
	});
	jQuery('#bulk-action-selector-top').on("change", function(e) {
		var abdc_action = jQuery('#bulk-action-selector-top').val();
		jQuery('#bulk-action-selector-bottom').val(abdc_action);
	});	

	// Get items type from hidden input in the page
	var aDBc_item_type = jQuery("#aDBc_item_type").attr('value');

	if(aDBc_item_type == "tables" || aDBc_item_type == "options" || aDBc_item_type == "tasks"){
		var iteration = jQuery("#aDBc_iteration").attr('value');
		// After reload page, check if we should call ajax processing, if so, proceed even before clicking the button to continue after timeout
		if(iteration != ""){
			// Since we continue scan, not need to send parameters
			startOrContinueScan("", "");
		}
	}

	jQuery('#aDBc_new_search_button').on('click', function(e){

        e.preventDefault();

		// Get counts of all items and uncategorized from hidden inputs
		var aDBc_count_all_items 		= jQuery("#aDBc_count_all_items").attr('value');
		var aDBc_count_uncategorized 	= jQuery("#aDBc_count_uncategorized").attr('value');

		// Choose what to show in the dialog box according to the number of items to scan
		if(aDBc_count_uncategorized == 0 || aDBc_count_uncategorized == aDBc_count_all_items){
			var aDBc_text 	= aDBc_ajax_obj.scan_all_only;
			var aDBc_scan 	= aDBc_ajax_obj.all_items2;
		}else{
			var aDBc_text 	= aDBc_ajax_obj.scan_all_or_u;
			var aDBc_scan 	= aDBc_ajax_obj.all_items;
		}

		Swal.fire({
			text				: aDBc_text,
			footer				: '<font size="2px" color="grey">' + aDBc_ajax_obj.scan_time_depends + '</font>',
			icon				: "question",
			showCloseButton		: true,
			showCancelButton	: true,

			confirmButtonText	: aDBc_scan + ' (' + aDBc_count_all_items + ')',
			confirmButtonColor	: '#0085ba',

			cancelButtonText	: aDBc_ajax_obj.uncategorized + ' (' + aDBc_count_uncategorized + ')',
			cancelButtonColor	: '#555',

			// Test if aDBc_count_uncategorized == 0 or aDBc_count_uncategorized == aDBc_count_all_items, disable uncategorized button
			onOpen: () => {
				if(aDBc_count_uncategorized == 0 || aDBc_count_uncategorized == aDBc_count_all_items){
					jQuery('.swal2-cancel').hide();
				}
			}

		}).then((result) => {
			// If the user clicked on "confirm" which is "All items"
			if(result.value){

				startOrContinueScan("scan_all", "");

			}else if(result.dismiss === Swal.DismissReason.cancel){

				startOrContinueScan("scan_uncategorized", "");

			}
		})

		return false;
	});

	// This function starts/continue a scan, only one of the two parameters will have a value, the other one will be empty
	// If aDBc_scan_type not empty 		=> the user wants to scan all items or uncategorized ones
	// if aDBc_items_to_scan not empty 	=> the user want to scan specific selected items
	// If both empty => the scan should continue
	function startOrContinueScan(aDBc_scan_type, aDBc_items_to_scan){

		// Disable all buttons ont the page to prevent clicking on them + Change scan button
		jQuery('#aDBc_new_search_button').attr("value", aDBc_ajax_obj.sentence_scanning);
		jQuery('#aDBc_new_search_button').css('background-image', 'url(' + aDBc_ajax_obj.images_path + 'loading20px.svg)');
		jQuery('#aDBc_new_search_button').attr("disabled", true);

		// Show progress bar
		jQuery('#aDBc_progress_container').show();
		jQuery('#aDBc-progress-bar').html("0%");

		jQuery.ajax({
			type : "post",
			url: aDBc_ajax_obj.ajaxurl,
			cache: false,
			data: {
				'action'				: 'aDBc_new_run_search_for_items',
				'aDBc_item_type'		: aDBc_item_type,
				'aDBc_scan_type'		: aDBc_scan_type,
				'aDBc_items_to_scan'	: aDBc_items_to_scan
			},
			success: function(result) {

				jQuery('#aDBc-progress-bar').html("100 %");
				jQuery('#aDBc-progress-bar').css("width", "100%");

			},
			complete: function(){
				// wait for 1 sec then reload the page.
				setTimeout(function(){location.reload();}, 1000);				
			}
		});
		setTimeout(getProgress, 500);

	}

	function getProgress(){

		jQuery.ajax({
			type : "post",
			url: aDBc_ajax_obj.ajaxurl,
			data: {
				'action': 'aDBc_get_progress_bar_width'
			},
			dataType : 'json',
			success: function(result) {
				var current = result['aDBc_progress'];
				var total 	= result['aDBc_total_items'];
				// xxx to delete console log
				// console.log(result);
				if(total > 0){
					jQuery('#aDBc-progress-bar').html(parseInt(current * (100/total)) + "%");
					jQuery('#aDBc-progress-bar').css("width", parseInt(current * (100/total)) + "%");
				}
				setTimeout(getProgress, 2000);
			}
		});
	}

	// Scan specific selected items
	jQuery('#doaction, #doaction2').on('click', function(e){

		// Get action from the clicked button
		if(this.id == 'doaction'){
		  var aDBc_action = jQuery("#bulk-action-selector-top").val();
		}else if(this.id == 'doaction2'){
		  var aDBc_action = jQuery('#bulk-action-selector-bottom').val();
		}

		// Get values of top_action and bottom action
		var abdc_top_action 	= jQuery('#bulk-action-selector-top').val();
		var abdc_bottom_action 	= jQuery('#bulk-action-selector-bottom').val();

		// Before performing any action, test first if #bulk-action-selector-top and #bulk-action-selector-bottom have the same value as in x10 above
		if(abdc_top_action != abdc_bottom_action){

			// Prevent doaction button from its default behaviour
			e.preventDefault();

			// If values are different, show an error msg
			Swal.fire({
			  icon					: 'error',
			  confirmButtonColor	: '#0085ba',
			  showCloseButton		: true,
			  text					: aDBc_ajax_obj.unexpected_error
			})

		// If no action selected
		}else if(aDBc_action == "-1"){

			// Prevent doaction button from its default behaviour
			e.preventDefault();

			// If no actions selected, show an error message
			Swal.fire({
			  icon					: 'error',
			  confirmButtonColor	: '#0085ba',
			  showCloseButton		: true,
			  text					: aDBc_ajax_obj.select_action
			})

		}else{

			// Test if the user has checked some items
			var aDBc_elements_to_process = [];

			// Get all selected items
			jQuery('input[name="aDBc_elements_to_process[]"]:checked').each(function(){aDBc_elements_to_process.push(this.value);});

			// If no items selected, show error message
			if(aDBc_elements_to_process.length === 0){

				// Prevent doaction button from its default behaviour
				e.preventDefault();

				Swal.fire({
				  icon					: 'error',
				  confirmButtonColor	: '#0085ba',
				  showCloseButton		: true,
				  text					: aDBc_ajax_obj.no_items_selected
				})

			}else{

				// Test if the user has selected "scan_selected" action
				if(aDBc_action == "scan_selected"){

					// Prevent doaction button from its default behaviour if the action is "scan_selected"
					e.preventDefault();

					// Disable all buttons ont the page to prevent clicking on them + Change scan button
					jQuery("#doaction").attr("disabled", true);
					jQuery("#doaction2").attr("disabled", true);

					startOrContinueScan("", aDBc_elements_to_process);

				}else{

					// The default warning msg to show is
					var message_to_show = aDBc_ajax_obj.clean_items_warning;

					// If 'empty' action is selected for tables, override the warning msg
					if(aDBc_action == 'empty'){
						var message_to_show = aDBc_ajax_obj.empty_tables_warning;
					}

					// We show the warning box msg only when actions such as: delete, clean, empty... are selected
					if(aDBc_action == 'delete' || aDBc_action == 'clean' || aDBc_action == 'empty'){

						// Prevent doaction button from its default behaviour
						e.preventDefault();

						Swal.fire({
							title				: '<font size="4px">' + aDBc_ajax_obj.are_you_sure + '</font>',
							text				: message_to_show,
							footer				: '<font size="3px" color="red"><b>' + aDBc_ajax_obj.make_db_backup_first + '</b></font>',
							imageUrl			: aDBc_ajax_obj.images_path + 'alert_delete.svg',
							imageWidth			: 60,
							imageHeight			: 60,
							showCancelButton	: true,
							showCloseButton		: true,
							cancelButtonText	: aDBc_ajax_obj.cancel,
							cancelButtonColor	: '#555',
							confirmButtonText	: aDBc_ajax_obj.Continue,
							confirmButtonColor	: '#0085ba',
							focusCancel 		: true,
						}).then((result) => {
							// If the user clicked on "confirm", submit the form
							if(result.value){
								jQuery("#aDBc_form").submit();
							}
						})
					}
				}
			}
		}
	});

	// Perform double check of items against server database to enhance accuracy
	/*jQuery('#aDBc_double_check').on('click', function(e){

		var me = jQuery(this);
        e.preventDefault();

		me.css('background-image', 'url(' + aDBc_ajax_obj.images_path + 'loading20px.svg)');
		me.attr("disabled", true);
		jQuery('#aDBc_double_check_sentence').show();
		jQuery('#aDBc_double_check_ignore_link').hide();

		jQuery.ajax({
			type : "post",
			url: aDBc_ajax_obj.ajaxurl,
			cache: false,
			data: {
				'action': 'aDBc_double_check_items',
				'aDBc_item_type': aDBc_item_type,
				// xxx Add nonce
			},
			success: function(result) {

			},
			complete: function(){
				// wait for 1 sec then reload the page
				setTimeout(function(){location.reload();}, 1000);				

			}
		});
		return false;
	});*/

	// Stop the scan
	jQuery('#aDBc_stop_scan').on('click', function(e){

        e.preventDefault();
		jQuery('#aDBc_stop_scan').hide();
		jQuery('#aDBc_stopping_msg').show();

		jQuery.ajax({
			type : "post",
			url: aDBc_ajax_obj.ajaxurl,
			cache: false,
			data: {
				'action': 'aDBc_stop_search',
				'aDBc_item_type': aDBc_item_type
			},
			success: function(result) {
			},
			complete: function(){
			}
		});
		//xxx return false;
	});

	// Actions to do when the user clicks on 'Edit' link to change the 'Keep last' value
	jQuery('.aDBc_keep_link').click(function(event){

		var idelement 	= (event.target.id).split("_");
		var itemname 	= idelement[idelement.length-1];

		jQuery("#aDBc_edit_keep_"	+ itemname).hide();
		jQuery("#aDBc_keep_label_"	+ itemname).hide();

		jQuery('#aDBc_keep_input_'	+ itemname).show();
		jQuery('#aDBc_keep_button_'	+ itemname).show();
		jQuery('#aDBc_keep_cancel_'	+ itemname).show();

		jQuery('.aDBc_keep_link').css("pointer-events", "none");
		jQuery('.aDBc_keep_link').css("cursor", "default");
		jQuery('.aDBc_keep_link').css("color", "#eee");

	});

	jQuery('.aDBc_keep_cancel_link').click(function(event){

		var idelement 	= (event.target.id).split("_");
		var itemname 	= idelement[idelement.length-1];

		jQuery('#aDBc_keep_input_'	+ itemname).hide();
		jQuery('#aDBc_keep_button_'	+ itemname).hide();
		jQuery('#aDBc_keep_cancel_'	+ itemname).hide();

		jQuery("#aDBc_edit_keep_"	+ itemname).show();
		jQuery("#aDBc_keep_label_"	+ itemname).show();

		jQuery('.aDBc_keep_link').css("pointer-events", "");
		jQuery('.aDBc_keep_link').css("cursor", "pointer");
		jQuery('.aDBc_keep_link').css("color", "");

	});

});
