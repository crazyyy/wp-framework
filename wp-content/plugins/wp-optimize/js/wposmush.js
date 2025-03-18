jQuery(function($) {
	WP_Optimize_Smush = WP_Optimize_Smush();
});

var WP_Optimize_Smush = function() {

	var $ = jQuery;

	var heartbeat = WP_Optimize_Heartbeat();
	var heartbeat_agents = [];

	var last_ui_update_agent_uid = null;

	var block_ui = wp_optimize.block_ui;

	/**
	 * Variables for smushing.
	 */
	var smush_images_grid = $('#wpo_smush_images_grid'),
		smush_images_optimization_message = $('#smush_info_images'),
		smush_images_refresh_btn = $('#wpo_smush_images_refresh'),
		smush_images_select_all_btn = $('#wpo_smush_images_select_all'),
		smush_images_select_none_btn = $('#wpo_smush_images_select_none'),
		smush_images_stats_clear_btn = $('#wpo_smush_clear_stats_btn'),
		smush_selected_images_btn = $('#wpo_smush_images_btn'),
		smush_mark_as_compressed_btn = $('#wpo_smush_mark_as_compressed'),
		convert_to_webp_btn = $('.wpo_smush.column-wpo_smush .convert-to-webp');
		smush_mark_all_as_uncompressed_btn = $('#wpo_smush_mark_all_as_uncompressed_btn'),
		restore_all_compressed_images_btn = $('#wpo_smush_restore_all_compressed_images_btn'),
		smush_view_logs_btn = $('.wpo_smush_get_logs'),
		smush_delete_backup_images_btn = $('#wpo_smush_delete_backup_btn'),
		compression_server_select = $('.compression_server'),
		reset_webp_serving_method_btn = $('#wpo_reset_webp_serving_method'),
		smush_images_tab_loaded = false,
		smush_service_features = [],
		smush_total_seconds = 0,
		smush_timer_locked = false,
		smush_timer_handle = 0,
		smush_image_list = [],
		smush_completed = false,
		smush_from_media_library = false,
		smush_mark_all_as_uncompressed = false,
		smush_affected_images = {},
		pending_tasks_cancel_btn = $('#wpo_smush_images_pending_tasks_cancel_button'),
		uncompressed_images_sites_select = $('#wpo_uncompressed_images_sites_select');

	/**
	 * These options used for block UI with custom content.
	 */
	var block_ui_custom_options = {
		baseZ: 160001,
		css: {
			top: '50%',
			transform: 'translate(0, -50%)',
			width: '400px',
			padding: '20px',
			cursor: 'pointer'
		}
	}

	$('#doaction, #doaction2').on('click', function(e) {
		e.stopImmediatePropagation();
		var action = $(this).prev('select').val();
		if ('wp_optimize_bulk_compression' !== action && 'wp_optimize_bulk_restore' !== action ) return;

		var $selected_images = get_media_library_selected_images();
		if (0 === $selected_images.length) return;
		e.preventDefault();
		if ('wp_optimize_bulk_compression' === action) bulk_compression($selected_images);
		if ('wp_optimize_bulk_restore' === action) bulk_restore($selected_images);
	});

	/**
	 * Handles bulk compression action from media library
	 *
	 * @param {Object} $selected_images
	 */
	function bulk_compression($selected_images) {
		block_ui(wposmush.server_check);

		data = { 'server': wposmush.smush_settings.compression_server, skip_notice: true };
		smush_manager_send_command('check_server_status', data, function(resp) {
			if (resp.online) {
				$selected_images.each(function(index, element) {
					smush_image_list.push({
						'attachment_id': parseInt(element.value),
						'blog_id': wposmush.blog_id
					});
				});

				data = {
					optimization_id: 'smush',
					selected_images: smush_image_list,
					smush_options: {
						'compression_server': wposmush.smush_settings.compression_server,
						'image_quality': wposmush.smush_settings.image_quality,
						'lossy_compression': wposmush.smush_settings.lossy_compression,
						'back_up_original': wposmush.smush_settings.back_up_original,
						'preserve_exif': wposmush.smush_settings.preserve_exif
					}
				}
				smush_from_media_library = true;
				smush_completed = false;
				if (smush_timer_locked) return;
				block_ui('', $.extend(block_ui_custom_options, {message: $('#wpo_smush_images_information_container')}), false, true);
				$('#wpo_smush_images_information_server').html(wposmush.smush_settings.compression_server);

				clear_smush_stats();

				smush_timer_handle = window.setInterval(smush_timer, 1000);
				smush_manager_send_command('process_bulk_smush', data);
			} else {
				error_message = resp.error ? resp.error + '<br>' + wposmush.server_error : wposmush.server_error;
				block_ui(error_message);
			}
		});
	}

	/**
	 * Handles bulk restore action from media library
	 *
	 * @param {Object} $selected_images
	 */
	function bulk_restore($selected_images) {
		smush_from_media_library = true;

		var processed_elements = [];
		var progress = function(element_id) {
			return function(callback) {
				processed_elements.push(element_id);
				
				if (1 < processed_elements.length && processed_elements.length === $selected_images.length) {
					callback(wposmush.images_restored_successfully);
				} else {
					callback();
				}
			}
		}

		$selected_images.each(function(index, element) {
			restore_selected_image(wposmush.blog_id, parseInt(element.value), progress(parseInt(element.value)));
		});
	}

	/**
	 * Handle Image Selection
	 */
	smush_images_grid.on('click', '.thumbnail', function (e) {
		$(this).closest('input[type="checkbox"]').prop('checked', true);
	});


	/**
	 * Handle Shift Ctrl keys state.
	 */
	var ctrl_shift_on_image_held = false;
	

	smush_images_grid.on('mousedown', '.thumbnail', function (e) {
		ctrl_shift_on_image_held = e.shiftKey || e.ctrlKey;
	});

	smush_images_grid.on('mouseup', '.thumbnail', function (e) {
		ctrl_shift_on_image_held = e.shiftKey || e.ctrlKey;
	});

	// Resets server rewrite capability
	reset_webp_serving_method_btn.on('click', function(e) {
		e.preventDefault();
		smush_manager_send_command('reset_webp_serving_method', { skip_notice: true }, function(resp) {
			if (!resp.success) {
				$('#enable_webp_conversion').prop("checked", false);
				$('#smush-information-modal .smush-information').text(resp.error_message);
				block_ui('', $.extend(block_ui_custom_options, {message: $('#smush-information-modal')}), false, true);
			} else {
				$('#wpo_reset_webp_serving_method_done').show().delay(3000).fadeOut();
			}
		});
	});

	/**
	 * Boolean flag to track whether uncompressed images have already been loaded,
	 * preventing multiple unnecessary loads
	 */
	var uncompressed_images_already_loaded = false;

	/**
	 *  Checks if smush is active and loads images if yes - image tabs change.
	 */
	$('#wp-optimize-nav-tab-wrapper__wpo_images .nav-tab').on('click', function() {
		if (uncompressed_images_already_loaded) return;

		if ($(this).is('#wp-optimize-nav-tab-wpo_images-smush')) {
			get_info_from_smush_manager(false);
		}
	});

	/**
	 * Checks if smush is active and loads images if yes - main menu change.
	 */
	$('#wp-optimize-wrap').on('page-change', function(e, params) {
		if (uncompressed_images_already_loaded) return;

		if ('wpo_images' == params.page) {
			if ($('#wp-optimize-nav-tab-wrapper__wpo_images .nav-tab-active').is('#wp-optimize-nav-tab-wpo_images-smush')) {
				get_info_from_smush_manager(false);
			}
		}
	});

	if ($('#smush-metabox').length > 0) {
		update_view_available_options();
	}


	var lastclick = null;
	smush_images_grid.on('click' , '.wpo_smush_image' , function(e) {
		var grid_input = $('#wpo_smush_images_grid input[type="checkbox"]');
		var input = $(this).find('.wpo_smush_image__input');
		var input_val = (!(input.prop('checked')));
			if (!lastclick) {
				$(this).find('.wpo_smush_image__input').prop('checked',input_val);
				lastclick = input;
			}
		if (true === ctrl_shift_on_image_held) {
			var start = grid_input.index(input);
			var end = grid_input.index(lastclick);
			if (start === end) {
				grid_input.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked', input_val);
			} else {
			if (true === lastclick.prop('checked')) {
				grid_input.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked', input_val);
			}
			}
		}
		lastclick = input;
		update_smush_action_buttons_state();
	});

	/**
	 * Disable smush actions buttons if no images selected.
	 */
	function update_smush_action_buttons_state() {
		var state = (0 == $('input[type="checkbox"]:checked', smush_images_grid).length);

		smush_selected_images_btn.prop('disabled', state);
		smush_mark_as_compressed_btn.prop('disabled', state);
	}

	update_smush_action_buttons_state();

	/**
	 * Handles change of smush service provider
	 */
	compression_server_select.on('change', function(e) {
		update_view_available_options();
		save_options();
	});

	/**
	 * Process bulk smush
	 */
	smush_selected_images_btn.off().on('click', function() {
		
		if (0 == $('#wpo_smush_images_grid input[type="checkbox"]:checked').length) {
			block_ui(wposmush.please_select_images);
			return;
		}

		block_ui(wposmush.server_check);

		data = { 'server': $("input[name='compression_server']:checked").val(), skip_notice: true };
		smush_manager_send_command('check_server_status', data, function(resp) {
			if (resp.online) {
				bulk_smush_selected_images();
			} else {
				error_message = resp.error ? resp.error + '<br>' + wposmush.server_error : wposmush.server_error;
				block_ui(error_message);
			}
		});
	});

	/**
	 * Mark as compressed
	 */
	smush_mark_as_compressed_btn.off().on('click', function() {

		var selected_images = [],
			image;

		$('#wpo_smush_images_grid input:checked').each(function() {
			image = {
				'attachment_id':$(this).val(),
				'blog_id': $(this).data('blog')
			};
			selected_images.push(image);
		});

		block_ui(wposmush.please_updating_images_info);

		smush_manager_send_command('mark_as_compressed', {selected_images: selected_images}, function(response) {
			$('#smush-information-modal .smush-information').text(response.summary);
			block_ui('', $.extend(block_ui_custom_options, {message: $('#smush-information-modal')}));
			// refresh images list.
			get_info_from_smush_manager(false);
		});
	});

	/**
	 * Handle "Mark all images as uncompressed" click.
	 */
	smush_mark_all_as_uncompressed_btn.on('click', function() {
		if (!confirm(wposmush.mark_all_images_uncompressed)) return;

		var restore_backup = confirm(wposmush.restore_images_from_backup);

		block_ui(wposmush.please_wait);

		smush_mark_all_as_uncompressed = true;
		run_mark_all_as_uncompressed(restore_backup);
	});

	/**
	 * Handle "Restore all compressed images" click.
	 */
	restore_all_compressed_images_btn.on('click', function() {
		if (!confirm(wposmush.restore_all_compressed_images)) return;

		block_ui(wposmush.please_wait);

		smush_mark_all_as_uncompressed = true;
		run_mark_all_as_uncompressed(true, true);
	});

	/**
	 * Handle "Cancel" button click for mark all images as uncompressed process
	 */
	$('#smush-information-modal-cancel-btn input[type="button"]').on('click', function() {
		smush_mark_all_as_uncompressed = false;
		get_info_from_smush_manager();
		$.unblockUI();
	});

	/**
	 * Send command for mark all compressed images as uncompressed.
	 *
	 * @param {bool} restore_backup if set to true then images will restored from backup if possible.
	 * @param {bool} delete_only_backups_meta if set to true the only backup meta will be deleted
	 */
	function run_mark_all_as_uncompressed(restore_backup, delete_only_backups_meta) {
		if (!smush_mark_all_as_uncompressed) return;

		restore_backup = restore_backup ? 1 : 0;
		delete_only_backups_meta = delete_only_backups_meta ? 1 : 0;

		var info = $('#smush-information-modal-cancel-btn .smush-information');
		smush_manager_send_command('mark_all_as_uncompressed',
			{
				restore_backup: restore_backup,
				delete_only_backups_meta: delete_only_backups_meta,
				skip_notice: true
			},
			function(resp) {
				// if cancel button pressed then exit
				if (!smush_mark_all_as_uncompressed) return;

				// if we get an error then show it
				if (resp.hasOwnProperty('error')) {
					block_ui(resp.error);
					get_info_from_smush_manager();
					return;
				}

				// if completed then refresh uncompressed images list and show final message.
				if (resp.completed) {
					block_ui('', $.extend(block_ui_custom_options, {message: $('#smush-information-modal')}));
					$('#smush-information-modal .smush-information').text(resp.message);
					get_info_from_smush_manager();
				} else {
					info.text(resp.message);
					run_mark_all_as_uncompressed(restore_backup, delete_only_backups_meta);
				}
			}
		);
	}

	/**
	 * Refresh image list
	 */
	smush_images_refresh_btn.off().on('click', function() {
		// The refresh image list button should not fetch from cache but run the query
		get_info_from_smush_manager(false);
	});

	/**
	 * Bind select all / select none controls
	 */
	smush_images_select_all_btn.off().on('click', function() {
		$('#wpo_smush_images_grid input[type="checkbox"]').prop("checked", true);
		lastclick = null;
		update_smush_action_buttons_state();
	});


	/**
	 * Bind select all / select none controls
	 */
	smush_images_select_none_btn.off().on('click', function() {
		$('#wpo_smush_images_grid input[type="checkbox"]').prop("checked", false);
		lastclick = null;
		update_smush_action_buttons_state();
	});

	/**
	 * Displays logs in a modal
	 */
	smush_view_logs_btn.off().on('click', function() {
		$("#log-panel").text("Please wait, fetching logs.");
		smush_manager_send_command('get_smush_logs', {}, function(resp) {
			$.blockUI({
				message: $("#smush-log-modal"),
				onOverlayClick: $.unblockUI(),
				css: {
					width: '80%',
					height: '80%',
					top: '15%',
					left: '15%'
				}
			});
			$("#log-panel").html("<pre>" + resp + "</pre>");
			download_link = ajaxurl + "?action=updraft_smush_ajax&subaction=get_smush_logs&nonce=" + wposmush.smush_ajax_nonce;
			$("#smush-log-modal a").attr('href', download_link);
		}, false);
	});

	/**
	 * Handle delete all backup images button click.
	 */
	smush_delete_backup_images_btn.on('click', function() {

		if (!confirm(wposmush.delete_image_backup_confirm)) return;
		smush_delete_backup_images_btn.prop('disabled', true);
		var spinner = $('#wpo_smush_delete_backup_spinner'),
			done = $('#wpo_smush_delete_backup_done');

		spinner.show();

		smush_manager_send_command('clean_all_backup_images', {}, function() {
			spinner.hide();
			smush_delete_backup_images_btn.prop('disabled', false);
			done.css('display', 'inline-block').delay(3000).fadeOut();
		});
	});

	/**
	 * Binds clear stats button
	 */
	smush_images_stats_clear_btn.off().on('click', function(e) {
		$('#wpo_smush_images_clear_stats_spinner').show().delay(3000).fadeOut();

		smush_manager_send_command('clear_smush_stats', {}, function(resp) {
			$('#wpo_smush_images_clear_stats_spinner').hide();
			$('#wpo_smush_images_clear_stats_done').show().delay(3000).fadeOut();
		});
	});

	/**
	 * Binds smush cancel button
	 */
	$('body').on('click', '#wpo_smush_images_pending_tasks_cancel_button', function(e) {

		if (wposmush.cancel === pending_tasks_cancel_btn.val()) {
			pending_tasks_cancel_btn.val(wposmush.cancelling);
			pending_tasks_cancel_btn.prop('disabled', true);
		}
		smush_manager_send_command('clear_pending_images', { restore_images: smush_image_list }, function(resp) {
			$.unblockUI();
			if (resp.status) {
				get_info_from_smush_manager();
				reset_view_bulk_smush();
			} else {
				console.log('Cancelling pending images apparently failed.', resp);
			}
			pending_tasks_cancel_btn.val(wposmush.cancel);
			pending_tasks_cancel_btn.prop('disabled', false);
		});
	});

	/**
	 * Handle the click on the 'Compress' button within the Media Library page and open a dialog for the image compression action.
	 */
	$('.column-wpo_smush').on('click', '.wpo-smush-compress-popup-btn', function(e) {
		var attachment_id = $(this).data('id'),
			blog_id = $(this).data('blog');

		e.preventDefault();

		smush_manager_send_command('get_smush_settings_form', {
			attachment_id: attachment_id,
			blog_id: blog_id
		}, function(resp) {
			if (resp.success) {
				var html = [
					'<div class="wpo-smush-compress-popup-content">',
					'<h3>',wposmush.compress_image,'</h3>',
					resp.html,
					'</div>',
					'<div class="wpo_smush_single_image action_button" style="display:inline-block;">',
						'<input type="button" data-blog="',blog_id,'" data-id="',attachment_id,'" id="smush_compress_',attachment_id,'" class="button-primary button" value="',wposmush.compress,'">',
					'</div>',
					'&nbsp;&nbsp;',
					'<a href="#" class="button wpo-smush-popup-cancel-btn">',wposmush.close,'</a>'
				].join('');
				block_ui('', $.extend(block_ui_custom_options, {message: html}));
			}
		});

	});

	/**
	 * Handle the 'Cancel' button in the dialog for the image compression action.
	 */
	$('body').on('click', '.wpo-smush-popup-cancel-btn', function(e) {
		e.preventDefault();
		$.unblockUI();
	});

	/**
	 * Single image compression
	 */
	$('body').on('click', '.wpo_smush_single_image .button', function() {

		image = {
			'attachment_id':$(this).data('id'),
			'blog_id': $(this).data('blog')
		};

		if ($('#enable_custom_compression').is(":checked")) {
			image_quality = $('#custom_compression_slider').val();
		} else {
			// The '60' here has to be kept in sync with WP_Optimize::admin_page_wpo_images_smush()
			image_quality = $('#enable_lossy_compression').is(":checked") ? 60 : 92;
		}
		lossy_compression = image_quality < 92 ? true : false;

		smush_options = {
			'compression_server': $("input[name='compression_server_" + image.attachment_id + "']:checked").val(),
			'image_quality': image_quality,
			'lossy_compression': lossy_compression,
			'back_up_original': $('#smush_backup_' + image.attachment_id).is(":checked"),
			'preserve_exif': $('#smush_exif_' + image.attachment_id).is(":checked")
		}

		data = { 'server':  $("input[name='compression_server_" + $(this).attr('id').substring(15) + "']:checked").val() };
		block_ui(wposmush.server_check);
		smush_manager_send_command('check_server_status', data, function(resp) {
			if (resp.online) {
				smush_selected_image(image, smush_options);
			} else {
				error_message = resp.error ? resp.error + '<br>' + wposmush.server_error : wposmush.server_error;
				block_ui(error_message);
			}
		});
	});

	/**
	 * Single image restore
	 */
	$('body').on('click', '.wpo_restore_single_image .button, .wpo_restore_single_image a', function(e) {
		var clicked_image = $(this);
		blog_id = clicked_image.data('blog');
		image_id = clicked_image.data('id');

		e.preventDefault();

		if (!image_id || !blog_id) return;
		restore_selected_image(blog_id, image_id);
	});

	/**
	 * Mark as compressed
	 */
	$('body').on('click', '.wpo_smush_mark_single_image .button, .wpo_smush_mark_single_image a', function(e) {
		mark_unmark_as_compressed_handler($(this), e, true);
	});

	/**
	 * Unmark as compressed
	 */
	$('body').on('click', '.wpo_smush_unmark_single_image .button, .wpo_smush_unmark_single_image a', function(e) {
		mark_unmark_as_compressed_handler($(this), e, false);
	});

	/**
	 * Handler for Mark/Unmark as compressed event.
	 *
	 * @param {jQuery}  target jQuery object for target element
	 * @param {Event}   e
	 * @param {Boolean} mark   True or false - mark / unmark
	 */
	function mark_unmark_as_compressed_handler(target, e, mark) {
		var blog_id = target.data('blog'),
		attachment_id = target.data('id'),
		image = {
			'attachment_id': attachment_id,
			'blog_id': blog_id
		},
		wrapper = target.closest('#smush-metabox-inside-wrapper')
		data = {selected_images: [ image ]};

		if (mark === false) {
			data.unmark = true;
		}
		
		e.preventDefault();
		
		block_ui(wposmush.please_updating_images_info);
				
		smush_manager_send_command('mark_as_compressed', data, function(response) {

			$('#smush-information-modal .smush-information').text(response.summary);

			block_ui('', $.extend(block_ui_custom_options, {message: $('#smush-information-modal')}));
		
			if (response.status) {
				if (wrapper.length) {
					if (mark) {
						$('.wpo_smush_single_image', wrapper).hide();
						$('.wpo-toggle-advanced-options', wrapper).removeClass('opened');
						$('.wpo_smush_mark_single_image', wrapper).hide();
						$('.wpo_smush_unmark_single_image', wrapper).show();
						$('.wpo_restore_single_image', wrapper).show();
						$('#smush_info', wrapper).text(response.info);
					} else {
						$('.wpo_smush_single_image', wrapper).show();
						$('.wpo_smush_mark_single_image', wrapper).show();
						$('.wpo_smush_unmark_single_image', wrapper).hide();
						$('.wpo_restore_single_image', wrapper).hide();
						$('#smush_info', wrapper).text(response.info);
					}
				}

				if (response.hasOwnProperty('media_column_html')) {
					update_smush_information_media_library_column(blog_id, attachment_id, response.media_column_html);
				}
			}
		});
	}


	$('body').on('click', '#wpo_smush_details .wpo-collapsible', toggle_smush_details);
	$('body').on('click', '.column-wpo_smush .wpo-collapsible', toggle_smush_details);

	function toggle_smush_details() {
		$(this).toggleClass('opened');
		if ($(this).hasClass('opened')) {
			$(this).text(wposmush.less);
		} else {
			$(this).text(wposmush.more);
		}
	}

	$('body').on('click', '#smush-log-modal .close, #smush-information-modal .information-modal-close', function() {
		$.unblockUI();
		if (smush_from_media_library) {
			reset_bulk_actions_dropdown();
		}
	});

	$('body').on('click', '.wpo_smush_stats_cta_btn, .wpo_smush_get_logs, #smush-complete-summary .close', function() {
		$.unblockUI();
		if (smush_from_media_library) {
			var selected_images_list = get_media_library_selected_images_list();
			smush_manager_send_command('get_smush_details', {selected_images: selected_images_list}, function(response) {
				if (response.success) {
					window.clearInterval(smush_timer_handle);
					update_media_library_screen(response.smush_details);
				} else {
					console.log(response)
				}
			});
		} else {
			get_info_from_smush_manager();
			setTimeout(reset_view_bulk_smush, 500);
		}
	});

	$('body').on('click', '.wpo-toggle-advanced-options', function(e) {
		e.preventDefault();
		$(this).toggleClass('opened');
	});

	$('.wpo-fieldgroup .autosmush input, .wpo-fieldgroup .compression_level, .wpo-fieldgroup .image_options, #smush-show-metabox').on('change', function(e) {
		save_options();
	});

	$('body').on('change', '.smush-options.compression_level', function() {
		if ($('#enable_custom_compression').is(':checked')) {
			$('.smush-options.custom_compression').show();
		} else {
			$('.smush-options.custom_compression').hide();
		}
	});

	$('body').on('change', '.smush-advanced input[type="radio"]', function() {
		update_view_available_options();
	});

	$('#enable_webp_conversion').on('change', function(e) {
		// only save when changing the options on the wpo dashboard.
		if (!$('#wp-optimize-wrap').length) return;

		$('#wpo_smush_images_save_options_spinner').show().delay(3000).fadeOut();
		$('#enable_webp_conversion').prop("disabled", true);

		var smush_options = get_smush_options();
		// Skip default notice and use popup to show error messages
		smush_options.skip_notice = true;

		smush_manager_send_command('update_webp_options', smush_options, function(resp) {
			$('#wpo_smush_images_save_options_spinner').hide();
			if (resp.hasOwnProperty('saved') && resp.saved) {
				$('#wpo_smush_images_save_options_done').show().delay(3000).fadeOut();
			} else {
				$('#enable_webp_conversion').prop("checked", false);
				if ('update_failed_no_working_webp_converter' === resp.error_code) {
					var html_msg = '<p>'
						+ wposmush.webp_conversion_tool_error
						+ ' <a href="https://getwpo.com/faqs/#How-can-I-get-WebP-conversion-tools-to-work-" target="_blank">'
						+ wposmush.webp_conversion_tool_how_to
						+ '</a></p>';
					$('#smush-information-modal .smush-information').html(html_msg);
				} else {
					$('#smush-information-modal .smush-information').text(resp.error_message);
				}
				block_ui('', $.extend(block_ui_custom_options, {message: $('#smush-information-modal')}), false, true);
			}
			$('#enable_webp_conversion').prop("disabled", false);
		});
	});

	convert_to_webp_btn.on('click', function(e){
		e.preventDefault();
		var $link = $(this);
		data = {
			'attachment_id': $(this).data('attachment-id'),
			skip_notice: true
		};
		block_ui(wposmush.converting_to_webp, {}, 0, true);
		smush_manager_send_command('convert_to_webp_format', data, function(response) {
			if (response.error) {
				block_ui(response.error, {}, 2000);
			} else {
				block_ui(response.success, {}, 2000);
				$link.next().remove();
				$link.remove();
			}
		});
	});

	/**
	 * Load and show information about uncompressed images.
	 *
	 * @param {Boolean}   use_cache     Use the request cache
	 *
	 * @return void
	 */
	function get_info_from_smush_manager(use_cache) {

		var use_cache = (typeof use_cache === 'undefined') ? true : use_cache;
		var data = { 'use_cache': use_cache };
	
		smush_images_optimization_message.html('...');

		disable_image_optimization_controls(true);
		
		heartbeat_agents.push(heartbeat.add_agent({
			_wait: false,
			_keep: false,
			command: 'updraft_smush_ajax',
			command_data: {data: data, subaction: 'get_ui_update'},
			callback: function(resp) {
				handle_response_from_smush_manager(resp, update_view_show_uncompressed_images);
				update_view_available_options();
				disable_image_optimization_controls(false);
				update_smush_action_buttons_state();
			}
		}));

		uncompressed_images_already_loaded = true;
	}


	/**
	 * Get selected images and make an ajax request to compress them.
	 *
	 * @return void
	 */
	function bulk_smush_selected_images() {
				
		$('#wpo_smush_images_grid input:checked').each(function() {
			image = {
				'attachment_id':$(this).val(),
				'blog_id': $(this).data('blog')
			};
			smush_image_list.push(image);
		});

		data = {
			optimization_id: 'smush',
			selected_images: smush_image_list,
			smush_options: {
				'compression_server': $("input[name='compression_server']:checked").val(),
				'image_quality': $('#image_quality').val(),
				'lossy_compression': $('#smush-lossy-compression').is(":checked"),
				'back_up_original': $('#smush-backup-original').is(":checked"),
				'preserve_exif': $('#smush-preserve-exif').is(":checked")
			}
		}
		
		update_view_bulk_smush_start();
		heartbeat_agents.push(heartbeat.add_agent({
			_wait: false,
			_keep: false,
			command: 'updraft_smush_ajax',
			command_data: {data: data, subaction: 'process_bulk_smush'}
		}));
	}

	/**
	 * Save options in the DB
	 *
	 * @return void
	 */
	function save_options() {
		// only save when changing the options on the wpo dashboard.
		if (!$('#wp-optimize-wrap').length) return;

		$('#wpo_smush_images_save_options_spinner').show().delay(3000).fadeOut();

		var smush_options = get_smush_options();

		smush_manager_send_command('update_smush_options', smush_options, function(resp) {
			$('#wpo_smush_images_save_options_spinner').hide();
			if (resp.hasOwnProperty('saved') && resp.saved) {
				$('#wpo_smush_images_save_options_done').show().delay(3000).fadeOut();
			} else {
				$('#wpo_smush_images_save_options_fail').show().delay(3000).fadeOut();
			}
		});
	}

	/**
	 * A timer to run for the duration of the bulk smush operation.
	 *
	 * @return void
	 */
	function smush_timer() {
		smush_timer_locked = true;
		smush_total_seconds++;
		seconds = (smush_total_seconds % 60) + '' < 10 ? '0' + (smush_total_seconds % 60) : (smush_total_seconds % 60);
		minutes = parseInt(smush_total_seconds / 60) + '' < 10 ? '0' + parseInt(smush_total_seconds / 60) : parseInt(smush_total_seconds / 60);
		
		$('#smush_stats_timer').text(minutes + ":" + seconds);
		trigger_events(smush_total_seconds);
	}

	/**
	 * A timer to run for the duration of the bulk smush operation.
	 *
	 * @param {Number} time_elapsed - time in seconds
	 *
	 * @return void
	 */
	function trigger_events(time_elapsed) {
		if (0 == time_elapsed % 3) {
			update_smush_stats(time_elapsed);
		}

		if (0 == time_elapsed % 60) {
			if (null != last_ui_update_agent_uid) {
				heartbeat.cancel_agent(last_ui_update_agent_uid);
				last_ui_update_agent_uid = null;
			}

			heartbeat_agents.push(heartbeat.add_agent({
				_wait: false,
				command: 'updraft_smush_ajax',
				command_data: {data: {}, subaction: 'process_pending_images'},
				callback: function(resp) {
					handle_response_from_smush_manager(resp, update_view_bulk_smush_progress);
				}
			}));
		}
	}

	/**
	 * Updates the UI with stats
	 *
	 * @param {Int}   time_elapsed     Elapsed time since process start
	 *
	 * @return void
	 */
	function update_smush_stats(time_elapsed) {
		data = {
			update_ui: true,
			use_cache: false
		}

		var initial_requests = time_elapsed < 5;

		var agent = heartbeat.add_agent({
			_wait: !initial_requests,
			_keep: false,
			command: 'updraft_smush_ajax',
			command_data: {data: data, subaction: 'get_ui_update'},
			callback: function(resp) {
				handle_response_from_smush_manager(resp, update_view_bulk_smush_progress);
			}
		});
		
		if (null !== agent) {
			last_ui_update_agent_uid = agent;

			heartbeat_agents.push(agent);
		}
	}

	/**
	 * Update images optimization tab view with data returned from images optimization.
	 *
	 * @param {Object} data - meta data returned from task manager
	 *
	 * @return void
	 */
	function update_view_show_uncompressed_images(data) {
		smush_images_grid.html('');

		if (!data || !data.hasOwnProperty('unsmushed_images')) return;

		var unsmushed_images = data.unsmushed_images,
			pending_tasks = data.pending_tasks,
			blog_id = 0;

		if (0 == unsmushed_images.length && 0 == pending_tasks) {
			smush_images_grid.text(wposmush.all_images_compressed).wrapInner("<div class='wpo-fieldgroup'> </div>");
		}

		if (1 === data.is_multisite) {
			blog_id = uncompressed_images_sites_select.find(":selected").val();
			add_unsmushed_images_to_grid(blog_id, data);
		} else {
			for (blog_id in data.unsmushed_images) {
				add_unsmushed_images_to_grid(blog_id, data);
			}
		}
	}

	function sort_unsmushed_images(a, b) {
		return a.id - b.id;
	}

	function add_unsmushed_images_to_grid(blog_id, data) {
		// Used to have upload.php?item= on multisite (using data.is_multisite), and no suffix
		var admin_url_pre_id = 'post.php?post=',
			admin_url_post_id = '&action=edit',
			admin_url = data.admin_urls[blog_id],
			unsmushed_images = data.unsmushed_images[blog_id];

		if ('undefined' !== typeof unsmushed_images) {
			unsmushed_images.sort(sort_unsmushed_images);
		}

		for (i in unsmushed_images) {
			if (!unsmushed_images.hasOwnProperty(i)) continue;
			var image = unsmushed_images[i];
			add_image_to_grid(image, blog_id, admin_url + admin_url_pre_id + image.id + admin_url_post_id);
		}
	}

	uncompressed_images_sites_select.on('change', function() {
		get_info_from_smush_manager();
	});

	/**
	 * Updates the view when bulk smush starts
	 *
	 * @return void
	 */
	function update_view_bulk_smush_start() {
		if (smush_timer_locked) return;

		block_ui('', $.extend(block_ui_custom_options, {message: $('#wpo_smush_images_information_container')}), false, true);
		service = $('.compression_server input[type="radio"]:checked + label small').text();
		$('#wpo_smush_images_information_server').html(service);

		clear_smush_stats();

		smush_timer_handle = window.setInterval(smush_timer, 1000);
		disable_image_optimization_controls(true);
	}

	/**
	 * Clears the statistics for image smushing in popup.
	 *
	 * This function clears the statistics displayed on the popup for image smushing.
	 *
	 * @returns {void}
	 */
	function clear_smush_stats() {
		$('#smush_stats_pending_images').html("...");
		$('#smush_stats_completed_images').html("...");
		$('#smush_stats_bytes_saved').html("...");
		$('#smush_stats_percent_saved').html("...");
		$('#smush_stats_timer').html("...");
	}

	/**
	 * Updates the media library screen with the provided smush details.
	 *
	 * @param {Object} smush_details - The details of the smushed images
	 * @return {void}
	 */
	function update_media_library_screen(smush_details) {
		for (var image_id in smush_details) {
			if(smush_details.hasOwnProperty(image_id)) {
				$('#post-' + image_id + ' .column-wpo_smush').html(smush_details[image_id]);
			}
		}
		reset_bulk_actions_dropdown();
	}

	/**
	 * Updates the view with progress related stats
	 *
	 * @param {Object} resp - response from smush manager.
	 *
	 * @return void
	 */
	function update_view_bulk_smush_progress(resp) {
		
		// Update stats
		$('#smush_stats_pending_images').html(resp.pending_tasks);
		$('#smush_stats_completed_images').html(resp.completed_task_count);
		$('#smush_stats_bytes_saved').html(resp.bytes_saved);
		$('#smush_stats_percent_saved').html(resp.percent_saved);

		// Show summary and close the modal
		if (true == resp.smush_complete) {
			// Force a delay here to avoid stale data
			setTimeout(function() {
				update_view_bulk_smush_complete(function() { get_info_from_smush_manager(false); });
			}, 1500);
		}
	}

	/**
	 * Updates the view when bulk smush completes
	 *
	 * @return void
	 */
	function update_view_bulk_smush_complete(callback) {

		data = {
			update_ui: true,
			use_cache: false,
			image_list: smush_image_list
		};

		(function(single_callback) {
			heartbeat_agents.push(heartbeat.add_agent({
				_wait: false,
				_keep: false,
				command: 'updraft_smush_ajax',
				command_data: {data: data, subaction: 'get_ui_update'},
				callback: function(resp) {

					summary = resp.session_stats;
					// Prevent pops with undefined headers
					if (!resp.session_stats) {
						return;
					}

					if (0 != resp.completed_task_count) {
						summary += '<hr>' + resp.summary;
					}

					show_smush_summary(summary);

					if (single_callback instanceof Function) {
						single_callback();
					}
				}
			}));
		})(callback);
	}

	/**
	 * Displays a modal with compression data
	 *
	 * @param {string} summary - stats and info
	 *
	 * @return void
	 */
	function show_smush_summary(summary) {
		
		if (smush_completed) return;

		$('#summary-message').html(summary);
		reset_view_bulk_smush();
		block_ui('', $.extend(block_ui_custom_options, {message: $('#smush-complete-summary')}));
		smush_completed = true;

		heartbeat.cancel_agents(heartbeat_agents);
	}

	/**
	 * Updates the view when bulk smush completes
	 *
	 * @return void
	 */
	function reset_view_bulk_smush() {
		// Reset timer and locks
		smush_total_seconds = 0;
		smush_timer_locked = false;
		smush_completed = false;
		smush_image_list = [];
		
		heartbeat.cancel_agents(heartbeat_agents);
		clearInterval(smush_timer_handle);
		
		disable_image_optimization_controls(false);
	}

	/**
	 * Append the image to the grid
	 *
	 * @param {Object} image	 - image data returned from smush manager
	 * @param {int} blog_id - The blog id the image
	 * @param {String} admin_url - The URL to link to for viewing the image
	 *
	 * @return void
	 */
	function add_image_to_grid(image, blog_id, admin_url) {

		var dom_id = ['wpo_smush_', blog_id, '_', image.id].join('');

		image_html = '<div class="wpo_smush_image" data-filesize="'+image.filesize+'">';
		image_html += '<a class="button" href="'+admin_url+'" target="_blank"> ' + wposmush.view_image + ' </a>';
		image_html += '<input id="' + dom_id + '" type="checkbox" data-blog="'+blog_id+ '" class="wpo_smush_image__input" value="'+image.id+'">';
		image_html += '<label for="' + dom_id + '"></a>';
		image_html += '<div class="thumbnail">';
		image_html += '<img class="lazyload" src="'+image.thumb_url+'">';
		image_html += '</div></label></div>';

		smush_images_grid.append(image_html);
	}

	/**
	 * Updates UI based on service provider selected
	 *
	 * @param {Object} features - image data returned from smush manager
	 *
	 * @return void
	 */
	function update_view_available_options() {
		features = wposmush.features;
		service = $("input[name^='compression_server']:checked").val();

		for (feature in features[service]) {
			$('.' + feature).prop('disabled', !features[service][feature]);
		}

		$('.wpo_smush_image').each(function() {
			if ($(this).data('filesize') > wposmush.features[service]["max_filesize"]) {
				$(this).hide();
			} else {
				$(this).show();
			}
		})
	}

	/**
	 * Disable smush controls (buttons, checkboxes) in bulk mode
	 *
	 * @param {boolean} disable - if true then disable controls, false - enable.
	 *
	 * @return void
	 */
	function disable_image_optimization_controls(disable) {
		$.each([
			smush_selected_images_btn,
			smush_images_select_all_btn,
			smush_images_select_none_btn,
			smush_images_refresh_btn,
			smush_mark_as_compressed_btn,
		], function(i, el) {
			el.prop('disabled', disable);
		});

		if (disable) {
			$('#wpo_smush_images_refresh').hide();
			$('.wpo_smush_images_loader').show();
		} else {
			$('#wpo_smush_images_refresh').show();
			$('.wpo_smush_images_loader').hide();
		}
	}

	/**
	 * Gets selected image and make an ajax request to compress it.
	 *
	 * @param {Object} selected_image - { attachment_id: ..., blog_id: ... }
	 * @param {Array}  smush_options - The options to use
	 *
	 * @return void
	 */
	function smush_selected_image(selected_image, smush_options) {
		
		// if no selected images then exit.
		if (0 == selected_image.length) return;

		data = {
			selected_image: selected_image,
			smush_options: smush_options
		}

		block_ui(wposmush.compress_single_image_dialog, {}, false, true);
		smush_manager_send_command('compress_single_image', data, function(resp) {
			handle_response_from_smush_manager(resp, update_view_single_image_complete);
		});
	}

	/**
	 * Get selected image and make an ajax request to compress it.
	 *
	 * @param {Number}   blog_id        - The blog id
	 * @param {Number}   selected_image - The image id
	 * @param {Function} done_callback  - Optional. It will be called when the AJAX command is done, used for multiple calls that need a single `done` action (like bulk_restore)
	 *
	 * @return void
	 */
	function restore_selected_image(blog_id, selected_image, done_callback) {
		
		// if no selected images then exit.
		if (0 == selected_image.length) return;
		
		block_ui(wposmush.please_wait);
		var data = { 'blog_id': blog_id, 'selected_image': selected_image };
		
		smush_manager_send_command.apply({unique: false}, ['restore_single_image', data, function(resp) {
			var done = function(resp_summary_alt) {
				if ('undefined' != typeof(resp_summary_alt)) {
					resp.summary = resp_summary_alt;
				}

				handle_response_from_smush_manager(resp, update_view_single_image_complete);
			}
			
			if (done_callback instanceof Function) {
				done_callback(done);
			} else {
				done();
			}
		}]);
	}

	/**
	 * Updates the view once a single image is compressed or restored.
	 *
	 * @param {Object} resp - response from smush manager.
	 *
	 * @return void
	 */
	function update_view_single_image_complete(resp) {

		if (resp.hasOwnProperty('success') && resp.success) {
			$(".smush-information").text(resp.summary);
			block_ui('', $.extend(block_ui_custom_options, {message: $("#smush-information-modal")}));

			$('.wpo-toggle-advanced-options.wpo_smush_single_image').removeClass('opened');

			update_view_singe_image_compress(resp.operation, resp.summary, resp.restore_possible, resp);

			// here we store data from the the response
			// this information will be used to show correct UI elements
			// when smush metabox will shown again without reloading main page
			var blog_id = resp.blog_id || resp.options.blog_id,
				image_id = resp.image || resp.options.attachment_id;

			if (!smush_affected_images.hasOwnProperty(blog_id)) smush_affected_images[blog_id] = {};
			if (!smush_affected_images[blog_id].hasOwnProperty(image_id)) smush_affected_images[blog_id][image_id] = {};

			if (resp.hasOwnProperty('media_column_html')) {
				update_smush_information_media_library_column(blog_id, image_id, resp.media_column_html);
			}

			if ('compress' == resp.operation) {
				smush_affected_images[blog_id][image_id] = {
					operation: resp.operation,
					summary: resp.summary,
					restore_possible: resp.restore_possible
				}
			} else {
				if (image_id) {
					reset_bulk_actions_dropdown();
				}
				smush_affected_images[blog_id][image_id] = {
					operation: resp.operation
				}
			}
		} else {
			block_ui(resp.error_message);
		}
	}

	/**
	 * Update information for the WP-Optimize column in the Media Library.
	 *
	 * @param {number} blog_id
	 * @param {number} image_id
	 * @param {string} html
	 */
	function update_smush_information_media_library_column(blog_id, image_id, html) {
		$(['.wpo-smush-media-library-column[data-blog="',blog_id,'"][data-id="',image_id,'"]'].join('')).parent().html(html);
	}

	/**
	 * Update metabox view depending on a command response.
	 *
	 * @param {string}  operation
	 * @param {string}  summary
	 * @param {boolean} restore_possible
	 * @param {object}  smush_image_data
	 */
	function update_view_singe_image_compress(operation, summary, restore_possible, smush_image_data) {
		var wrapper = $("#smush_info").closest('#smush-metabox-inside-wrapper');

		if (0 === wrapper.length) return;

		if ('compress' == operation) {
			$(".wpo_smush_single_image").hide();
			$(".wpo_restore_single_image").show();
			
			if (smush_image_data && smush_image_data.hasOwnProperty('sizes-info')) {
				$("#smush_info").text(summary);
				$("#wpo_smush_details").html(smush_image_data['sizes-info']);
			} else {
				$("#smush_info").text(summary);
				$("#wpo_smush_details").text('').hide();
			}

			$('.wpo_smush_mark_single_image').hide();

			if (restore_possible) {
				$(".restore_possible").show();
			} else {
				$(".restore_possible").hide();
			}
		} else {
			$(".wpo_smush_single_image").show();
			$(".wpo_restore_single_image").hide();

			$('.wpo_smush_mark_single_image').show();
			$('.wpo_smush_unmark_single_image', wrapper).hide();
		}
	}

	/**
	 * Handle smush metabox load event. This handler is used to restore correct smush metabox view.
	 */
	$(document).on('admin-metabox-smush-loaded', function() {
		var image_data = $('.wpo_restore_single_image input[type="button"]').first().data();

		if (!image_data) return;

		if (smush_affected_images.hasOwnProperty(image_data.blog) && smush_affected_images[image_data.blog].hasOwnProperty(image_data.id)) {
			var smush_image_data = smush_affected_images[image_data.blog][image_data.id];

			if ('compress' == smush_image_data.operation) {
				update_view_singe_image_compress(smush_image_data.operation, smush_image_data.summary, smush_image_data.restore_possible, smush_image_data);
			} else {
				update_view_singe_image_compress(smush_image_data.operation);
			}
		}
	});

	/**
	 * Check returned response from the smush manager and call update view callback.
	 *
	 * @param {Object} resp - response from smush manager.
	 * @param {Function} update_view_callback - callback function to update view.
	 *
	 * @return void
	 */
	function handle_response_from_smush_manager(resp, update_view_callback) {
		if (resp && resp.hasOwnProperty('status') && resp.status) {
			if (update_view_callback) update_view_callback(resp);
		} else {
			alert(wposmush.error_unexpected_response);
			console.log(resp);
		}
	}

	/**
	 * Retrieves the selected images from the media library.
	 *
	 * @return {jQuery} - The selected images as a jQuery object.
	 */
	function get_media_library_selected_images() {
		return $('input[name="media[]"]:checked');
	}

	/**
	 * Retrieves the list of selected images from the media library.
	 *
	 * @return {Array.<number>} The list of selected image IDs.
	 */
	function get_media_library_selected_images_list() {
		var selected_images_list = [];
		var $selected_images = get_media_library_selected_images();
		$selected_images.each(function(index, element) {
			selected_images_list.push(parseInt(element.value));
		});
		return selected_images_list;
	}

	/**
	 * Resets the bulk action dropdown by setting its value to "-1" and unchecking all the selected checkboxes.
	 *
	 * @returns {void}
	 */
	function reset_bulk_actions_dropdown() {
		$('#bulk-action-selector-top, #bulk-action-selector-bottom').val("-1");
		$('input[name="media[]"]:checked, #cb-select-all-1, #cb-select-all-2').prop('checked', false);
	}
	
	/**
	 * Send an action to the task manager via admin-ajax.php.
	 *
	 * @param {string}   action	 The action to send
	 * @param {[type]}   data	   Data to send
	 * @param {Function} callback   Will be called with the results
	 * @param {boolean}  json_parse JSON parse the results
	 *
	 * @return {JSON}
	 */
	function smush_manager_send_command(action, data, callback, json_parse) {

		json_parse = ('undefined' === typeof json_parse) ? true : json_parse;

		data = (data.hasOwnProperty('skip_notice') && Object.keys(data).length === 1) || $.isEmptyObject(data) ? {'use_cache' : false} : data;

		(function(single_callback, _keep, _unique) {
			heartbeat_agents.push(heartbeat.add_agent({
				_wait: false,
				_keep: _keep,
				_unique: _unique,
				command: 'updraft_smush_ajax',
				command_data: {data: data, subaction: action},
				callback: function(response) {
					if (json_parse) {
						try {
							var resp = wpo_parse_json(response);
						} catch (e) {
							console.log("smush_manager_send_command JSON parse error");
							console.log(e);
							console.log(response);
							alert(wposmush.error_unexpected_response);
						}
						if ('undefined' !== typeof single_callback) single_callback(resp);
					} else {
						if ('undefined' !== typeof single_callback) single_callback(response);
					}
				}
			}));
		})(callback, this.keep, this.unique);
	};

	// Attach heartbeat API events
	heartbeat.setup();

	// Gather smush options
	var get_smush_options = function() {
		var image_quality = '';
		if ($('#enable_custom_compression').is(":checked")) {
			image_quality = $('#custom_compression_slider').val();
		} else {
			// The '90' here has to be kept in sync with WP_Optimize::admin_page_wpo_images_smush()
			image_quality = $('#enable_lossy_compression').is(":checked") ? 60 : 92;
		}
		var lossy_compression = image_quality < 92 ? true : false;

		return {
			'compression_server': $("input[name='compression_server']:checked").val(),
			'image_quality': image_quality,
			'lossy_compression': lossy_compression,
			'back_up_original': $('#smush-backup-original').is(":checked"),
			'back_up_delete_after': $('#smush-backup-delete').is(":checked"),
			'back_up_delete_after_days': $('#smush-backup-delete-days').val(),
			'preserve_exif': $('#smush-preserve-exif').is(":checked"),
			'autosmush': $('#smush-automatically').is(":checked"),
			'show_smush_metabox': $('#smush-show-metabox').is(":checked"),
			'webp_conversion': $('#enable_webp_conversion').is(":checked")
		};
	}
	wp_optimize.smush_settings = get_smush_options;
} // END WP_Optimize_Smush

