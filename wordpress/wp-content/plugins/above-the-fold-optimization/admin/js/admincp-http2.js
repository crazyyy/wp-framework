jQuery(function($) {

    // JSON editors
    var editors = {};

    /**
     * Asset Cache editor
     */
    if ($('#http2_push').length > 0) {

        $('#http2_push').html('');

        var assetcacheChangeTimeout;

        var options = {
            name: "http2.push",
            mode: 'code',
            modes: ['code', 'tree'], // allowed modes
            onError: function(err) {
                console.error('JSON', err.toString());
                alert('JSON error. Please verify your input.\n\nSee console for details.');
            },
            onChange: function() {
                var t = editors['http2push'].getText();
                console.log(t);

                if ($.trim(t) === '') {
                    if (assetcacheChangeTimeout) {
                        clearTimeout(assetcacheChangeTimeout);
                    }
                    // wait for copy past action
                    assetcacheChangeTimeout = setTimeout(function() {
                        assetcacheChangeTimeout = false;
                        var t = editors['http2push'].getText();
                        if ($.trim(t) === '') {
                            editors['http2push'].set([]);
                            jQuery('#http2_push_config_src').val('[]');
                        }
                    }, 25);
                    return;
                }

                try {
                    var json = editors['http2push'].get();
                } catch (e) {
                    return;
                }
                jQuery('#http2_push_config_src').val(JSON.stringify(json));
            },
            onModeChange: function(newMode, oldMode) {
                var t = editors['http2push'].getText();
                if ($.trim(t) === '') {
                    editors['http2push'].set([]);
                }
                // expand nodes
                if (newMode === 'tree') {
                    //editors['http2push'].expandAll();
                } else {
                    $('#http2_push_config_src').data('json-editor').editor.setOptions({
                        maxLines: 50
                    });
                }
            },
            search: false,
            schema: {
                "title": "HTTP/2 Push",
                "type": "array",
                "items": {
                    "oneOf": [{
                        "title": "WordPress enqueued stylesheets or scripts.",
                        "type": "object",
                        "properties": {
                            "type": {
                                "type": "string",
                                "enum": ["style", "script", "image"]
                            },
                            "match": {
                                "oneOf": [{
                                    "type": "string",
                                    "enum": ["all"]
                                }, {
                                    "title": "Match the URL of a stylesheet of script.",
                                    "type": "object",
                                    "properties": {
                                        "pattern": {
                                            "type": "string",
                                            "minLength": 1
                                        },
                                        "regex": {
                                            "type": "boolean"
                                        },
                                        "exclude": {
                                            "type": "boolean"
                                        }
                                    },
                                    "required": ["pattern"],
                                    "additionalProperties": false
                                }]
                            },
                            "meta": {
                                "title": "Add meta rel=preload to header.",
                                "type": "boolean"
                            }
                        },
                        "additionalProperties": false,
                        "required": ["type", "match"]
                    }, {
                        "title": "Custom resources.",
                        "type": "object",
                        "properties": {
                            "type": {
                                "type": "string",
                                "enum": ["custom"]
                            },
                            "resources": {
                                "title": "Resources to push.",
                                "type": "array",
                                "items": {
                                    "type": "object",
                                    "properties": {
                                        "file": {
                                            "type": "string"
                                        },
                                        "type": {
                                            "type": "string",
                                            "enum": ["audio", "video", "track", "script", "style", "image", "font", "fetch", "worker", "embed", "object", "document"]
                                        },
                                        "mime": {
                                            "type": "string"
                                        }
                                    },
                                    "additionalProperties": false,
                                    "required": ["file", "type"]
                                },
                                "uniqueItems": true
                            },
                            "meta": {
                                "title": "Add meta rel=preload to header.",
                                "type": "boolean"
                            }
                        },
                        "additionalProperties": false,
                        "required": ["type", "resources"]
                    }]
                },
                "uniqueItems": true
            }
        };

        var json = [];
        if (jQuery('#http2_push_config_src').val() !== '') {
            json = jQuery('#http2_push_config_src').val();
            if (typeof json !== 'object') {
                try {
                    json = JSON.parse(json);
                } catch (e) {
                    json = [];
                }
            }
            if (!json || typeof json !== 'object') {
                json = [];
            }
        }

        if (json instanceof Array && json.length === 0) {
            json = [];
        }

        var empty = false;
        if (JSON.stringify(json) === '[]') {
            empty = true;
        }

        editors['http2push'] = new JSONEditor($('#http2_push')[0], options, json);

        if (options.mode === 'code') {
            if (!empty) {
                editors['http2push'].editor.setOptions({
                    maxLines: 50
                });
            }
        }

        // set editor reference

        $('#http2_push_config_src').data('json-editor', editors['http2push']);

        $('[data-http2-insert]').on('click', function(e) {
            e.stopPropagation();

            try {
                var json = editors['http2push'].get();
            } catch (e) {
                return;
            }

            if (json instanceof Array) {

                var insertJson = $(this).data('http2-insert');
                if (typeof insertJson === 'string') {
                    insertJson = JSON.parse(insertJson);
                }

                if (!(insertJson instanceof Array)) {
                    insertJson = [insertJson];
                }
                for (var i = 0; i < insertJson.length; i++) {
                    json.push(insertJson[i]);
                }
                editors['http2push'].set(json);


                jQuery('#http2_push_config_src').val(JSON.stringify(json));
            }
        });

    }


});