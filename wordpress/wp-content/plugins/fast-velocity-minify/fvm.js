(function($){
	
	$(function(){
		
		// disable some checkboxes when some other is on or off
		$('#fastvelocity_min_enable_defer_js').bind('click init', function() {
			if( $(this).is(':checked')) {
				$("#fastvelocity_min_exclude_defer_jquery, #fastvelocity_min_exclude_defer_login").prop("disabled", false);
			} else {
				$("#fastvelocity_min_exclude_defer_jquery, #fastvelocity_min_exclude_defer_login").prop("disabled", true);
			}
		}).trigger('init'); 
		
		// disable some checkboxes when some other is on or off
		$('#fastvelocity_min_skip_html_minification').bind('click init', function() {
			if( $(this).is(':checked')) {
				$("#fastvelocity_min_strip_htmlcomments").prop("disabled", true).prop('checked', false);
			} else {
				$("#fastvelocity_min_strip_htmlcomments").prop("disabled", false);
			}
		}).trigger('init');
		
		// disable some checkboxes when some other is on or off
		$('#fastvelocity_min_disable_css_merge').bind('click init', function() {
			if( $(this).is(':checked')) {
				$("#fastvelocity_min_disable_css_minification, #fastvelocity_min_force_inline_css").prop("disabled", true);
				$("#fastvelocity_min_force_inline_css_footer").prop("disabled", true);
				$("#fastvelocity_min_skip_cssorder, #fastvelocity_min_remove_print_mediatypes").prop("disabled", true);
			} else {
				$("#fastvelocity_min_disable_css_minification, #fastvelocity_min_force_inline_css").prop("disabled", false);
				$("#fastvelocity_min_force_inline_css_footer").prop("disabled", false);
				$("#fastvelocity_min_skip_cssorder, #fastvelocity_min_remove_print_mediatypes").prop("disabled", false);
			}
		}).trigger('init');
		
		// disable some checkboxes when some other is on or off
		$('#fastvelocity_min_disable_js_merge').bind('click init', function() {
			if( $(this).is(':checked')) {
				$("#fastvelocity_min_use_yui, #fastvelocity_min_disable_js_minification").prop("disabled", true);
				$("#fastvelocity_min_enable_defer_js, #fastvelocity_min_defer_for_pagespeed").prop("disabled", true);
				$("#fastvelocity_min_exclude_defer_jquery, #fastvelocity_min_exclude_defer_login").prop("disabled", true);
			} else {
				$("#fastvelocity_min_use_yui, #fastvelocity_min_disable_js_minification").prop("disabled", false);
				$("#fastvelocity_min_enable_defer_js, #fastvelocity_min_defer_for_pagespeed").prop("disabled", false);
				$("#fastvelocity_min_exclude_defer_jquery, #fastvelocity_min_exclude_defer_login").prop("disabled", false);
			}
		}).trigger('init'); 
		
		// disable some checkboxes when some other is on or off
		$('#fastvelocity_min_fvm_removecss').bind('click init', function() {
			if( $(this).is(':checked')) {
				$("#fastvelocity_min_send_css_to_footer, #fastvelocity_min_critical_path_visibility").prop("disabled", true);
				$("#fastvelocity_min_critical_css_tester").prop("disabled", true);
			} else {
				$("#fastvelocity_min_send_css_to_footer, #fastvelocity_min_critical_path_visibility").prop("disabled", false);
				$("#fastvelocity_min_critical_css_tester").prop("disabled", false);
			}
		}).trigger('init');
		
		// disable collapse
		$('.postbox h3, .postbox .handlediv').unbind('click.postboxes');
		
		// variables
		var $fastvelocity_min_processed = $('#fastvelocity_min_processed'),
		$fastvelocity_min_jsprocessed = $('#fastvelocity_min_jsprocessed',$fastvelocity_min_processed),
		$fastvelocity_min_jsprocessed_ul = $('ul',$fastvelocity_min_jsprocessed),
		$fastvelocity_min_cssprocessed = $('#fastvelocity_min_cssprocessed',$fastvelocity_min_processed),
		$fastvelocity_min_cssprocessed_ul = $('ul',$fastvelocity_min_cssprocessed),
		$fastvelocity_min_noprocessed = $('#fastvelocity_min_noprocessed'),
		timeout = null,
		stamp = null;
		
		$($fastvelocity_min_processed).on('click','.log',function(e){
			e.preventDefault();
			$(this).parent().nextAll('pre').slideToggle();
		});
				
		function getFiles(extra) {
			stamp = new Date().getTime();
			var data = {
				'action': 'fastvelocity_min_files',
				'stamp': stamp
			};
			if(extra) {
				for (var attrname in extra) { data[attrname] = extra[attrname]; }
			}
	
			
			$.post(ajaxurl, data, function(response) {
				
				if(response.cachesize.length > 0) { 
					$("#fvm_cache_size").html(response.cachesize);
				}

				if(stamp == response.stamp) {					
					if(response.js.length > 0) { 
						$fastvelocity_min_jsprocessed.show();
						
						$(response.js).each(function(){
							var $li = $fastvelocity_min_jsprocessed_ul.find('li.'+this.hash);
							if($li.length > 0) {
								if($li.find('pre').html() != this.log) {
									$li.find('pre').html(this.log);
								}
							} else {
								$fastvelocity_min_jsprocessed_ul.append('<li class="'+this.hash+'"><span class="filename">'+this.filename+' ('+this.fsize+')</span> <span class="actions"><a href="#" class="log button button-primary">View Log</a></span><pre>'+this.log+'</pre></li><div class="clear"></div>');
							}
						});
						
					}
					if(response.css.length > 0) {
																		
						$(response.css).each(function(){
							var $li = $fastvelocity_min_cssprocessed_ul.find('li.'+this.hash);
							if($li.length > 0) {
								if($li.find('pre').html() != this.log) {
									$li.find('pre').html(this.log);
								}
							} else {
								$fastvelocity_min_cssprocessed_ul.append('<li class="'+this.hash+'"><span class="filename">'+this.filename+' ('+this.fsize+')</span> <span class="actions"><a href="#" class="log button button-primary">View Log</a></span><pre>'+this.log+'</pre></li><div class="clear"></div>');
							}
						});
					}
					
					// check for new files
					timeout = setTimeout(getFiles, 4000);
				}
			});
		}
		
		getFiles();
		
	});

})(jQuery);