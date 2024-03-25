var WP_Optimize_Heartbeat_Agents = {};

/**
 * Attach to WordPress heartbeat API. Has a fallback method if core API is disabled
 *
 * @returns {object} WP_Optimize_Heartbeat exports
 */
var WP_Optimize_Heartbeat = function () {
	var $ = jQuery;
	var agent_idle_ttl_in_seconds = 60; // retry after 60 seconds without a response
	var wpo_fallback;

	/**
	 * Generate a unique ID to be used as agents IDs
	 *
	 * @returns {string}
	 */
	var guid = function() {
		var s4 = function() {
			return Math.floor((1 + Math.random()) * 0x10000)
				.toString(16)
				.substring(1);
		}
		//return id of format 'aaaaaaaa'-'aaaa'-'aaaa'-'aaaa'-'aaaaaaaaaaaa'
		return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
	}

	/**
	 * Configure the heartbeat events, if heartbeat API is missing, setup fallback
	 *
	 * @returns {void}
	 */
	function setup() {
		$(document).on('heartbeat-send', function(event, data) {
			for(var uid in WP_Optimize_Heartbeat_Agents) {
				if (!WP_Optimize_Heartbeat_Agents[uid].sent) {
					data[uid] = WP_Optimize_Heartbeat_Agents[uid].command;

					WP_Optimize_Heartbeat_Agents[uid].sent = true;
				}

				// Retry after idle time is passed (no response in X seconds)
				var seconds = ((new Date()).getTime() - WP_Optimize_Heartbeat_Agents[uid].sent_time.getTime()) / 1000;
				if (seconds > agent_idle_ttl_in_seconds) {
					WP_Optimize_Heartbeat_Agents[uid].sent = false;
				}
			}
		});

		$(document).on('heartbeat-tick', function(event, data) {
			if ('object' == typeof(data.callbacks)) {
				for(var uid in data.callbacks) {
					if (is_wpo_heartbeat(uid)) {
						var response = JSON.parse(data.callbacks[uid]);

						if ('undefined' != typeof(response.result) && false == response.result) {
							wp_optimize.notices.show_notice(response.error_code, response.error_message);
						} else {
							WP_Optimize_Heartbeat_Agents[uid].callback(response);
						}

						delete WP_Optimize_Heartbeat_Agents[uid];
					}
				}
			}
		});

		if (is_heartbeat_api_disabled()) {
			wpo_fallback = WP_Optimize_Heartbeat_Fallback();
		}
	}
	
	/**
	 * Check if heartbeat action is a WP-Optimize action or something else that we should ignore
	 *
	 * @param {string} uid The UID of the agent
	 * @returns {bool}
	 */
	function is_wpo_heartbeat(uid) {
		return 0 === uid.indexOf('wpo-heartbeat-');
	}

	/**
	 * Check if native heartbeat API is available
	 *
	 * @returns {bool}
	 */
	function is_heartbeat_api_disabled() {
		return 'undefined' == typeof(wp.heartbeat);
	}

	/**
	 * Filter function to check if an agent is already scheduled
	 *
	 * @param {object} agent1 First comparison agent, usually already scheduled agents
	 * @param {object} agent2 Second comparison agent, usually the one you are trying to check if it already exists
	 * @returns {bool}
	 */
	function do_agents_match(agent1, agent2) {
		var command_matches = agent1.command === agent2.command;
		var command_not_sent_yet = false === agent1.sent;
		
		return command_matches && command_not_sent_yet;
	}

	/**
	 * Add a heartbeat agent that will be sent to backend and has a callback to receive the response
	 *
	 * @param {object} data Expected an object like {command: string}
	 * @returns {string|null}
	 */
	function add_agent(data) {
		var already_scheduled = Object.values(WP_Optimize_Heartbeat_Agents).some(function(agent) { return do_agents_match(agent, data); });
		if (already_scheduled) {
			return null;
		}
		
		var agent_id = 'wpo-heartbeat-' + guid();
		data.sent = false;
		data.sent_time = new Date();
		WP_Optimize_Heartbeat_Agents[agent_id] = data;
		return agent_id;
	}

	/**
	 * Remove agent from list
	 *
	 * @param {string} agent_id The id of the agent to be removed
	 * @returns {void}
	 */
	function cancel_agent(agent_id) {
		delete WP_Optimize_Heartbeat_Agents[agent_id];
	}

	return {
		setup: setup,
		add_agent: add_agent,
		cancel_agent: cancel_agent
	};
}

/**
 * Fallback for the heartbeat api
 *
 * @returns {object} WP_Optimize_Heartbeat_Fallback exports
 */
var WP_Optimize_Heartbeat_Fallback = function() {
	var timeout_handler;

	var payload = {
		"data":{},
		"interval":wpo_heartbeat_ajax.interval,
		"_nonce":wpo_heartbeat_ajax.nonce,
		"action":"heartbeat",
		"screen_id":window.pagenow,
		"has_focus":false
	};

	/**
	 * Actually trigger the standard AJAX call to run a heartbeat event
	 *
	 * @param {int} interval How many seconds until next heartbeat
	 * @returns {void}
	 */
	function do_heartbeat(interval) {
		var this_payload = Object.assign({}, payload);
		var data = {};

		jQuery(document).trigger('heartbeat-send', data);

		this_payload.data = data;

		jQuery.ajax({
			type : "post",
			dataType : "json",
			url : wpo_heartbeat_ajax.ajaxurl,
			data : this_payload,
			success: function(response) {
				if('undefined' != typeof(response.callbacks)) {
					jQuery(document).trigger('heartbeat-tick', response);
				}
			}
		});

		timeout_handler = setTimeout(do_heartbeat, interval * 1000, interval);
	}

	timeout_handler = setTimeout(do_heartbeat, payload.interval * 1000, payload.interval);
}