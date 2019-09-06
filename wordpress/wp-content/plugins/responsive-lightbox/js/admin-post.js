( function ( $ ) {

	$( document ).on( 'ready', function () {
		var modal = $( '#rl-modal-gallery' ),
			load_delayed_galleries = _.debounce( get_galleries, 500 ),
			last_checked_gallery = 0
			galleries = {};

		// search galleries
		$( '#rl-media-search-input' ).on( 'keyup', function () {
			load_delayed_galleries( modal, $( this ).val() );
		} );

		// reload galleries in modal
		modal.on( 'click', '.rl-reload-galleries', function ( e ) {
			e.preventDefault();

			// reset galleries
			galleries = {};

			// load galleries
			get_galleries( modal, $( '#rl-media-search-input' ).val() );
		} );

		// select category
		modal.on( 'change', '#rl-media-attachment-categories', function() {
			$( '.rl-reload-galleries' ).click();
		} );

		// close gallery modal
		modal.on( 'click', '.media-modal-close, .media-modal-backdrop, .rl-media-button-cancel-gallery', function ( e ) {
			e.preventDefault();

			modal.hide();
		} );

		// select gallery in modal
		modal.on( 'click', '.rl-galleries-list li .js--select-attachment, .rl-galleries-list li button', function ( e ) {
			e.preventDefault();

			var gallery = $( this ).closest( 'li' ),
				current_checked_gallery = parseInt( gallery.data( 'id' ) );

			if ( last_checked_gallery !== current_checked_gallery ) {
				gallery.parent().find( 'li' ).removeClass( 'selected details' );

				last_checked_gallery = current_checked_gallery;

				gallery.addClass( 'selected details' );

				select_gallery( modal, current_checked_gallery, false );
			} else {
				if ( gallery.hasClass( 'selected details' ) ) {
					gallery.removeClass( 'selected details' );

					select_gallery( modal, current_checked_gallery, true );
				} else {
					gallery.addClass( 'selected details' );

					select_gallery( modal, current_checked_gallery, false );
				}
			}
		} );

		// insert gallery shortcode handler
		modal.on( 'click', '.rl-media-button-insert-gallery', function ( e ) {
			e.preventDefault();

			if ( $( this ).attr( 'disabled' ) ) {
				return;
			}

			var shortcode = '[rl_gallery id="' + last_checked_gallery + '"]';
				editor = tinyMCE.get( 'content' );

			if ( editor ) {
				editor.execCommand( 'mceInsertContent', false, shortcode );
			} else {
				wp.media.editor.insert( shortcode );
			}

			modal.hide();
		});

		// add gallery button handler
		$( document ).on( 'click', '#rl-insert-modal-gallery-button', function ( e ) {
			e.preventDefault();

			modal.show();

			set_columns( modal );

			get_galleries( modal, $( '#rl-media-search-input' ).val() );
		} );

		$( window ).on( 'resize', function () {
			set_columns( modal );
		} );
	} );

	// set number of columns
	function set_columns( element ) {
		var list = element.find( '.rl-galleries-list' ),
			list_width = list.width(),
			content = element.find( '.media-frame-content' ),
			columns = parseInt( content.attr( 'data-columns' ) ),
			old_columns = new_columns = columns;

		if ( list_width ) {
			var width = element.find( '.media-sidebar' ).outerWidth() + 'px';

			list.css( 'right', width );
			element.find( '.attachments-browser .media-toolbar' ).css( 'right', width );
			new_columns = Math.min( Math.round( list_width / 170 ), 12 ) || 1;

			if ( ! old_columns || old_columns !== new_columns ) {
				content.attr( 'data-columns', new_columns );
			}
		}
	};

	// update gallery preview
	function update_gallery_preview( element, gallery, animate ) {
		// update gallery attachments
		element.find( '.rl-attachments-list' ).append( gallery.attachments ).fadeOut( 0 ).delay( animate? 'fast' : 0 ).fadeIn( 0 );

		// update number of images in gallery
		element.find( '.rl-gallery-count' ).text( gallery.count );

		// update gallery edit link
		if ( gallery.edit_url !== '' )
			element.find( '.rl-edit-gallery-link' ).removeClass( 'hidden' ).attr( 'href', gallery.edit_url );
		else
			element.find( '.rl-edit-gallery-link' ).addClass( 'hidden' ).attr( 'href', '' );
	}

	// select gallery
	function select_gallery( element, gallery_id, toggle ) {
		element.find( '.media-selection' ).toggleClass( 'empty', toggle );
		element.find( '.rl-media-button-insert-gallery' ).prop( 'disabled', toggle );

		// load gallery preview images?
		if ( ! toggle ) {
			// clear images
			element.find( '.rl-attachments-list' ).empty();

			// load cached images
			if ( typeof galleries[gallery_id] !== 'undefined' ) {
				// update images
				update_gallery_preview( element, galleries[gallery_id], false );
			// get images for the first time
			} else {
				var spinner = element.find( '.rl-gallery-images-spinner' ),
					info = element.find( '.selection-info' );

				// display spinner
				spinner.fadeIn( 'fast' ).css( 'visibility', 'visible' );

				// turn off info
				info.addClass( 'rl-loading-content' );

				$.post( ajaxurl, {
					action: 'rl-post-gallery-preview',
					post_id: rlArgs.post_id,
					gallery_id: gallery_id,
					nonce: rlArgs.nonce
				} ).done( function ( response ) {
					try {
						if ( response.success ) {
							// store gallery data
							galleries[gallery_id] = response.data;

							// update gallery data
							update_gallery_preview( element, galleries[gallery_id], true );
						} else {
							//@TODO
						}
					} catch( e ) {
						//@TODO
					}
				} ).always( function () {
					// hide spinner
					spinner.fadeOut( 'fast' );

					// turn on info
					info.removeClass( 'rl-loading-content' );
				} );
			}
		}
	}

	// get galleries
	function get_galleries( element, search = '' ) {
		var spinner = $( '.rl-gallery-reload-spinner' );

		// clear galleries
		element.find( '.rl-galleries-list' ).empty();

		// hide gallery info
		element.find( '.media-selection' ).addClass( 'empty' );

		// clear images
		element.find( '.rl-attachments-list' ).empty();

		// display spinner
		spinner.fadeIn( 'fast' );

		// get galleries
		$.post( ajaxurl, {
			action: 'rl-post-get-galleries',
			post_id: rlArgs.post_id,
			search: search,
			nonce: rlArgs.nonce,
			category: element.find( '#rl-media-attachment-categories' ).val()
		} ).done( function ( response ) {
			try {
				if ( response.success ) {
					element.find( '.rl-galleries-list' ).empty().append( response.data );
				} else {
					//@TODO
				}
			} catch( e ) {
				//@TODO
			}
		} ).always( function () {
			// hide spinner
			spinner.fadeOut( 'fast' );
		} );
	}

} )( jQuery );