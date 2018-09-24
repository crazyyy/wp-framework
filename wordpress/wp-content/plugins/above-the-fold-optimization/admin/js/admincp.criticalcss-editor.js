jQuery(function() {

    /**
     * Advanced Critical CSS editor
     */
    var advancedEditor = (jQuery('#abtfcss').length > 0 && parseInt(jQuery('#abtfcss').data('advanced')) === 1) ? true : false;

    // CodeMirror instances
    var advancedEditors = {};

    if (advancedEditor) {

        // load editor
        var loadEditor = function(editor_id) {

            if (jQuery('#ccss_editor_'+editor_id+' .abtfcss').length === 0) {
                return;
            }

            // codemirror
            advancedEditors[editor_id] = CodeMirror.fromTextArea(
                jQuery('#ccss_editor_'+editor_id+' .abtfcss')[0], {
                lineWrapping: true,
                lineNumbers: true,
                gutters: ["CodeMirror-lint-markers"],
                lint: true
            });
            advancedEditors[editor_id].on('change', function() {
                window.inputChange = true;
            });

            jQuery('#ccss_editor_'+editor_id).closest('.menu-item').removeClass('menu-item-edit-inactive').addClass('menu-item-edit-active');

            resizeEditors();
        }

        // unload editor
        var unloadEditor = function(editor_id) {
            if (advancedEditors[editor_id]) {
                advancedEditors[editor_id].save();
                advancedEditors[editor_id].toTextArea();
                advancedEditors[editor_id] = false;

                jQuery('#ccss_editor_'+editor_id).closest('.menu-item').addClass('menu-item-edit-inactive').removeClass('menu-item-edit-active');

            }
        }

        // resize editor
        var resizeEditors = function() {
            var d = jQuery('.CodeMirror').closest('.inside').outerWidth();
            var w = (d - 26);
            jQuery('.CodeMirror').css({width: w + 'px'});
        }


        /**
         * Resize editors on window resize
         */
        jQuery( window ).resize(function() {

            resizeEditors();

            for (editor_id in advancedEditors) {
                if (advancedEditors.hasOwnProperty(editor_id)) {
                    continue;
                }
                if (advancedEditors[editor_id]) {
                    advancedEditors[editor_id].refresh();
                }
            }
        });
    }

    // load condition selectize for editor
    window.loadConditionSelect = function(selectizeInput) {
        
        if (jQuery(selectizeInput).length === 0) {
            return;
        }

        jQuery(selectizeInput).val('');

        /**
         * Populate selectmenu
         */
        var selectize = jQuery(selectizeInput).selectize({
            options: [],
            searchField: ['title', 'titlelong', 'value'],
            persist : true,
            optgroupField: 'optgroup',
            placeholder: "Select one or more conditions. Type the name of a page or post to search (autocomplete)...",
            delimiter: '|==abtf==|',
            render: {
                optgroup_header: function(item, escape) {
                    return '<div class="optgroup-header "><span class="'+item.class+'">&nbsp;</span>' + escape(item.title) + '</div>';
                },
                option: function(item, escape) {
                    return '<div class="opt">' +
                        '<span class="title">' +
                            '<span class="name">' + escape((item.titlelong) ? item.titlelong : item.title) + '</span>' +
                            '<span class="desc">&nbsp;&nbsp;' + escape(item.value) + '</span>' +
                        '</span>' +
                    '</div>';
                },
                item: function(item, escape) {
                    return '<div class="'+item.class+'" title="' + escape(item.value) + ((item.titlelong) ? ' - ' + escape(item.titlelong) : '') + '">' +
                        '<span class="name">' + escape(item.title) + '</span>' +
                    '</div>';
                }
            },
            createFilter: function(input) {
                var match, regex;

                // email@address.com
                regex = new RegExp('^filter:([a-z0-9\-\_]+(:.*)?)?$', 'i');
                if (regex.test(input)) return input;

                return false;
            },
            create: function(input) {
                if ((new RegExp('^filter:[a-z0-9\-\_]+(:.*)?$', 'i')).test(input)) {
                    return {
                        'value': input,
                        'title': input,
                        'optgroup': 'filter',
                        'class': 'filter'
                    };
                }
                return false;
            },
            load: function (query, callback) {
                if (!query.length) return callback();
                jQuery.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'abtf_condition_search',
                        query: query,
                        maxresults: 10
                    },
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        callback(res);
                    }
                });
            },
            plugins: ['remove_button']
        });

        // insert default options
        var opt,optgroup;
        for (optgroup in window.conditional_options[1]) {
            if (!window.conditional_options[1].hasOwnProperty(optgroup)) {
                continue;
            }
            selectize[0].selectize.addOptionGroup(optgroup,window.conditional_options[1][optgroup]);
        }
        for (var i = 0; i < window.conditional_options[0].length; i++) {
            opt = window.conditional_options[0][i];
            selectize[0].selectize.addOption(opt);
        }

        // set selected options
        var selected_conditions = jQuery(selectizeInput).data('conditions');
        if (selected_conditions) {
            for (var i = 0; i < selected_conditions.length; i++) {
                if (typeof selectize[0].selectize.options[selected_conditions[i].value] === 'undefined') {
                    selectize[0].selectize.addOption(selected_conditions[i]);
                }
                selectize[0].selectize.addItem(selected_conditions[i].value,true);
            }
        }
    }

    // unload condition selectize for editor
    window.unloadConditionSelect = function(selectizeInput) {
        if (jQuery(selectizeInput).length === 0) {
            return;
        }

        var selectize = jQuery(selectizeInput)[0].selectize;
        var selected = selectize.getValue().split(selectize.settings.delimiter);

        var conditions = [];
        if (selected instanceof Array) {
            var keys = ['value','title','optgroup','class'];
            var kl = keys.length;
            var l = selected.length;
            for (var i = 0; i < l; i++) {
                if (selectize.options[selected[i]]) {
                    var opt = selectize.options[selected[i]];
                    var value = {};
                    for (var k = 0; k < kl; k++) {
                        if (typeof opt[keys[k]] !== 'undefined') {
                            value[keys[k]] = opt[keys[k]];
                        }
                    }
                    conditions.push(value);
                }
            }
        }

        // update selected conditions parameter
        jQuery(selectizeInput).data('conditions', conditions);

        selectize.destroy();
    }

    if (jQuery('.criticalcss-edit-header').length > 0) {

        var toggleTimeout = {};

        var toggleClickHandler = function(header,state) {

            var editor_id = jQuery(header).attr('rel');

            var toggleState = parseInt(jQuery('#ccss_editor_' + editor_id).data('toggle-start'));
            if (toggleState === 1) {

                if (state === 1) {

                    if (toggleTimeout[editor_id]) {
                        clearTimeout(toggleTimeout[editor_id]);
                    }

                    // restore
                    jQuery('#ccss_editor_' + editor_id).data('toggle-start','');
                    jQuery(header).on('click', toggleCriticalCSSEditor);

                    jQuery('.loading-editor',header).hide();
                }
            } else {

                // stop listening for clicks
                if (state === 0) {

                    // show loading notice
                    if (!jQuery('#ccss_editor_' + editor_id).is(':visible')) {
                        jQuery('.loading-editor',header).show();
                    }

                    // stop listening for clicks
                    jQuery('#ccss_editor_' + editor_id).data('toggle-start',1);
                    jQuery(header).off('click', toggleCriticalCSSEditor);

                    // restore timeout
                    toggleTimeout[editor_id] = setTimeout(function() {
                        toggleClickHandler(header,1);
                    },3000);
                }
            }

            return toggleState;

        }

        /**
         * Toggle critical CSS editor
         */
        var toggleCriticalCSSEditor = function(e) {

            var header = jQuery(this);
            var editor_id = jQuery(this).attr('rel');

            // prevent multiple fast clicks
            if(e.originalEvent.detail > 1){
                return;
            }
            e.preventDefault();
            e.stopPropagation();

            // stop listening for clicks on header, to prevent overload
            if (toggleClickHandler(header,0) === 1) {
                return false;
            }

            setTimeout(function() {

                // load editor in animation frame
                window.requestAnimationFrame(function RAF() {

                    if (jQuery('#ccss_editor_' + editor_id).is(':visible')) {

                        /**
                         * Destroy advanced editor
                         */
                        if (advancedEditor) {
                            unloadEditor(editor_id);
                        }

                        // unload selectize
                        unloadConditionSelect(jQuery('.conditions input[rel="conditions"]',jQuery('#ccss_editor_' + editor_id)));

                        jQuery('#ccss_editor_' + editor_id).hide();

                    } else {

                        jQuery('#ccss_editor_' + editor_id).show();

                        if (advancedEditor) {
                            loadEditor(editor_id);
                        }

                        // load selectize
                        loadConditionSelect(jQuery('.conditions input[rel="conditions"]',jQuery('#ccss_editor_' + editor_id)));

                    }

                    // restore listening for clicks
                    toggleClickHandler(header,1);

                });
            },10);
        }

        // watch click
        jQuery('.criticalcss-edit-header').on('click', toggleCriticalCSSEditor);

        // delete buttons
        jQuery('.criticalcss-edit-header').each(function(i, header) {
            if (jQuery('.item-delete',jQuery(header)).length > 0) {

                var ccss_file = jQuery(header).data('file');

                jQuery('.item-delete',jQuery(header)).on('click', function(e) {

                    e.preventDefault();
                    e.stopPropagation();

                    if (confirm(jQuery(this).data('confirm'),true)) {

                        // create delete form
                        var form = jQuery('<form />');
                        form.attr('method','post');
                        form.attr('action',jQuery('#abtf_settings_form').data('delccss'));

                        var input = jQuery('<input type="hidden" name="file" />');
                        input.val(ccss_file);
                        form.append(input);

                        var input = jQuery('<input type="hidden" name="_wpnonce" />');
                        input.val(jQuery('#_wpnonce').val());
                        form.append(input);

                        jQuery('body').append(form);

                        jQuery(form).submit();
                    }
                });
            }
        })

    }

    /**
     * Advanced Critical CSS editor
     */
    if (jQuery('#abtfcss').length > 0 && parseInt(jQuery('#abtfcss').data('advanced')) === 1) {

        jQuery('.ccss_editor').each(function(i,el) {

            // editor is visible
            if (jQuery(el).is(':visible')) {
                if (advancedEditor) {
                    loadEditor(jQuery('.criticalcss-edit-header',jQuery(el).parents('.menu-item').first()).attr('rel'));
                }
            }
        });

/*
        window.abtfcssToggle = function(obj) {
            if (jQuery('.CodeMirror').hasClass('large')) {
                jQuery(obj).html('[+] Large Editor');
            } else {
                jQuery(obj).html('[-] Small Editor');
            }

            jQuery('.CodeMirror').toggleClass('large');
            //window.abtfcss.refresh();
        };*/
    }
});