jQuery(function($) {
	var initAjaxControls = function() {
	    function toggleRedLine(val){
	        var row = $(this).parents('tr');
            if( !row.hasClass('row-global-disabled') ){
                var disable_display = row.find('#wbcr_updates_manager_hide_item').val();
                var disable_all_updates = row.find('#wbcr_updates_manager_disable_updates').val();
                if(disable_display !== undefined) disable_display = parseInt(disable_display);
                if(disable_all_updates !== undefined) disable_all_updates = parseInt(disable_all_updates);

                if(!disable_all_updates && (disable_display === undefined || !disable_display)){
                    row.removeClass('inactive').addClass('active');
                }else{
                    row.removeClass('active').addClass('inactive');
                }
            }

        }

		$('.factory-ajax-checkbox').on('change', function(ev) {
			var action = $(this).data('action');
			var new_value = $(this).val();

			var data = {};
			data['action'] = 'wbcr-upm-change-flag';
			data['theme'] = $(this).data('theme-slug');
			if( !data['theme'] ) {
				data['plugin'] = $(this).data('plugin-slug');
			}
			data['flag'] = $(this).data('action');
			data['value'] = new_value;
			if( $(this).data('inverse') ){
                data['value'] = 0 + ! parseInt(new_value);
			}

			var disable_group = $(this).data('disable-group');
			if( disable_group ) {

				if( new_value == true ) {
					$("." + disable_group).find('button, input').prop('disabled', true);
                    toggleRedLine.apply(this);

				} else {
                    $("." + disable_group).each(function(k, v) {
                        if( !$(v).hasClass('global-disabled') ) {
                            $(v).find('button, input').prop('disabled', false);
                        }
                        toggleRedLine.apply(this);

                    });
				}

			}
			$.ajax({
				url: ajaxurl,
				method: 'post',
				data: data,
				success: function(response) {

					if( !response || !response.success ) {
						if( response.data.error_message ) {
							$.wbcr_factory_clearfy_206.app.showNotice('Error: [' + response.data.error_message + ']', 'danger');
						}
						return false;
					}

					/*var noticeId = $.wbcr_factory_clearfy_206.app.showNotice('Settings successfully updated', 'success');

					setTimeout(function() {
						$.wbcr_factory_clearfy_206.app.hideNotice(noticeId);
					}, 5000);*/
				},
				error: function(xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);

					$.wbcr_factory_clearfy_206.app.showNotice('Error: [' + thrownError + '] Status: [' + xhr.status + '] Error massage: [' + xhr.responseText + ']', 'danger');
				}
			});
		});

        $('.wbcr_um_select_item').on('change', function(){
            $('.wbcr_um_select_all').prop('checked', false);
        });
        $('.wbcr_um_select_all').on('change', function(){
            if($(this).prop('checked')){
                $('.wbcr_um_select_item').prop('checked', true);
            }else{
                $('.wbcr_um_select_item').prop('checked', false);
            }
        });

	};

	initAjaxControls();
});