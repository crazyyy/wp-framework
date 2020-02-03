jQuery(document).ready(function ($) {
    'use strict';
    //tabs
    $(document).on('click', '.cmplz-tablinks', function(){
        $(".cmplz-tablinks").removeClass('active');
        $(this).addClass('active');
        $(".cmplz-tabcontent").removeClass('active');
        $("#"+$(this).data('tab')).addClass('active');
        $('input[name=cmplz_active_tab]').val($(this).data('tab'));
    });

    //remove alerts
    window.setTimeout(function () {
        $(".cmplz-hide").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 2000);

    /*
    * open and close panels
    * */
    $(document).on('click', '.cmplz-panel-toggle', function(){
        var content = $(this).closest('.cmplz-slide-panel').find('.cmplz-panel-content');
        var icon_toggle = $(this).closest('.cmplz-slide-panel').find('i.toggle');
        //close all open panels

        if (content.is(':hidden')){
            icon_toggle.removeClass('fa-caret-right');
            icon_toggle.addClass('fa-caret-down');
            content.slideDown("fast");

        } else {
            content.slideUp( 'fast');
            icon_toggle.removeClass('fa-caret-down');
            icon_toggle.addClass('fa-caret-right');
        }
    });

    /*
    * help modals
    * */
    $(document).on('click', '.cmplz-open-modal', function(e){

        e.preventDefault();
        var field_group = $(this).closest('.field-group');
        var field = field_group.find('.cmplz-field');
        var help_modal = field_group.find('.cmplz-help-modal');

        //close all other modals.

        $('.cmplz-field').each(function(){
            $(this).css('float','none');
            $(this).css('width','100%');
        });

        $('.cmplz-help-modal').each(function(){
            $(this).hide();

            //reset parent div height
            $(this).parent().height(0);
        });
        field.css('float','left');
        field.css('width','60%');

        //force the div height
        if (!field_group.hasClass('cmplz-settings')) {
            var height = field.height();
            if (help_modal.height() > height) height = help_modal.height();
            height += 20;
            help_modal.parent().height(height);
        }
        help_modal.fadeIn();



    });

    $(document).on('click', '.cmplz-help-modal span', function(e){
        $(this).closest('.cmplz-help-modal').fadeOut();
    });


    //colorpicker in the wizard
    $('.cmplz-color-picker').wpColorPicker({
            change:
                function (event, ui) {
                    var container_id = $(event.target).data('hidden-input');
                    $('#' + container_id).val(ui.color.toString());
                }
        }
    );


    /*
    *
    * On multiple fields, we check if all input type=text and textareas are filled
    *
    * */

    function cmplz_validate_multiple() {
        $('.multiple-field').each(function(){

            var completed=true;
            $(this).find('input[type=text]').each(function () {
               if ($(this).val()===''){
                   completed = false;
               }
            });

            $(this).find('textarea').each(function () {
                if ($(this).val()===''){
                    completed = false;
                }
            });

            var icon = $(this).closest('.cmplz-panel').find('.cmplz-multiple-field-validation i');
            if (completed){
                icon.removeClass('fa-times');
                icon.addClass('fa-check');
            } else {
                icon.addClass('fa-times');
                icon.removeClass('fa-check');
            }
        });
    }
    cmplz_validate_multiple()
    $(document).on('keyup', '.multiple-field input[type=text]', function () {
        cmplz_validate_multiple();
    });
    $(document).on('keyup', '.multiple-field textarea', function () {
        cmplz_validate_multiple();
    });

    //validation of checkboxes
    cmplz_validate_checkboxes();
    $('.cmplz-validate-multicheckbox .is-required:checkbox').change(cmplz_validate_checkboxes);

    function cmplz_validate_checkboxes() {
        $('.cmplz-validate-multicheckbox').each(function (i) {
            var set_required = [];
            var all_unchecked = true;
            $(this).find(':checkbox').each(function (i) {

                set_required.push($(this));

                if ($(this).is(':checked')) {
                    all_unchecked = false;
                }
            });
            var container = $(this).closest('.field-group').find('.cmplz-label');
            if (all_unchecked) {
                container.removeClass('valid-multicheckbox');
                container.addClass('invalid-multicheckbox');
                $.each(set_required, function (index, item) {
                    item.prop('required', true);
                    item.addClass('is-required');
                });

            } else {
                container.removeClass('invalid-multicheckbox');
                container.addClass('valid-multicheckbox');
                $.each(set_required, function (index, item) {
                    item.prop('required', false);
                    item.removeClass('is-required');
                });
            }

        });


        //now apply the required.

        check_conditions();
    }


    //validation of checkboxes
    cmplz_validate_radios();
    $('input:radio').attr('required',true).click(cmplz_validate_radios);
    //$(document).on('click','input:radio:required', cmplz_validate_radios );
    function cmplz_validate_radios() {
        $('.cmplz-validate-radio').each(function (i) {
            var set_required = [];
            var all_unchecked = true;

            $(this).find('input:radio').each(function (i) {
                set_required.push($(this));
                if ($(this).is(':checked')) {
                    all_unchecked = false;
                }
            });
            var container = $(this).closest('.field-group').find('.cmplz-label');
            if (all_unchecked) {
                container.removeClass('valid-radio');
                container.addClass('invalid-radio');
            } else {
                container.removeClass('invalid-radio');
                container.addClass('valid-radio');
            }

        });


        //now apply the required.

        check_conditions();
    }

    check_conditions();
    $("input").change(function (e) {
        check_conditions();
    });

    $("select").change(function (e) {
        check_conditions();
    });

    $("textarea").change(function (e) {
        check_conditions();
    });


    $(document).on("cmplzRenderConditions", check_conditions);

    /*conditional fields*/
    function check_conditions() {
        var value;
        var showIfConditionMet = true;

        $(".condition-check").each(function (e) {
            var question = 'cmplz_' + $(this).data("condition-question");
            var condition_type = 'AND';

            if (question == undefined) return;

            var condition_answer = $(this).data("condition-answer");

            //remove required attribute of child, and set a class.
            var input = $(this).find('input[type=checkbox]');
            if (!input.length) {
                input = $(this).find('input');
            }
            if (!input.length) {
                input = $(this).find('textarea');
            }
            if (!input.length) {
                input = $(this).find('select');
            }

            if (input.length && input[0].hasAttribute('required')) {
                input.addClass('is-required');
            }

            //cast into string
            condition_answer += "";

            if (condition_answer.indexOf('NOT ') !== -1) {
                condition_answer = condition_answer.replace('NOT ', '');
                showIfConditionMet = false;
            } else {
                showIfConditionMet = true;
            }
            var condition_answers = [];
            if (condition_answer.indexOf(' OR ') !== -1) {
                condition_answers = condition_answer.split(' OR ');
                condition_type = 'OR';
            } else {
                condition_answers = [condition_answer];
            }

            var container = $(this);
            var conditionMet = false;
            condition_answers.forEach(function (condition_answer) {
                value = get_input_value(question);

                if ($('select[name=' + question + ']').length) {
                    value = Array($('select[name=' + question + ']').val());
                }

                if ($("input[name='" + question + "[" + condition_answer + "]" + "']").length){
                    if ($("input[name='" + question + "[" + condition_answer + "]" + "']").is(':checked')) {
                        conditionMet = true;
                        value = [];
                    } else {
                        conditionMet = false;
                        value = [];
                    }
                }

                if (showIfConditionMet) {

                    //check if the index of the value is the condition, or, if the value is the condition
                    if (conditionMet || value.indexOf(condition_answer) != -1 || (value == condition_answer)) {

                        container.removeClass("hidden");
                        //remove required attribute of child, and set a class.
                        if (input.hasClass('is-required')) input.prop('required', true);
                        //prevent further checks if it's an or statement
                        if (condition_type === 'OR') conditionMet = true;

                    } else {
                        container.addClass("hidden");
                        if (input.hasClass('is-required')) input.prop('required', false);
                        //prevent further checks if it's an or statement
                        if (condition_type === 'OR') return;
                    }
                } else {

                    if (conditionMet || value.indexOf(condition_answer) != -1 || (value == condition_answer)) {
                        container.addClass("hidden");
                        if (input.hasClass('is-required')) input.prop('required', false);

                    } else {
                        container.removeClass("hidden");
                        if (input.hasClass('is-required')) input.prop('required', true);
                    }
                }
            });

        });
    }


    /**
        get checkbox values, array proof.
    */

    function get_input_value(fieldName) {

        if ($('input[name=' + fieldName + ']').attr('type') == 'text') {
            return $('input[name^=' + fieldName + ']').val();
        } else {
            var checked_boxes = [];
            $('input[name=' + fieldName + ']:checked').each(function () {
                checked_boxes[checked_boxes.length] = $(this).val();
            });
            return checked_boxes;
        }
    }


    /*cookie scan */
    var cmplz_interval = 10000;
    var progress = complianz_admin.progress;
    var progressBar = $('.cmplz-progress-bar');
    var cookieContainer = $(".detected-cookies");
    var previous_page;

    if ($("#cmplz-scan-progress").length){
        cmplz_interval = 3000;
    }

    function checkIframeLoaded() {
        // Get a handle to the iframe element
        var iframe = document.getElementById('cmplz_cookie_scan_frame');
        var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
        if (!cookieContainer.find('.cmplz-loader').length && progress < 100) {
            cookieContainer.html('<div class="cmplz-loader"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>');
            cookieContainer.addClass('loader');
        }
        // Check if loading is complete
        iframe.onload = function () {
            // The loading is complete, call the function we want executed once the iframe is loaded
            if (progress >= 100) return;

            $.get(
                complianz_admin.admin_url,
                {
                    action: 'cmplz_get_scan_progress'
                },
                function (response) {
                    var obj;
                    if (response) {
                        obj = jQuery.parseJSON(response);

                        progress = parseInt(obj['progress']);
                        var next_page = obj['next_page'];
                        if (progress >= 100) {
                            progress = 100;
                            progressBar.css({width: progress + '%'});
                            $.ajax({
                                type: "GET",
                                url: complianz_admin.admin_url,
                                dataType: 'json',
                                data: ({
                                    action: 'load_detected_cookies',
                                }),
                                success: function (response) {
                                    if (response.success) {
                                        $('.detected-cookies').html(response.cookies);
                                        $('.detected-cookies.loader').removeClass('loader');
                                    }
                                }
                            });

                        } else {
                            progressBar.css({width: progress + '%'});
                            console.log('loading for cookie scan: '+next_page);
                            $("#cmplz_cookie_scan_frame").attr('src', next_page);

                            window.setTimeout(checkIframeLoaded, cmplz_interval);
                        }
                    }
                }
            );
            return;
        }

        // If we are here, it is not loaded. Set things up so we check the status again
        window.setTimeout(checkIframeLoaded, cmplz_interval);
    }

    if ($('#cmplz_cookie_scan_frame').length) {
        checkIframeLoaded();
    }

    progressBar.css({width: progress + '%'});

    /*Cookie Database sync*/
    var syncProgress = 0;
    var syncProgressBar = $('.cmplz-sync-progress-bar');
    if ($('#cmplz-sync-progress').length) {
        var syncProgress = complianz_admin.syncProgress;
        if (syncProgress<100) {
            syncProgressBar.css({width: syncProgress + '%'});
            syncCookieDatabase();
        }
    } else if ($('.cmplz-list-container').length){
        loadListItem();
    }

    var loader = '<div class="cmplz-loader"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>';
    function syncCookieDatabase() {
        //hide cookies during sync

        //$('#cmplz-sync-loader').html(loader);

        $.get(
            complianz_admin.admin_url,
            {
                action: 'cmplz_run_sync'
            },
            function (response) {
                var obj;
                if (response) {
                    obj = jQuery.parseJSON(response);

                    syncProgress = parseInt(obj['progress']);
                    var message = obj['message'];
                    if (typeof message !== 'undefined' && message.length>0){
                        $('#cmplz_action_error').removeClass('cmplz-hidden');
                        $('#cmplz_action_error .cmplz-panel').html(message);
                    }
                    if (syncProgress >= 100) {
                        syncProgress = 100;
                        $('#cmplz-sync-loader').html('');
                        loadListItem();
                        syncProgressBar.css({width: syncProgress + '%'});
                    } else {
                        syncProgressBar.css({width: syncProgress + '%'});
                        window.setTimeout(syncCookieDatabase, 500);
                    }

                }
            }
        );
    }


    //custom text for policy
    $(document).on("click", ".cmplz-add-to-policy", function () {
        var title = $(this).closest('.cmplz-slide-panel').find('.cmplz-title').html();
        var text = $(this).closest('.cmplz-slide-panel').find('.cmplz-panel-content').html();

        var content = tmce_getContent('cmplz_custom_privacy_policy_text');
        tmce_setContent(content + '<h3>' + title + '</h3>' + text, 'cmplz_custom_privacy_policy_text');
        $(this).remove();
    });

    function tmce_getContent(editor_id, textarea_id) {
        if (typeof editor_id == 'undefined') editor_id = wpActiveEditor;
        if (typeof textarea_id == 'undefined') textarea_id = editor_id;

        if (jQuery('#wp-' + editor_id + '-wrap').hasClass('tmce-active') && tinyMCE.get(editor_id)) {
            return tinyMCE.get(editor_id).getContent();
        } else {
            return jQuery('#' + textarea_id).val();
        }
    }

    function tmce_setContent(content, editor_id, textarea_id) {
        if (typeof editor_id == 'undefined') editor_id = wpActiveEditor;
        if (typeof textarea_id == 'undefined') textarea_id = editor_id;

        if (jQuery('#wp-' + editor_id + '-wrap').hasClass('tmce-active') && tinyMCE.get(editor_id)) {
            return tinyMCE.get(editor_id).setContent(content);
        } else {
            return jQuery('#' + textarea_id).val(content);
        }
    }

    function tmce_focus(editor_id, textarea_id) {
        if (typeof editor_id == 'undefined') editor_id = wpActiveEditor;
        if (typeof textarea_id == 'undefined') textarea_id = editor_id;

        if (jQuery('#wp-' + editor_id + '-wrap').hasClass('tmce-active') && tinyMCE.get(editor_id)) {
            return tinyMCE.get(editor_id).focus();
        } else {
            return jQuery('#' + textarea_id).focus();
        }
    }


    //statistics, handle graphs visibility

    var cmplz_visible_stat = '#bar_pct_all_container';
    $(cmplz_visible_stat).show();
    $(document).on('change', 'select[name=cmplz_region]', function () {

        $(cmplz_visible_stat).hide();
        var region = $('select[name=cmplz_region]').val();
        var type = $('select[name=stats_type]').val();
        cmplz_visible_stat = '#bar_' + type + '_' + region + '_container';
        $(cmplz_visible_stat).fadeIn();
    });

    $(document).on('change', 'select[name=stats_type]', function () {
        $(cmplz_visible_stat).hide();
        var region = 'eu';
        if ($('select[name=cmplz_region]').length) region = $('select[name=cmplz_region]').val();
        var type = $('select[name=stats_type]').val();
        cmplz_visible_stat = '#bar_' + type + '_' + region + '_container';
        $(cmplz_visible_stat).fadeIn();
    });

    /**
     * Keep personal data checkbox in sync with entry field
     */

    $(document).on('change', '.cmplz_isPersonalData', function(){
        cmplz_personalDataFieldVisibility($(this));
    });
    function cmplz_personalDataFieldVisibility(obj){
        var container = obj.closest('.cmplz-field');
        if (obj.is(":checked")) {
            container.find('.cmplz_collectedPersonalData').parent().show();
        } else {
            container.find('.cmplz_collectedPersonalData').parent().hide();
        }
    }

    /**
     * Keep thirdparty checkbox in sync with privacy policy url field
     */

    $(document).on('change', '.cmplz_thirdParty', function(){
        cmplz_privacyStatementUrlFieldVisibility($(this));
    });
    function cmplz_privacyStatementUrlFieldVisibility(obj){
        var container = obj.closest('.cmplz-field');
        if (obj.is(":checked")) {
            container.find('.cmplz_privacyStatementURL').parent().show();
        } else {
            container.find('.cmplz_privacyStatementURL').parent().hide();
        }
    }

    /**
     * Keep sync button in sync with disabled state for both cookies and services
     */
    $(document).on('change', '.cmplz_sync', function(){

        var container = $(this).closest('.cmplz-field');
        var disabled = false;
        if ($(this).is(":checked")) disabled=true;
        container.find(':input').each(function () {
            if ($(this).attr('name')==='cmplz_remove_item' || $(this).attr('name')==='cmplz-save-item' || $(this).attr('name')==='cmplz_showOnPolicy' || $(this).attr('name')==='cmplz_sync') return;
            $(this).prop('disabled', disabled);
            if (disabled){
                $(this).closest('div').addClass('cmplz-disabled');

            } else{
                $(this).closest('div').removeClass('cmplz-disabled');

            }
        });
    });

    /**
     * Keep sync icon in sync.
     */

    $(document).on('change', '.cmplz_sync', function(){
        var container = $(this).closest('.cmplz-panel');

        if ($(this).is(":checked")) {
            container.find('.fa-sync-alt').removeClass('cmplz-disabled');
        } else {
            container.find('.fa-sync-alt').addClass('cmplz-disabled');
        }
    });

    /**
     * Keep show on policy icon in sync
     */

    $(document).on('change', '.cmplz_showOnPolicy', function(){
        var container = $(this).closest('.cmplz-panel');

        if ($(this).is(":checked")) {
            container.find('.fa-file').removeClass('cmplz-error');
        } else {
            container.find('.fa-file').addClass('cmplz-error');
        }
    });



    $(document).on('keyup', '.cmplz-panel input', function(){
        cmplzCheckIfCookieIsComplete($(this));
    });
    $(document).on('change', '.cmplz-panel select', function(){
        cmplzCheckIfCookieIsComplete($(this));
    });

    function cmplzCheckIfCookieIsComplete(obj){
        var isComplete = true;
        var container = obj.closest('.cmplz-panel');
        container.find(':input:not(.cmplz_cookieFunction)').each(function () {
            if (!$(this).is(':checkbox') && !$(this).is(':hidden') && $(this).prop("type")!=='button'){
                if ($(this).prop('nodeName')!=='SELECT' && $(this).val().length > 0) {
                    //text is complete
                } else if($(this).prop('nodeName')==='SELECT' && $(this).val()!=0){
                    //select is complete
                } else {
                    isComplete = false;
                }
            }
        });

        if (isComplete){
            var icon = container.find('.fa.fa-times');
            icon.removeClass('cmplz-error');
            icon.addClass('cmplz-success');
            icon.addClass('fa-check');
            icon.removeClass('fa-times');


        } else {
            var icon = container.find('.fa.fa-check');
            icon.addClass('cmplz-error');
            icon.removeClass('cmplz-success');
            icon.addClass('fa-times');
            icon.removeClass('fa-check');


        }
    }


    /**
     * handle language switch for cookies
     *
     **/

    if ($('#cmplz_language').length) {
        var syncProgress = complianz_admin.syncProgress;
        if (syncProgress==100) loadListItem();

        $(document).on('change', '#cmplz_language', function () {
            $('.cmplz-list-container').html('<div class="cmplz-skeleton"></div>');
            loadListItem();
        });
    }

    //select2 dropdown
    if ($('.cmplz-select2').length) {
        cmplzInitSelect2()
    }

    function cmplzInitSelect2() {
        $('.cmplz-select2').select2({
            tags: true,
            width:'400px',
        });

        $('.cmplz-select2-no-additions').select2({
            width:'400px',
        });
    }



    function loadListItem(){

        var language = $('#cmplz_language').val();

        var type = $('#cmplz_language').data('type');
        $.ajax({
            type: "GET",
            url: complianz_admin.admin_url,
            dataType: 'json',
            data: ({
                language: language,
                action: 'cmplz_get_list',
                type: type,
            }),
            success: function (response) {
                if (response.success) {
                    $('.cmplz-list-container').html(response.html);

                    $('.cmplz_isPersonalData').each(function(){
                        cmplz_personalDataFieldVisibility($(this));
                    });

                    $('.cmplz_thirdParty').each(function(){
                        cmplz_privacyStatementUrlFieldVisibility($(this));
                    });

                    cmplzInitSelect2();
                }
            }
        });
    }

    /**
    * add, Save and delete cookies
    *
    * */

    $(document).on('click', '.cmplz-edit-item', function(){
        var template = $('.cmplz-settings-template').html();
        var alertSuccess = $('#cmplz_action_success');
        var action = $(this).data('action');
        var btn = $(this);
        var type = btn.data('type');
        var container = $(this).closest('.cmplz-'+type+'-field');
        var panel = $(this).closest('.cmplz-panel.cmplz-slide-panel');
        var language = $('#cmplz_language').val();
        var btnHtml = btn.html();
        btn.html('<div class="cmplz-loader"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>');

        var item_id = container.data(type+'_id');
        var data = {};
        container.find(':input').each(function () {
            if ($(this).attr('type')==='button') return;

            if ($(this).attr('type')==='checkbox') {
                data[$(this).attr('name')] = $(this).is(":checked");
            } else {
                data[$(this).attr('name')] = $(this).val();
            }
        });


        $.ajax({
            type: "POST",
            url: complianz_admin.admin_url,
            dataType: 'json',
            data: ({
                item_id : item_id,
                type : type,
                data : JSON.stringify(data),
                cmplz_action : action,
                language:language,
                action: 'cmplz_edit_item',
            }),
            success: function (response) {
                if (response.success) {
                    if (action==='delete'){
                        panel.remove();
                    }
                    if (action==='add'){
                        var html = response.html;
                        var list_container = $('.cmplz-field>div.cmplz-list-container');
                        var noservice = $('.cmplz-service-divider.no-service');
                        if (noservice.length){
                            noservice.after(html);
                        } else {
                            html = response.divider + html;
                            list_container.append(html);
                        }
                    }
                    if (action==='save'){
                        alertSuccess.show(100, function(){
                            alertSuccess.delay(1000).hide();
                        });
                    }

                    btn.html(btnHtml);
                    cmplzInitSelect2();

                }
            }
        });
    });

    /*
    * show shortcodes
    *
    * */

    $(document).on('click', '.cmplz-open-shortcode', function(){
        $(this).closest('.cmplz-success').find('.cmplz-shortcode').toggle();
    });



    /*
    * Check for anonymous window, adblocker
    *
    * */

    function cmplz_check_cookie_blocking_services() {
        if ($('#cmplz_anonymous_window_warning').length) {
            var fs = window.RequestFileSystem || window.webkitRequestFileSystem;
            if (!fs) {
                return;
            }
            fs(window.TEMPORARY, 100, function (fs) {
            }, function (err) {
                $('#cmplz_anonymous_window_warning').show();
            });
        }

        if ($('#cmplz_adblock_warning').length) {
            if (window.canRunAds === undefined) {
                // adblocker detected, show fallback
                $("#cmplz_adblock_warning").show();
            }
        }
    }
    cmplz_check_cookie_blocking_services();

});