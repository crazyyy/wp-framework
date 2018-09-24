/**
 * loadScript
 *
 * @link https://github.com/walmartlabs/little-loader
 *
 * @package    abovethefold
 * @subpackage abovethefold/public
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

Abtf[CONFIG.LOAD_MODULE](function(window, Abtf) {

    // Global state.
    var pendingScripts = {};
    var scriptCounter = 0;

    /**
     * Insert script into the DOM
     *
     * @param {Object} script Script DOM object
     * @returns {void}
     */
    var _addScript = function(script) {

        // Get the first script element, we're just going to use it
        // as a reference for where to insert ours. Do NOT try to do
        // this just once at the top and then re-use the same script
        // as a reference later. Some weird loaders *remove* script
        // elements after the browser has executed their contents,
        // so the same reference might not have a parentNode later.
        var firstScript = document.getElementsByTagName("script")[0];

        // Append the script to the DOM, triggering execution.
        firstScript.parentNode.insertBefore(script, firstScript);
    };

    // mark loadScript injections
    Abtf[CONFIG.LOAD_SCRIPT_MARK] = false;

    Abtf[CONFIG.LOAD_SCRIPT] = function(src, callback) {

        var script = document.createElement("script");

        if (Abtf[CONFIG.LOAD_SCRIPT_MARK]) {

            // mark Above The Fold
            script.setAttribute('data-abtf', '');
        }

        var done = false;
        var err;
        var _cleanup; // _must_ be set below.

        /**
         * Final handler for error or completion.
         *
         * **Note**: Will only be called _once_.
         *
         * @returns {void}
         */
        var _finish = function() {

            // Only call once.
            if (done) {
                return;
            }
            done = true;

            // Internal cleanup.
            _cleanup();

            // Callback.
            if (callback) {
                callback(err);
            }
        };

        /**
         * Error handler
         *
         * @returns {void}
         */
        var _error = function() {
            err = new Error(src || "EMPTY");
            _finish();
        };

        if (script.readyState && !("async" in script)) {

            /*eslint-disable consistent-return*/

            // This section is only for IE<10. Some other old browsers may
            // satisfy the above condition and enter this branch, but we don't
            // support those browsers anyway.

            var id = scriptCounter++;
            var isReady = {
                loaded: true,
                complete: true
            };
            var inserted = false;

            // Clear out listeners, state.
            _cleanup = function() {
                script.onreadystatechange = script.onerror = null;
                pendingScripts[id] = void 0;
            };

            // Attach the handler before setting src, otherwise we might
            // miss events (consider that IE could fire them synchronously
            // upon setting src, for example).
            script.onreadystatechange = function() {
                var firstState = script.readyState;

                // Protect against any errors from state change randomness.
                if (err) {
                    return;
                }

                if (!inserted && isReady[firstState]) {
                    inserted = true;

                    // Append to DOM.
                    _addScript(script);
                }

                // --------------------------------------------------------------------
                //                       GLORIOUS IE8 HACKAGE!!!
                // --------------------------------------------------------------------
                //
                // Oh IE8, how you disappoint. IE8 won't call `script.onerror`, so
                // we have to resort to drastic measures.
                // See, e.g. http://www.quirksmode.org/dom/events/error.html#t02
                //
                // As with all things development, there's a Stack Overflow comment that
                // asserts the following combinations of state changes in IE8 indicate a
                // script load error. And crazily, it seems to work!
                //
                // http://stackoverflow.com/a/18840568/741892
                //
                // The `script.readyState` transitions we're interested are:
                //
                // * If state starts as `loaded`
                // * Call `script.children`, which _should_ change state to `complete`
                // * If state is now `loading`, then **we have a load error**
                //
                // For the reader's amusement, here is HeadJS's catalog of various
                // `readyState` transitions in normal operation for IE:
                // https://github.com/headjs/headjs/blob/master/src/2.0.0/load.js#L379-L419
                if (firstState === "loaded") {
                    // The act of accessing the property should change the script's
                    // `readyState`.
                    //
                    // And, oh yeah, this hack is so hacky-ish we need the following
                    // eslint disable...
                    /*eslint-disable no-unused-expressions*/
                    script.children;
                    /*eslint-enable no-unused-expressions*/

                    if (script.readyState === "loading") {
                        // State transitions indicate we've hit the load error.
                        //
                        // **Note**: We are not intending to _return_ a value, just have
                        // a shorter short-circuit code path here.
                        return _error();
                    }
                }

                // It's possible for readyState to be "complete" immediately
                // after we insert (and execute) the script in the branch
                // above. So check readyState again here and react without
                // waiting for another onreadystatechange.
                if (script.readyState === "complete") {
                    _finish();
                }
            };

            // Onerror handler _may_ work here.
            script.onerror = _error;

            // Since we're not appending the script to the DOM yet, the
            // reference to our script element might get garbage collected
            // when this function ends, without onreadystatechange ever being
            // fired. This has been witnessed to happen. Adding it to
            // `pendingScripts` ensures this can't happen.
            pendingScripts[id] = script;

            // This triggers a request for the script, but its contents won't
            // be executed until we append it to the DOM.
            script.src = src;

            // In some cases, the readyState is already "loaded" immediately
            // after setting src. It's a lie! Don't append to the DOM until
            // the onreadystatechange event says so.


        } else {

            // This section is for modern browsers, including IE10+.

            // Clear out listeners.
            _cleanup = function() {
                script.onload = script.onerror = null;
            };

            script.onerror = _error;
            script.onload = _finish;
            script.async = true;
            script.charset = "utf-8";

            script.src = src;

            // Append to DOM.
            _addScript(script);
        }
    };

});