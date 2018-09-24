( function ( $ ) {

	$( document ).on( 'ready', function () {
		
		var gallery_frame = null,
			attachment_frame = null,
			gallery_container = $( '.rl-gallery-images' ),
			gallery_ids = $( '.rl-gallery-ids' );

		media_gallery_sortable( gallery_container, gallery_ids, $( 'input[name="rl_gallery[images][menu_item]"]:checked' ).val() );

		// color picker
		$( '.rl-gallery-tab-content .color-picker' ).wpColorPicker();

		// make sure HTML5 validation is turned off
		$( 'form#post' ).attr( 'novalidate', 'novalidate' );

		// make sure to dispay images metabox at start
		$( '#responsive-gallery-images' ).show();

		// move navigation tabs and metaboxes to second postbox container to fix mobile devices problem
		$( '.rl-display-metabox, .rl-hide-metabox, h2.nav-tab-wrapper' ).prependTo( '#postbox-container-2' );

		// change navigation menu
		$( document ).on( 'change', '.rl-gallery-tab-menu-item', function () {
			var tab = $( this ).closest( '.postbox' ).attr( 'id' ).replace( 'responsive-gallery-', '' ),
				source = $( this ).closest( '.rl-gallery-tab-menu' ),
				container = $( this ).closest( '.inside' ).find( '.rl-gallery-tab-content' ),
				spinner = source.find( '.spinner' ),
				menu_item = $( this ).val();

			// disable nav on ajax
			container.addClass( 'rl-loading-content' );
			source.addClass( 'rl-loading-content' );

			// display spinner
			spinner.fadeIn( 'fast' ).css( 'visibility', 'visible' );

			// post ajax request
			$.post( ajaxurl, {
				action: 'rl-get-menu-content',
				post_id: rlArgs.post_id,
				tab: tab,
				menu_item: menu_item,
				nonce: rlArgs.nonce
			} ).done( function ( response ) {
				try {
					if ( response.success ) {
						// replace HTML
						container.html( response.data );

						// enable nav after ajax
						container.removeClass( 'rl-loading-content' );
						source.removeClass( 'rl-loading-content' );

						// update gallery data
						gallery_frame = null;
						gallery_container = $( '.rl-gallery-images' );
						gallery_ids = $( '.rl-gallery-ids' );

						// refresh sortable only for media library
						media_gallery_sortable( gallery_container, gallery_ids, menu_item );

						// color picker
						container.find( '.color-picker' ).wpColorPicker();
					} else {
						// @todo
					}
				} catch ( e ) {
					// @todo
				}

				// hide spinner
				spinner.fadeOut( 'fast' );
			} ).fail( function () {
				// hide spinner
				spinner.fadeOut( 'fast' );
			} );
		} );

		// change navigation menu
		$( document ).on( 'click', '.nav-tab', function ( e ) {
			e.preventDefault();

			var anchor = $( this ).attr( 'href' ).substr( 1 );

			// remove active class
			$( '.nav-tab' ).removeClass( 'nav-tab-active' );

			// add active class
			$( this ).addClass( 'nav-tab-active' );

			// hide all normal metaboxes
			$( '#postbox-container-2 div[id^="responsive-gallery-"]' ).removeClass( 'rl-display-metabox' ).addClass( 'rl-hide-metabox' );

			// display needed metabox
			if ( anchor === '' ) {
				$( '#responsive-gallery-images' ).addClass( 'rl-display-metabox' ).removeClass( 'rl-hide-metabox' );
			} else {
				$( '#responsive-gallery-' + anchor ).addClass( 'rl-display-metabox' ).removeClass( 'rl-hide-metabox' );
			}

			$( 'input[name="rl_active_tab"]' ).val( anchor );
		} );

		$( '.rl-shortcode' ).on( 'click', function () {
			$( this ).select();
		} );

		// remove image
		$( document ).on( 'click', '.rl-gallery-image-remove', function ( e ) {
			e.preventDefault();

			// prevent featured images being removed
			if ( $( this ).closest( '.rl-gallery-images-featured' ).length === 1 ) {
				return false;
			}

			var li = $( this ).closest( 'li.rl-gallery-image' ),
				attachment_ids = get_current_attachments( gallery_ids );

			// remove id
			attachment_ids = _.without( attachment_ids, parseInt( li.data( 'attachment_id' ) ) );

			// remove attachment
			li.remove();

			// update attachment ids
			gallery_ids.val( $.unique( attachment_ids ).join( ',' ) );

			return false;
		} );

		// edit image
		$( document ).on( 'click', '.rl-gallery-image-edit', function ( e ) {
			e.preventDefault();

			var li = $( this ).closest( 'li.rl-gallery-image' ),
				attachment_id = parseInt( li.data( 'attachment_id' ) ),
				attachment_changed = false;

			// frame already exists?
			if ( attachment_frame !== null ) {
				attachment_frame.detach();
				attachment_frame.dispose();
				attachment_frame = null;
			}

			// create new frame
			attachment_frame = wp.media( {
				id: 'rl-edit-attachment-modal',
				frame: 'select',
				uploader: false,
				multiple: false,
				title: rlArgs.editTitle,
				library: {
					post__in: attachment_id
				},
				button: {
					text: rlArgs.buttonEditFile
				}
			} ).on( 'open', function () {
				var attachment = wp.media.attachment( attachment_id ),
					selection = attachment_frame.state().get( 'selection' );

				attachment_frame.$el.closest( '.media-modal' ).addClass( 'rl-edit-modal' );

				// get attachment
				attachment.fetch();

				// reset selection
				//selection.reset();

				// add attachment
				selection.add( attachment );
			} );

			attachment_frame.open();

			return false;
		} );

		// change image status
		$( document ).on( 'click', '.rl-gallery-image-status', function ( e ) {
			e.preventDefault();

			var li = $( this ).closest( 'li.rl-gallery-image' ),
				input = li.find( '.rl-gallery-exclude' ),
				status = li.hasClass( 'rl-status-active' ),
				id = parseInt( li.data( 'attachment_id' ) ),
				item = '';

			if ( id > 0 )
				item = id;
			else
				item = li.find( '.rl-gallery-inner img' ).attr( 'src' );

			// exclude?
			if ( status ) {
				li.addClass( 'rl-status-inactive' ).removeClass( 'rl-status-active' );

				// add item
				input.val( item );
			} else {
				li.addClass( 'rl-status-active' ).removeClass( 'rl-status-inactive' );

				// remove item
				input.val( '' );
			}

			return false;
		} );

		// open the modal on click
		$( document ).on( 'click', '.rl-gallery-select', function ( e ) {
			e.preventDefault();

			// open media frame if already exists
			if ( gallery_frame !== null ) {
				gallery_frame.open();

				return;
			}

			// create the media frame
			gallery_frame = wp.media( {
				title: rlArgs.textSelectImages,
				multiple: 'add',
				autoSelect: true,
				library: {
					type: 'image'
				},
				button: {
					text: rlArgs.textUseImages
				}
			} ).on( 'open', function () {
				var selection = gallery_frame.state().get( 'selection' ),
					attachment_ids = get_current_attachments( gallery_ids );

				// deselect all attachments
				selection.reset();

				$.each( attachment_ids, function () {
					// prepare attachment
					attachment = wp.media.attachment( this );

					// select attachment
					selection.add( attachment ? [ attachment ] : [ ] );
				} );
			} ).on( 'select', function () {
				var selection = gallery_frame.state().get( 'selection' ),
					attachment_ids = get_current_attachments( gallery_ids ),
					selected_ids = [ ];

				if ( selection ) {
					selection.map( function ( attachment ) {
						if ( attachment.id ) {
							// add attachment
							selected_ids.push( attachment.id );

							// is image already in gallery?
							if ( $.inArray( attachment.id, attachment_ids ) !== -1 ) {
								return;
							}

							// add attachment
							attachment_ids.push( attachment.id );
							attachment = attachment.toJSON();

							// is preview size available?
							if ( attachment.sizes && attachment.sizes['thumbnail'] ) {
								attachment.url = attachment.sizes['thumbnail'].url;
							}

							// append new image
							gallery_container.append( rlArgs.mediaItemTemplate.replace( /__IMAGE_ID__/g, attachment.id ).replace( /__IMAGE__/g, '<img width="150" height="150" src="' + attachment.url + '" class="attachment-thumbnail size-thumbnail" alt="" sizes="(max-width: 150px) 100vw, 150px" />' ).replace( /__IMAGE_STATUS__/g, 'rl-status-active' ) );
						}
					} );
				}

				// assign copy of attachment ids
				var copy = attachment_ids;

				for ( var i = 0; i < attachment_ids.length; i++ ) {
					// unselected image?
					if ( $.inArray( attachment_ids[i], selected_ids ) === -1 ) {
						gallery_container.find( 'li.rl-gallery-image[data-attachment_id="' + attachment_ids[i] + '"]' ).remove();

						copy = _.without( copy, attachment_ids[i] );
					}
				}

				gallery_ids.val( $.unique( copy ).join( ',' ) );
			} );

			// open media frame
			gallery_frame.open();
		} );

		// preview
		$( document ).on( 'click', '.rl-gallery-update-preview', function ( e ) {
			e.preventDefault();

			var container = $( '.rl-gallery-tab-inside-images-featured' ),
				parent = $( this ).parent(),
				spinner = parent.find( '.spinner' ),
				rules = $( '.rl-rules-groups > .rl-rules-group' ),
				query_args = {};

			container.find( 'tr[data-field_type]' ).each( function() {
				var el = $( this ),
					field_name = el.data( 'field_name' ),
					value = null;

				switch ( el.data( 'field_type' ) ) {
					case 'number':
						value = parseInt( el.find( 'input' ).val() );

						if ( ! value ) {
							value = 0;
						}
						console.log
						break;

					case 'select':
						value = el.find( 'select option:selected' ).val();

						if ( ! value ) {
							value = '';
						}
						break;

					case 'radio':
						value = el.find( 'input:checked' ).val();

						if ( ! value ) {
							value = '';
						}
						break;

					case 'multiselect':
						value = el.find( 'select' ).val();

						if ( ! value ) {
							value = [];
						}
						break;
				}

				query_args[field_name] = value;
			} );

			// disable ui
			// container.addClass( 'rl-loading-content' );

			// display spinner
			spinner.fadeIn( 'fast' ).css( 'visibility', 'visible' );

			// post ajax request
			$.post( ajaxurl, {
				action: 'rl-get-preview-content',
				post_id: rlArgs.post_id,
				menu_item: $( '.rl-gallery-tab-menu-images input:checked' ).val(),
				query: query_args,
				excluded: container.find( '.rl-gallery-exclude-ids' ).val(),
				nonce: rlArgs.nonce
			} ).done( function ( response ) {
				try {
					if ( response.success ) {
						$( '.rl-gallery-images' ).empty().append( response.data );
					} else {
						// @todo
					}
				} catch ( e ) {
					// @todo
				}

				// hide spinner
				spinner.fadeOut( 'fast' );
			} ).fail( function () {
				// hide spinner
				spinner.fadeOut( 'fast' );
			} );
		} );

		// load values for specified rule
		$( document ).on( 'change', '.rl-rule-type', function () {
			var _this = $( this ),
				td = _this.closest( 'tr' ).find( 'td.value' ),
				select = td.find( 'select' ),
				spinner = td.find( '.spinner' );

			select.hide();
			spinner.fadeIn( 'fast' ).css( 'visibility', 'visible' );

			$.post( ajaxurl, {
				action: 'rl-get-group-rules-values',
				type: _this.val(),
				nonce: rlArgs.nonce
			} ).done( function ( data ) {
				spinner.hide();

				try {
					var response = JSON.parse( data );

					// remove old select options and adds new ones
					select.fadeIn( 'fast' ).find( 'option, optgroup' ).remove().end().append( response.select );
				} catch ( e ) {
					//
				}
			} ).fail( function () {
				//
			} );
		} );

	} );

	// listen for insert/remove media library thumbnail
	$( document ).on( 'DOMNodeInserted', '#postimagediv .inside', function ( e ) {
		var value = $( '#postimagediv .inside' ).attr( 'data-featured-type' );

		if ( $( '#rl-gallery-featured-' + value ).length > 0 ) {
			$( '#rl-gallery-featured-' + value ).prop( 'checked', true );

			$( '#postimagediv .inside' ).trigger( 'change' );
		}
	} );

	// handle featured image change
	$( document ).on( 'change', '#postimagediv .inside', function () {
		var el = $( this ).find( 'input[name="rl_gallery_featured_image"]:checked' ),
			value = $( el ).val();

		$( '#postimagediv .inside' ).attr( 'data-featured-type', value );
		$( '.rl-gallery-featured-image-select' ).children( 'div' ).hide();
		$( '.rl-gallery-featured-image-select-' + value ).show();

		// media library
		if ( value === 'id' ) {
			var thumbnail_id = parseInt( $( '#_thumbnail_id' ).attr( 'data-featured-id' ) );
			if ( thumbnail_id > 0 ) {
				$( '#_thumbnail_id' ).val( thumbnail_id ).attr( 'data-featured-id', -1 );
			}
			// custom URL
		} else if ( value === 'url' ) {
			var thumbnail_id = parseInt( $( '#_thumbnail_id' ).val() );
			if ( thumbnail_id > 0 ) {
				$( '#_thumbnail_id' ).attr( 'data-featured-id', thumbnail_id ).val( -1 );
			}
			// first gallery image
		} else {
			var thumbnail_id = parseInt( $( '#_thumbnail_id' ).val() );
			if ( thumbnail_id > 0 ) {
				$( '#_thumbnail_id' ).attr( 'data-featured-id', thumbnail_id ).val( -1 );
			}
		}
	} );

	$( document ).on( 'ready ajaxComplete', function () {
		// init select2
		$( '.rl-gallery-tab-inside select.select2' ).select2( {
			closeOnSelect: true,
			multiple: true,
			width: 300,
			minimumInputLength: 0
		} );
	} );

	// get attachment ids
	function get_current_attachments( gallery_ids ) {
		var attachments = gallery_ids.val();

		// return integer image ids or empty array
		return attachments !== '' ? attachments.split( ',' ).map( function ( i ) {
			return parseInt( i )
		} ) : [ ];
	}

	// 
	function media_gallery_sortable( gallery, ids, type ) {
		if ( type === 'media' ) {
			// images order
			gallery.sortable( {
				items: 'li.rl-gallery-image',
				cursor: 'move',
				scrollSensitivity: 40,
				forcePlaceholderSize: true,
				forceHelperSize: false,
				helper: 'clone',
				opacity: 0.65,
				placeholder: 'rl-gallery-sortable-placeholder',
				start: function ( event, ui ) {
					ui.item.css( 'border-color', '#f6f6f6' );
				},
				stop: function ( event, ui ) {
					ui.item.removeAttr( 'style' );
				},
				update: function ( event, ui ) {
					var attachment_ids = [ ];

					gallery.find( 'li.rl-gallery-image' ).each( function () {
						attachment_ids.push( parseInt( $( this ).attr( 'data-attachment_id' ) ) );
					} );

					ids.val( $.unique( attachment_ids ).join( ',' ) );
				}
			} );
		}
	}

} )( jQuery );