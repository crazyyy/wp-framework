/**
 * Send an action over AJAX. A wrapper around jQuery.ajax. In future, all consumers can be reviewed to simplify some of the options, where there is historical cruft.
 *
 * @param {string}   action   - the action to send
 * @param {*}        data     - data to send
 * @param {Function} callback - will be called with the results
 * @param {object}   options  -further options. Relevant properties include:
 * - [json_parse=true] - whether to JSON parse the results
 * - [alert_on_error=true] - whether to show an alert box if there was a problem (otherwise, suppress it)
 * - [action='aios_ajax'] - what to send as the action parameter on the AJAX request (N.B. action parameter to this function goes as the 'subaction' parameter on the AJAX request)
 * - [nonce=aios_ajax_nonce] - the nonce value to send.
 * - [nonce_key='nonce'] - the key value for the nonce field
 * - [timeout=null] - set a timeout after this number of seconds (or if null, none is set)
 * - [async=true] - control whether the request is asynchronous (almost always wanted) or blocking (would need to have a specific reason)
 * - [type='POST'] - GET or POST
 */
function aios_send_command(action, data, callback, options) {

	var default_options = {
		json_parse: true,
		alert_on_error: true,
		action: 'aios_ajax',
		nonce: aios_data.ajax_nonce,
		nonce_key: 'nonce',
		timeout: null,
		async: true,
		type: 'POST'
	};

	if ('undefined' === typeof options) options = {};

	for (var opt in default_options) {
		if (!options.hasOwnProperty(opt)) { options[opt] = default_options[opt]; }
	}

	var ajax_data = {
		action: options.action,
		subaction: action
	};

	ajax_data[options.nonce_key] = options.nonce;
	ajax_data.data = data;

	var ajax_opts = {
		type: options.type,
		url: ajaxurl,
		data: ajax_data,
		success: function(response, status) {
			if (options.json_parse) {
				try {
					var resp = aios_parse_json(response);
				} catch (e) {
					if ('function' == typeof options.error_callback) {
						return options.error_callback(response, e, 502, resp);
					} else {
						console.log(e);
						console.log(response);
						if (options.alert_on_error) { alert(aios_trans.unexpected_response+' '+response); }
						return;
					}
				}
				if (resp.hasOwnProperty('fatal_error')) {
					if ('function' == typeof options.error_callback) {
						// 500 is internal server error code
						return options.error_callback(response, status, 500, resp);
					} else {
						console.error(resp.fatal_error_message);
						if (options.alert_on_error) { alert(resp.fatal_error_message); }
						return false;
					}
				}
				if ('function' == typeof callback) callback(resp, status, response);
			} else {
				if ('function' == typeof callback) callback(response, status);
			}
		},
		error: function(response, status, error_code) {
			if ('function' == typeof options.error_callback) {
				options.error_callback(response, status, error_code);
			} else {
				console.log("aios_send_command: error: "+status+" ("+error_code+")");
				console.log(response);
			}
		},
		dataType: 'text',
		async: options.async
	};

	if (null != options.timeout) { ajax_opts.timeout = options.timeout; }

	jQuery.ajax(ajax_opts);

}

/**
 * Parse JSON string, including automatically detecting unwanted extra input and skipping it
 *
 * @param {string}  json_mix_str - JSON string which need to parse and convert to object
 * @param {boolean} analyse		 - if true, then the return format will contain information on the parsing, and parsing will skip attempting to JSON.parse() the entire string (will begin with trying to locate the actual JSON)
 *
 * @throws SyntaxError|String (including passing on what JSON.parse may throw) if a parsing error occurs.
 *
 * @returns Mixed parsed JSON object. Will only return if parsing is successful (otherwise, will throw). If analyse is true, then will rather return an object with properties (mixed)parsed, (integer)json_start_pos and (integer)json_end_pos
 */
function aios_parse_json(json_mix_str, analyse) {

	analyse = ('undefined' === typeof analyse) ? false : true;

	// Just try it - i.e. the 'default' case where things work (which can include extra whitespace/line-feeds, and simple strings, etc.).
	if (!analyse) {
		try {
			var result = JSON.parse(json_mix_str);
			return result;
		} catch (e) {
			console.log('AIOS: Exception when trying to parse JSON (1) - will attempt to fix/re-parse based upon first/last curly brackets');
			console.log(json_mix_str);
		}
	}

	var json_start_pos = json_mix_str.indexOf('{');
	var json_last_pos = json_mix_str.lastIndexOf('}');

	// Case where some php notice may be added after or before json string
	if (json_start_pos > -1 && json_last_pos > -1) {
		var json_str = json_mix_str.slice(json_start_pos, json_last_pos + 1);
		try {
			var parsed = JSON.parse(json_str);
			if (!analyse) { console.log('AIOS: JSON re-parse successful'); }
			return analyse ? { parsed: parsed, json_start_pos: json_start_pos, json_last_pos: json_last_pos + 1 } : parsed;
		} catch (e) {
			console.log('AIOS: Exception when trying to parse JSON (2) - will attempt to fix/re-parse based upon bracket counting');

			var cursor = json_start_pos;
			var open_count = 0;
			var last_character = '';
			var inside_string = false;

			// Don't mistake this for a real JSON parser. Its aim is to improve the odds in real-world cases seen, not to arrive at universal perfection.
			while ((open_count > 0 || cursor == json_start_pos) && cursor <= json_last_pos) {

				var current_character = json_mix_str.charAt(cursor);

				if (!inside_string && '{' == current_character) {
					open_count++;
				} else if (!inside_string && '}' == current_character) {
					open_count--;
				} else if ('"' == current_character && '\\' != last_character) {
					inside_string = inside_string ? false : true;
				}

				last_character = current_character;
				cursor++;
			}
			console.log("Started at cursor="+json_start_pos+", ended at cursor="+cursor+" with result following:");
			console.log(json_mix_str.substring(json_start_pos, cursor));

			try {
				var parsed = JSON.parse(json_mix_str.substring(json_start_pos, cursor));
				console.log('AIOS: JSON re-parse successful');
				return analyse ? { parsed: parsed, json_start_pos: json_start_pos, json_last_pos: cursor } : parsed;
			} catch (e) {
				// Throw it again, so that our function works just like JSON.parse() in its behaviour.
				throw e;
			}
		}
	}

	throw "AIOS: could not parse the JSON";

}

/**
 * Updates the content of an HTML element identified by its ID with the provided badge text.
 *
 * @param {Array} badges - An array of objects representing badges to update.
 * @param {string} badges.id - The ID of the HTML element to update.
 * @param {string} badges.html - The HTML content to set for the element.
 * @returns {void}
 */
function aios_update_badge(badges) {
	badges.forEach(function(badge) {
		aios_update_content(badge.id, badge.html);
	});
}

/**
 * Update the content of an element with the specified HTML.
 *
 * @param {string} id - The ID of the element to update.
 * @param {string} html - The HTML content to set for the element.
 * @returns {void}
 */
function aios_update_content(id, html) {
	jQuery(id).html(html);
}


/**
 * Function to block the UI and display a loading message.
 * Uses jQuery blockUI plugin.
 *
 * @param {string} message - A string to be shown when function is called
 *
 * @returns {void}
 */
