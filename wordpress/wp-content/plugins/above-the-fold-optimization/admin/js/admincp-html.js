jQuery(function($) {

    /**
     * Search & Replace editor
     */
    if ($('#html_search_replace').length > 0) {

        $('#html_search_replace').html('');

        var changeTimeout;

        var options = {
            name: "html.replace",
            mode: 'code',
            modes: ['code', 'tree'], // allowed modes
            onError: function(err) {
                console.error('JSON', err.toString());
                alert('JSON error. Please verify your input.\n\nSee console for details.');
            },
            onChange: function() {
                var t = editor.getText();

                if ($.trim(t) === '') {
                    if (changeTimeout) {
                        clearTimeout(changeTimeout);
                    }
                    // wait for copy past action
                    changeTimeout = setTimeout(function() {
                        changeTimeout = false;
                        var t = editor.getText();
                        if ($.trim(t) === '') {
                            editor.set([]);
                            jQuery('#html_search_replace_src').val('[]');
                        }
                    }, 25);

                    return;
                }

                try {
                    var json = editor.get();
                } catch (e) {

                    return;
                }
                jQuery('#html_search_replace_src').val(JSON.stringify(json));
            },
            onModeChange: function(newMode, oldMode) {
                var t = editor.getText();
                if ($.trim(t) === '') {
                    editor.set([]);
                }
                // expand nodes
                if (newMode === 'tree') {
                    editor.expandAll();
                }
            },
            search: false,
            schema: {
                "title": "HTML search and replace",
                "type": "array",
                "items": {
                    "oneOf": [{
                        "title": "String Match",
                        "type": "object",
                        "properties": {
                            "search": {
                                "type": "string"
                            },
                            "replace": {
                                "type": "string"
                            }
                        },
                        "required": [
                            "search",
                            "replace"
                        ],
                        "additionalProperties": false
                    }, {
                        "title": "Regular Expression Match",
                        "type": "object",
                        "properties": {
                            "search": {
                                "type": "string"
                            },
                            "replace": {
                                "type": "string"
                            },
                            "regex": {
                                "title": "Regular expression",
                                "type": "boolean",
                                "enum": [
                                    true
                                ]
                            }
                        },
                        "required": [
                            "search",
                            "replace",
                            "regex"
                        ],
                        "additionalProperties": false
                    }]
                },
                "uniqueItems": true
            }
        };

        var json = [];
        if (jQuery('#html_search_replace_src').val() !== '') {
            json = jQuery('#html_search_replace_src').val();
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
        var editor = new JSONEditor($('#html_search_replace')[0], options, json);

        editor.compact(); // collapseAll();

        // set editor reference
        $('#html_search_replace_src').data('json-editor', editor);

    }

});