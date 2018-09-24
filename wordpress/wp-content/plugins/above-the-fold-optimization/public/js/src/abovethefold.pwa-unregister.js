/**
 * Unregister Google PWA Service Worker
 *
 * @package    abovethefold
 * @subpackage abovethefold/public
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

Abtf[CONFIG.LOAD_MODULE](function(window, Abtf) {


    // test availability of serviceWorker
    if (!('serviceWorker' in window.navigator)) {
        return;
    }

    // functionality is disabled, this script should not be loaded
    if (!Abtf[CONFIG.PWA_UNREGISTER]) {
        return;
    }

    var UNREGISTER = function() {
        try {
            navigator.serviceWorker.getRegistrations().then(function(registrations) {

                console.warn(registrations);
                if (registrations) {
                    registrations.forEach(function(registration) {
                        if (typeof registration.unregister === 'function') {

                            // verify script url
                            if (registration.active && registration.active.scriptURL) {
                                if (!registration.active.scriptURL.match(/abtf-pwa/)) {
                                    return;
                                }
                            }

                            if (ABTFDEBUG) {
                                console.warn('Abtf.pwa() ➤ unregister Service Worker', registration);
                            }
                            registration.unregister();
                        }
                    });
                }
            });
        } catch (e) {

        }
    }

    window.addEventListener('load', function() {
        if (Abtf[CONFIG.IDLE]) {
            Abtf[CONFIG.IDLE](UNREGISTER);
        } else {
            UNREGISTER();
        }
    });

});