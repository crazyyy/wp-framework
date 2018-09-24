( function ( $ ) {

	/**
	 * Hook into doResponsiveLightbox event
	 */
	$( document ).on( 'doResponsiveLightbox', function ( event ) {
		// special masonry check
		if ( typeof event.masonry !== 'undefined' && event.masonry === false ) {
			return false;
		}

		if ( typeof event.pagination_type !== 'undefined' ) {
			// infinite scroll
			if ( event.pagination_type === 'infinite' ) {
				var gallery = event.infinite.gallery,
					gallery_no = parseInt( gallery.data( 'gallery_no' ) ) + 1,
					elements = $( event.infinite.response ).find( '.rl-gallery-container[data-gallery_id="' + event.gallery_id + '"] .rl-gallery-item' );

				if ( typeof window['rlArgsBasicMasonryGallery' + gallery_no] !== 'undefined' ) {
					var options = JSON.parse( window['rlArgsBasicMasonryGallery' + gallery_no] );

					// init masonry
					grid = gallery.masonry( {
						itemSelector: '.rl-gallery-item',
						columnWidth: '.rl-grid-sizer',
						percentPosition: true,
						originLeft: options.originLeft,
						originTop: options.originTop
					} );

					// append new images
					grid.append( elements ).masonry( 'appended', elements );

					// layout masonry
					grid.imagesLoaded( function () {
						grid.masonry( 'layout' );

						// reinitialize lightbox
						$.event.trigger( {
							type: 'doResponsiveLightbox',
							script: rlArgs.script,
							selector: rlArgs.selector,
							args: rlArgs,
							masonry: false
						} );
					} );
				}
			// ajax
			} else {
				var grid = $( '.rl-gallery-container[data-gallery_id="' + event.gallery_id + '"] .rl-gallery' ),
					gallery_no = parseInt( grid.data( 'gallery_no' ) ) + 1;

				if ( typeof window['rlArgsBasicMasonryGallery' + gallery_no] !== 'undefined' ) {
					var options = JSON.parse( window['rlArgsBasicMasonryGallery' + gallery_no] );

					// init masonry
					grid.masonry( {
						itemSelector: '.rl-gallery-item',
						columnWidth: '.rl-grid-sizer',
						percentPosition: true,
						originLeft: options.originLeft,
						originTop: options.originTop
					} );

					// layout masonry
					grid.imagesLoaded( function () {
						grid.masonry( 'layout' );
					} );
				}
			}
		} else {
			$( '.rl-basicmasonry-gallery' ).each( function () {
				var grid = $( this ),
					gallery_no = parseInt( grid.data( 'gallery_no' ) ) + 1;

				if ( typeof window['rlArgsBasicMasonryGallery' + gallery_no] !== 'undefined' ) {
					var options = JSON.parse( window['rlArgsBasicMasonryGallery' + gallery_no] );

					// init masonry
					grid.masonry( {
						itemSelector: '.rl-gallery-item',
						columnWidth: '.rl-grid-sizer',
						percentPosition: true,
						originLeft: options.originLeft,
						originTop: options.originTop
					} );

					// layout masonry
					grid.imagesLoaded( function () {
						// remove loading class
						grid.parent().removeClass( 'rl-loading' );
						grid.masonry( 'layout' );
					} );
				}
			} );
		}
	} );

} )( jQuery );