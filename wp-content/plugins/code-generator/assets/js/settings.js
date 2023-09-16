/**
 * Plugin Template js settings.
 *
 *  @package WordPress Plugin Template/Settings
 */

jQuery( document ).ready(
	function ($) {

		/***** Colour picker *****/

		$( '.colorpicker' ).hide();
		$( '.colorpicker' ).each(
			function () {
				$( this ).farbtastic( $( this ).closest( '.color-picker' ).find( '.color' ) );
			}
		);

		$( '.color' ).click(
			function () {
				$( this ).closest( '.color-picker' ).find( '.colorpicker' ).fadeIn();
			}
		);

		$( document ).mousedown(
			function () {
				$( '.colorpicker' ).each(
					function () {
						var display = $( this ).css( 'display' );
						if (display == 'block') {
							$( this ).fadeOut();
						}
					}
				);
			}
		);

		/***** Uploading images *****/

		var file_frame;

		jQuery.fn.uploadMediaFile = function (button, preview_media) {
			var button_id  = button.attr( 'id' );
			var field_id   = button_id.replace( '_button', '' );
			var preview_id = button_id.replace( '_button', '_preview' );

			// If the media frame already exists, reopen it.
			if (file_frame) {
				file_frame.open();
				return;
			}

			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media(
				{
					title: jQuery( this ).data( 'uploader_title' ),
					button: {
						text: jQuery( this ).data( 'uploader_button_text' ),
					},
					multiple: false
				}
			);

			// When an image is selected, run a callback.
			file_frame.on(
				'select',
				function () {
					attachment = file_frame.state().get( 'selection' ).first().toJSON();
					jQuery( "#" + field_id ).val( attachment.id );
					if (preview_media) {
						jQuery( "#" + preview_id ).attr( 'src', attachment.sizes.thumbnail.url );
					}
					file_frame = false;
				}
			);

			// Finally, open the modal.
			file_frame.open();
		}

		jQuery( '.image_upload_button' ).click(
			function () {
				jQuery.fn.uploadMediaFile( jQuery( this ), true );
			}
		);

		// Copy
		function copyToClipboard() {
			var $temp = jQuery( '#generate_wp_code textarea' );
			$temp.select();
			document.execCommand( "copy" );
		}
		jQuery( 'body' ).on( 'click', '#generate_wp_copy', copyToClipboard );

		// Generate code
		jQuery( '.generate_wp_generate' ).click( function (e) {
			e.preventDefault();
			var $form = jQuery( '#generate_wp_settings form' ),
				settings = {};

			$form.serializeArray().forEach(function (item) {
				settings[item.name] = item.value;
			});
			if ( ! settings.tab ) {
				settings.tab = jQuery('#generate_wp_header a').first().text();
			}

			const data = {
				action: 'gwp_generate_code',
				settings: settings
			};

			jQuery.ajax( {
				url: ajaxurl,
				type: 'POST',
				data: data
			} ).done( function( res ) {
				if ( res.success ) {
					jQuery('#generate_wp_code').html( '<textarea>' + res.data + '</textarea>' );
					jQuery('#generate_wp_snippet' ).dialog('open');
				} else {
					jQuery('#generate_wp_error').text( res.data ).show().fadeOut(3000);
				}
			});
		} );

		// initalise the dialog
		$('#generate_wp_snippet').dialog({
			title: 'Code snippet',
			dialogId: 'wp-dialog',
			dialogClass: 'wp-dialog',
			autoOpen: false,
			draggable: true,
			width: 'auto',
			modal: true,
			resizable: true,
			closeOnEscape: true,
			show: {
				duration: 500
			},
			hide: {
				duration: 500
			},
			position: {
				my: 'center',
				at: 'center',
				of: window
			},
			open: function () {
				// close dialog by clicking the overlay behind it
				jQuery('.ui-widget-overlay').unbind( 'click' ).bind('click', function() { jQuery( '#generate_wp_snippet' ).dialog('close'); } );
			},
			create: function () {
				jQuery('.ui-dialog-title').after('<button id="generate_wp_copy">Copy</button>');
			},
		});

		// dependency for showing
		jQuery('#generate_wp_settings select').on('change', function(){
			var val = jQuery(this).val(),
				id = jQuery(this).prop('id'),
				slow = 1000,
				children = jQuery('#generate_wp_settings [data-parent="' + id + '"]');


			children.each(function( i, el ){
				var compare = jQuery( this ).data('parent-val'),
					parent = jQuery( this ).closest('tr'),
					child_id = jQuery(this).prop('id'),
					child_children = jQuery('#generate_wp_settings [data-parent="' + child_id + '"]');


				if ( "undefined" !== typeof compare && '' + compare === '' + val) {
					var show = true;
				} else {
					var show = false;
				}
				if ( show ) {
					parent.show(slow);

					if ( jQuery( this ).is('select') ) {
						jQuery( this ).trigger('change');
					}
				} else {
					child_children.each(function(){
						jQuery( this ).closest('tr').hide(slow);
					});

					parent.hide(slow);
				}
			});
		}).trigger('change');

		// Hooks list
		if ( 'undefined' !== typeof wpgHooks ) {
			var allWpgHooks = [];
			jQuery.map( wpgHooks, function(obj){
				allWpgHooks[ obj.text ] = obj;
			} );
		}


		jQuery( '#hook_name, #filter_name' ).on( 'change', function(){
			var val = jQuery(this).val(),
				obj = "undefined" !== typeof allWpgHooks[ val ] ? allWpgHooks[ val ] : {};

			if ( "undefined" !== typeof obj[ 'description' ] ) {
				var descr = obj[ 'description' ];
				if ( "undefined" !== typeof obj[ 'file' ]
						&& "undefined" !== typeof obj[ 'file' ]['line']
						&& "undefined" !== typeof obj[ 'file' ]['name'] ) {
					var url = 'https://github.com/WordPress/WordPress/blob/master/' + obj[ 'file' ]['name'] + '#L' + obj[ 'file' ]['line'];
					descr = descr + ' <a href="' + url + '" target="_blank">Source</a>';
				}
				jQuery( '.wpg_' + obj[ 'type' ] + '_description' ).html( descr );
			}

			var params = "undefined" !== typeof obj[ 'params' ] ? obj[ 'params' ] : [];
			var paramsNames = [];
			var paramsDescr = [];
			jQuery.map( params, function(obj){
				paramsNames.push( obj.name );
				paramsDescr.push( obj.name + ' (' + obj.type + ') ' +obj.description );
			} );
			var paramsLine = paramsNames.join(', ');
			jQuery( '#args_list' ).val( paramsLine );

			var paramsDescrLine = paramsDescr.join('<br>');
			jQuery( '.wpg_params_description' ).html( paramsDescrLine );

			var params_count = params.length;
			jQuery( '#accepted_args' ).val( params_count );

		}).trigger('change');

		jQuery( '.image_delete_button' ).click(
			function () {
				jQuery( this ).closest( 'td' ).find( '.image_data_field' ).val( '' );
				jQuery( this ).closest( 'td' ).find( '.image_preview' ).remove();
				return false;
			}
		);

	}
);
