/**
 * loadCSS (installed from bower module)
 *
 * @link https://github.com/filamentgroup/loadCSS/
 *
 * @package    abovethefold
 * @subpackage abovethefold/public
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

Abtf[CONFIG.LOAD_MODULE](function(window, Abtf) {

    var lastSheet; // last inserted sheet

    // start loadCSS
    var LOADCSS = function(href, media, callback) {

        // target for inserting CSS
        if (lastSheet) {
            var target = lastSheet.nextSibling;
        } else {
            var target = document.getElementById('AbtfCSS').nextSibling;
        }

        lastSheet = window.loadCSS(href, target, media, function() {
            if (ABTFDEBUG) {
                console.info('Abtf.css() ➤ loadCSS() render', Abtf[CONFIG.LOCALURL](href));
            }
            if (callback) {
                callback();
            }
        });
    }

    // queue 
    var LOADCSS_QUEUE = [];
    var LOADCSS_QUEUE_RUNNING;

    // process queue
    var PROCESS_QUEUE = function() {

        if (LOADCSS_QUEUE_RUNNING) {
            return;
        }
        LOADCSS_QUEUE_RUNNING = true;

        var sheet = LOADCSS_QUEUE.shift();
        while (sheet) {
            LOADCSS.apply(window, sheet);
            sheet = LOADCSS_QUEUE.shift();
        }
        LOADCSS_QUEUE_RUNNING = false;

        CRITICAL_CSS_READY = true;
    }

    // wait for critical CSS element to be available
    var RETRY_ATTEMPTS = 0;
    var RETRY_TIMEOUT;

    var CRITICAL_CSS_READY = false;
    var WAIT_FOR_CRITICAL_CSS = function(href, media, callback) {
        if (CRITICAL_CSS_READY) {
            LOADCSS(href, media, callback);
        } else {

            // critical CSS element not yet available, wait for it
            if (!document.getElementById('AbtfCSS')) {

                // add to queue
                LOADCSS_QUEUE.push([href, media, callback]);
                if (!RETRY_TIMEOUT) {

                    // retry callback
                    var retry = function() {
                        if (RETRY_ATTEMPTS > 100) {
                            if (ABTFDEBUG) {
                                console.error('Abtf.fonts()', 'async CSS reference <style id="AbtfCSS"> not found');
                            }
                            return;
                        }
                        RETRY_ATTEMPTS++;
                        if (!document.getElementById('AbtfCSS')) {
                            RETRY_TIMEOUT = setTimeout(retry, 0);
                        } else {
                            PROCESS_QUEUE();
                        }
                    }
                    RETRY_TIMEOUT = setTimeout(retry, 0);
                }
            } else {
                if (RETRY_TIMEOUT) {
                    clearTimeout(RETRY_TIMEOUT);
                }

                // elements pending in queue
                if (LOADCSS_QUEUE.length > 0) {
                    LOADCSS_QUEUE.push([href, media, callback]);
                    PROCESS_QUEUE();
                } else {
                    LOADCSS(href, media, callback);
                    CRITICAL_CSS_READY = true;
                }
            }
        }
    }

    Abtf[CONFIG.LOADCSS] = (typeof window.loadCSS !== 'undefined') ? function(href, media, callback) {

        if (ABTFDEBUG) {
            console.info('Abtf.css() ➤ loadCSS() async download start', Abtf[CONFIG.LOCALURL](href));
        }

        // wait for <style id="AbtfCSS"> target (insert sheets after critical CSS)
        WAIT_FOR_CRITICAL_CSS(href, media, callback);

    } : function() {};

});