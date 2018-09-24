/**
 * loadCSS (v1.2.0) improved with requestAnimationFrame following Google guidelines.
 *
 * @link https://github.com/filamentgroup/loadCSS/
 * @link https://developers.google.com/speed/docs/insights/OptimizeCSSDelivery
 *
 * @package    abovethefold
 * @subpackage abovethefold/public
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

Abtf[CONFIG.LOAD_MODULE](function(window, Abtf) {

    var doc = window.document;
    var criticalCSSElement;

    Abtf[CONFIG.LOADCSS] = function(href, media, callback) {

        if (ABTFDEBUG) {
            console.info('Abtf.css() ➤ loadCSS()[RAF] async download start', Abtf[CONFIG.LOCALURL](href));
        }

        // Arguments explained:
        // `href` [REQUIRED] is the URL for your CSS file.
        // `before` [OPTIONAL] is the element the script should use as a reference for injecting our stylesheet <link> before
        // By default, loadCSS attempts to inject the link after the last stylesheet or script in the DOM. However, you might desire a more specific location in your document.
        // `media` [OPTIONAL] is the media type or query of the stylesheet. By default it will be 'all'
        var el = doc.createElement("link");

        // detect critical css element
        if (!criticalCSSElement && criticalCSSElement !== false) {
            criticalCSSElement = document.getElementById('AbtfCSS');
            if (!criticalCSSElement) {
                criticalCSSElement = false;
            }
        }
        if (criticalCSSElement) {
            var ref = criticalCSSElement;
        } else {
            var refs = (doc.body || doc.getElementsByTagName("head")[0]).childNodes;
            ref = refs[refs.length - 1];
        }

        var sheets = doc.styleSheets;
        el.rel = "stylesheet";
        el.href = href;
        // temporarily set media to something inapplicable to ensure it'll fetch without blocking render
        el.media = "only x";

        // wait until body is defined before injecting link. This ensures a non-blocking load in IE11.
        function ready(cb) {
            if (doc.body) {
                return cb();
            }
            setTimeout(function() {
                ready(cb);
            });
        }

        /**
         * CSS rendered flag
         */
        var CSSrendered = false;

        // A method (exposed on return object for external use) that mimics onload by polling until document.styleSheets until it includes the new sheet.
        var onloadcss_fallback = function(cb) {

            if (CSSrendered) {
                return;
            }

            var resolvedHref = el.href;
            var i = sheets.length;
            while (i--) {
                if (CSSrendered) {
                    break;
                }
                if (sheets[i].href === resolvedHref) {
                    return cb();
                }
            }
            setTimeout(function() {
                onloadcss_fallback(cb);
            });
        };

        /**
         * Render CSS when file is loaded
         */
        function renderCSS() {

            // already rendered?
            if (CSSrendered) {
                return;
            }
            CSSrendered = true;

            if (el.addEventListener) {
                el.removeEventListener("load", renderCSS);
            }

            function render() {

                /**
                 * Use animation frame to paint CSS
                 *
                 * @link https://developers.google.com/speed/docs/insights/OptimizeCSSDelivery
                 */
                Abtf[CONFIG.RAF](function() {

                    el.media = media || "all";
                    if (ABTFDEBUG) {
                        console.info('Abtf.css() ➤ loadCSS()[RAF] render', Abtf[CONFIG.LOCALURL](href));
                    }

                    /**
                     * Callback on completion
                     */
                    if (callback) {
                        callback();
                    }
                });
            }

            if (typeof Abtf[CONFIG.CSS_DELAY] !== 'undefined' && parseInt(Abtf[CONFIG.CSS_DELAY]) > 0) {

                if (ABTFDEBUG) {
                    console.info('Abtf.css() ➤ loadCSS()[RAF] render delay', Abtf[CONFIG.CSS_DELAY], Abtf[CONFIG.LOCALURL](href));
                }

                /**
                 * Delayed rendering
                 */
                setTimeout(render, Abtf[CONFIG.CSS_DELAY]);
            } else {
                render();
            }
        }

        // once loaded, set link's media back to `all` so that the stylesheet applies once it loads
        if (el.addEventListener) {
            el.addEventListener("load", renderCSS);
        } else {
            el.onload = renderCSS;
        }

        // Inject link
        // Note: the ternary preserves the existing behavior of "before" argument, but we could choose to change the argument to "after" in a later release and standardize on ref.nextSibling for all refs
        // Note: `insertBefore` is used instead of `appendChild`, for safety re: http://www.paulirish.com/2011/surefire-dom-element-insertion/
        ready(function() {

            ref.parentNode.insertBefore(el, ref.nextSibling);

            onloadcss_fallback(renderCSS);
        });

        return el;

    };

});