function aios_block_ui(message = aios_trans.saving) {
	jQuery.blockUI({
		css: {
			width: '500px',
			border: 'none',
			'border-radius': '10px',
			left: 'calc(50% - 250px)',
			top: 'calc(50% - 150px)',
			padding: '20px'
		},
		message: '<div style="margin: 8px; font-size:150%;" class="aios_saving_popup"><img src="' + aios_trans.logo + '" height="80" width="80" style="padding-bottom:10px;"><br>' + message + '</div>'
	});
}

/**
 * Display a success modal with optional message and icon.
 *
 * @param {Object|string} args - Configuration object or message string.
 * @param {boolean} close_popup - Optional. If true, the popup will close automatically after 2 seconds. Default is true.
 *
 * @returns {void}
 */
function aios_show_success_modal(args, close_popup = true) {
	if ('string' == typeof args) {
		args = {
			message: args
		};
	}
	var data = jQuery.extend(
		{
			icon: 'yes',
			close: aios_trans.close,
			message: '',
			classes: 'success'
		},
		args
	);

	var closeButtonHTML = '';
	if (!close_popup) {
		closeButtonHTML = '<button class="button aios-close-overlay"><span class="dashicons dashicons-no-alt"></span>' + data.close + '</button>';
	}

	jQuery.blockUI({
		css: {
			width: '500px',
			border: 'none',
			'border-radius': '10px',
			left: 'calc(50% - 250px)',
			top: 'calc(50% - 150px)',
			cursor: 'default'
		},
		onOverlayClick: jQuery.unblockUI,
		message: '<div class="aios_success_popup ' + data.classes + '"><span class="dashicons dashicons-' + data.icon + '"></span><div class="aios_success_popup--message">' + data.message + '</div>' + closeButtonHTML + '</div>'
	});

	// click the show more for AJAX info
	jQuery('.aios_success_popup').on('click', '#aios_ajax_showmoreoptions', function (e) {
		e.preventDefault();
		let more_options = jQuery('#aios_ajax_moreoptions');
		more_options.toggle();
		// Toggle text between "Show more" and "Hide"
		let new_text = more_options.is(':visible') ? aios_trans.hide_info : aios_trans.show_info;
		jQuery(this).text(new_text);
	});

	// close success popup
	jQuery('.blockUI .aios-close-overlay').on('click', function() {
		jQuery.unblockUI();
	});

	if (close_popup) {
		setTimeout(function () {
			jQuery.unblockUI();
		}, 1500);
	}
}

/**
 * Submits a form using AJAX and handles the response.
 *
 * @param {jQuery} form - The jQuery object representing the form element.
 * @param {string} action - The action to perform when submitting the form.
 * @param {boolean|Object} [use_data=true] - Indicates whether to include form data in the AJAX request.
 * @param {string} [block_ui_message="Saving..."] - The message to display while blocking UI during AJAX request.
 * @param {Function} [pre_ajax_callback] - Optional callback function to execute before the AJAX request.
 * @param {Function} [post_ajax_callback] - Optional callback function to execute after the AJAX request.
 */
function aios_submit_form(form, action, use_data = true, block_ui_message = aios_trans.saving, pre_ajax_callback, post_ajax_callback) {
	aios_block_ui(block_ui_message);
	var submitButton = form.find(':submit');
	submitButton.prop('disabled', true);
	var data = {};

	if ('function' === typeof pre_ajax_callback) {
		pre_ajax_callback();
	}

	if ('object' === typeof use_data) {
		data = use_data; // Use custom data object
	} else if (use_data) {
		var dataArray = form.serializeArray();
		var dataLength = dataArray.length;
		for (var i = 0; i < dataLength; i++) {
			data[dataArray[i].name] = dataArray[i].value;
		}
	}
	aios_send_command(action, data, function(response) {
		aios_handle_ajax_update(response, post_ajax_callback);
		submitButton.prop('disabled', false);
	});
}

/**
 * Handle AJAX response and update UI elements accordingly.
 * If a callback function is provided, it will be executed.
 *
 * @param {Object} response - The AJAX response object.
 * @param {Function} [callback] - Optional callback function to execute.
 *
 * @returns {void}
 */
function aios_handle_ajax_update(response, callback) {

	// update contents on the page
	if (response.hasOwnProperty('content')) {
		jQuery.each(response.content, function(key, value) {
			aios_update_content('#' + key, value);
		});
	}

	// update fields with new values if changed
	if (response.hasOwnProperty('values')) {
		jQuery.each(response.values, function(key, value) {
			jQuery('#' + key).val(value);
		});
	}

	// update badges
	if (response.hasOwnProperty('badges')) {
		aios_update_badge(response.badges);
	}

	if ('function' === typeof callback) {
		callback(response);
	}

	aios_show_ajax_response_message(response);
}

/**
 * Displays an AJAX response message in a modal or unblocks the UI.
 *
 * This function processes the response from an AJAX request and displays
 * the message or info in a modal. If there is an error in the response,
 * it shows a warning modal. If there are additional informational messages,
 * it provides a toggle to display them. If no messages are present, it unblocks the UI.
 *
 * @param {Object} response - The response object returned from the AJAX call.
 * @param {string} [response.message] - The main message to be displayed in the modal.
 * @param {string} [response.status] - The status of the response ('error' indicates a warning).
 * @param {Array<string>} [response.info] - Additional information messages to display.
 */
function aios_show_ajax_response_message(response) {
	var update_message = (response.hasOwnProperty('message') && response.message.length > 0) || (response.hasOwnProperty('info') && response.info.length > 0);

	if (update_message) {
		var messageContainer = jQuery('<div></div>');
		var close_popup = true;

		// display single message
		if (response.hasOwnProperty('message')) {
			messageContainer.append(response.message);
			messageContainer.append('<br>');
		}

		if (response.hasOwnProperty('info') && response.info.length > 0) {
			close_popup = false;
			// info toggle
			let toggle = jQuery('<span>' + aios_trans.show_notices + ' (<a href="#" id="aios_ajax_showmoreoptions">' + aios_trans.show_info + '</a>)</span>');
			toggle.appendTo(messageContainer);


			let infoContainer = jQuery('<div id="aios_ajax_moreoptions" class="aiowps_more_info_body" style="display:none;"></div>');
			response.info.forEach(function (info) {
				infoContainer.append(`<span class="aios-modal-info">${info}</span>`, '<br>');
			});

			infoContainer.appendTo(messageContainer);
		}


		if ('error' === response.status) {
			aios_show_success_modal({
				message: messageContainer.html(),
				icon: 'no-alt',
				classes: 'warning'
			}, false);
		} else {
			aios_show_success_modal(messageContainer.html(), close_popup);
		}
	} else {
		setTimeout(function() {
			jQuery.unblockUI();
		}, 1500);
	}
}

