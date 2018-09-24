/**
 * Load CSS asynchronicly
 *
 * @link https://developers.google.com/speed/docs/insights/OptimizeCSSDelivery
 *
 * @package    abovethefold
 * @subpackage abovethefold/public
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

Abtf[CONFIG.LOAD_MODULE](function(window, Abtf) {

    // Wait for Critical CSS <style>
    var retrycount = 0;
    var retrydelay = 1;

    var timeset = false;

    Abtf[CONFIG.LOAD_CSS] = function() {

        var m;
        var files = Abtf[CONFIG.CSS];

        if (!files) {
            return;
        }

        if (typeof files !== 'object') {
            if (ABTFDEBUG) {
                console.error('Abtf.css()', 'output buffer failed to apply CSS optimization');
            }
            return;
        }

        if (ABTFDEBUG) {
            console.log('Abtf.css()', files);
        }

        // target for inserting CSS
        var target = (document.getElementById('AbtfCSS')) ? document.getElementById('AbtfCSS').nextSibling : false;

        for (i in files) {
            if (!files.hasOwnProperty(i) || typeof files[i] !== 'object') {
                if (ABTFDEBUG) {
                    console.error('Abtf.css()', 'Invalid CSS file configuration', i, files);
                }
                continue;
            }
            m = files[i][0].join(',');
            Abtf[CONFIG.LOADCSS](files[i][1], m);
        }
    };

});