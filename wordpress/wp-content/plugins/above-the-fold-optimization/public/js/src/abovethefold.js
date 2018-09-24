/**
 * Above the fold optimization Javascript
 *
 * This javascript handles the CSS delivery optimization.
 *
 * @package    abovethefold
 * @subpackage abovethefold/public
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */
(function(window, Abtf, undefined) {

    if (ABTFDEBUG) {
        console.warn('Abtf', 'debug notices visible to admin only');
    };

    /**
     * DomReady
     */
    Abtf[CONFIG.DOMREADY] = function(a, b, c) {
        b = document;
        c = 'addEventListener';
        b[c] ? b[c]('DOMContentLoaded', a) : window.attachEvent('onload', a);
    };

    // init Above the fold optimization client
    var MODULE_QUEUE = [];
    var CORE_MODULE_LOADED;
    Abtf[CONFIG.LOAD_MODULE] = function(factory, core) {
        if (!CORE_MODULE_LOADED && !core) {
            MODULE_QUEUE.push(factory);
        } else {
            factory(window, window.Abtf, window.document, Object);
            if (core === true) {
                if (MODULE_QUEUE.length > 0) {
                    var module = MODULE_QUEUE.shift();
                    while (module) {
                        Abtf[CONFIG.LOAD_MODULE](module, 1);
                        module = MODULE_QUEUE.shift();
                    }
                }
                CORE_MODULE_LOADED = true;

                // load queued header init
                if (HEADER_LOAD_QUEUED) {
                    Abtf[CONFIG.HEADER]();
                }
            }
        }
    };

    // Core factory 
    var CoreModule = function(window, Abtf) {

        // requestAnimationFrame
        var raf = (window.requestAnimationFrame ||
            window.webkitRequestAnimationFrame ||
            window.mozRequestAnimationFrame ||
            window.msRequestAnimationFrame ||
            function(callback) {
                window.setTimeout(callback, 1000 / 60);
            });
        Abtf[CONFIG.RAF] = function() {
            raf.apply(window, arguments);
        };

        // requestIdleCallback, run tasks in CPU idle time
        var id = (window.requestIdleCallback) ? window.requestIdleCallback : false;
        Abtf[CONFIG.IDLE] = (id) ? function() {
            id.apply(window, arguments);
        } : false;

        if (Abtf[CONFIG.GWF]) {
            var GWF_CONFIG = Abtf[CONFIG.GWF];
        }

        // load Google WebFonts
        var LOAD_GWF = function() {
            if (GWF_CONFIG[CONFIG.GWF_ASYNC]) {
                Abtf[CONFIG.ASYNC](GWF_CONFIG[CONFIG.GWF_ASYNC_URL], 'webfont');

                if (ABTFDEBUG) {
                    console.log('Abtf.fonts()', 'async', window.WebFontConfig);
                }

            } else if (typeof window.WebFont !== 'undefined') {

                // load WebFontConfig
                window.WebFont.load(window.WebFontConfig);

                if (ABTFDEBUG) {
                    console.log('Abtf.fonts()', window.WebFontConfig);
                }
            }
        }

        /**
         * Header init
         */
        Abtf[CONFIG.HEADER] = function() {

            if (Abtf[CONFIG.PROXY]) {
                Abtf[CONFIG.PROXY_SETUP](Abtf[CONFIG.PROXY]);
            }
            // load scripts in header
            if (Abtf[CONFIG.JS] && !Abtf[CONFIG.JS][1]) {
                Abtf[CONFIG.LOAD_JS](Abtf[CONFIG.JS][0]);
            }

            // Google Web Font Loader
            if (Abtf[CONFIG.GWF]) {

                if (typeof window.WebFontConfig === 'undefined') {
                    window.WebFontConfig = {};
                }

                // apply Google Fonts
                if (GWF_CONFIG[CONFIG.GWF_GOOGLE_FONTS]) {
                    if (!window.WebFontConfig.google) {
                        window.WebFontConfig.google = {};
                    }
                    if (!window.WebFontConfig.google.families) {
                        window.WebFontConfig.google.families = [];
                    }
                    var l = GWF_CONFIG[CONFIG.GWF_GOOGLE_FONTS].length;
                    for (var i = 0; i < l; i++) {
                        window.WebFontConfig.google.families.push(GWF_CONFIG[CONFIG.GWF_GOOGLE_FONTS][i]);
                    }
                }

                if (!GWF_CONFIG[CONFIG.GWF_FOOTER]) {
                    LOAD_GWF();
                }
            }

            // load CSS
            if (Abtf[CONFIG.LOAD_CSS] && !Abtf[CONFIG.CSS_FOOTER]) {
                Abtf[CONFIG.LOAD_CSS]();
            }
        };

        /**
         * Footer init
         */
        Abtf[CONFIG.FOOTER] = function() {

            // Load CSS
            if (Abtf[CONFIG.LOAD_CSS] && Abtf[CONFIG.CSS_FOOTER]) {

                if (ABTFDEBUG) {
                    console.log('Abtf.css()', 'footer start');
                }

                Abtf[CONFIG.LOAD_CSS]();
            }

            // load scripts in footer
            if (Abtf[CONFIG.JS] && Abtf[CONFIG.JS][1]) {

                if (ABTFDEBUG) {
                    console.log('Abtf.js()', 'footer start');
                }

                Abtf[CONFIG.LOAD_JS](Abtf[CONFIG.JS][0]);
            }

            // Google Web Font Loader
            if (Abtf[CONFIG.GWF] && GWF_CONFIG[CONFIG.GWF_FOOTER]) {

                if (ABTFDEBUG) {
                    console.log('Abtf.fonts()', 'footer start');
                }
                LOAD_GWF();
            }
        };

        // footer load position
        Abtf[CONFIG.DOMREADY](Abtf[CONFIG.FOOTER]);

        /**
         * Async load script
         */
        Abtf[CONFIG.ASYNC] = function(scriptFile, id) {
            (function(d) {
                var wf = d.createElement('script');
                wf.src = scriptFile;
                if (id) {
                    wf.id = id;
                }
                wf.async = true;
                var s = d.getElementsByTagName('script')[0];
                if (s) {
                    s.parentNode.insertBefore(wf, s);
                } else {
                    var h = document.head || document.getElementsByTagName("head")[0];
                    h.appendChild(wf);
                }
            })(document);
        }

        if (ABTFDEBUG) {

            var SITE_URL = document.createElement('a');
            SITE_URL.href = document.location.href;
            var BASE_URL_REGEX = new RegExp('^(https?:)?//' + SITE_URL.host.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'i');

            /**
             * Return local url for debug notices
             */
            Abtf[CONFIG.LOCALURL] = function(url) {
                return url.replace(BASE_URL_REGEX, '');
            }
        }
    }

    // load config
    var configParam = 'data-abtf';
    var LOAD_CONFIG = function(script) {
        var config = script.getAttribute(configParam);
        if (config && typeof config === 'string') {
            try {
                config = JSON.parse(config);
            } catch (err) {
                if (ABTFDEBUG) {
                    console.error('Abtf', 'failed to parse config', config, err);
                }
            }
        }
        if (!config || !(config instanceof Array)) {
            if (ABTFDEBUG) {
                console.error('Abtf', 'invalid config', config);
            }
            throw new Error('invalid config');
        }
        var l = config.length;
        for (var i = 0; i < l; i++) {
            if (typeof window.Abtf[i] !== 'undefined') {
                continue;
            }
            window.Abtf[i] = (config[i] === -1) ? undefined : config[i];
        }

        // load core module
        Abtf[CONFIG.LOAD_MODULE](CoreModule, true);
    }

    // detect script object
    if (document.currentScript && document.currentScript.hasAttribute(configParam)) {
        LOAD_CONFIG(document.currentScript);
    } else {

        // old browsers, IE6-9 etc
        var getCurrentScript = function() {
            return document.querySelector('script[' + configParam + ']');
        }
        var currentScript = getCurrentScript();
        if (currentScript) {
            LOAD_CONFIG(currentScript);
        } else {

            var missingError = '<script ' + configParam + '> client missing';

            // script not located, try again on domready
            if (window.console && typeof console.error !== 'undefined') {
                console.error(missingError);
            }

            Abtf[CONFIG.DOMREADY](function() {
                currentScript = getCurrentScript();
                if (currentScript) {
                    LOAD_CONFIG(currentScript);
                } else {
                    if (ABTFDEBUG) {
                        console.warn('Abtf', 'client script <script ' + configParam + '> detected on domready. Make sure that the script tag is included in the header unmodified.');
                    }
                    throw new Error(missingError);
                }
            });
        }
    }

    // header load queue
    var HEADER_LOAD_QUEUED;
    Abtf[CONFIG.HEADER_LOAD] = function() {
        if (CORE_MODULE_LOADED) {
            Abtf[CONFIG.HEADER]();
        } else {
            HEADER_LOAD_QUEUED = true;
        }
    }

})(window, Abtf);