(function() {
	var is_handling = false;

	/**
	 * Handles the loading of a single script element. If the script element has a `data-type`
	 * attribute, it updates the script type accordingly. If the script element has a `data-src`
	 * attribute, it updates the source and attempts to load it.
	 *
	 * @param {HTMLElement} script_element
	 * @returns {Promise}
	 */
	function handle_script_element(script_element) {
		// If 'data-type' is defined, update the script element's type
		update_script_element_type(script_element);

		// If 'data-src' is defined, update the script's source and load it
		return update_script_element_src(script_element);
	}

	/**
	 * Recursively loads script elements one by one. Once a script is successfully loaded,
	 * the next script in the array is loaded. If all scripts are loaded, the function resolves,
	 * otherwise, it rejects on the first error encountered.
	 *
	 * @param {number} index - The current index of the script element being processed.
	 * @param {Array<HTMLElement>} script_elements - An array of script elements to be loaded.
	 * @param {function} resolve - A function to call when all scripts have been successfully loaded.
	 * @param {function} reject - A function to call if an error occurs during loading of any script.
	 */
	function load_next_script(index, script_elements, resolve, reject) {

		if (index < script_elements.length) {
			handle_script_element(script_elements[index])
				.then(function() {
					load_next_script(index + 1, script_elements, resolve, reject);
				})
				.catch(function() {
					load_next_script(index + 1, script_elements, resolve, reject);
				});
		} else {
			all_scripts_loaded();
			resolve();
		}

	}

	/**
	 * For the given list of script elements with type="text/plain", replace the current script element
	 * with the appropriate type or replace the src attribute with the data-src value for externally loaded scripts.
	 *
	 * @param {Array} script_elements
	 * @returns {Promise}
	 */
	function load_scripts_sequentially(script_elements) {
		// Wrap everything in a Promise to handle asynchronous loading
		return new Promise(function(resolve, reject) {
			load_next_script(0, script_elements, resolve, reject);
		});
	}

	/**
	 * Replaces the current script element with a new one, setting the type attribute to the value of data-type.
	 *
	 * @param {HTMLElement} script_element
	 */
	function update_script_element_type(script_element) {
		const data_type = script_element.getAttribute('data-type');
		const no_delay_js = script_element.hasAttribute('data-no-delay-js');

		if (!data_type || no_delay_js) return;
		
		script_element.type = data_type;
		script_element.removeAttribute('data-type');

		const new_script = script_element.cloneNode(true);

		// Replace the original script tag with the new one
		// We use replaceChild to exclude script running
		script_element.parentNode.replaceChild(new_script, script_element);
	}

	/**
	 * Updates the `src` attribute of a script element and removes its `data-src` attribute.
	 * Returns a promise that resolves when the script is successfully loaded or rejects if the script fails to load.
	 *
	 * @param {HTMLElement} script_element
	 * @returns {Promise}
	 */
	function update_script_element_src(script_element) {
		return new Promise(function(resolve, reject) {
			const no_delay_js = script_element.hasAttribute('data-no-delay-js');
			const data_src = script_element.getAttribute('data-src');

			// If there's no 'data-src', resolve the promise immediately
			if (!data_src || no_delay_js) {
				return resolve();
			}

			script_element.src = data_src;
			script_element.removeAttribute('data-src');

			// Event listener for script load completion
			script_element.onload = resolve;
			script_element.onerror = reject;
		});
	}


	/**
	 * Called when all delayed scripts have loaded. Triggers DOMContentLoaded and load events to run their handlers in delayed scripts.
	 */
	function all_scripts_loaded() {
		window.wpo_delayed_scripts_loaded = true;

		var event = new Event('DOMContentLoaded');
		document.dispatchEvent(event);
		// Create a new load event
		event = new Event('load');
		// Dispatch the load event on the window
		window.dispatchEvent(event);
	}

	/**
	 * List of events to trigger delayed script loading.
	 *
	 * @return {string[]}
	 */
	function get_event_list() {
		return [
			'scroll',
			'mousemove',
			'mouseover',
			'resize',
			'touchstart',
			'touchmove',
		];
	}

	/**
	 * Adds event listeners to trigger delayed script loading on user interaction.
	 */
	function attach_event_listeners() {
		get_event_list().forEach(function (event) {
			window.addEventListener(event, handle_delay_js);
		});
	}

	/**
	 * Removes event listeners that were added to trigger delayed script loading.
	 */
	function remove_event_listeners() {
		get_event_list().forEach(function (event) {
			window.removeEventListener(event, handle_delay_js);
		});
	}

	/**
	 * Get all script elements and load them if their loading was delayed."
	 *
	 * @return {void}
	 */
	function handle_delay_js() {

		if (is_handling) return;

		is_handling = true;

		// Remove all event listeners after the first call
		remove_event_listeners();

		const script_elements = document.querySelectorAll('script');

		load_scripts_sequentially(script_elements);
	}

	// Attach events on any manipulation with the page
	document.addEventListener('DOMContentLoaded', function () {
		if (!window.wpo_delayed_scripts_loaded) {
			attach_event_listeners();
		}
	});
})();
