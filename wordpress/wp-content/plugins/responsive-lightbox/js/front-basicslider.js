( function ( $ ) {

    /**
     * Hook into doResponsiveLightbox event
     */
    $( document ).on( 'doResponsiveLightbox', function () {

		$( '.rl-basicslider-gallery' ).each( function( index ) {
			var gallery = $( this ),
				options = JSON.parse( window['rlArgsBasicSliderGallery' + ( gallery.data( 'gallery_no' ) + 1 )] );

			if ( typeof options !== 'undefined' && typeof options !== false ) {
				gallery.slippry( {
					adaptiveHeight: options.adaptive_height,
					loop: options.loop,
					captions: options.captions === 'none' ? false : options.captions,
					initSingle: options.init_single,
					responsive: options.responsive,
					preload: options.preload,
					pager: options.pager,
					controls: options.controls,
					hideOnEnd: options.hide_on_end,
					slideMargin: options.slide_margin,
					transition: options.transition === 'none' ? false : options.transition,
					kenZoom: options.kenburns_zoom,
					speed: options.speed,
					easing: options.easing,
					continuous: options.continuous,
					useCSS: options.use_css,
					auto: options.slideshow,
					autoDirection: options.slideshow_direction,
					autoHover: options.slideshow_hover,
					autoHoverDelay: options.slideshow_hover_delay,
					autoDelay: options.slideshow_delay,
					pause: options.slideshow_pause,
				} );
			}
		} );

    } );

} )( jQuery );