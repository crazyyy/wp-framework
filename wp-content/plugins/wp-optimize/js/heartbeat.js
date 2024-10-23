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
	var _setup = false;

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
		if (false === _setup) {
			_setup = true;
			
			$(document).on('heartbeat-send', function(event, data) {
				for(var uid in WP_Optimize_Heartbeat_Agents) {
					var agent = WP_Optimize_Heartbeat_Agents[uid];

					if (!agent.sent) {
						if ('command_data' in agent) {
							data[uid] = {};
							data[uid][agent.command] = agent.command_data;
						} else {
							data[uid] = agent.command;
						}

						agent.sent_time = new Date().getTime();
						agent.sent = true;
					}

					// Retry after idle time is passed (no response in X seconds)
					var seconds = ((new Date()).getTime() - agent.sent_time) / 1000;
					if (seconds > agent_idle_ttl_in_seconds) {
						agent.sent = false;
					}
				}
			});

			$(document).on('heartbeat-tick', function(event, data) {
				if ('object' == typeof(data.callbacks)) {
					for(var uid in data.callbacks) {
						if (is_wpo_heartbeat(uid)) {
							var response;
							try {
								response = JSON.parse(data.callbacks[uid]);
							} catch(e) {
								response = data.callbacks[uid];
							}

							if ('undefined' != typeof(response.result) && false === response.result && ('undefined' == typeof(response.skip_notice) || false === response.skip_notice)) {
								wp_optimize.notices.show_notice(response.error_code, response.error_message);
							} else {
								if ('undefined' !== typeof(WP_Optimize_Heartbeat_Agents[uid]) && WP_Optimize_Heartbeat_Agents[uid].callback instanceof Function) {
									WP_Optimize_Heartbeat_Agents[uid].callback(response);
								}
							}

							if ('undefined' !== typeof WP_Optimize_Heartbeat_Agents[uid]) {
								delete WP_Optimize_Heartbeat_Agents[uid];
							}
						}
					}
				}
			});

			if (is_heartbeat_api_disabled()) {
				wpo_fallback = WP_Optimize_Heartbeat_Fallback();
			} else {
				// Some agents send `_wait:false` because the UI needs to execute that action quickly, `disableSuspend` allows for `connectNow` to trigger a heartbeat instantly
				wp.heartbeat.disableSuspend();
			}
		}
	}
	
	/**
	 * Cancel a group of agents all at once
	 *
	 * @param {array} agents_ids The list of agent ids to cancel
	 */
	function cancel_agents(agents_ids) {
		while(agent_id = agents_ids.shift()) {
			cancel_agent(agent_id);
		}
	}
	
	/**
	 * Check if heartbeat action is a WP-Optimize action or something else that we should ignore
	 *
	 * @param {string} uid The UID of the agent
	 * @returns {boolean}
	 */
	function is_wpo_heartbeat(uid) {
		return 0 === uid.indexOf('wpo-heartbeat-');
	}

	/**
	 * Check if native heartbeat API is available
	 *
	 * @returns {boolean}
	 */
	function is_heartbeat_api_disabled() {
		return 'undefined' === typeof(wp.heartbeat);
	}

	/**
	 * Filter function to check if an agent is already scheduled
	 *
	 * @param {object} agent1 First comparison agent, usually already scheduled agents
	 * @param {object} agent2 Second comparison agent, usually the one you are trying to check if it already exists
	 * @returns {boolean}
	 */
	function do_agents_match(agent1, agent2) {
		var command_matches = agent1.command === agent2.command;
		var subaction1 = agent1.command_data && agent1.command_data.subaction ? agent1.command_data.subaction : undefined;
		var subaction2 = agent2.command_data && agent2.command_data.subaction ? agent2.command_data.subaction : undefined;
		var subaction_matches = subaction1 === subaction2;
		var command_not_sent_yet = false === agent1.sent;
		
		return command_matches && subaction_matches && command_not_sent_yet;
	}

	/**
	 * Add a heartbeat agent that will be sent to backend and has a callback to receive the response
	 *
	 * @param {object} data Expected an object like {command: string}. Commands will be treated as `data._unique:true` by default. Some commands may need permission to schedule multiple times, by sending `_unique:false`
	 * @returns {string|null}
	 */
	function add_agent(data) {
		var already_scheduled = Object.values(WP_Optimize_Heartbeat_Agents).some(function(agent) { return do_agents_match(agent, data); });
		if (already_scheduled && ('undefined' == typeof(data._unique) || (true == data._unique))) {
			return null;
		}
		
		var agent_id = 'wpo-heartbeat-' + guid();
		data.sent = false;
		WP_Optimize_Heartbeat_Agents[agent_id] = data;

		if ('undefined' !== typeof(data._wait) && false === data._wait) {
			trigger_heartbeat();
		}

		return agent_id;
	}

	/**
	 * Trigger a heartbeat by code
	 *
	 * @returns {void}
	 */
	function trigger_heartbeat() {
		if (is_heartbeat_api_disabled()) {
			wpo_fallback.do_heartbeat();
		} else {
			setTimeout(function() { wp.heartbeat.connectNow(); }, 50);
		}
	}

	/**
	 * Remove agent from list if `_keep:false`. Defaults to `true`, not cancel
	 * A method called cancel_agents that by default does not cancel anything is controversial,
	 * but in practice only things like informational requests can be really cancelled,
	 * otherwise you get strange inconsistent results when things get wiped out and callbacks are not being called.
	 *
	 * @param {string} agent_id The id of the agent to be removed
	 * @returns {void}
	 */
	function cancel_agent(agent_id) {
		var agent = WP_Optimize_Heartbeat_Agents[agent_id];
		if('undefined' != typeof(agent)) {
			if ('undefined' != typeof(agent._keep) && (false == agent._keep)) {
				delete WP_Optimize_Heartbeat_Agents[agent_id];
			}
		}
	}

	return {
		setup: setup,
		add_agent: add_agent,
		cancel_agents: cancel_agents,
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
		interval = 'undefined' == typeof(interval) ? payload.interval : interval;

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

		if (timeout_handler) {
			clearTimeout(timeout_handler);
		}

		timeout_handler = setTimeout(do_heartbeat, interval * 1000, interval);
	}

	timeout_handler = setTimeout(do_heartbeat, payload.interval * 1000, payload.interval);

	return {
		do_heartbeat: do_heartbeat
	};
}