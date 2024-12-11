var WPO_Status_Report = (function($) {
	var report_initialized = false;
	var report_initializing = false;

	return function() {
		if (false !== report_initialized || false !== report_initializing) return;

		var replaceable_md_tags;

		/**
		 * Use WordPress Fetch API to show directory size information, update HTML and plain text report
		 */
		function fetch_directory_sizes() {
			wp.apiFetch({
				path: 'wp-site-health/v1/directory-sizes'
			}).then(function(data) {
				var tag;
				
				for(var fieldname in data) {
					$('#wpo-value-wp-paths-sizes-' + fieldname).html(data[fieldname].size);

					tag = '{{[wp-paths-sizes-' + fieldname + ']}}';
					replace_md_report_tag(tag, data[fieldname].size);

					delete replaceable_md_tags[fieldname];
				}

				for(var fieldname in replaceable_md_tags) {
					if (null !== replaceable_md_tags[fieldname]) {
						replace_md_report_tag(replaceable_md_tags[fieldname], wpoptimize.data_not_available);
						$('#wpo-value-wp-paths-sizes-' + fieldname).html(wpoptimize.data_not_available);
					}
				}
			}).catch(function(e) {
				var elems = document.querySelectorAll('.wpo-ajax-field-wp-paths-sizes');
				elems.forEach(function(e) {
					e.innerHTML = wpoptimize.data_not_available;
				});
			});
		}

		/**
		 * Generate system report
		 */
		function generate_system_report() {
			report_initializing = true;
			$('#wpo-generate-status-report-text').html(wpoptimize.please_wait + " " + '<i id="wpo-preview-loader"><img width="12" height="12" src="' + wpoptimize.spinner_src + '"></i>');
			
			wp_optimize.send_command('generate_status_report', {}, function (resp) {
				$("#wpo-status-report-container").html(resp.html);

				attach_click_handlers();
				fill_settings_debug_report();
				fetch_directory_sizes();

				replaceable_md_tags = resp.replaceable_md_tags;

				report_initialized = true;
			}).always(function() {
				report_initializing = false;
			});
		};

		/**
		 * Show/Hide plain text markdown report button click events and log download
		 */
		function attach_click_handlers() {
			var server_info = $('#wpo-server-info');
			var btn_show_status_report = $('#wpo-show-status-report-btn');
			var btn_copy_status_report = $('#wpo-copy-status-report-btn');
			var server_info_report = $('#wpo-server-info-report');
			btn_show_status_report.on('click', function(e) {
				var to_show = server_info_report.is(':hidden');
				if (true === to_show) {
					$(this).text(wpoptimize.hide);
					server_info.prepend(server_info_report);
					server_info_report.show();
					server_info_report.trigger('select');

					// give event loop some time to render the select() method we just called
					setTimeout(function(o) { o.scrollTop(0); }, 50, server_info_report);
				} else {
					$(this).text(wpoptimize.show);
					server_info.append(server_info_report);
					server_info_report.hide();
				}
			});

			(function(btn) {
				btn.on('click', function(event) {
					event.preventDefault();

					var server_info_report = $('#wpo-server-info-report');
					try {
						if (clipboard in navigator) {
							navigator.clipboard.writeText(server_info_report.val());
							show_clipboard_action_result(wpoptimize.clipboard_success);
						} else {
							throw new Error();
						}
					} catch(e) {
						const textArea = document.createElement('textarea');
						textArea.value = server_info_report.val();
						textArea.style.opacity = 0;
						var container = btn.parent();
						container.append(textArea);
						textArea.focus();
						textArea.select();
						try {
							const success = document.execCommand('copy');
							if (success) {
								show_clipboard_action_result(wpoptimize.clipboard_success);
							} else {
								throw new Error("Exec command failed, could not copy");
							}
						} catch (err) {
							console.log(err);
							show_clipboard_action_result(wpoptimize.clipboard_failed);
						}
						$(textArea).remove();
					}
				});
			})(btn_copy_status_report);

			/**
			 * Display the result for clipboard copy action
			 *
			 * @param {string} msg The result message
			 */
			function show_clipboard_action_result(msg) {
				$("#wpo-copy-action-result").html(msg);
				$("#wpo-copy-action-result").show();
				setTimeout(function() { $("#wpo-copy-action-result").hide(); }, 1500);
			}

			$('#wpo-download-logs').on('click', function() {
				$('#wpo-generate-zip-file-text').html(wpoptimize.please_wait + " " + '<i id="wpo-preview-loader"><img width="12" height="12" src="' + wpoptimize.spinner_src + '"></i>');
				$(this).prop('disabled', true);

				wp_optimize.send_command('generate_logs_zip', {}, function (resp) {
					const zip = new JSZip();
					
					resp.data.forEach(function(ziplog) {
						if (ziplog.compressed) {
							zip.file(ziplog.name + '.gz', atob(ziplog.src), {binary: true});
						} else {
							zip.file(ziplog.name, atob(ziplog.src), {binary: true});
						}
					});
					
					zip.generateAsync({type : "blob", compression: "DEFLATE"}).then(function(logs) {
						var blob = new Blob([logs]);
						const url = window.URL.createObjectURL(blob);
						const a = document.createElement('a');
						a.style.display = 'none';
						a.href = url;
						
						var now = new Date().toJSON().replace(/:/g, '_');
						a.download = 'logs-' + now + '.zip';
						document.body.appendChild(a);
						a.click();
						window.URL.revokeObjectURL(url);

						$('#wpo-generate-zip-file-text').html('');
						$('#wpo-download-logs').prop('disabled', false);
					});
				});
			});

			$("#wpo-download-status-report-btn").on('click', function() {
				var blob = new Blob([server_info_report.val()]);
				const url = window.URL.createObjectURL(blob);
				const a = document.createElement('a');
				a.style.display = 'none';
				a.href = url;
				
				var now = new Date().toJSON().replace(/:/g, '_');
				a.download = 'wp-optimize-report-' + now + '.txt';
				document.body.appendChild(a);
				a.click();
				window.URL.revokeObjectURL(url);
			});
		}

		/**
		 * Insert the plugin settings section in HTML and plain text report
		 */
		function fill_settings_debug_report() {
			var report = JSON.stringify(WP_Optimize.build_settings(), null, 2);

			$('#wpo-general-settings').html(report);

			replace_md_report_tag('{{[wpo-general-settings]}}', report);
		}

		/**
		 * Helper to insert text in textarea object with markdown report contents
		 *
		 * @param {string} tag  The search string to find the replaceable tag
		 * @param {string} text The actual text that needs to be in the report
		 */
		function replace_md_report_tag(tag, text) {
			var markdown_report = $('#wpo-server-info-report').html();
			markdown_report = markdown_report.replace(tag, text);
			$('#wpo-server-info-report').html(markdown_report);
		}

		// Attach tab change
		$('#wp-optimize-wrap').on('tab-change/wpo_settings/status', function(e) {
			e.preventDefault();

			if (false === report_initialized) {
				generate_system_report();
			}
		});
	}
})(jQuery);