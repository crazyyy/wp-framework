jQuery(function($) {
	WP_Optimize_Smush = WP_Optimize_Smush();
});

var WP_Optimize_Smush = function() {

	var $ = jQuery;

	var heartbeat = WP_Optimize_Heartbeat();
	var heartbeat_agents = [];

	var last_ui_update_agent_uid = null;

	/**
	 * Variables for smushing.
	 */
	var smush_nav_tab = $('#wp-optimize-images-nav-tab-smush'),
		smush_images_grid = $('#wpo_smush_images_grid'),
		smush_images_optimization_message = $('#smush_info_images'),
		smush_images_pending_tasks_container = $('#wpo_smush_images_pending_tasks_container'),
		smush_images_pending_tasks_btn = $('#wpo_smush_images_pending_tasks_button'),
		smush_images_refresh_btn = $('#wpo_smush_images_refresh'),
		smush_images_select_all_btn = $('#wpo_smush_images_select_all'),
		smush_images_select_none_btn = $('#wpo_smush_images_select_none'),
		smush_images_stats_clear_btn = $('#wpo_smush_clear_stats_btn'),
		smush_selected_images_btn = $('#wpo_smush_images_btn'),
		smush_mark_as_compressed_btn = $('#wpo_smush_mark_as_compressed'),
		smush_single_image_btn = $('.wpo_smush_single_image .button'),
		smush_single_restore_btn = $('.wpo_restore_single_image .button'),
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
		$('#smush-information-modal .smush-information').text(wposmush.server_check);
		update_view_modal_message($('#smush-information-modal'));

		data = { 'server': wposmush.smush_settings.compression_server };
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
				update_view_modal_message($('#wpo_smush_images_information_container'));

				$('#wpo_smush_images_information_server').html(wposmush.smush_settings.compression_server);

				clear_smush_stats();

				smush_timer_handle = window.setInterval(smush_timer, 1000);
				smush_manager_send_command('process_bulk_smush', data);
			} else {
				if (resp.error) {
					error_message = resp.error + '<br>' + wposmush.server_error
					$('#smush-information-modal .smush-information').html(error_message);
				} else {
					$('#smush-information-modal .smush-information').text(wposmush.server_error);
				}
				update_view_modal_message($('#smush-information-modal'), $.unblockUI);
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
		smush_manager_send_command('reset_webp_serving_method', {}, function(resp) {
			if (!resp.success) {
				console.log('[Failed] WebP server capability detection');
				$('#enable_webp_conversion').prop("checked", false);
				$('#smush-information-modal .smush-information').text(resp.error_message);
				update_view_modal_message($('#smush-information-modal'))
			} else {
				$('#wpo_reset_webp_serving_method_done').show().delay(3000).fadeOut();
			}
		});
	});

	/**
	 *  Checks if smush is active and loads images if yes - image tabs change.
	 */
	$('#wp-optimize-nav-tab-wrapper__wpo_images .nav-tab').on('click', function() {
		if ($(this).is('#wp-optimize-nav-tab-wpo_images-smush')) {
			get_info_from_smush_manager();
		}
	});

	/**
	 * Checks if smush is active and loads images if yes - main menu change.
	 */
	$('#wp-optimize-wrap').on('page-change', function(e, params) {
		if ('wpo_images' == params.page) {
			if ($('#wp-optimize-nav-tab-wrapper__wpo_images .nav-tab-active').is('#wp-optimize-nav-tab-wpo_images-smush')) {
				get_info_from_smush_manager();
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
			$('#smush-information-modal .smush-information').text(wposmush.please_select_images)
			update_view_modal_message($('#smush-information-modal'), $.unblockUI);
			return;
		}

		$('#smush-information-modal .smush-information').text(wposmush.server_check);
		update_view_modal_message($('#smush-information-modal'));

		data = { 'server': $("input[name='compression_server']:checked").val() };
		smush_manager_send_command('check_server_status', data, function(resp) {
			if (resp.online) {
				bulk_smush_selected_images();
			} else {
				if (resp.error) {
					error_message = resp.error + '<br>' + wposmush.server_error
					$('#smush-information-modal .smush-information').html(error_message);
				} else {
					$('#smush-information-modal .smush-information').text(wposmush.server_error);
				}
				update_view_modal_message($('#smush-information-modal'), $.unblockUI);
			}
		});
	});

	/**
	 * Mark as compressed
	 */
	smush_mark_as_compressed_btn.off().on('click', function() {
		if (0 == $('#wpo_smush_images_grid input[type="checkbox"]:checked').length) {
			$('#smush-information-modal .smush-information').text(wposmush.please_select_compressed_images)
			update_view_modal_message($('#smush-information-modal'), $.unblockUI);
			return;
		}

		var selected_images = [],
			image;

		$('#wpo_smush_images_grid input:checked').each(function() {
			image = {
				'attachment_id':$(this).val(),
				'blog_id': $(this).data('blog')
			};
			selected_images.push(image);
		});

		update_view_modal_message(wposmush.please_updating_images_info);

		smush_manager_send_command('mark_as_compressed', {selected_images: selected_images}, function(response) {
			$('#smush-information-modal .smush-information').text(response.summary);
			update_view_modal_message($('#smush-information-modal'), $.unblockUI);
			// refresh images list.
			get_info_from_smush_manager();
		});
	});

	/**
	 * Handle "Mark all images as uncompressed" click.
	 */
	smush_mark_all_as_uncompressed_btn.on('click', function() {
		if (!confirm(wposmush.mark_all_images_uncompressed)) return;

		var restore_backup = confirm(wposmush.restore_images_from_backup);

		update_view_modal_message($('#smush-information-modal-cancel-btn'));
		$('#smush-information-modal-cancel-btn .smush-information').text(wposmush.please_wait);

		smush_mark_all_as_uncompressed = true;
		run_mark_all_as_uncompressed(restore_backup);
	});

	/**
	 * Handle "Restore all compressed images" click.
	 */
	restore_all_compressed_images_btn.on('click', function() {
		if (!confirm(wposmush.restore_all_compressed_images)) return;

		update_view_modal_message($('#smush-information-modal-cancel-btn'));
		$('#smush-information-modal-cancel-btn .smush-information').text(wposmush.please_wait);

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
				delete_only_backups_meta: delete_only_backups_meta
			},
			function(resp) {
				// if cancel button pressed then exit
				if (!smush_mark_all_as_uncompressed) return;

				// if we get an error then show it
				if (resp.hasOwnProperty('error')) {
					update_view_modal_message($('#smush-information-modal'), $.unblockUI);
					$('#smush-information-modal .smush-information').text(resp.error);
					get_info_from_smush_manager();
					return;
				}

				// if completed then refresh uncompressed images list and show final message.
				if (resp.completed) {
					update_view_modal_message($('#smush-information-modal'), $.unblockUI);
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
	 * Binds pending tasks button
	 */
	smush_images_pending_tasks_btn.off().on('click', function(e) {
		$('#smush-information-modal .smush-information').text(wposmush.server_check);
		update_view_modal_message($('#smush-information-modal'), $.unblockUI);
		data = { 'server': $("input[name='compression_server']:checked").val() };
		smush_manager_send_command('check_server_status', data, function(resp) {
			if (resp.online) {
				update_view_bulk_smush_start();
				smush_manager_send_command('process_pending_images', {}, function(resp) {
					handle_response_from_smush_manager(resp, update_view_bulk_smush_progress);
				});
			} else {
				if (resp.error) {
					error_message = resp.error + '<br>' + wposmush.server_error
					$('#smush-information-modal .smush-information').html(error_message);
				} else {
					$('#smush-information-modal .smush-information').text(wposmush.server_error);
				}
				update_view_modal_message($('#smush-information-modal'), $.unblockUI);
			}
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
		smush_manager_send_command('clear_pending_images', {}, function(resp) {
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
		update_view_modal_message(wposmush.server_check);
		smush_manager_send_command('check_server_status', data, function(resp) {
			if (resp.online) {
				smush_selected_image(image, smush_options);
			} else {
				if (resp.error) {
					error_message = resp.error + '<br>' + wposmush.server_error

					update_view_modal_message(error_message, $.unblockUI);
				} else {
					update_view_modal_message(wposmush.server_error, $.unblockUI);
				}
			}
		});
	});

	/**
	 * Single image restore
	 */
	$('body').on('click', '.wpo_restore_single_image .button', function() {
		var clicked_image = $(this);
		blog_id = clicked_image.data('blog');
		image_id = clicked_image.data('id');

		if (!image_id || !blog_id) return;
		restore_selected_image(blog_id, image_id);
	});

	/**
	 * Mark as compressed
	 */
	$('body').on('click', '.wpo_smush_mark_single_image .button', function() {
		var image = {
			'attachment_id':$(this).data('id'),
			'blog_id': $(this).data('blog')
		},
			wrapper = $(this).closest('#smush-metabox-inside-wrapper');

		update_view_modal_message(wposmush.please_updating_images_info);

		smush_manager_send_command('mark_as_compressed', {selected_images: [ image ]}, function(response) {
			$('#smush-information-modal .smush-information').text(response.summary);
			update_view_modal_message($('#smush-information-modal'), $.unblockUI);

			if (response.status) {
				$('.wpo_smush_single_image', wrapper).hide();
				$('.wpo-toggle-advanced-options', wrapper).removeClass('opened');
				$('.wpo_smush_mark_single_image', wrapper).hide();
				$('.wpo_smush_unmark_single_image', wrapper).show();
				$('.wpo_restore_single_image', wrapper).show();
				$('#smush_info', wrapper).text(response.info);
			}
		});
	});

	/**
	 * Unmark as uncompressed
	 */
	$('body').on('click', '.wpo_smush_unmark_single_image .button', function() {
		var image = {
			'attachment_id':$(this).data('id'),
			'blog_id': $(this).data('blog')
		},
			wrapper = $(this).closest('#smush-metabox-inside-wrapper');

		update_view_modal_message(wposmush.please_updating_images_info);

		smush_manager_send_command('mark_as_compressed', {selected_images: [ image ], unmark: true}, function(response) {
			$('#smush-information-modal .smush-information').text(response.summary);
			update_view_modal_message($('#smush-information-modal'), $.unblockUI);

			if (response.status) {
				$('.wpo_smush_single_image', wrapper).show();
				$('.wpo_smush_mark_single_image', wrapper).show();
				$('.wpo_smush_unmark_single_image', wrapper).hide();
				$('.wpo_restore_single_image', wrapper).hide();
				$('#smush_info', wrapper).text('');
			}
		});
	});

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
				update_view_modal_message($('#smush-information-modal'));
			}
			$('#enable_webp_conversion').prop("disabled", false);
		});
	});

	convert_to_webp_btn.on('click', function(e){
		e.preventDefault();
		var $link = $(this);
		data = {
			'attachment_id': $(this).data('attachment-id')
		};
		update_view_modal_message(wposmush.converting_to_webp);
		smush_manager_send_command('convert_to_webp_format', data, function(response) {
			if (response.error) {
				update_view_modal_message(response.error, $.unblockUI);
				setTimeout(function() {
					$.unblockUI();
				}, 2000);
			} else {
				update_view_modal_message(response.success, $.unblockUI);
				setTimeout(function() {
					$.unblockUI();
				}, 2000);
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
		smush_images_pending_tasks_container.hide();

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

		if (0 != pending_tasks) {
			smush_images_pending_tasks_container.show().find('.red').text(data.pending);
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
		update_view_modal_message($('#wpo_smush_images_information_container'));

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
		update_view_modal_message($('#smush-complete-summary'));
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
			smush_images_pending_tasks_btn,
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

		update_view_modal_message(wposmush.compress_single_image_dialog);
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
		
		update_view_modal_message(wposmush.please_wait, $.unblockUI);
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
			update_view_modal_message($("#smush-information-modal"), $.unblockUI);

			$('.wpo-toggle-advanced-options.wpo_smush_single_image').removeClass('opened');

			update_view_singe_image_compress(resp.operation, resp.summary, resp.restore_possible, resp);

			// here we store data from the the response
			// this information will be used to show correct UI elements
			// when smush metabox will shown again without reloading main page
			var blog_id = resp.blog_id || resp.options.blog_id,
				image_id = resp.image || resp.options.attachment_id;

			if (!smush_affected_images.hasOwnProperty(blog_id)) smush_affected_images[blog_id] = {};
			if (!smush_affected_images[blog_id].hasOwnProperty(image_id)) smush_affected_images[blog_id][image_id] = {};

			if ('compress' == resp.operation) {
				smush_affected_images[blog_id][image_id] = {
					operation: resp.operation,
					summary: resp.summary,
					restore_possible: resp.restore_possible
				}
			} else {
				if (image_id) {
					update_media_library_wp_optimize_column(image_id);
					reset_bulk_actions_dropdown();
				}
				smush_affected_images[blog_id][image_id] = {
					operation: resp.operation
				}
			}
		} else {
			$(".smush-information").text(resp.error_message);
			update_view_modal_message($("#smush-information-modal"), $.unblockUI);
		}
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
	 * Display a modal message
	 *
	 * @param {string}   message	 The message or element to display
	 * @param {Function} callback	 Called when the overlay is clicked
	 *
	 * @return void
	 */
	function update_view_modal_message(message, callback) {

		$.blockUI({
			message: message,
			onOverlayClick: callback,
			baseZ: 160001,
			css: {
				width: '400px',
				padding: '20px',
				cursor: 'pointer'
			}
		});
	}

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
	 * Updates the media library WP Optimize column for a specified image.
	 *
	 * @param {number} image_id - The ID of the image to update the column for.
	 */
	function update_media_library_wp_optimize_column(image_id) {
		var admin_url = ajaxurl.replace('/admin-ajax.php', '/');
		admin_url += 'post.php?post=' + image_id + '&action=edit';
		$('#post-' + image_id + ' .column-wpo_smush').html('<a href="' + admin_url + '">' + wposmush.compress + '</a><br>');
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
		data = $.isEmptyObject(data) ? {'use_cache' : false} : data;

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

	setTimeout(get_info_from_smush_manager, 1000, false);
	
} // END WP_Optimize_Smush

/**
 * Parse JSON string, including automatically detecting unwanted extra input and skipping it
 *
 * @param {string|object} json_mix_str - JSON string which need to parse and convert to object
 *
 * @throws SyntaxError|String (including passing on what JSON.parse may throw) if a parsing error occurs.
 *
 * @return mixed parsed JSON object. Will only return if parsing is successful (otherwise, will throw)
 */
function wpo_parse_json(json_mix_str) {
	// When using wp_send_json to return the value, the format is already parsed.
	if ('object' === typeof json_mix_str) return json_mix_str;

	// Just try it - i.e. the 'default' case where things work (which can include extra whitespace/line-feeds, and simple strings, etc.).
	try {
		var result = JSON.parse(json_mix_str);
		return result;
	} catch (e) {
		console.log("WPO: Exception when trying to parse JSON (1) - will attempt to fix/re-parse");
		console.log(json_mix_str);
	}

	var json_start_pos = json_mix_str.indexOf('{');
	var json_last_pos = json_mix_str.lastIndexOf('}');

	// Case where some php notice may be added after or before json string
	if (json_start_pos > -1 && json_last_pos > -1) {
		var json_str = json_mix_str.slice(json_start_pos, json_last_pos + 1);
		try {
			var parsed = JSON.parse(json_str);
			return parsed;
		} catch (e) {
			console.log("WPO: Exception when trying to parse JSON (2) - will attempt to fix/re-parse based upon bracket counting");

			var cursor = json_start_pos;
			var open_count = 0;
			var last_character = '';
			var inside_string = false;

			// Don't mistake this for a real JSON parser. Its aim is to improve the odds in real-world cases seen, not to arrive at universal perfection.
			while ((open_count > 0 || cursor == json_start_pos) && cursor <= json_last_pos) {

				var current_character = json_mix_str.charAt(cursor);

				if (!inside_string && '{' == current_character) {
					open_count++;
				} else if (!inside_string && '}' == current_character) {
					open_count--;
				} else if ('"' == current_character && '\\' != last_character) {
					inside_string = inside_string ? false : true;
				}

				last_character = current_character;
				cursor++;
			}

			console.log("Started at cursor="+json_start_pos+", ended at cursor="+cursor+" with result following:");
			console.log(json_mix_str.substring(json_start_pos, cursor));

			try {
				var parsed = JSON.parse(json_mix_str.substring(json_start_pos, cursor));
				// console.log('WPO: JSON re-parse successful');
				return parsed;
			} catch (e) {
				// Throw it again, so that our function works just like JSON.parse() in its behaviour.
				throw e;
			}

		}
	}

	throw "WPO: could not parse the JSON";

}
