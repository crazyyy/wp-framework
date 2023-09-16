
jQuery(document).ready(function ($) {

    const { __, _x, _n, _nx } = wp.i18n;

    if (typeof cm_settings !== 'undefined') {

        // it's Edit Snippet Page

        myCodeMirror = wp.codeEditor.initialize($('#ps_code_editor'), cm_settings);
        
        // var cm = wp.CodeMirror.fromTextArea(document.getElementById('#ps_code_editor') );
        
        // document.post_snippets_editor.setOption('lint',false);

        // cm.on('change',function(){console.log("Hello")});

        // myCodeMirror.codemirror.setGutterMarker(1, 'CodeMirror-lint-markers', document.getElementById('mceu_1-button'));


        // var cm = wp.CodeMirror.fromTextArea(document.getElementById("checking_codemirror"));
        // cm.on('change',function(){console.log("Hello")});
        // cm.getValue()

    }

    jQuery('.CodeMirror-sizer').addClass( $("input[type=hidden][name=pspro-edit-code-editor-page]").val() );

    if(window.post_snippets_editor){

        if( jQuery('input#pspro_snippet_php').is(':checked') ){
            window.post_snippets_editor.setOption('lint', true);
            jQuery('.CodeMirror-sizer').removeClass('php-not-selected');
        }else{
            window.post_snippets_editor.setOption('lint', false);
            jQuery('.CodeMirror-sizer').addClass('php-not-selected');
        }
    }

    jQuery('body').on('change', 'input#pspro_snippet_php', function(){
        
        if( jQuery(this).is(':checked') ){

            window.post_snippets_editor.setOption('lint', true);
            jQuery('.CodeMirror-sizer').removeClass('php-not-selected');

        }
        else{

            window.post_snippets_editor.setOption('lint', false);
            jQuery('.CodeMirror-sizer').addClass('php-not-selected');

        }
        // console.log( jQuery(this).is(':checked') )
        // console.log(jQuery("input#pspro_snippet_php").is(':checked'))
    
    });


    /**Groups Page Required Attribute replication */
    $('body').on('click', `form#ps_groups_page_form input#submit, form#ps_groups_page_form [name="edit"], form#ps_groups_page_form [name="delete"]`, function(e){
        
        if( this.id == 'submit'){

            if( $('input#pspro_group_name').val() == ''){
                document.getElementById('pspro_group_name').setCustomValidity(__('Enter Group Name',"post-snippets"));
            }
            else if( $('input#pspro_group_slug').val() == ''){
                document.getElementById('pspro_group_slug').setCustomValidity(__('Enter Group Slug',"post-snippets"));
            }
            else if( $('textarea#pspro_group_desc').val() == ''){
                document.getElementById('pspro_group_desc').setCustomValidity(__('Enter Group Description',"post-snippets"));
            }
            else{
                document.getElementById('pspro_group_name').setCustomValidity("");
                document.getElementById('pspro_group_slug').setCustomValidity("");
                document.getElementById('pspro_group_desc').setCustomValidity("");
            }

        }
        else{
            document.getElementById('pspro_group_name').setCustomValidity("");
            document.getElementById('pspro_group_slug').setCustomValidity("");
            document.getElementById('pspro_group_desc').setCustomValidity("");
        }

    });

    $('body').on('keypress change', `input#pspro_group_name, input#pspro_group_slug, textarea#pspro_group_desc`, function(){
    
        document.getElementById('pspro_group_name').setCustomValidity("");
        document.getElementById('pspro_group_slug').setCustomValidity("");
        document.getElementById('pspro_group_desc').setCustomValidity("");
    
    });

    /**End Groups Page Required Attribute replication */


    $(`div.pspro_edit_copy_shortcode button`).click( function(e){
        e.preventDefault();
        if( $("input#pspro_snippet_shortcode").is(':checked') ){
            const shortcode = document.getElementById('pspro_edit_shotcode_text');
            $("#pspro_edit_shotcode_text").prop('disabled', false);
            shortcode.select();
            $("#pspro_edit_shotcode_text").prop('disabled', true);
            document.execCommand("copy");
            window.getSelection().removeAllRanges();

            $('#pspro_edit_shortcode_copied').fadeIn("slow");

            setTimeout(()=>{
                $('#pspro_edit_shortcode_copied').fadeOut("slow");
            },1000);
        }

    });

    $("input#pspro_snippet_shortcode").change(function(){
        if(this.checked){
            $(`div.pspro_edit_copy_shortcode button`).prop("disabled", false);
            $(`input#pspro_edit_shotcode_text`).show();
        }
        else{
            $(`div.pspro_edit_copy_shortcode button`).prop("disabled", true);
            $(`input#pspro_edit_shotcode_text`).hide();
        }
    });

    // Pro  

	// $("[data-ps-download]").click(function (e) {		
        
    //     e.preventDefault();

	// 	var data = {
    //         'action': 'sync_down',
    //         'sync_down': $("#sync_down").val(),
    //         'snippets_id': [],
	// 	};

	// 	// $("#sp-loading").show();

	// 	var is_single_snippet_page = $("div.pspro_edit_download_snippet button").val();

    //     if( $("input.post-snippet-table-individual-checkbox").is(':checked') || is_single_snippet_page){     /**If any snippet is actually selected */

    //         var selected_snippets = [];

    //         if(is_single_snippet_page){

    //             selected_snippets.push(is_single_snippet_page); 

    //         }else{

    //             $("input.post-snippet-table-individual-checkbox:checked").each(function(){

    //                 selected_snippets.push( $(this).val() );
                
    //             });
    //         }

    //         $( "#sync-down-confirm" ).dialog({
    //             resizable: false,
    //             height: "auto",
    //             width: 400,
    //             modal: true,
    //             buttons: [
    //                 {
    //                     text: __("Cancel","post-snippets"),
    //                     click: function() {
    //                         $( this ).dialog( "close" );
    //                     },
    //                 },
    //                 {
    //                     text: __("Download","post-snippets"),
    //                     click: function() {
    //                         $( this ).dialog( "close" );
    //                         $("#sp-loading").show();

    //                         data.snippets_id = selected_snippets;
                            
    //                         $.ajax({

    //                             type: "POST",
    //                             url: ajaxurl,
    //                             data: data,
    //                             timeout: 0,

    //                             success: function (res) {

    //                             // $.post(ajaxurl, data, function (res) {
                                
                                
    //                             $("#sp-loading").hide();
                                
                                
    //                             if(res.success){
    //                                 $("#sync-up-success [upload-success]").html( __("code: ","post-snippets") + res.data.code + "<br>" + __("message: ","post-snippets") + res.data.message);
    //                                 $("#sync-up-success").dialog({
    //                                     resizable: false,
    //                                     height: "auto",
    //                                     width: 400,
    //                                     modal: true,
    //                                     close: function( event, ui ) {
    //                                         location.reload();
    //                                     }
    //                                 });
    //                             } 
                                
    //                             else{

    //                                 $("#sync-up-error [data-error]").html( __("code: ","post-snippets") + res.data.code + "<br>" + __("message: ","post-snippets") + res.data.message);
    //                                 $("#sync-up-error").dialog({
    //                                     resizable: false,
    //                                     height: "auto",
    //                                     width: 400,
    //                                     modal: true,                                        
    //                                 });
                                    
    //                             }

    //                         },


    //                         });
                        
                        
    //                     },
    //                 }
    //             ]                
    //         });

    //     }
    //     else{
    //         $('#pspro_edit_shortcode_copied').fadeIn("slow");

    //         setTimeout(()=>{
    //             $('#pspro_edit_shortcode_copied').fadeOut("slow");
    //         },1000);
    //     }
	// });

 // Sync Up data Pro
	// $("[data-sync-up]").click(function (e) {

	// 	e.preventDefault();

	// 	// var key = $(this).data("key");
	// 	var data = {
    //         'action': 'sync_up',
	// 		// 'key': key,
    //         'snippets_id': [],
	// 		'update': 1,
    //         'sync_up': $("#sync_up").val()
	// 	};

	// 	// var id = $(this).data("target");
	// 	// $("#sync-up-confirm strong").text($("#" + id + "-title").text());

    //     var is_single_snippet_page = $("div.pspro_edit_upload_snippet button").val();

    //     if( $("input.post-snippet-table-individual-checkbox").is(':checked') || is_single_snippet_page){     /**If any snippet is actually selected */

    //         var selected_snippets = [];

    //         if(is_single_snippet_page){

    //             selected_snippets.push(is_single_snippet_page); 

    //         }else{

    //             $("input.post-snippet-table-individual-checkbox:checked").each(function(){

    //                 selected_snippets.push( $(this).val() );
                
    //             });
    //         }

    //         $( "#sync-up-confirm" ).dialog({
    //             resizable: false,
    //             height: "auto",
    //             width: 400,
    //             modal: true,
    //             buttons: [
    //                 {
    //                     text: __("Cancel","post-snippets"),
    //                     click: function() {
    //                         $( this ).dialog( "close" );
    //                     },
    //                 },
    //                 {
    //                     text: __("Upload","post-snippets"),
    //                     click: function() {
    //                         $( this ).dialog( "close" );
    //                         $("#sp-loading").show();

    //                         data.snippets_id = selected_snippets;

    //                         $.ajax({

    //                             type: "POST",
    //                             url: ajaxurl,
    //                             data: data,
    //                             timeout: 0,

    //                             success: function (res) {
                            
    //                                 // $.post(ajaxurl, data, function (res) {
                                
                                
    //                                 $("#sp-loading").hide();
                                    
                                    
    //                                 if(res.success){
    //                                     $("#sync-up-success [upload-success]").html( __("code: ","post-snippets") + res.data.code + "<br>" + __("message: ","post-snippets") + res.data.message);
    //                                     $("#sync-up-success").dialog({
    //                                         resizable: false,
    //                                         height: "auto",
    //                                         width: 400,
    //                                         modal: true
    //                                     });
    //                                 } 
                                    
    //                                 else{

    //                                     /*
    //                                     if(res.data.code == "2") {
    //                                         var snippet = JSON.parse(res.data.message);
    //                                         snippet.options = JSON.parse(snippet.options);

    //                                         $("#sync-update-confirm [data-title]").text(snippet.title);
    //                                         $("#sync-update-confirm [data-description]").text(snippet.description);
    //                                         $("#sync-update-confirm textarea").val(snippet.snippet);
    //                                         $("#sync-update-confirm [data-vars]").val(snippet.vars);

    //                                         for(var k in snippet.options) {
    //                                             if(snippet.options[k])
    //                                             $("#sync-update-confirm [data-options]").append("<i class='dashicons dashicons-yes'></i> " + k);
    //                                         }
    //                                         //$("#sync-update-confirm [data-options]").text(snippet.options);

    //                                         $("#sync-update-confirm").dialog({
    //                                             resizable: false,
    //                                             height: "auto",
    //                                             width: 600,
    //                                             modal: true,
    //                                             buttons: {
    //                                                 Cancel: function() {
    //                                                 $( this ).dialog( "close" );
    //                                                 },
    //                                                 Update: function () {
    //                                                     $( this ).dialog( "close" );
    //                                                     $("#sp-loading").show();
    //                                                     data.update = 1;
    //                                                     $.post(ajaxurl, data, function (res) {
    //                                                         $("#sp-loading").hide();
    //                                                         if(res.success){
    //                                                             $("#sync-up-success").dialog({
    //                                                                 resizable: false,
    //                                                                 height: "auto",
    //                                                                 width: 300,
    //                                                                 modal: true
    //                                                             });
    //                                                         } else {
    //                                                             $("#sync-up-error [data-error]").html("code: " + res.data.code + "<br>message: " + res.data.message);
    //                                                         }
    //                                                     });
    //                                                 }
    //                                             }
    //                                         });
    //                                     }*/
                                        
    //                                     // else {
    //                                         $("#sync-up-error [data-error]").html( __("code: ","post-snippets") + res.data.code + "<br>" + __("message: ","post-snippets") + res.data.message);
    //                                         $("#sync-up-error").dialog({
    //                                             resizable: false,
    //                                             height: "auto",
    //                                             width: 400,
    //                                             modal: true
    //                                         });
    //                                     // }
    //                                 }
    //                             },

    //                         });
                        
                        
    //                     },
    //                 }
    //             ]
                
    //         });

    //     }
    //     else{
    //         $('#pspro_edit_shortcode_copied').fadeIn("slow");

    //         setTimeout(()=>{
    //             $('#pspro_edit_shortcode_copied').fadeOut("slow");
    //         },1000);
    //     }
        
    
    // });

    /*******Edit Page Location Meta Box**********/
    
    if( $("select#pspro_edit_location_select").val() === 'specific_page'){
        $('select#pspro_edit_page_select').attr('disabled', false);
        $('button#pspro_edit_add_selection').attr('disabled', false);
    }

    $("select#pspro_edit_location_select").change(function(){
        if( $(this).val() === 'specific_page'){
            $('select#pspro_edit_page_select').attr('disabled', false);
            $('button#pspro_edit_add_selection').attr('disabled', false);

        }
        else{
            $('select#pspro_edit_page_select').attr('disabled', true);
            $('button#pspro_edit_add_selection').attr('disabled', true);

        }
    });

    $("button#pspro_edit_add_selection").click(function(e){

        e.preventDefault();

        if( $('select#pspro_edit_page_select').prop('disabled') || $("select#pspro_edit_location_select").val() !== 'specific_page'){
            return false;
        }

        var selected_url = $('select#pspro_edit_page_select option:selected').data('url');

        $("input#pspro_edit_preview_text").val(selected_url);
        $('button#pspro_edit_preview_button').attr('disabled', false);

    });

    $('button#pspro_edit_preview_button').click(function(){

        if( $("input#pspro_edit_preview_text").val() == '' ){
            return false
        }

        window.open( $("input#pspro_edit_preview_text").val() );

    });

    if( $("input#pspro_edit_preview_text").val() !== '' ){
        $('button#pspro_edit_preview_button').attr('disabled', false);
    }

    if($('input[name=pspro_edit_where_site]:checked').val() == 'admin'){
        $("div#postbox-container-2").hide();
    }

    $('input[name=pspro_edit_where_site]').change(function(){
        if( $(this).val() == 'admin'){
            $("div#postbox-container-2").hide();
        }else if( $(this).val() == 'frontend'){
            $("div#postbox-container-2").show();
        }
    });

    /*******Edit Page Location Meta Box END********/

});
