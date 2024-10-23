var wp_optimize = window.wp_optimize || {};

/**
 * Send an action via admin-ajax.php.
 *
 * @param {string}   action     The action to send
 * @param {[type]}   data       Data to send
 * @param {Function} callback   Will be called with the results
 * @param {boolean}  json_parse JSON parse the results
 * @param {object}   options    Optional extra options; current properties supported are 'timeout' (in milliseconds)
 *
 * @return {JSON}
 */
wp_optimize.send_command = function (action, data, callback, json_parse, options) {

	json_parse = ('undefined' === typeof json_parse) ? true : json_parse;

	if (!data) data = {};
	// If the command doesn't have the property, default to true
	if (!data.hasOwnProperty('include_ui_elements')) {
		data.include_ui_elements = true;
	}

	var ajax_data = {
		action: 'wp_optimize_ajax',
		subaction: action,
		nonce: wp_optimize_send_command_data.nonce,
		data: data
	};

	var args = {
		type: 'post',
		data: ajax_data,
		success: function (response) {
			if (json_parse) {
				try {
					var resp = wpo_parse_json(response);
				} catch (e) {
					console.log(e);
					console.log(response);
					alert(wpoptimize.error_unexpected_response);
					return;
				}
				// If result == false and and error code is provided, show the error and return.
				if (!resp.result && resp.hasOwnProperty('error_code') && resp.error_code) {
					wp_optimize.notices.show_notice(resp.error_code, resp.error_message);
					return;
				}
				if ('function' === typeof callback) callback(resp);
			} else {
				if (!response.result && response.hasOwnProperty('error_code') && response.error_code) {
					wp_optimize.notices.show_notice(response.error_code, response.error_message);
					return;
				}
				if ('function' === typeof callback) callback(response);
			}
		}
	};

	// Eventually merge options
	if ('object' === typeof options) {
		if (options.hasOwnProperty('timeout')) { args.timeout = options.timeout; }
		if (options.hasOwnProperty('error') && 'function' === typeof options.error) { args.error = options.error; }
	}

	return jQuery.ajax(ajaxurl, args);
};


/**
 * JS notices
 */
wp_optimize.notices = {
	errors: [],
	show_notice: function(error_code, error_message) {
		// WPO main page
		if (jQuery('#wp-optimize-wrap').length) {
			if (!this.notice) this.add_notice();
			this.notice.show();
			if (!this.errors[error_code]) {
				this.errors[error_code] = jQuery('<p/>').html(error_message).appendTo(this.notice).data('error_code', error_code);
			}
		// Post edit page
		} else if (window.wp && wp.hasOwnProperty('data')) {
			wp.data.dispatch('core/notices').createNotice(
				'error',
				'WP-Optimize: ' + error_message,
				{
					isDismissible: true
				}
			);
		// Other locations
		} else {
			alert('WP-Optimize: ' + error_message);
		}
	},
	add_notice: function() {
		this.notice_container = jQuery('<div class="wpo-main-error-notice"></div>').prependTo('#wp-optimize-wrap');
		this.notice = jQuery('<div class="notice notice-error wpo-notice is-dismissible"><button type="button" class="notice-dismiss"><span class="screen-reader-text">'+commonL10n.dismiss+'</span></button></div>');
		this.notice.appendTo(this.notice_container);
		this.notice.on('click', '.notice-dismiss', function(e) {
			this.notice.hide().find('p').remove();
			this.errors = [];
		}.bind(this));
	}
};

/**
 * Parse JSON string, including automatically detecting unwanted extra input and skipping it
 *
 * @param {string|object} json_mix_str - JSON string which need to parse and convert to object
 *
 * @throws SyntaxError|String (including passing on what JSON.parse may throw) if a parsing error occurs.
 *
 * @return mixed parsed JSON object. Will only return if parsing is successful (otherwise, will throw)
 */
function wpo_parse_json(json_mix_str) {
	// When using wp_send_json to return the value, the format is already parsed.
	if ('object' === typeof json_mix_str) return json_mix_str;

	// Just try it - i.e. the 'default' case where things work (which can include extra whitespace/line-feeds, and simple strings, etc.).
	try {
		var result = JSON.parse(json_mix_str);
		return result;
	} catch (e) {
		console.log("WPO: Exception when trying to parse JSON (1) - will attempt to fix/re-parse");
		console.log(json_mix_str);
	}

	var json_start_pos = json_mix_str.indexOf('{');
	var json_last_pos = json_mix_str.lastIndexOf('}');

	// Case where some php notice may be added after or before json string
	if (json_start_pos > -1 && json_last_pos > -1) {
		var json_str = json_mix_str.slice(json_start_pos, json_last_pos + 1);
		try {
			var parsed = JSON.parse(json_str);
			return parsed;
		} catch (e) {
			console.log("WPO: Exception when trying to parse JSON (2) - will attempt to fix/re-parse based upon bracket counting");

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
				// console.log('WPO: JSON re-parse successful');
				return parsed;
			} catch (e) {
				// Throw it again, so that our function works just like JSON.parse() in its behaviour.
				throw e;
			}

		}
	}

	throw "WPO: could not parse the JSON";

}
