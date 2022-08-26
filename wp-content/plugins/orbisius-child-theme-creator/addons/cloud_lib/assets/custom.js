/**
 * Used for the Snippet Library
 */
jQuery(document).ready(function($) {    
    $('.orb_ctc_ext_cloud_lib_account_log_out').on('click', function (e) {
        e.preventDefault();
        
        var params = {};
        var res_container = $('.orb_ctc_ext_cloud_lib_account').find('.result');
        res_container.html('Please, wait ...');
        
        $.ajax({
            type : 'post',
            url: ajaxurl + '?action=orb_ctc_addon_cloud_lib_log_out',
            data: params,
            success: function(json) {
                if (json.status) {
                    res_container.html('Please, wait');
                    window.location.reload();
                } else {
                    res_container.html(json.msg);
                }
            }
        });
    } );
    
    $('.orb_ctc_signup_form').on('submit', function (e) {
        e.preventDefault();
        var params = $(this).serialize();
        
        if ($('.orb_ctc_pass').val() != $('.orb_ctc_pass2').val() ) {
            alert('Error: Passwords do not match');
            return false;
        }

        var submit_btn = $(this).find(':submit');
        var res_container = $('.orb_ctc_ext_cloud_lib_signup_wrapper').find('.result');
        res_container.html('Please, wait');
        submit_btn.hide();
        
        $.ajax({
            type : 'post',
            url: ajaxurl + '?action=orb_ctc_addon_cloud_lib_signup',
            data: params,
            success: function(json) {
                if (json.status) {
                    res_container.html('Please, wait');
                    window.location.reload();
                } else {
                    var msg = json.msg || "There was an error with the registration. Contact us and report if you think this is a glitch.";
                    res_container.html(msg);
                    submit_btn.show();
                }
            }
        });
        
        return false;
    })
    
    $('.orb_ctc_ext_cloud_lib_edit_snippet_form').on('submit', function (e) {
        e.preventDefault();
        
        var id = $('.edit_id').val().trim() || 0;
        var new_title = $('.edit_title').val().trim();
        var new_content = $('.edit_content').val().trim();
        snippet_update(id, new_title, new_content);
        
        return false;
    });
    
    $('.orb_ctc_login_form').on('submit', function (e) {
        e.preventDefault();
        var params = $(this).serialize();
        
        var submit_btn = $(this).find(':submit');
        var res_container = $('.orb_ctc_ext_cloud_lib_login_wrapper').find('.result');
        res_container.html('Please, wait');
        submit_btn.hide();
        
        $.ajax({
            type : 'post',
            url: ajaxurl + '?action=orb_ctc_addon_cloud_lib_login',
            data: params,
            success: function(json) {
                if (json.status) {
                    res_container.html('Please, wait');
                    window.location.reload();
                } else {
                    var msg = json.msg || "Login details are incorrect.";
                    res_container.html(msg);
                    submit_btn.show();
                }
            }
        });
        
        return false;
    })
	/**
	 * Snippets search autocomplete suggestions
	 * 
	 * Returns suggestions from remote source
	 * Suggestions are based on the characters typed in the input field
	 * 
	 * Expects JSON array
	 * @see https://stackoverflow.com/questions/9656523/jquery-autocomplete-with-callback-ajax-json
	 */
	 $( "#search_text" ).autocomplete( {
            minLength: 3,
            open: function() {
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            },
            source: function (request, response) {
                $.ajax({
                    type : 'post',
                    url: ajaxurl,
                    data: {
                        action: "orb_ctc_addon_cloud_lib_autocomplete",
                        term: request.term,
                    },
                    success: function(json) {
                        response($.map(json.data, function(item) {
                            return {
                                value: item.id,
                                label: item.title
                            };
                        }));
                    },
                    select: function (event, ui) {
                      //  return false;
                    }
                });
            },
	});
	
	/**
	 * Search for a snippet button
	 */
	$('#snippet_search_btn').on("click", function() {
            var search = $("#search_text").val().trim();

            if (search !== '') {
                search_snippets(search);
            } else {
                $("#search_text").focus();
            }
	});

	/**
	 * Press enter to search for a snippet
	 */
	$('#search_text').keypress(function(e) {
            if (e.keyCode == 13 || e.which == 13) {
		// e.preventDefault();
		// sendSelected(this.value);
		// $(this).autocomplete('close');
		var search = $("#search_text").val().trim();
	    
		if (search !== '') {
		    search_snippets(search);
		} else {
    		    $("#search_text").focus();
        	}
	    }
	});
	
	/**
	 * Search for a snippet button
	 * 
	 * On click:	searches for a snippet title matching the criteria from the input field
	 * 
	 * On success:	shows a new text box with the returned data - content and title
	 * 
	 */
	//$('#snippet_search_btn').on("click", function() {
	$( "#search_text" ).on( "autocompleteselect", function( event, ui ) {
            /**
             * Holds the value of the input field
             */
            //var search = $("#search_text").val().trim();
            var search	= ui.item.label;
            
            if (search !== '') {
                search_snippets(search);
            } else {
                $("#search_text").focus();
            }
	});
	
	function search_snippets (search) {
	    $.ajax({
		//dataType: "json",
		type : "post",
		url: ajaxurl,
		data: {
			action: "orb_ctc_addon_cloud_lib_search",
			"search":search
		},
		//success: function (data) {
		success: function(json) {
                    if (json.status) {
                        if (json.data.length > 0) {
                            $.map(json.data, function(item) {
                                if (item != '[]') {
                                    $('.found_snippet').show();
                                    $("#found_snippet_text").val(item.content).focus();
                                    $("#found_snippet_title").val(item.title).focus();
                                }
                            });
                        }
                    }
		}
	});
    }
	
    /**
     * Add a new snippet button
     * 
     * On click:	Displays title and text fields
     * 
     */
    $('#new_snippet_btn').on("click", function() {
        $('.new_snippet_wrapper').show("slow");
    });

    // When title is entered and the Enter key is pressed submit the form.
    $('#add_snippet_title').on("keypress", function(e) {
        if (e.keyCode == 13 || e.which == 13) {
            e.preventDefault();
            $('#snippet_save_btn').trigger('click');
            return false;
        } else {
            return true;
        }
    });

    // When CTRL + Enter is pressed submit the add snippet form
    // https://stackoverflow.com/questions/1684196/ctrlenter-jquery-in-textarea
    // https://stackoverflow.com/questions/7445151/jquery-document-keydown-issues
    $(document).on('keydown', '.add_snippet_text', function(e) {
        if (e.ctrlKey && (e.keyCode == 13 || e.which == 13)) {
            e.preventDefault();
            $('#snippet_save_btn').trigger('click');
            return false;
        } else {
            return true;
        }
    });

    // just enter and no control key -> jump to content
    $(document).on('keydown', '.edit_title', function(e) {
        if (!e.ctrlKey && ( e.keyCode == 13 || e.which == 13)) {
            $('.edit_content').focus();
            return false;
        } else {
            return true;
        }
    });

    // When CTRL + Enter is pressed submit the add snippet form
    // https://stackoverflow.com/questions/1684196/ctrlenter-jquery-in-textarea
    // https://stackoverflow.com/questions/7445151/jquery-document-keydown-issues

    // @todo handle CTRL+S ??? while in the text area to save
    // https://stackoverflow.com/questions/93695/best-cross-browser-method-to-capture-ctrls-with-jquery
    $(document).on('keydown', '.edit_title,.edit_content', function(e) {
        if (e.ctrlKey && (e.keyCode == 13 || e.which == 13)) {
            e.preventDefault();
            $("#edit_snippet").dialog('close');
            $('.orb_ctc_ext_cloud_lib_edit_snippet_form').trigger('submit'); 
            return false;
        } else {
            return true;
        }
    });

    /**
     * Save a new snippet button
     * 
     * On click:	If title is missing, cannot proceed
     * 		If text is missing, asks for confirmation to proceed
     * 
     */
    $('.orb_ctc_ext_cloud_lib_add_new_snippet_form').on("submit", function(e) {
        e.preventDefault();
        //$('#snippet_save_btn').trigger('click');
        return false;
    });

    $('#snippet_save_btn').on("click", function(e) {
        var title	= $('#add_snippet_title').val().trim();
        var text	= $('#add_snippet_text').val().trim();
        snippet_update(0, title, text);
    });

    /**
     * Delete a snippet by id button
     * 
     */
    $('#manage_snippets_table').on("click", '.snippet_delete_btn', function() {
        var id		= $(this).closest('tr').data('id');
        //var title	= $(this).closest('tr').data('title');
        var title   = $(this).closest('tr').children('td.title_cell').children('.snippet_title').text();

        $('.delete_snippet_title').text(title);

        $("#snippet_confirm_dialog_delete").dialog( {
            dialogClass: 'snippet_confirm_dialog_delete',
            modal: true,
            resizable: false,
            draggable: false,
            buttons: [{
                            text: "Yes",
                            "class": 'button-primary',
                            click: function() {
                                    $(this).dialog("close"); 
                                    delete_snippet(id);
                            }
                    },
                    {
                            text: "No",
                            "class": 'button',
                            click: function() { 
                                $(this).dialog("close");
                            }
                    }],
            close: function(event, ui) {
                $('.snippet_delete_btn').blur();
            }
        });
    });

    /**
     * We subtract 1 because we have 1 hidden row.
     * We don't filter by visibility because when a different tab is
     * shown those a technically hidden.
     * @returns {Number}
     */
    function get_snippet_count() {
        return $('#manage_snippets_table .snippet_row').length - 1;
    }

    /**
     * Delete snippet by id
     * 
     * @param id
     * 
     */
    function delete_snippet(id) {
        $(".snippet_row_" + id).remove();

        // if there aren't any visible rows (i.e. excluding the 0 row that we use for cloning)
        if ($('#manage_snippets_table .snippet_row:visible').length <= 0) {
            $('#no_snippets_row').show();
        } else {
            $('#no_snippets_row').hide();
        }

        $.ajax({
            url: ajaxurl,
            data: {
                id: id,
                action: "orb_ctc_addon_cloud_lib_delete"
            },
            success: function (json) {
                // update max items via js
                $('.usage_items').text(get_snippet_count());

                if (json.status) {
                    // the row is deleted anyways so nothing to do.
                    // just have some coffee.
                } else {
                    alert(json.msg);
                }
            }
        });
    }

    /**
     * Edit / view window combined
     * 
     */
    $('#manage_snippets_table').on("click", '.snippet_edit_view_btn', function() {
        var row	= $(this).closest('.snippet_row');
        var id      = $(row).data('id') || 0;
        var title_el  = $(row).find('.snippet_title');
        var title = title_el.html().trim();
        var content_el   = $(row).find('.snippet_content');
        var content = content_el.html().trim();

        // decode entities: browsers will encode '&' and other chars. We want the chars unencoded i.e. not as &amp;
        // https://stackoverflow.com/questions/1147359/how-to-decode-html-entities-using-jquery
        title = $("<textarea/>").html(title).val();
        content = $("<textarea/>").html(content).val();

        $('.edit_id').val(id);
        $('.edit_title').val(title);
        $('.edit_content').val(content);

        var orb_ctc_cloud_lib_edit_snippet_dlg = $("#edit_snippet").dialog( {
            dialogClass: 'edit_snippet',
            modal: true,
            autoOpen: true,
//                autoOpen: false,
            show : false,
            width : 'auto',
            resizable: true,
            minWidth: 300,
            minHeight: 300,
            position: { my: "center", at: "center", of: window },
            buttons: [
                {
                    text: 'Save Changes',
                    class: 'button-primary',
                    click: function() {
                        $('.orb_ctc_ext_cloud_lib_edit_snippet_form').trigger('submit'); 
                        $(this).dialog("close");
                    }
                },
                {
                    text: 'Close',
                    class: 'button',
                    click: function() {
                        $(this).dialog('close');
                    }
                }
            ],
            close: function(event, ui) {
                $('.snippet_edit_view_btn').blur(); //???
            }
        });
    });

    function snippet_update(id, title, text) {
        id = parseInt(id);
        id = id || 0;
        var $row_to_update = '';

        // in edit for show msg
        var res_container = $('.new_snippet_wrapper').find('.result');
        res_container.html('Please, wait ...');

        if (id <= 0) {
            $('#no_snippets_row').hide();
            $row_to_update = $('#manage_snippets_table .snippet_row:first').clone();
            $row_to_update.show();

            // newest snippets go first.
            $('#manage_snippets_table').prepend($row_to_update);

            // update max items via js
            $('.usage_items').text(get_snippet_count());
        } else {
            $row_to_update = $('.snippet_row_' + id);
        }

        var submit_btn = $('.new_snippet_wrapper').find(':submit');
        submit_btn.hide();

        $row_to_update.find('.snippet_title').html('Please, wait...');
        $row_to_update.find('.snippet_content').empty().hide();

        $.ajax({
            url: ajaxurl,
            data: {
                id : id,
                title : title,
                text : text,
                action: "orb_ctc_addon_cloud_lib_cloud_update"
            },
            success: function (json) {
                res_container.html(json.msg);
                submit_btn.show();

                if (json.status) {
                   $row_to_update.data('id', json.data.id);
                   $row_to_update.prop('id', json.data.id);
                   $row_to_update.find('.snippet_title').html(title);
                   $row_to_update.removeClass('snippet_row_0');
                   $row_to_update.addClass('snippet_row_' + json.data.id);
                   $row_to_update.find('.snippet_content').html(text);
                   $row_to_update.find('.snippet_content').show();

                   setTimeout(function () {
                        res_container.empty();
                        $('.orb_ctc_ext_cloud_lib_add_new_snippet_form').trigger('reset');
                        $('.orb_ctc_ext_cloud_lib_add_new_snippet_form .add_snippet_text').focus();
                   }, 2500);
                } else {

                }
            }
        });
    }

    /**
     * View snippet button
     * 
     * Displays View snippet window
     * 
     */
    $('.snippet_view_btn').on("click", function() {

            //var id	= $(this).parents('tr').data('id');
            //var title	= $(this).parents('tr').data('title');
    var title   = $(this).parents('tr').children('td.title_cell').children('.snippet_title').text();
            //var content	= $(this).parents('tr').data('content');
    var content = $(this).parents('tr').children('td.title_cell').children('.snippet_content').text();

            $('.view_title').val(title);
            $('.view_content').val(content);
            //$('.edit_snippet').show();

            $("#view_snippet").dialog( {
            dialogClass: 'view_snippet',
            modal: true,
            resizable: false,
            buttons: [{
                            text: "Copy",
                            "class": 'button-primary',
                            click: function() {
                                    $(this).dialog("close"); 
                                    //todo make copy button actually work
                            }
                    },
                    {
                            text: "Close",
                            "class": 'button',
                            click: function() { 
                                    $(this).dialog("close");
                            }
                    }],
            close: function(event, ui) {
            }
            });
    });

    // https://api.jqueryui.com/tabs/
    // https://stackoverflow.com/questions/3641154/jquery-trapping-tab-select-event
    $( '.orb_ctc_addon_cloud_lib_tabs' ).tabs({
        heightStyle: "auto", // All panels will be set to the height of the tallest panel.
        activate : function(event, ui) {
            if (ui.newPanel.selector == '#orb_ctc_ext_cloud_lib_add') {
                if ($('#add_snippet_title').val().trim() == '') {
                    $('#add_snippet_title').focus();
                } else {
                    $('#add_snippet_text').focus();
                }
            } else if (ui.newPanel.selector == '#orb_ctc_ext_cloud_lib_signup') {
                if ($('#orb_ctc_email').val() == '') {
                   $('#orb_ctc_email').focus();
                } else {
                    $('#orb_ctc_pass2').focus();
                }
            } else if (ui.newPanel.selector == '#orb_ctc_ext_cloud_lib_login') {
                if ($('#orb_ctc_login_email').val() == '') {
                   $('#orb_ctc_login_email').focus();
                } else {
                    $('#orb_ctc_login_pass').focus();
                }
            }
        }       
    })
    // https://stackoverflow.com/questions/436587/jquery-ui-tabs-automatic-height
    .css({
        'min-height': '250px',
        'overflow': 'auto'
    });

    // update max items via js
    $('.usage_items').text(get_snippet_count());
});