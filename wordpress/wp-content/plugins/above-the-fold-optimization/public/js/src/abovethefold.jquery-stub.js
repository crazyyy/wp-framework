/**
 * jQuery Stub for async jquery loading and inline jQuery.ready capture.
 *
 * @package    abovethefold
 * @subpackage abovethefold/public
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

Abtf[CONFIG.LOAD_MODULE](function(window, Abtf, document, Object) {

    /**
     * jQuery already loaded
     */
    if (window.jQuery) {
        return;
    }

    /**
     * jQuery Ready Queue
     */
    var JQUERY_READY_QUEUE = [];
    var JQUERY_BIND_READY_QUEUE = [];
    var JQUERY_NOCONFLICT = false;

    // push to queue
    var pushQueue = function(handler, fn) {
        if (handler === "ready") {
            JQUERY_BIND_READY_QUEUE.push(fn);
        } else {
            JQUERY_READY_QUEUE.push(handler);
        }
    };

    // register noConflict
    var noConflict = function() {
        JQUERY_NOCONFLICT = true;
    };

    // Define an alias object 
    var JQUERY_ALIAS_OBJECT = {
        ready: pushQueue,
        bind: pushQueue
    };

    /**
     * jQuery Stub
     */
    window.$ = window.jQuery = function(handler) {
        if (handler === document || handler === undefined) {

            // Queue $(document).ready(handler), $().ready(handler)
            // and $(document).bind("ready", handler) by returning
            // an object with alias methods for pushQueue
            return JQUERY_ALIAS_OBJECT;
        } else {
            // Queue $(handler)
            pushQueue(handler);
        }
    }

    // noConflict()
    window.$.noConflict = window.jQuery.noConflict = noConflict;

    window.$.isStub = window.jQuery.isStub = true;

    /**
     * Object Watch Polyfill
     */
    // object.watch
    if (!Object.prototype.watch) {
        Object.defineProperty(Object.prototype, "watch", {
            enumerable: false,
            configurable: true,
            writable: false,
            value: function(prop, handler) {
                var
                    oldval = this[prop],
                    newval = oldval,
                    getter = function() {
                        return newval;
                    },
                    setter = function(val) {
                        oldval = newval;
                        return newval = handler.call(this, prop, oldval, val);
                    };

                if (delete this[prop]) { // can't watch constants
                    Object.defineProperty(this, prop, {
                        get: getter,
                        set: setter,
                        enumerable: true,
                        configurable: true
                    });
                }
            }
        });
    }

    // object.unwatch
    if (!Object.prototype.unwatch) {
        Object.defineProperty(Object.prototype, "unwatch", {
            enumerable: false,
            configurable: true,
            writable: false,
            value: function(prop) {
                var val = this[prop];
                delete this[prop]; // remove accessors
                this[prop] = val;
            }
        });
    }

    /**
     * Wait for jQuery
     */
    window.watch('jQuery', function(id, oldval, jQuery) {

        /**
         * Verify if valid jQuery
         */
        if (typeof jQuery !== 'function' || typeof jQuery.fn === 'undefined' || typeof jQuery.isStub !== 'undefined') {
            return jQuery;
        }

        /**
         * jQuery.noConflict()
         */
        if (JQUERY_NOCONFLICT) {
            jQuery.noConflict();

            if (ABTFDEBUG) {
                console.info('Abtf.jQuery.noConflict()');
            }
        }

        /**
         * jQuery.ready()
         */
        var readycount = 0;

        // process jQuery.ready queue
        jQuery.each(JQUERY_READY_QUEUE, function(index, handler) {
            jQuery(handler);
            readycount++;
        });

        // process jQuery.bind('ready') queue
        jQuery.each(JQUERY_BIND_READY_QUEUE, function(index, handler) {
            jQuery(document).bind('ready', handler);
            readycount++;
        });

        if (ABTFDEBUG) {
            if (readycount > 0) {
                console.info('Abtf.jQuery.ready()', readycount + ' callbacks');
            }
        }

        window.unwatch('jQuery');
        window['jQuery'] = jQuery;

        return jQuery;
    });

});