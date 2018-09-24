/**
 * HTML5 Web Worker and Fetch API based script loader with localStorage cache
 *
 * Inspired by basket.js
 * @link https://addyosmani.com/basket.js/
 *
 * @package    abovethefold
 * @subpackage abovethefold/public
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

Abtf[CONFIG.LOAD_MODULE](function(window, Abtf) {

    // test availability of localStorage
    if (!window.localStorage) {
        return;
    }

    // test availability Web Workers
    if (!window.Worker) {
        return;
    }

    /**
     * Object urls to revoke on unload
     */
    var OBJECT_URLS = [];

    // async
    var ASYNC = function(fn) {
        if ('Promise' in window) {
            new Promise(function resolver(resolve, reject) {
                resolve(fn());
            });
        } else {
            if (window.setImmediate !== 'undefined') {
                window.setImmediate(fn);
            } else {
                setTimeout(fn, 0);
            }
        }
    };

    /**
     * localStorage controller
     */
    var LS = {

        // Prefix for cache entries
        prefix: 'abtf-',

        // Default expire time in seconds
        default_expire: 86400, // 1 day

        // preloaded scripts, loaded while waiting for dependencies
        preloaded: {},

        // return current time in seconds
        now: function() {
            return (+new Date() / 1000);
        },

        // process task when idle
        execWhenIdle: function(task, timeframe) {

            if (Abtf[CONFIG.IDLE]) {

                // shedule for idle time
                Abtf[CONFIG.IDLE](task, {
                    timeout: timeframe
                });

            } else {
                task();
            }
        },

        /**
         * Save script to localStorage cache
         */
        saveScript: function(url, scriptData, expire) {

            // minimize interference with rendering
            LS.execWhenIdle(function idleTime() {

                var scriptObj = {};

                var now = LS.now();
                scriptObj.date = now;
                scriptObj.expire = now + (expire || LS.default_expire);

                if (scriptData instanceof Array) {

                    // chunked
                    scriptObj.chunked = true;
                    scriptObj.chunks = scriptData.length;

                    var chunkObjects = [];
                    var l = scriptData.length;
                    for (var i = 0; i < l; i++) {
                        chunkObjects.push(scriptData[i]);
                    }
                } else {
                    var chunkObjects = false;
                    scriptObj.data = scriptData;
                }

                LS.add(url, scriptObj);

                if (chunkObjects) {
                    var l = chunkObjects.length;
                    for (var i = 0; i < l; i++) {
                        LS.add('chunk:' + i + ':' + url, chunkObjects[i]);
                    }
                }

            }, 3000);
        },

        /**
         * Get script from localStorage cache
         */
        getScript: function(url) {

            if (typeof LS.preloaded[url] !== 'undefined' && LS.preloaded[url] !== false) {
                return LS.preloaded[url];
            }

            // abort preloading
            LS.preloaded[url] = false;

            // get from localStorage
            var cacheObject = LS.get(url);

            if (!cacheObject || typeof cacheObject !== 'object') {
                return false; // not in cache
            }

            // verify expire time
            if (typeof cacheObject.expire !== 'undefined' && (cacheObject.expire - LS.now()) < 0) {
                return false; // expired
            }

            /**
             * Chunked data
             */
            if (typeof cacheObject.chunked !== 'undefined' && cacheObject.chunked === true) {
                var data = [],
                    chunkData;
                for (var i = 0; i < cacheObject.chunks; i++) {
                    chunkData = LS.get('chunk:' + i + ':' + url);

                    // chunk is missing
                    if (chunkData === false || typeof chunkData === 'undefined') {
                        return false;
                    }
                    data.push(chunkData);
                }
                cacheObject.data = data.join('');
            } else if (!cacheObject.data) {
                return false; // no data
            }

            var scriptData = '/* @source ' + url + ' */\n';

            var idle = false,
                idle_timeframe;

            /** requestIdleCallback */
            if (Abtf[CONFIG.IDLE] && typeof Abtf[CONFIG.JS][2] !== 'undefined' && Abtf[CONFIG.JS][2]) {

                var l = Abtf[CONFIG.JS][2].length,
                    str;
                for (var i = 0; i < l; i++) {
                    if (typeof Abtf[CONFIG.JS][2][i] !== 'object') {
                        continue;
                    }
                    if (url.indexOf(Abtf[CONFIG.JS][2][i][0]) !== -1) {
                        idle = true;
                        if (Abtf[CONFIG.JS][2][i][1]) {
                            idle_timeframe = Abtf[CONFIG.JS][2][i][1];
                        }
                        break;
                    }
                }
            }

            if (idle) {
                scriptData += 'window.requestIdleCallback(function(){';
                scriptData += cacheObject.data;
                if (idle_timeframe) {
                    scriptData += '},{timeout:' + idle_timeframe + '});';
                } else {
                    scriptData += '});';
                }
            } else {
                scriptData += cacheObject.data;
            }

            // create blob url
            LS.preloaded[url] = createBlobUrl(scriptData, 'application/javascript');
            OBJECT_URLS.push(LS.preloaded[url]);

            return LS.preloaded[url];
        },

        /**
         * Preload script
         */
        preloadScript: function(url) {

            if (typeof LS.preloaded[url] !== 'undefined') {
                return;
            }

            // minimize interference with rendering
            LS.execWhenIdle(function idleTime() {

                if (typeof LS.preloaded[url] !== 'undefined') {
                    return;
                }

                LS.preloaded[url] = LS.getScript(url);

            }, 100);
        },

        /**
         * Add data to localStorage cache
         */
        add: function(key, storeObj, retryCount) {

            // skip retry after 10 removed entries
            if (typeof retryCount !== 'undefined' && parseInt(retryCount) > 10) {

                if (ABTFDEBUG) {
                    console.error('Abtf.js() ➤ localStorage quota reached', 'retry limit reached, abort saving...', key);
                }
                return;
            }

            if (typeof storeObj === 'object') {
                storeObj = JSON.stringify(storeObj);
            }
            try {
                localStorage.setItem(LS.prefix + key, storeObj);
                return true;
            } catch (e) {

                /**
                 * localStorage quota reached, prune old cache entries
                 */
                if (e.name.toUpperCase().indexOf('QUOTA') >= 0) {
                    var item, entry, entryKey;
                    var tempScripts = [];

                    for (item in localStorage) {
                        if (item.indexOf(LS.prefix) === 0 && item.indexOf('chunk:') === -1) {
                            entryKey = item.split(LS.prefix)[1];
                            entry = LS.get(entryKey);
                            if (entry) {
                                tempScripts.push([entryKey, entry]);
                            }
                        }
                    }

                    if (tempScripts.length) {
                        tempScripts.sort(function(a, b) {
                            return a[1].date - b[1].date;
                        });

                        if (ABTFDEBUG) {
                            console.error('Abtf.js() ➤ localStorage quota reached', 'removed', tempScripts[0][0], 'for key', key);
                        }

                        LS.remove(tempScripts[0][0]);

                        // minimize interference with rendering
                        LS.execWhenIdle(function idleTime() {

                            if (typeof retryCount === 'undefined') {
                                retryCount = 0;
                            }
                            LS.add(key, storeObj, ++retryCount);

                        }, 1000);

                        return;
                    } else {


                        if (ABTFDEBUG) {
                            console.error('Abtf.js() ➤ localStorage quota reached', 'no files to remove');
                        }

                        // no files to remove. Larger than available quota
                        return;
                    }

                } else {

                    if (ABTFDEBUG) {
                        console.error('Abtf.js() ➤ localStorage error', e.name, e);
                    }

                    // some other error
                    return;
                }
            }
        },

        /**
         * Remove from localStorage
         */
        remove: function(key) {

            var entry = LS.get(key);
            if (!entry) {
                return;
            }

            if (entry.chunked) {

                // remove chunks
                var l = parseInt(entry.chunks);
                for (var i = 0; i < l; i++) {
                    localStorage.removeItem(LS.prefix + 'chunk:' + i + ':' + key);
                }
            }

            localStorage.removeItem(LS.prefix + key);
        },

        /**
         * Get from localStorage
         */
        get: function(key) {
            var item = localStorage.getItem(LS.prefix + key);
            try {

                // chunk, return string data
                if (key.indexOf('chunk:') !== -1) {
                    return item || false;
                }

                // return entry object
                return JSON.parse(item || 'false');

            } catch (e) {
                return false;
            }
        },

        /**
         * Clear expired entries in localStorage
         */
        clear: function(expired) {
            var item, key;
            var now = this.now();

            if (ABTFDEBUG) {
                var removed = [];
            }

            var entry, clear;
            for (item in localStorage) {
                key = item.split(LS.prefix)[1];
                if (key) {
                    if (key.indexOf('chunk:') !== -1) {
                        // chunk, remove by parent object
                        continue;
                    }

                    // get entry
                    entry = LS.get(key);
                    if (!entry) {
                        // entry does not exist
                        continue;
                    }

                    if (!expired || entry.expire <= now) {

                        // remove entry
                        LS.remove(key);

                        if (ABTFDEBUG) {
                            removed.push(key);
                        }
                    }
                }
            }

            if (ABTFDEBUG) {
                if (removed.length > 0) {
                    console.warn('Abtf.js() ➤ localStorage cleared', removed.length, 'expired scripts');
                }
            }
        }

    };

    /**
     * Create javascript blob url
     */
    var createBlobUrl = function(fileData, mimeType) {
        var blob;

        /**
         * Create blob
         */
        try {
            blob = new Blob([fileData], {
                type: mimeType
            });
        } catch (e) { // Backwards-compatibility
            window.BlobBuilder = window.BlobBuilder || window.WebKitBlobBuilder || window.MozBlobBuilder;
            blob = new BlobBuilder();
            blob.append(fileData);
            blob = blob.getBlob(mimeType);
        }

        /**
         * Return blob url
         */
        return URL.createObjectURL(blob);
    };

    /**
     * Web Worker source code
     */
    var WORKER_CODE = ((function() {

            // Fetch API
            self.FETCH = self.fetch || false;

            // default timeout
            self.DEFAULT_TIMEOUT = 5000;

            // @todo performance tests
            // @link https://jsperf.com/localstorage-10x100kb-vs-2x-500kb-vs-1x-1mb
            self.MAX_CHUNK_SIZE = 100000; // 100kb

            // chunk data for localStorage
            self.CHUNK_DATA = function(data, chunkSize) {
                var chunksCount = Math.ceil(data.length / chunkSize);
                var chunks = new Array(chunksCount);
                var offset;

                for (var i = 0; i < chunksCount; i++) {
                    offset = i * chunkSize;
                    chunks[i] = data.substring(offset, offset + chunkSize);
                }

                return chunks;
            };

            /**
             * Method for loading resource
             */
            self.LOAD_RESOURCE = function(file) {

                // resource loaded flag
                var resourceLoaded = false;
                var request_timeout = false;

                // onload callback
                var resourceOnload = function(error, returnData) {
                    if (resourceLoaded) {
                        return; // already processed
                    }

                    resourceLoaded = true;

                    if (request_timeout) {
                        clearTimeout(request_timeout);
                        request_timeout = false;
                    }

                    if (!error && returnData) {

                        /**
                         * localStorage appears to become buggy with large scripts
                         *
                         * Split data in chunks.
                         */
                        var dataSize = returnData.length;

                        // calculate data size
                        if (dataSize > self.MAX_CHUNK_SIZE) {
                            returnData = self.CHUNK_DATA(returnData, self.MAX_CHUNK_SIZE);
                        }
                    }

                    self.RESOURCE_LOAD_COMPLETED(file, error, returnData);
                };

                /**
                 * Use Fetch API
                 */
                if (self.FETCH) {

                    // fetch configuration
                    var fetchInit = {
                        method: 'GET',
                        mode: 'cors',
                        cache: 'default'
                    };

                    var handleError = function(error) {
                        if (resourceLoaded) {
                            return; // already processed
                        }

                        if (typeof error === 'object' && error.status) {
                            error = [error.status, error.statusText];
                        }

                        // error
                        resourceOnload(error);
                    };

                    // fetch request
                    self.FETCH(file.url, fetchInit)
                        .then(function(response) {
                            if (resourceLoaded) {
                                return; // already processed
                            }

                            // handle response
                            if (response.ok) {

                                // get text data
                                response.text().then(function(data) {
                                    resourceOnload(false, data);
                                });

                            } else {

                                // error
                                resourceOnload([response.status, response.statusText]);
                            }

                        }, handleError).catch(handleError);

                    // Fetch API does not support abort or cancel or timeout
                    // simply ignore the request on timeout
                    var timeout = file.timeout || self.DEFAULT_TIMEOUT;
                    if (isNaN(timeout)) {
                        timeout = self.DEFAULT_TIMEOUT;
                    }
                    request_timeout = setTimeout(function requestTimeout() {
                        if (resourceLoaded) {
                            return; // already processed
                        }

                        resourceOnload('timeout');
                    }, timeout);
                } else {

                    // start XHR request
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', file.url, true);

                    /**
                     * Set XHR response type
                     */
                    xhr.responseType = 'text';

                    // watch state change
                    xhr.onreadystatechange = function() {
                            if (resourceLoaded) {
                                return; // already processed
                            }

                            // handle response
                            if (xhr.readyState === 4) {

                                if (xhr.status !== 200) {

                                    // error
                                    resourceOnload(xhr.statusText);
                                } else {

                                    /**
                                     * Return text
                                     */
                                    resourceOnload(false, xhr.responseText);

                                }
                            }
                        }
                        /**
                         * Resource load completed
                         */
                    xhr.onerror = function resourceError() {
                        if (resourceLoaded) {
                            return; // already processed
                        }

                        resourceOnload(xhr.statusText);
                    };

                    // By default XHRs never timeout, and even Chrome doesn't implement the
                    // spec for xhr.timeout. So we do it ourselves.
                    var timeout = file.timeout || self.DEFAULT_TIMEOUT;
                    if (isNaN(timeout)) {
                        timeout = self.DEFAULT_TIMEOUT;
                    }
                    request_timeout = setTimeout(function requestTimeout() {
                        if (resourceLoaded) {
                            return; // already processed
                        }
                        try {
                            xhr.abort();
                        } catch (e) {

                        }
                        resourceOnload('timeout');
                    }, timeout);

                    xhr.send(null);

                }
            };

            /**
             * Post back to UI after completion of specific resource
             */
            self.RESOURCE_LOAD_COMPLETED = function(file, error, returnData) {

                if (error) {

                    if (!(error instanceof Array) && typeof error === 'object') {
                        error = error.toString();
                    }

                    // return error
                    self.postMessage([2, file.i, error]);
                } else {

                    // send back data to save in localStorage
                    self.postMessage([1, file.i, returnData]);
                }

            };

            /**
             * Handle load request for web worker
             */
            self.onmessage = function(oEvent) {

                var files = oEvent.data;

                // load multiple files
                if (files instanceof Array) {
                    var l = files.length;
                    for (var i = 0; i < l; i++) {
                        if (typeof files[i] === 'object' && typeof files[i].url !== 'undefined' && typeof files[i].i !== 'undefined') {
                            self.LOAD_RESOURCE(files[i]);
                        }
                    }
                } else if (typeof files === 'object' && typeof files.url !== 'undefined' && typeof files.i !== 'undefined') {
                    self.LOAD_RESOURCE(files);
                } else {
                    throw new Error('Web Worker Script Loader: Invalid resource object');
                }
            }

        }).toString()
        .replace(/^function\s*\(\s*\)\s*\{/, '')
        .replace(/\}$/, '')
    );

    /**
     * Web Worker Script Loader
     */
    var WEBWORKER = {

        // web worker code
        workerUri: createBlobUrl(WORKER_CODE, 'application/javascript'),

        // web worker
        worker: false,

        scriptIndex: 0,
        scriptQueue: [],

        // start web worker
        start: function() {

            this.worker = new Worker(this.workerUri);

            // listen for messages from worker
            this.worker.addEventListener('message', this.handleMessage);

            // listen for errors
            this.worker.addEventListener('error', this.handleError);
        },

        /**
         * Stop web worker
         */
        stop: function() {
            if (this.worker) {

                // remove listeners
                this.worker.removeEventListener('message', this.handleMessage);

                // listen for errors
                this.worker.removeEventListener('error', this.handleError);

                // terminate worker
                this.worker.terminate();

                this.worker = false;

                if (ABTFDEBUG) {
                    console.warn('Abtf.js() ➤ web worker terminated');
                }
            }
        },

        /**
         * Handle response from Web Worker
         */
        handleMessage: function(event) {
            var response = event.data;

            var scriptIndex = response[1];
            if (typeof WEBWORKER.scriptQueue[scriptIndex] === 'undefined') {

                // script not in queue
                if (ABTFDEBUG) {
                    console.error('Abtf.js() ➤ web worker script loader invalid response', response);
                }
                return;
            }

            // data is returned
            if (parseInt(response[0]) === 1) {
                WEBWORKER.scriptQueue[scriptIndex].onData(response[2]);
                return;
            }

            // error
            if (parseInt(response[0]) === 2) {
                if (ABTFDEBUG) {
                    if (response[2] instanceof Array) {
                        if (parseInt(response[2][0]) > 200 && parseInt(response[2][0]) < 600) {
                            console.error('Abtf.js() ➤ web worker ➤ ' + response[2][0] + ' ' + response[2][1], WEBWORKER.scriptQueue[scriptIndex].url);
                            return;
                        }
                    }
                    console.error('Abtf.js() ➤ web worker script loader error', response[2]);
                }
                return;
            }
        },

        /**
         * Handle error response
         */
        handleError: function(error) {

            // output error to console
            if (ABTFDEBUG) {
                console.error('Abtf.js() ➤ web worker script loader error', error);
            }
        },

        /**
         * Load script
         */
        loadScript: function(url, onData) {

            if (!this.worker) {
                this.start();
            }

            url = Abtf[CONFIG.PROXIFY](url);

            var scriptIndex = parseInt(this.scriptIndex);
            this.scriptIndex++;

            // add to queue
            this.scriptQueue[scriptIndex] = {
                url: url,
                onData: onData
            };

            // send to web worker 
            this.worker.postMessage({
                url: url,
                i: scriptIndex
            });
        }
    };

    // start web worker
    WEBWORKER.start();

    /**
     * Clear memory
     */
    window.addEventListener("beforeunload", function(e) {

        // stop web worker
        WEBWORKER.stop();

        // revoke script object urls
        if (OBJECT_URLS.length > 0) {
            var l = OBJECT_URLS.length;
            for (var i = 0; i < l; i++) {
                try {
                    URL.revokeObjectURL(OBJECT_URLS[i]);
                } catch (err) {
                    if (ABTFDEBUG) {
                        console.error('Abtf.js() ➤ failed to revoke script url', OBJECT_URLS[i], err);
                    }
                }
            }
        }
    });

    /**
     * Clear expired entries
     */
    if (Abtf[CONFIG.IDLE]) {

        // shedule for idle time
        Abtf[CONFIG.IDLE](function() {
            LS.clear(true);
        }, {
            timeout: 3000
        });

    } else {

        // fallback to setTimeout
        var clear_timeout;
        var initClearTimeout = function() {
            if (clear_timeout) {
                clearTimeout(clear_timeout);
            }
            clear_timeout = setTimeout(function() {
                LS.clear(true);
            }, 2000);
        };

        // set timeout
        initClearTimeout();

        // reset timeout on script load
        Abtf[CONFIG.ON_SCRIPT_LOAD](initClearTimeout);
    }

    /**
     * Load cached script
     */
    Abtf[CONFIG.LOAD_CACHED_SCRIPT] = function(src, callback, onStart) {

        ASYNC(function() {

            /**
             * Try localStorage cache
             */
            var url = LS.getScript(src);
            if (url) {
                if (ABTFDEBUG) {
                    onStart(url);
                }
                Abtf[CONFIG.LOAD_SCRIPT](url, callback);
                return;
            }

            if (ABTFDEBUG) {
                // not cached
                onStart(false);
            }

            /**
             * Not in cache, start regular request and potentially use browser cache speed
             */
            Abtf[CONFIG.LOAD_SCRIPT](src, function scriptLoaded() {

                callback();

                /**
                 * Load script into cache in the background
                 */
                WEBWORKER.loadScript(src, function onData(scriptData) {

                    if (!scriptData) {
                        if (ABTFDEBUG) {
                            console.error('Abtf.js() ➤ web worker script loader no data', Abtf[CONFIG.LOCALURL](src));
                        }
                        return;
                    }

                    if (ABTFDEBUG) {
                        if (scriptData instanceof Array) {
                            console.info('Abtf.js() ➤ web worker ➤ localStorage saved chunked', '(' + scriptData.length + ' chunks)', Abtf[CONFIG.LOCALURL](src));
                        } else {
                            console.info('Abtf.js() ➤ web worker ➤ localStorage saved', '(' + scriptData.length + ')', Abtf[CONFIG.LOCALURL](src));
                        }
                    }

                    // save script to local storage
                    LS.saveScript(src, scriptData);

                });

            });

        });

    };

    /**
     * Preload cached script
     */
    Abtf[CONFIG.PRELOAD_CACHED_SCRIPT] = function(url) {
        ASYNC(function() {
            LS.preloadScript(url);
        });
    };

    /**
     * Load cached script url
     */
    Abtf[CONFIG.LOAD_CACHED_SCRIPT_URL] = function(src) {

        /**
         * Try localStorage cache
         */
        var url = LS.getScript(src);
        if (url) {
            return url;
        }

        /**
         * Load script into cache in the background
         */
        WEBWORKER.loadScript(src, function onData(scriptData) {

            if (!scriptData) {
                if (ABTFDEBUG) {
                    console.error('Abtf.js() ➤ web worker script loader no data', Abtf[CONFIG.LOCALURL](src));
                }
                return;
            }

            if (ABTFDEBUG) {
                if (scriptData instanceof Array) {
                    console.info('Abtf.js() ➤ web worker ➤ localStorage saved chunked', '(' + scriptData.length + ' chunks)', Abtf[CONFIG.LOCALURL](src));
                } else {
                    console.info('Abtf.js() ➤ web worker ➤ localStorage saved', '(' + scriptData.length + ')', Abtf[CONFIG.LOCALURL](src));
                }
            }

            // save script to local storage
            LS.saveScript(src, scriptData);

        });

        // return original url 
        return src;

    };

});