jQuery(function($) {
	//Add Generic Admin Dashboard JS Code in this file

	//Media Uploader - start
	jQuery("#aiowps_restore_htaccess_form").on('submit', function(e) {
		e.preventDefault();
		var form = jQuery(this);

		aios_read_restore_file(this, 'htaccess', function () {
			aios_submit_form(form, 'perform_restore_htaccess_file', true, aios_trans.processing, null, function (response) {
				form[0].reset();
			})
		});
	});

	jQuery("#aiowps_restore_wp_config_form").on('submit', function(e) {
		e.preventDefault();
		var form = jQuery(this);

		aios_read_restore_file(this, 'wp_config', function () {
			aios_submit_form(form, 'perform_restore_wp_config_file', true, aios_trans.processing, null, function (response) {
				form[0].reset();
			})
		});
	});

	jQuery("#aiowps_restore_settings_form").on('submit', function(e) {
		e.preventDefault();
		var form = jQuery(this);

		aios_read_restore_file(this, 'import_settings', function () {

			aios_submit_form(form, 'perform_restore_aiowps_settings', true, aios_trans.processing, null, function(response) {
				form[0].reset();
				if (response.hasOwnProperty('redirect_url')) {
					// Redirect to the URL
					window.location.href = response.redirect_url;
				}
			})
		})
	});

	/**
	 * Reads the contents of a selected file and submits the form after populating a hidden input with the file contents.
	 *
	 * @param {HTMLFormElement} form - The form element to submit after reading the file contents.
	 * @param {string} 			file - The type of file to read ('htaccess', 'wp_config', 'import_settings').
	 * @param {Function} [callback] - Optional. A callback function to execute after reading the file contents.
	 */
	function aios_read_restore_file(form, file, callback) {
		var aios_import_file_input = document.getElementById('aiowps_' + file + '_file');
		if (0 == aios_import_file_input.files.length) {
			alert(aios_trans.no_import_file);
			return;
		}
		var aios_import_file_file = aios_import_file_input.files[0];
		var aios_import_file_reader = new FileReader();
		aios_import_file_reader.onload = function() {
			jQuery('#aiowps_' + file + '_file_contents').val(this.result);
			if ('function' === typeof callback) {
				// If callback is provided, execute it
				callback();
			} else {
				// If callback is not provided, submit the form
				form.submit();
			}
		};
		aios_import_file_reader.readAsText(aios_import_file_file);
	}
	//End of Media Uploader
	
	// Triggers the more info toggle link
	jQuery(".aiowps_more_info_body").hide();//hide the more info on page load
	function toggleMoreInfo() {
		jQuery('.aiowps_more_info_anchor').on('click', function () {
			jQuery(this).next(".aiowps_more_info_body").animate({"height": "toggle"});
			var toggle_char_ref = jQuery(this).find(".aiowps_more_info_toggle_char");
			var toggle_char_value = toggle_char_ref.text();
			if ("+" === toggle_char_value) {
				toggle_char_ref.text("-");
			} else {
				toggle_char_ref.text("+");
			}
		});
	}
	toggleMoreInfo();
	//End of more info toggle

	/**
	 * This function uses javascript to retrieve a query arg from the current page URL
	 *
	 * @param {string} name - The name of the query parameter to retrieve.
	 * @returns {string|null} The value of the query parameter, or null if the parameter does not exist.
	 */
	function getParameterByName(name) {
		var url = window.location.href;
		name = name.replace(/[\[\]]/g, "\\$&");
		var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
			results = regex.exec(url);
		if (!results) return null;
		if (!results[2]) return '';
		return decodeURIComponent(results[2].replace(/\+/g, " "));
	}

	// Start of brute force attack prevention toggle handling
	jQuery('input[name=aiowps_enable_brute_force_attack_prevention]').on('click', function() {
		jQuery('input[name=aiowps_brute_force_secret_word]').prop('disabled', !jQuery(this).prop('checked'));
		jQuery('input[name=aiowps_cookie_based_brute_force_redirect_url]').prop('disabled', !jQuery(this).prop('checked'));
		jQuery('input[name=aiowps_brute_force_attack_prevention_pw_protected_exception]').prop('disabled', !jQuery(this).prop('checked'));
		jQuery('input[name=aiowps_brute_force_attack_prevention_ajax_exception]').prop('disabled', !jQuery(this).prop('checked'));
	});
	// End of brute force attack prevention toggle handling

	// Start of CAPTCHA handling
	jQuery('.wrap').on('change', '#aiowps_default_captcha', function () {
		var selected_captcha = jQuery(this).val();
		jQuery('.captcha_settings').hide();
		jQuery('#aios-'+ selected_captcha).show();
		
		if ('none' === selected_captcha) {
			jQuery('#aios-captcha-options').hide();
		} else {
			jQuery('#aios-captcha-options').show();
		}
	});
	// End of CAPTCHA handling

	/**
	 * Take a backup with UpdraftPlus if possible.
	 *
	 * @param {String}   file_entities
	 *
	 * @return void
	 */
	function take_a_backup_with_updraftplus(file_entities) {
		// Set default for file_entities to empty string
		if ('undefined' == typeof file_entities) file_entities = '';
		var exclude_files = file_entities ? 0 : 1;

		if ('function' === typeof updraft_backupnow_inpage_go) {
			updraft_backupnow_inpage_go(function () {
				// Close the backup dialogue.
				jQuery('#updraft-backupnow-inpage-modal').dialog('close');
			}, file_entities, 'autobackup', 0, exclude_files, 0);
		}
	}

	if (jQuery('#aios-manual-db-backup-now').length) {
		jQuery('#aios-manual-db-backup-now').on('click', function (e) {
			e.preventDefault();
			take_a_backup_with_updraftplus();
		});
	}

	// Hide 2FA premium section (advertisements) for free.
	if (jQuery('.tfa-premium').length && 0 == jQuery('#tfa_trusted_for').length) {
		jQuery('.tfa-premium').parent().find('hr').first().hide();
		jQuery('.tfa-premium').hide();
	}

	// Start of trash spam comments toggle handling
	jQuery('input[name=aiowps_enable_trash_spam_comments]').on('click', function() {
		jQuery('input[name=aiowps_trash_spam_comments_after_days]').prop('disabled', !jQuery(this).prop('checked'));
	});
	// End of trash spam comments toggle handling

	/**
	 * Copies text to the clipboard using the deprecated document.execCommand method.
	 *
	 * @param {string} text - The text to be copied to the clipboard.
	 */
	function deprecated_copy(text) {
		var $temp = jQuery('<input>');
		jQuery('body').append($temp);
		$temp.val(text).select();
		if (document.execCommand('copy')) {
			alert(aios_trans.copied);
		}
		$temp.remove();
	}

	// Start of copy-to-clipboard click handling
	jQuery('.copy-to-clipboard').on('click', function(event) {
		if (navigator.clipboard) {
			navigator.clipboard.writeText(event.target.value).then(function() {
					alert(aios_trans.copied);
				}, function() {
					deprecated_copy(event.target.value);
			});
		} else {
			deprecated_copy(event.target.value);
		}
	});
	// End of copy-to-clipboard click handling

	// Start audit log list table handling
	var audit_log_table_id = '#audit-log-list-table #tables-filter',
	audit_log_elements = '.tablenav-pages a, .manage-column.sortable a, .manage-column.sorted a, .current-page, #search-submit, .action',
	audit_log_bulk_action_selector = '#bulk-action-selector-top, #bulk-action-selector-bottom',
	audit_log_table_tab = 'render_audit_log_tab',
	audit_log_filter_event = '.audit-filter-event',
	audit_log_search = '#search_audit_events-search-input',
	audit_log_level = '.audit-filter-level';
	detect_table_action(audit_log_table_id, audit_log_elements, audit_log_bulk_action_selector, audit_log_table_tab, audit_log_filter_event, audit_log_search, audit_log_level);
	// End of audit log list table handling


	// Start of list table handling

	/**
	 * Attaches event handlers to specified table elements for detecting and performing actions,
	 * then updates the table based on the current state or the clicked element.
	 *
	 * @param {string} id - The ID selector of the table element (e.g., '#my-table').
	 * @param {string} elements - The elements inside the table to attach event handlers to (e.g., 'input, select').
	 * @param {string} action_selector - The selector for the bulk action dropdown element (e.g., '#bulk-action-selector-top').
	 * @param {string} tab - The tab or section to update after performing an action (e.g., 'posts', 'comments').
	 * @param {string} [filter_event_selector=''] - The selector for filtering by event type (optional).
	 * @param {string} [search_selector=''] - The selector for the search input element (optional).
	 * @param {string} [filter_level_selector=''] - The selector for filtering by level (optional).
	 * @param {boolean} [detect=true] - Whether to detect actions based on the clicked element or to perform an action immediately.
	 *
	 * @returns {void}
	 */
	function detect_table_action(id, elements, action_selector, tab, filter_event_selector = '', search_selector = '', filter_level_selector = '', detect = true) {
	
		if (true === detect) {
			jQuery(id).on('click change', elements, function(e) {
				// Check if the event's default action is prevented by the confirm message cancel
				if (!e.isDefaultPrevented()) {
					e.preventDefault();
					perform_action.call(this); // Ensure the context (this) is correct
				}
			});
		} else {
			perform_action.call(jQuery(id).get(0)); // Use the first element from the selector to maintain context
		}

		/**
		 * Perform the action based on the clicked element or the current sorting state.
		 *
		 * @returns {void}
		 */
		function perform_action() {
			aios_block_ui(aios_trans.processing);
			var checked_values = jQuery('th.check-column input[type="checkbox"]:checked').map(function() {
				return jQuery(this).val();
			}).get();
	
			var event_filter = jQuery(filter_event_selector).val();
			if (event_filter) {
				event_filter = event_filter.replace(/\s+/g, '_').toLowerCase();
			}

			var top_selector = jQuery('#bulk-action-selector-top').val(),
			bottom_selector = jQuery('#bulk-action-selector-bottom').val(),
			search = jQuery(search_selector).val(),
			action;

			if ('-1' !== top_selector) {
				action = top_selector;
			} else if ('-1' !== bottom_selector) {
				action = bottom_selector;
			} else {
				action = '-1';
			}
	
			var data = {
				'paged': get_page_number(jQuery(this)),
				'order': get_order(jQuery(this)),
				'orderby': get_order_by(jQuery(this)),
				's': search || '',
				'level-filter': jQuery(filter_level_selector).val() || '-1',
				'event-filter': event_filter || '-1',
				'items': checked_values,
				'action': action
			};
	
			update_list_table(tab, data);
	
			jQuery(action_selector).val('-1');
		}
	}

	/**
	 * Remove the message after a set time.
	 *
	 * @returns {void}
	 */
	function remove_aios_message() {
	setTimeout(function() {
		jQuery('#aios_message').remove();
	}, 5000);
	}

	/**
	 * Get the column ID based on the clicked element or the current sorting state.
	 *
	 * @param {jQuery} element - The jQuery object representing the clicked element.
	 *
	 * @returns {string} The ID of the column.
	 */
	function get_order_by(element) {
		if (element.is('.manage-column.sortable a')) return element.closest('th').attr('id');
		else if (0 < jQuery('.sorted').length) return jQuery('.sorted').attr('id');
		else return element.closest('th').attr('id');
	}

	/**
	 * Get the order (ascending or descending) based on the clicked element or the current sorting state.
	 *
	 * @param {jQuery} element - The jQuery object representing the clicked element.
	 *
	 * @returns {string} The order ('asc' for ascending, 'desc' for descending).
	 */
	function get_order(element) {
		if (element.is('.manage-column.sortable a') || element.is('.manage-column.sorted a')) {
			var url = element.attr('href'),
			orderMatch = url.match(/[?&]order=([^&]+)/);
			return orderMatch[1];
		} else if (0 < jQuery('.sorted').length) {
			return  jQuery('.sorted').hasClass('asc') ? 'asc' : 'desc';
		} else {
			return element.closest('th').hasClass('asc') ? 'asc' : 'desc';
		}
	}
	
	/**
	 * Get the page number based on the clicked element.
	 *
	 * @param {jQuery} element - The jQuery object representing the clicked element.
	 *
	 * @returns {number|string} The page number. If the clicked element represents a specific page, returns that page number. If not, returns the current page number.
	 */
	function get_page_number(element) {
		if (element.hasClass('first-page'))
			return '1';
		else if (element.hasClass('last-page'))
			return find_page_number(jQuery('.last-page'));
		else if (element.hasClass('prev-page'))
			return find_page_number(jQuery('.prev-page'));
		else if (element.hasClass('next-page'))
			return find_page_number(jQuery('.next-page'));
		else return jQuery('.current-page').val();
	}
	
	/**
	 * Finds and returns the page number from the href attribute of the provided element.
	 *
	 * @param {jQuery} element - The jQuery object representing the element containing the href attribute.
	 *
	 * @returns {number} The page number extracted from the href attribute.
	 */
	function find_page_number(element) {
		return parseInt(element.attr('href').split('paged=')[1]);
	}

	/**
	 * Update the list table with data from an AJAX call.
	 * If the current page number exceeds the total pages available,
	 * make a new request for the last available page.
	 *
	 * @param {string} table - The table tab.
	 * @param {object} data - The data object containing table parameters.
	 */
	function update_list_table(table, data) {
		aios_send_command(table, data, function (response) {
			// Check if the requested page number exceeds the total pages available
			if (data.paged > response.total_pages && 0 < response.total_pages) {
				// Update data to request the last available page
				data.paged = response.total_pages;
				// Make another AJAX call to get the data for the last page
				aios_send_command(table, data, function (response) {
					render_table(response);
					}, {
						error_callback: handle_ajax_error
				});
			} else {
				// Proceed to render the table with the current response
				render_table(response);
			}
			}, {
				error_callback: handle_ajax_error
		});
	}
	// End of list table handling

	/**
	 * Render the table elements based on the AJAX response.
	 *
	 * @param {object} response - The response object from the AJAX call.
	 */
	function render_table(response) {
		// Add the requested rows
		if (response.rows.length) jQuery('#the-list').html(response.rows);
		// Update column headers for sorting
		if (response.column_headers.length) jQuery('thead tr, tfoot tr').html(response.column_headers);
		// Update pagination for navigation
		if (response.pagination.top.length) jQuery('.tablenav.top .tablenav-pages').html(jQuery(response.pagination.top).html());
		if (response.pagination.bottom.length) jQuery('.tablenav.bottom .tablenav-pages').html(jQuery(response.pagination.bottom).html());
		// Add/Remove the message
		if (response.aios_list_message && response.aios_list_message.length) jQuery('#wpbody-content .wrap h2:first').after(response.aios_list_message);

		remove_aios_message();
		jQuery.unblockUI();
	}

	/**
	 * Handle errors from the AJAX call.
	 *
	 * @param {object} response - The response object from the AJAX call.
	 * @param {string} status - The status of the AJAX call.
	 * @param {string} error_code - The error code from the AJAX call.
	 * @param {object} resp - The response object containing detailed error information.
	 */
	function handle_ajax_error(response, status, error_code, resp) {
		if (typeof resp !== 'undefined' && resp.hasOwnProperty('fatal_error')) {
			console.error(resp.fatal_error_message);
			alert(resp.fatal_error_message);
		} else {
			var error_message = "aios_send_command: error: " + status + " (" + error_code + ")";
			console.log(error_message);
			alert(error_message);
		}
		jQuery.unblockUI();
	}

	// Start of database table prefix handling
	jQuery('#aiowps_enable_random_prefix').on('click', function() {
		jQuery('#aiowps_new_manual_db_prefix').prop('disabled', jQuery(this).prop('checked'));
	});

	jQuery('#aiowps_new_manual_db_prefix').on('input', function() {
		if (jQuery(this).prop('value')) {
			jQuery('#aiowps_enable_random_prefix').prop('disabled', true);
		} else {
			jQuery('#aiowps_enable_random_prefix').prop('disabled', false);
		}
	});
	// End of database table prefix handling

	// Dashboard menu ajaxify
	jQuery("#locked-ip-list-table").on('click', '.aios-unlock-ip-button', function(e) {
		e.preventDefault();
		var element = jQuery(this);
		confirm(element.data('message')) ? aios_send_command('unlock_ip', {ip: element.data('ip')}, function(response) {
			jQuery('#aios_message').remove();
			jQuery('#wpbody-content .wrap h2:first').after(response.message);
			if ('success' === response.status) jQuery('#locked-ip-list-table').load(' #locked-ip-list-table > *');
		}) : false;
	});

	jQuery("#locked-ip-list-table").on('click', '.aios-delete-locked-ip-record', function(e) {
		e.preventDefault();
		var element = jQuery(this);
		confirm(element.data('message')) ? aios_send_command('delete_locked_ip_record', {id: element.data('id')}, function(response) {
			jQuery('#aios_message').remove();
			jQuery('#wpbody-content .wrap h2:first').after(response.message);
			if ('success' === response.status) jQuery('#locked-ip-list-table').load(' #locked-ip-list-table > *');
		}) : false;
	});

	jQuery("#permanent-ip-list-table").on('click', '.aios-unblock-permanent-ip', function(e) {
		e.preventDefault();
		var element = jQuery(this);
		confirm(element.data('message')) ? aios_send_command('blocked_ip_list_unblock_ip', {id: element.data('id')}, function(response) {
			jQuery('#aios_message').remove();
			jQuery('#wpbody-content .wrap h2:first').after(response.message);
			if ('success' === response.status) jQuery('#permanent-ip-list-table').load(' #permanent-ip-list-table > *');
		}) : false;
	});

	jQuery('#audit-log-list-table').on('click', '.aios-delete-audit-log', function(e) {
		e.preventDefault();
		var element = jQuery(this);
		confirm(element.data('message')) ? aios_send_command('delete_audit_log', {id: element.data('id')}, function(response) {
			jQuery('#wpbody-content .wrap h2:first').after(response.message);
			if ('success' === response.status) detect_table_action(audit_log_table_id, '.aios-delete-audit-log', audit_log_bulk_action_selector, audit_log_table_tab, audit_log_filter_event, audit_log_search, audit_log_level, detect = false);
		}) : false;
	});

	jQuery('#audit-log-list-table').on('click', '.aios-unlock-ip-button', function(e) {
		e.preventDefault();
		var element = jQuery(this);
		confirm(element.data('message')) ? aios_send_command('unlock_ip', {ip: element.data('ip')}, function(response) {
			jQuery('#wpbody-content .wrap h2:first').after(response.message);
			if ('success' === response.status) detect_table_action(audit_log_table_id, '.aios-unlock-ip-button', audit_log_bulk_action_selector, audit_log_table_tab, audit_log_filter_event, audit_log_search, audit_log_level, detect = false);
		}) : false;
	});

	jQuery('#audit-log-list-table').on('click', '.aios-unblacklist-ip-button', function(e) {
		e.preventDefault();
		var element = jQuery(this);
		confirm(element.data('message')) ? aios_send_command('unblacklist_ip', {ip: element.data('ip')}, function(response) {
			jQuery('#wpbody-content .wrap h2:first').after(response.message);
			if ('success' === response.status) detect_table_action(audit_log_table_id, '.aios-unblacklist-ip-button', audit_log_bulk_action_selector, audit_log_table_tab, audit_log_filter_event, audit_log_search, audit_log_level, detect = false);
		}) : false;
	});

	jQuery('#audit-log-list-table').on('click', '.aios-lock-ip-button', function(e) {
		e.preventDefault();
		var element = jQuery(this);
		confirm(element.data('message')) ? aios_send_command('lock_ip', {ip: element.data('ip'), lock_reason: 'audit-log'}, function(response) {
			jQuery('#wpbody-content .wrap h2:first').after(response.message);
			if ('success' === response.status) detect_table_action(audit_log_table_id, '.aios-lock-ip-button', audit_log_bulk_action_selector, audit_log_table_tab, audit_log_filter_event, audit_log_search, audit_log_level, detect = false);
		}) : false;
	});

	jQuery('#audit-log-list-table').on('click', '.aios-blacklist-ip-button', function(e) {
		e.preventDefault();
		var element = jQuery(this);
		confirm(element.data('message')) ? aios_send_command('blacklist_ip', {ip: element.data('ip')}, function(response) {
			jQuery('#wpbody-content .wrap h2:first').after(response.message);
			if ('success' === response.status) detect_table_action(audit_log_table_id, '.aios-blacklist-ip-button', audit_log_bulk_action_selector, audit_log_table_tab, audit_log_filter_event, audit_log_search, audit_log_level, detect = false);
		}) : false;
	});

	jQuery('#aios-clear-debug-logs').on('click', '.aios-clear-debug-logs', function(e) {
		e.preventDefault();
		if (confirm(jQuery(this).data('message'))) {
			aios_send_command('clear_debug_logs', {}, function(response) {
				jQuery('#aios_message').remove();
				jQuery('#wpbody-content .wrap h2:first').after(response.message);
				if ("success" === response.status) jQuery('#debug-list-table').load(' #debug-list-table > *');
			});
		}
	});
	// End of dashboard menu ajaxify

	//Start of Spam prevention ajaxify
	jQuery('#aios-spam-prevention-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_comment_spam_prevention');
	})

	jQuery('#aios-auto-spam-block-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_auto_block_spam_ip');
	})

	jQuery('#aios-spam-ip-search-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_ip_spam_search', true, aios_trans.processing, null, function (response) {
			var targetOffset = jQuery('#aios-spammer-list-table').offset().top;
			jQuery('html, body').animate({ scrollTop: targetOffset }, 'slow');
			if ("success" === response.status) {
				jQuery('#aios-spammer-list-table').load(' #aios-spammer-list-table > *');
			}
		})
	})

	jQuery('#aios-spammer-list-table').on('click', '.aios-block-author-ip', function(e) {
		e.preventDefault();
		var ip = jQuery(this).data('ip');
		var data = {
			'ip': ip
		}

		if (confirm(jQuery(this).data('message'))) {
			aios_submit_form(jQuery(this), 'perform_block_spam_ip', data, aios_trans.processing, null, function (response) {
				if ("success" === response.status) {
					jQuery('#aios-spammer-list-table').load(' #aios-spammer-list-table > *');
					jQuery('html, body').animate({ scrollTop: 0 }, 'slow');
				}
			});
		}
	})
	//End of spam prevention ajaxify
	
	// Start of settings menu ajaxify
	jQuery('#aiowpsec-disable-all-features-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_disable_all_features', true, aios_trans.disabling);
	});

	jQuery('#aiowpsec-disable-all-firewall-rules-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_disable_all_firewall_rules', true, aios_trans.disabling);
	});

	jQuery('#aiowpsec-reset-settings-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_reset_all_settings', true, aios_trans.processing);
	});

	jQuery('#aiowps_enable_debug').on('change', function(e) {
		e.preventDefault();
		var aiowps_enable_debug = jQuery(this).is(':checked') ? '1' : '';
		var data = {
			'aiowps_enable_debug': aiowps_enable_debug
		};
		
		aios_submit_form(jQuery(this), 'perform_save_debug_settings', data, aios_trans.processing);
	});

	jQuery('#aiowpsec-save-htaccess-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_backup_htaccess_file', true, aios_trans.processing, null, function (response) {
			if ('success' === response.status) {
				aios_download_txt_file(response.data, response.title);
			}
		});
	});

	jQuery('#aiowpsec-delete-plugin-settings-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_delete_plugin_settings');
	});

	jQuery('#aiowpsec-remove-wp-meta-info-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_remove_wp_version_info_settings');
	});

	jQuery('#aiowpsec-ip-settings-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_save_ip_settings');
	});

	jQuery('#aiowpsec-save-wp-config-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_save_wp_config', {}, aios_trans.saving, null, function(response) {
			aios_download_txt_file(response.data, response.title);
		});
	});

	jQuery('#aiowpsec-export-settings-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_export_aios_settings', {}, aios_trans.exporting, null, function(response) {
			aios_download_txt_file(response.data, response.title);
		});
	});
	// End of settings menu ajaxify
	// Start of Filesystem menu ajaxify
	jQuery('#aios-file-permissions-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_fix_permissions', true, aios_trans.processing);
	})

	jQuery('#aiowps_delete_default_wp_files').on('click', function(e) {
		e.preventDefault();
		var button = jQuery(this);
		aios_submit_form(jQuery(this), 'perform_delete_default_wp_files', {'aios-delete_default_wp_files': 1}, aios_trans.deleting, function() {
			button.prop('disabled', true);
			},
			function(response) {
				button.prop('disabled', false);
		});
	})

	jQuery('#aios-file-protection-settings-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_file_protection_settings');
	})

	jQuery('#aios-host-system-logs-form').on('submit', function(e) {
		e.preventDefault();

		aios_submit_form(jQuery(this), 'perform_host_system_logs', true, aios_trans.processing, function () {
			jQuery('#aios-host-system-logs-results').html('');
			jQuery('#aiowps_activejobs_table').html('<p><span class="aiowps_spinner spinner">'+ aios_trans.processing + '</span></p>');
			jQuery('#aiowps_activejobs_table .aiowps_spinner').addClass('visible');
			},
			function(response) {
				var loading_span = jQuery('#aiowps_activejobs_table');
				loading_span.hide();
		});
	})

	jQuery('#aios-frame-display-settings-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_save_frame_display_prevent');
	})

	jQuery('#aios-copy-protection-settings-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this),'perform_save_copy_protection');
	})
	//End of Filesystem menu ajaxify
	
	// Firewall menu ajaxify
	jQuery('#aios-php-firewall-settings-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_php_firewall_settings', true, aios_trans.saving, null, function(response) {
			if ("success" === response.status) {
				jQuery('.aio_orange_box').remove();
				jQuery('#post-body h2:first').after(response.xmlprc_warning);
			}
		});
	});

	jQuery('#aios-htaccess-firewall-settings-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this),'perform_htaccess_firewall_settings');
	});

	jQuery("#aios-rest-api-settings-form").on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this),'perform_save_wp_rest_api_settings');
	});

	jQuery("#aios-blacklist-settings-form").on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this),'perform_save_blacklist_settings');
	});

	jQuery("#aios-internet-bots-settings-form").on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this),'perform_internet_bot_settings');
	});

	jQuery("#aios-firewall-allowlist-form").on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this),'perform_firewall_allowlist');
	});

	jQuery("#aios-6g-firewall-settings-form").on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_xG_firewall_settings', true, aios_trans.saving, null, function(response) {
			if ("success" === response.status) {
				var aiowps_enable_6g_firewall = jQuery('#aiowps_enable_6g_firewall').prop('checked');
				if (aiowps_enable_6g_firewall) {
					jQuery('.aios-toggle-advanced-options').removeClass('advanced-options-disabled');
					jQuery('.aiowps_more_info_body').hide();
				} else {
					jQuery('.aios-toggle-advanced-options').addClass('advanced-options-disabled');
					jQuery('.button.button-link.aios-toggle-advanced-options').removeClass('opened');
				}
			}
		})
	});

	jQuery('#aiowps-firewall-status-container').on('submit', "#aiowpsec-firewall-setup-form", function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_setup_firewall', true, aios_trans.setting_up_firewall, null, function (response) {
			jQuery("#aios-firewall-setup-notice").remove();
			jQuery('#wpbody-content .wrap h2:first').after(response.info_box);
		});
	});

	jQuery('#aiowps-firewall-status-container').on('submit', "#aiowps-firewall-downgrade-form", function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_downgrade_firewall', true, aios_trans.downgrading_firewall, null, function (response) {
			jQuery("#aios-firewall-installed-notice").remove();
			jQuery('#wpbody-content .wrap h2:first').after(response.info_box);
		});
	});
	// end of firewall menu ajax

	// Start of file scan handling
	jQuery('.aiowps_next_scheduled_scan_wrapper').on('click', '.aiowps_view_last_fcd_results', view_scan_results_handler);
	jQuery('#aiowps_fcds_change_detected').on('click', '.aiowps_view_last_fcd_results', view_scan_results_handler);

	// start of user security menu ajax
	jQuery('#aios-users-enumeration-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_save_user_enumeration');
	});

	jQuery('#aios-change-admin-username-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_change_admin_username', true, aios_trans.saving, null, function (response) {
			if (response.hasOwnProperty('logout_user') && true === response.logout_user) {
				setTimeout(function() {
					// Check if a logout URL is present in the response
					if (response.hasOwnProperty('logout_url')) {
						// Redirect to the logout URL
						window.location.href = response.logout_url;
					} else {
						// If no logout URL is provided, reload the current page
						location.reload();
					}
				}, 3000);
			}
		});
	});

	jQuery('#aios-user-login-lockdown-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_save_login_lockout_settings');
	});

	jQuery('#aios-user-login-lockout-whitelist-settings-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_save_login_lockout_whitelist_settings');
	});

	jQuery('#aios-force-user-logout-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_force_logout', true, aios_trans.saving, null, function (response) {
			if (response.hasOwnProperty('logout_user') && true === response.logout_user) {
				setTimeout(function() {
					// Check if a logout URL is present in the response
					if (response.hasOwnProperty('logout_url')) {
						// Redirect to the logout URL
						window.location.href = response.logout_url;
					} else {
						// If no logout URL is provided, reload the current page
						location.reload();
					}
				}, 3000);
			}
		});
	});

	jQuery('#aios-disable-application-password-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_disable_application_password');
	});

	jQuery('#aios-enable-salt-postfix-form').submit(function (e) {
		e.preventDefault();
		aios_submit_form(jQuery(this),'perform_add_salt_postfix', true, aios_trans.saving, null,function() {
			setTimeout(function () {
				location.reload();
			}, 3000);
		});
	});

	jQuery('#aios-logged-in-users-table').on('click', '.aios-force-logout-user', function(e) {
		e.preventDefault();
		let user_id = jQuery(this).data('user-id'), data = {
			logged_in_id: user_id,
			action: 'force_user_logout'
		};
		if (confirm(jQuery(this).data('message'))) {
			aios_submit_form(jQuery(this), 'perform_logged_in_user_action', data, aios_trans.processing, null, function (response) {
				if ('success' === response.status) {
					jQuery('#aios-logged-in-users-table').load(' #aios-logged-in-users-table > *');
				}
			});
		}
	});

	jQuery("#aios-refresh-logged-in-user-list-form").on('submit', function(e) {
		e.preventDefault();
		aios_block_ui(aios_trans.refreshing);
		var submitButton = jQuery(this).find(':submit');
		submitButton.prop('disabled', true);
		jQuery('#aios-logged-in-users-table').load(' #aios-logged-in-users-table > *', function () {
			jQuery.unblockUI();
			submitButton.prop('disabled', false);
		});
	});

	jQuery('#aios-manually-approve-registrations-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_manual_approval_settings');
	});

	jQuery("#aios-manual-approval-table").on('click', '.aios-approve-user-acct', function(e) {
		e.preventDefault();
		let user_id = jQuery(this).data('id'), data = {
			user_id: user_id,
			action: 'approve_acct'
		};
		if (confirm(jQuery(this).data('message'))) {
			aios_submit_form(jQuery(this), 'perform_manual_approval_item_action', data, aios_trans.processing, null, function () {
				jQuery('#aios-manual-approval-table').load(' #aios-manual-approval-table > *');
			});
		}
	});

	jQuery("#aios-manual-approval-table").on('click', '.aios-delete-user-acct', function(e) {
		e.preventDefault();
		let user_id = jQuery(this).data('id'), data = {
			user_id: user_id,
			action: 'delete_acct'
		};
		if (confirm(jQuery(this).data('message'))) {
			aios_submit_form(jQuery(this), 'perform_manual_approval_item_action', data, aios_trans.processing, null, function () {
				jQuery('#aios-manual-approval-table').load(' #aios-manual-approval-table > *');
			});
		}
	});

	jQuery("#aios-manual-approval-table").on('click', '.aios-block-ip', function(e) {
		e.preventDefault();
		let ip_address = jQuery(this).data('ip'), data = {
			ip_address: ip_address,
			action: 'block_ip'
		};
		if (confirm(jQuery(this).data('message'))) {
			aios_submit_form(jQuery(this),'perform_manual_approval_item_action', data, aios_trans.blocking, null, function() {
				jQuery('#aios-manual-approval-table').load(' #aios-manual-approval-table > *');
			})
		}
	});

	jQuery("#aios-refresh-manual-approval-list-form").on('submit', function(e) {
		e.preventDefault();
		aios_block_ui(aios_trans.refreshing);
		var submitButton = jQuery(this).find(':submit');
		submitButton.prop('disabled', true);
		jQuery('#aios-manual-approval-table').load(' #aios-manual-approval-table > *', function () {
			jQuery.unblockUI();
			submitButton.prop('disabled', false);
		});
	});

	// end of user security menu ajax

	// start of tools menu ajaxify
	jQuery("#aiowpsec-whois-lookup-form").on('submit', function(e) {
		e.preventDefault();

		jQuery('#aios-who-is-lookup-result-container').html('');

		aios_submit_form(jQuery(this), 'perform_whois_lookup', true, aios_trans.processing, null, function () {
			var targetOffset = jQuery('#aios-who-is-lookup-result-container').offset().top;
			jQuery('html, body').animate({ scrollTop: targetOffset }, 'slow');
		});
	});

	jQuery("#aiowpsec-site-lockout-form").on('submit', function (e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_general_visitor_lockout', true, aios_trans.saving, function () {
			var editor = tinyMCE.get('aiowps_site_lockout_msg_editor_content');
			if (editor) {
				editor.save();
			}
		});
	});

	jQuery("#aiowpsec-save-custom-rules-settings-form").on('submit', function (e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_store_custom_htaccess_settings');
	});
	// end  of tools menu ajaxify
	jQuery('#aiowpsec-scheduled-fcd-scan-form').on('submit', function(e) {
		e.preventDefault();
		aios_submit_form(jQuery(this), 'perform_save_file_detection_change_settings');
	});

	/**
	 * This function handles the view last scan result event
	 *
	 * @param {*} e - the event
	 */
	function view_scan_results_handler(e) {
		e.preventDefault();
		
		var reset_change_detected = jQuery(this).data('reset_change_detected') ? 1 : 0;

		aios_submit_form(jQuery(this), 'get_last_scan_results', { reset_change_detected: reset_change_detected}, aios_trans.processing, null, function (response) {
			if (reset_change_detected) jQuery('#aiowps_fcds_change_detected').remove();
			var targetOffset = jQuery('#aiowps_previous_scan_wrapper').offset().top;
			jQuery('html, body').animate({ scrollTop: targetOffset }, 'slow');
		})
	}

	jQuery('#aiowps_manual_fcd_scan').on('click', function(e) {
		e.preventDefault();

		aios_submit_form(jQuery(this), 'perform_file_scan', true, aios_trans.scanning, function () {
			jQuery('#aiowps_activejobs_table').html('<p><span class="aiowps_spinner spinner">'+ aios_trans.processing + '</span></p>');
			jQuery('#aiowps_activejobs_table .aiowps_spinner').addClass('visible');
			}, function (response) {
				jQuery('#aiowps_activejobs_table').html('');
				if (response.hasOwnProperty('result')) {
					jQuery('#aiowps_activejobs_table').append('<p>'+response.result+'</p>');
				}
		});
	});
	// End of file scan handling
	
	// Start of login whitelist suggests both IPv4 and IPv6
	if (jQuery('#aios_user_ip_maybe_also').length) {
		var selector = '#aios-ipify-ip-address';
		var ipfield = '#aios_user_ip_maybe_also';
		var getting_text = jQuery(ipfield).attr('getting_text');
		var ip_maybe = jQuery(ipfield).attr('ip_maybe');
		if ('v6' == ip_maybe) {
			var url = 'https://api64.ipify.org/?format=json';
		} else {
			var url = 'https://api.ipify.org/?format=json';
		}
		jQuery(selector).html(getting_text);
		jQuery.ajax({
			type: 'GET',
			dataType: 'json',
			url: url,
			success: function (response, status) {
				if (response.hasOwnProperty('ip') && response.ip != jQuery('#aiowps_user_ip').val()) {
					jQuery(ipfield).val(response.ip);
					jQuery(ipfield).removeClass('aio_hidden');
				} else {
					console.log(response);
				}
				jQuery(selector).html('');
			},
			error: function (response, status, error_code) {
				console.log(response);
				jQuery(selector).html('');
			}
		});
	}
	// End of login whitelist suggests both IPv4 and IPv6

	// Click the 'show/hide advanced options' button
	jQuery('button.button-link.aios-toggle-advanced-options').on('click', function() {
		if (!jQuery(this).hasClass('advanced-options-disabled')) {
			jQuery(this).toggleClass('opened');
		}
	});

	// Start of the new UI settings
	var initial_values = {};
	jQuery('.aiowps-actions').hide();

	/**
	 * Set active tab from URL
	 *
	 * @param {string} subtab
	 *
	 * @returns {void}
	 */
	function set_active_tab_from_url() {
		const url_params = new URLSearchParams(window.location.search);
		const subtab = url_params.get('subtab');
		if (subtab) {
			jQuery('.aiowps-rules li').removeClass('aiowps-active');
			jQuery(`.aiowps-rules li[data-template="${subtab}"]`).addClass('aiowps-active');
			jQuery('.aiowps-settings .postbox').hide();
			jQuery(`.aiowps-settings .postbox[data-template="${subtab}"]`).show();
		} else {
			jQuery('.aiowps-settings .postbox:first').show();
		}
	}

	var initial_values = {};

	/**
	 * Store initial values of the settings
	 *
	 * @returns {void}
	 */
	function store_values() {
		jQuery('.aiowps-settings :input').each(function() {
			if (jQuery(this).is(':checkbox')) {
				initial_values[jQuery(this).attr('name')] = jQuery(this).is(':checked');
			} else {
				initial_values[jQuery(this).attr('name')] = jQuery(this).val();
			}
		});
	}

	// Store initial values on page load
	store_values();

	// Add change event listener to all inputs
	jQuery('.aiowps-settings :input').on('change', function() {
		var all_inputs_back_to_original = true;
		jQuery('.aiowps-settings :input').each(function() {
			var input_name = jQuery(this).attr('name');
			if (jQuery(this).is(':checkbox')) {
				if (jQuery(this).is(':checked') !== initial_values[input_name]) {
					all_inputs_back_to_original = false;
					return false;
				}
			} else {
				if (jQuery(this).val() !== initial_values[input_name]) {
					all_inputs_back_to_original = false;
					return false;
				}
			}
		});

		if (all_inputs_back_to_original) {
			jQuery('.aiowps-actions').hide();
		} else {
			jQuery('.aiowps-actions').show();
		}
	});

	// Add click event listener to the button
	jQuery('.aiowps-actions :input').on('click', function() {
		// Hide the actions div
		jQuery('.aiowps-actions').hide();

		// Re-store the values
		store_values();
	});

	/**
	 * Initiates the download of a text file with the provided data and title.
	 *
	 * @param {string} data - The text data to be included in the file.
	 * @param {string} title - The name of the file to be downloaded.
	 */
	function aios_download_txt_file(data, title) {

		// Create a Blob containing the text data
		let blob = new Blob([data], { type: 'text/plain' });

		// Create a temporary URL to the Blob
		let url = window.URL.createObjectURL(blob);

		// Create a temporary <a> element to trigger the download
		let a = document.createElement('a');
		a.href = url;
		a.download = title;
		document.body.appendChild(a);
		a.click();

		// Cleanup: remove the temporary <a> element and revoke the Blob URL
		document.body.removeChild(a);
		window.URL.revokeObjectURL(url);
	}
	// Add click event listener to rules
	jQuery('.aiowps-rules li').on('click', function() {
		jQuery('.aiowps-rules li').removeClass('aiowps-active');
		jQuery(this).addClass('aiowps-active');
		var template = jQuery(this).data('template');
		jQuery('.aiowps-settings .postbox').hide();
		jQuery('.aiowps-settings .postbox').each(function() {
			if (jQuery(this).data('template') === template) {
				jQuery(this).show();
				return false;
			}
		});
		const url_params = new URLSearchParams(window.location.search);
		const subtab_param = 'subtab=' + template;

		if (url_params.has('subtab')) {
			// If subtab parameter already exists, replace its value
			url_params.set('subtab', template);
		} else {
			// If subtab parameter doesn't exist
			if ("" === url_params.toString()) {
				// If there are no existing parameters, append subtab with '?'
				window.history.replaceState({}, '', window.location.pathname + '?' + subtab_param);
				return;
			} else {
				// If there are existing parameters
				const query_params = Array.from(url_params.entries());
				const new_params = query_params.map(param => param.join('=')).join('&');
				window.history.replaceState({}, '', window.location.pathname + '?' + new_params + '&' + subtab_param);
				return;
			}
		}

		window.history.replaceState({}, '', window.location.pathname + '?' + url_params.toString());
	});

	// Search for rules
	jQuery('.aiowps-search').on('keydown', function(event) {
		if ('Enter' === event.key) {
			event.preventDefault();
		}
	});

	jQuery('.aiowps-search').on('keyup', function(event) {
		if ('Enter' === event.key) {
			event.preventDefault();
		}
		var value = jQuery(this).val().toLowerCase();
		jQuery('.aiowps-rules li').each(function() {
			var template_value = jQuery(this).data('template').toLowerCase();
			var span_text = jQuery(this).find('span').text().toLowerCase();
			var th_match = false;
			jQuery('.form-table th').each(function() {
				var th_text = jQuery(this).text().toLowerCase();
				if (th_text.indexOf(value) > -1) {
					var template = jQuery(this).closest('.postbox').data('template');
					if (template === template_value) {
						th_match = true;
						return false;
					}
				}
			});
			if (template_value.indexOf(value) > -1 || span_text.indexOf(value) > -1 || th_match) {
				jQuery(this).show();
			} else {
				jQuery(this).hide();
			}
		});
	});

	jQuery('#aiowps-rule-search .clear-search').on('click', function() {
		jQuery('.aiowps-search').val('');
		jQuery('.aiowps-search').trigger('keyup');
	});

	set_active_tab_from_url();
	// End of the new UI settings
});
