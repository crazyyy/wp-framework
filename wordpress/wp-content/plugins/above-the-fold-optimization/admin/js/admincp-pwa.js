jQuery(function($) {

    // JSON editors
    var editors = {};

    /**
     * Asset Cache editor
     */
    if ($('#cache_assets').length > 0) {

        $('#cache_assets').html('');

        var assetcacheChangeTimeout;

        var options = {
            name: "pwa.cache.assets",
            mode: 'code',
            modes: ['code', 'tree'], // allowed modes
            onError: function(err) {
                console.error('JSON', err.toString());
                alert('JSON error. Please verify your input.\n\nSee console for details.');
            },
            onChange: function() {
                var t = editors['assetpolicy'].getText();

                if ($.trim(t) === '') {
                    if (assetcacheChangeTimeout) {
                        clearTimeout(assetcacheChangeTimeout);
                    }
                    // wait for copy past action
                    assetcacheChangeTimeout = setTimeout(function() {
                        assetcacheChangeTimeout = false;
                        var t = editors['assetpolicy'].getText();
                        if ($.trim(t) === '') {
                            editors['assetpolicy'].set({});
                            jQuery('#cache_assets_src').val('{}');
                        }
                    }, 25);
                    return;
                }

                try {
                    var json = editors['assetpolicy'].get();
                } catch (e) {

                    return;
                }
                jQuery('#cache_assets_src').val(JSON.stringify(json));
            },
            onModeChange: function(newMode, oldMode) {
                var t = editors['assetpolicy'].getText();
                if ($.trim(t) === '') {
                    editors['assetpolicy'].set({});
                }
                // expand nodes
                if (newMode === 'tree') {
                    //editors['assetpolicy'].expandAll();
                } else {
                    $('#cache_assets_src').data('json-editor').editor.setOptions({
                        maxLines: 50
                    });
                }
            },
            search: false,
            schema: {
                "title": "PWA Cache Policy",
                "type": "array",
                "items": {
                    "type": "object",
                    "properties": {
                        "title": {
                            "type": "string"
                        },
                        "match": {
                            "type": "array",
                            "items": {
                                "oneOf": [{
                                    "title": "Match the URL of an asset.",
                                    "type": "object",
                                    "properties": {
                                        "type": {
                                            "type": "string",
                                            "enum": ["url"]
                                        },
                                        "pattern": {
                                            "type": "string",
                                            "minLength": 1
                                        },
                                        "regex": {
                                            "type": "boolean"
                                        },
                                        "not": {
                                            "type": "boolean"
                                        }
                                    },
                                    "required": ["type", "pattern"],
                                    "additionalProperties": false
                                }, {
                                    "title": "Match the URL of an asset in a list of URLs.",
                                    "type": "object",
                                    "properties": {
                                        "type": {
                                            "type": "string",
                                            "enum": ["url"]
                                        },
                                        "pattern": {
                                            "type": "array",
                                            "items": {
                                                "type": "string",
                                                "minLength": 1
                                            },
                                            "uniqueItems": true
                                        },
                                        "not": {
                                            "type": "boolean"
                                        }
                                    },
                                    "required": ["type", "pattern"],
                                    "additionalProperties": false
                                }, {
                                    "title": "Match a request header.",
                                    "type": "object",
                                    "properties": {
                                        "type": {
                                            "type": "string",
                                            "enum": ["header"]
                                        },
                                        "name": {
                                            "type": "string",
                                            "minLength": 1
                                        },
                                        "pattern": {
                                            "type": "string",
                                            "minLength": 1
                                        },
                                        "regex": {
                                            "type": "boolean"
                                        },
                                        "not": {
                                            "type": "boolean"
                                        }
                                    },
                                    "required": ["type", "name", "pattern"],
                                    "additionalProperties": false
                                }]
                            },
                            "uniqueItems": true
                        },
                        "strategy": {
                            "title": "Enter the cache strategy for the matched resources.",
                            "type": "string",
                            "default": "network",
                            "enum": ["never", "cache", "network", "event"]
                        },
                        "offline": {
                            "title": "Enter a path to an alternative resource to precache and serve when the network fails and no cache is available.",
                            "type": "string"
                        },
                        "cache": {
                            "title": "Cache configuration",
                            "type": "object",
                            "properties": {
                                "update_interval": {
                                    "title": "Enter a time in seconds to update the cache.",
                                    "type": "number",
                                    "min": 0
                                },
                                "head_update": {
                                    "title": "Update cache ased on HTTP HEAD request with etag/last-modified header validation.",
                                    "type": "boolean"
                                },
                                "max_age": {
                                    "title": "Enter an expire time in seconds.",
                                    "type": "number",
                                    "min": 0
                                },
                                "conditions": {
                                    "type": "array",
                                    "items": {
                                        "oneOf": [{
                                            "title": "Match the URL of an asset.",
                                            "type": "object",
                                            "properties": {
                                                "type": {
                                                    "type": "string",
                                                    "enum": ["url"]
                                                },
                                                "pattern": {
                                                    "type": "string",
                                                    "minLength": 1
                                                },
                                                "regex": {
                                                    "type": "boolean"
                                                },
                                                "not": {
                                                    "type": "boolean"
                                                }
                                            },
                                            "required": ["type", "pattern"],
                                            "additionalProperties": false
                                        }, {
                                            "title": "Match a response header.",
                                            "type": "object",
                                            "properties": {
                                                "type": {
                                                    "type": "string",
                                                    "enum": ["header"]
                                                },
                                                "name": {
                                                    "type": "string",
                                                    "minLength": 1
                                                },
                                                "pattern": {
                                                    "type": "string",
                                                    "minLength": 1
                                                },
                                                "regex": {
                                                    "type": "boolean"
                                                },
                                                "not": {
                                                    "type": "boolean"
                                                }
                                            },
                                            "required": ["type", "name", "pattern"],
                                            "additionalProperties": false
                                        }, {
                                            "title": "Match a response header by comparison.",
                                            "type": "object",
                                            "properties": {
                                                "type": {
                                                    "type": "string",
                                                    "enum": ["header"]
                                                },
                                                "name": {
                                                    "type": "string",
                                                    "minLength": 1
                                                },
                                                "pattern": {
                                                    "oneOf": [{
                                                        "title": "Compare a numeric header value.",
                                                        "type": "object",
                                                        "properties": {
                                                            "operator": {
                                                                "type": "string",
                                                                "enum": ["<", "=", ">"]
                                                            },
                                                            "value": {
                                                                "type": "number"
                                                            }
                                                        },
                                                        "additionalProperties": false
                                                    }]
                                                },
                                                "not": {
                                                    "type": "boolean"
                                                }
                                            },
                                            "required": ["type", "name", "pattern"],
                                            "additionalProperties": false
                                        }]
                                    },
                                    "uniqueItems": true
                                }
                            },
                            "required": [],
                            "additionalProperties": false
                        }
                    },
                    "additionalProperties": false,
                    "required": ["match", "strategy"]
                },
                "uniqueItems": true
            }
        };

        var json = {};
        if (jQuery('#cache_assets_src').val() !== '') {
            json = jQuery('#cache_assets_src').val();
            if (typeof json !== 'object') {
                try {
                    json = JSON.parse(json);
                } catch (e) {
                    json = {};
                }
            }
            if (!json || typeof json !== 'object') {
                json = {};
            }
        }

        if (json instanceof Array && json.length === 0) {
            json = {};
        }

        var empty = false;
        if (JSON.stringify(json) === '{}') {
            empty = true;
        }

        editors['assetpolicy'] = new JSONEditor($('#cache_assets')[0], options, json);

        if (options.mode === 'code') {
            if (!empty) {
                editors['assetpolicy'].editor.setOptions({
                    maxLines: 50
                });
            }
        }

        // set editor reference

        $('#cache_assets_src').data('json-editor', editors['assetpolicy']);

    }

    /**
     * Web App Manifest editor
     */
    if ($('#webapp_manifest').length > 0) {

        $('#webapp_manifest').html('');

        var changeTimeout;

        var options = {
            name: "pwa.manifest",
            mode: 'tree',
            modes: ['code', 'tree'], // allowed modes
            onError: function(err) {
                console.error('JSON', err.toString());
                alert('JSON error. Please verify your input.\n\nSee console for details.');
            },
            onChange: function() {
                var t = editors['manifest'].getText();

                if ($.trim(t) === '') {
                    if (changeTimeout) {
                        clearTimeout(changeTimeout);
                    }
                    // wait for copy past action
                    changeTimeout = setTimeout(function() {
                        changeTimeout = false;
                        var t = editors['manifest'].getText();
                        if ($.trim(t) === '') {
                            editors['manifest'].set({});
                            jQuery('#webapp_manifest_src').val('{}');
                        }
                    }, 25);
                    return;
                }

                try {
                    var json = editors['manifest'].get();
                } catch (e) {

                    return;
                }
                jQuery('#webapp_manifest_src').val(JSON.stringify(json));
            },
            onModeChange: function(newMode, oldMode) {
                var t = editors['manifest'].getText();
                if ($.trim(t) === '') {
                    editors['manifest'].set({});
                }
                // expand nodes
                if (newMode === 'tree') {
                    //editors['manifest'].expandAll();
                }
            },
            search: false,
            schema: {
                "title": "Web App Manifest",
                "type": "object",
                "properties": {
                    "short_name": {
                        "type": "string"
                    },
                    "name": {
                        "type": "string"
                    },
                    "theme_color": {
                        "type": "string"
                    },
                    "background_color": {
                        "type": "string"
                    },
                    "display": {
                        "type": "string",
                        "enum": ["fullscreen", "standalone", "minimal-ui", "browser"]
                    },
                    "orientation": {
                        "type": "string",
                        "enum": ["any",
                            "natural",
                            "landscape",
                            "landscape-primary",
                            "landscape-secondary",
                            "portrait",
                            "portrait-primary",
                            "portrait-secondary"
                        ]
                    },
                    "start_url": {
                        "type": "string"
                    },
                    "lang": {
                        "type": "string"
                    },
                    "dir": {
                        "type": "string"
                    },
                    "scope": {
                        "type": "string"
                    },
                    "serviceworker": {
                        "type": "object",
                        "properties": {
                            "src": {
                                "type": "string"
                            },
                            "scope": {
                                "type": "string"
                            },
                            "use_cache": {
                                "type": "boolean"
                            }
                        },
                        "additionalProperties": true
                    },
                    "related_applications": {
                        "type": "array",
                        "items": {
                            "type": "object",
                            "properties": {
                                "platform": {
                                    "type": "string"
                                },
                                "url": {
                                    "type": "string"
                                },
                                "id": {
                                    "type": "string"
                                }
                            },
                            "additionalProperties": true
                        },
                        "uniqueItems": true
                    },
                    "icons": {
                        "type": "array",
                        "items": {
                            "type": "object",
                            "properties": {
                                "src": {
                                    "type": "string"
                                },
                                "type": {
                                    "type": "string"
                                },
                                "sizes": {
                                    "type": "string"
                                },
                                "density": {
                                    "type": "string"
                                }
                            },
                            "additionalProperties": true
                        },
                        "uniqueItems": true
                    },
                    "screenshots": {
                        "type": "array",
                        "items": {
                            "type": "object",
                            "properties": {
                                "src": {
                                    "type": "string"
                                },
                                "type": {
                                    "type": "string"
                                },
                                "sizes": {
                                    "type": "string"
                                }
                            },
                            "additionalProperties": true
                        },
                        "uniqueItems": true
                    }
                },
                "required": [
                    "name",
                    "short_name",
                    "icons",
                    "theme_color",
                    "background_color",
                    "display",
                    "orientation",
                    "start_url"
                ],
                "additionalProperties": true
            }
        };

        var json = {};
        if (jQuery('#webapp_manifest_src').val() !== '') {
            json = jQuery('#webapp_manifest_src').val();
            if (typeof json !== 'object') {
                try {
                    json = JSON.parse(json);
                } catch (e) {
                    json = {};
                }
            }
            if (!json || typeof json !== 'object') {
                json = {};
            }
        }

        if (json instanceof Array && json.length === 0) {
            json = {};
        }

        var empty = false;
        if (JSON.stringify(json) === '{}') {
            empty = true;
            options.mode = 'code';
        }

        editors['manifest'] = new JSONEditor($('#webapp_manifest')[0], options, json);

        if (options.mode === 'code') {
            //editors['manifest'].compact(); // collapseAll();
        }

        // set editor reference
        $('#webapp_manifest_src').data('json-editor', editors['manifest']);

    }


    // load condition selectize for editor
    if (jQuery('#offline_page').length > 0) {

        /**
         * Populate selectmenu
         */
        var selectize = jQuery('#offline_page').selectize({
            options: [],
            searchField: ['name', 'value'],
            persist: true,
            maxItem: 1,
            placeholder: "Enter a URL or absolute path, e.g. /offline/",
            delimiter: '|==abtf==|',
            render: {
                option: function(item, escape) {
                    return '<div class="opt">' +
                        '<span class="title">' +
                        '<span class="name">' + escape(item.name) + '</span>' +
                        '</span>' +
                        '</div>';
                },
                item: function(item, escape) {
                    return '<div>' +
                        '<span class="name">' + escape(item.name) + '</span>' +
                        '</div>';
                }
            },
            create: function(input) {
                return {
                    'value': input,
                    'name': input
                };
            },
            load: function(query, callback) {
                if (!query.length) return callback();
                jQuery.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'abtf_page_search',
                        query: query,
                        maxresults: 10
                    },
                    error: function() {
                        callback();
                    },
                    success: function(res) {
                        if (res && document.location.host) {
                            var l = res.length;
                            for (var i = 0; i < l; i++) {
                                res[i].value = res[i].value.replace(document.location.protocol + '//' + document.location.host, '');
                            }
                        }
                        callback(res);
                    }
                });
            },
            plugins: ['remove_button']
        });

    }


});