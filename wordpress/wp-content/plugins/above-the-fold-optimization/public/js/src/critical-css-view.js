/**
 * Critical CSS Quality Test View
 *
 * @package    abovethefold
 * @subpackage abovethefold/public
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

(function(w) {

    // Create IE + others compatible event handler
    var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
    var eventer = window[eventMethod];
    var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";

    // Listen to message from child window
    eventer(messageEvent, function(e) {
        if (e.data && e.data.action) {

            if (!document.getElementById('AbtfCSS')) {
                alert('Error: Critical CSS <style> element not found.');
                return;
            }

            switch (e.data.action) {
                case "extract":
                    var type = e.data.type;
                    switch (type) {
                        case "critical-css":
                            window.extractCriticalCSS(function(css) {

                                parent.postMessage({
                                    "action": "critical-css",
                                    "css": css
                                }, "*");
                            });
                            break;
                        case "full-css":
                            window.extractFullCSS();
                            break;
                    }
                    break;
                case "set":

                    var style = document.getElementById('AbtfCSS');
                    if (style.styleSheet) {
                        style.styleSheet.cssText = e.data.css;
                    } else {
                        style.innerHTML = '';
                        style.appendChild(document.createTextNode(e.data.css));
                    }
                    break;
                case "get":

                    var css;
                    var style = document.getElementById('AbtfCSS');
                    if (style.styleSheet) {
                        css = style.styleSheet.cssText;
                    } else {
                        css = style.innerHTML; /// style.appendChild(document.createTextNode(css));
                    }

                    parent.postMessage({
                        "action": "critical-css",
                        "css": css
                    }, "*");
                    break;
            }
        }
    }, false);

})(window, document);