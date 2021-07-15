<?php
/* Security-Check */
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class pbsfi_frontend
{
	/** @var pbSEOFriendlyImages */
	var $pbSEOFriendlyImages;

	/** @var pbsfi_optimizer */
	var $optimizer;

	var $enable_caching = false;
	var $caching_ttl = 3600;

	public function __construct( pbSEOFriendlyImages &$pb_SEO_friendly_images )
	{
		$this->pbSEOFriendlyImages = $pb_SEO_friendly_images;

        if( isset($this->pbSEOFriendlyImages->settings['enable_caching']) && $this->pbSEOFriendlyImages->settings['enable_caching'] == true ) {
            $this->enable_caching = true;
        }

        if( isset($this->pbSEOFriendlyImages->settings['caching_ttl']) && is_numeric($this->pbSEOFriendlyImages->settings['caching_ttl']) ) {
            $this->caching_ttl = $this->pbSEOFriendlyImages->settings['caching_ttl'];
        }
	}

	/**
	 * initialize frontend functions
	 *
	 * @return void
	 */
	public function initialize()
	{
		// process post thumbnails
		if( isset($this->pbSEOFriendlyImages->settings['optimize_img']) && ($this->pbSEOFriendlyImages->settings['optimize_img'] == 'all' || $this->pbSEOFriendlyImages->settings['optimize_img'] == 'thumbs') ) {

		    if( function_exists('is_woocommerce') && is_woocommerce() && $this->pbSEOFriendlyImages->isProVersion() ) {

                add_filter( 'wp_get_attachment_image_attributes', [ $this, 'optimize_image_attributes' ], 10, 2 );

            } else {
                add_filter( 'wp_get_attachment_image_attributes', [ $this, 'optimize_image_attributes' ], 10, 2 );
            }

		} else if( function_exists('is_woocommerce') && is_woocommerce() && $this->pbSEOFriendlyImages->isProVersion() ) {
            add_filter( 'wp_get_attachment_image_attributes', [ $this, 'optimize_image_attributes' ], 10, 2 );
        }

		// process post images
		if( isset($this->pbSEOFriendlyImages->settings['optimize_img']) && ($this->pbSEOFriendlyImages->settings['optimize_img'] == 'all' || $this->pbSEOFriendlyImages->settings['optimize_img'] == 'post') ) {
			add_filter( 'the_content', [ $this, 'optimize_html' ], 9999, 1 );

			/*
			 * Support for AdvancedCustomFields
			 */
			//add_filter('acf/load_value/type=textarea', [ $this, 'optimize_html' ], 20, 3);
			add_filter('acf/load_value/type=wysiwyg', [ $this, 'optimize_html' ], 20, 3);

			// support for acf below v.4 removed
		}
	}

	/**
	 * Check if the optimizer is already initialized and initialize if not
	 *
	 * @return void
	 */
	private function _maybe_initialize_optimizer()
	{
		if( false === is_a($this->optimizer, 'pbsfi_optimizer') ) {
			$this->optimizer = new pbsfi_optimizer( $this->pbSEOFriendlyImages->settings );
		}
	}

    /**
     * Optimize given HTML code
     *
     * @param string $content
     *
     * @param int $post_id
     * @param null|string $field
     * @return string
     */
	public function optimize_html( $content, $post_id=0, $field=null )
	{
	    if( $post_id === 0 ) {
            // set post_id
	        $post_id = get_the_ID();
        }

	    $caching = apply_filters('pbsfi_optimize_html_caching', $this->enable_caching, $post_id, $field);

	    // Get Cache
	    if( $caching ) {
	        $cache = new pbsfi_cache($this->enable_caching, $this->caching_ttl);

	        $cache_key =  'post_'.$post_id.(!empty($field) ? '_'.$field : '');

            $cache_item = $cache->get_cache( $cache_key );

            if( $cache_item )
                return $cache_item;
        }

		// maybe initialize the optimizer class
		$this->_maybe_initialize_optimizer();

		// optimize html
		$content = $this->optimizer->optimize_html( $content );

		// Set Cache
        if( $caching && isset($cache_key) && isset($cache) ) {
            $cache->set_cache($cache_key, $content);
        }

		return $content;
	}

	/**
	 * Add image title and alt to post thumbnails
	 *
	 * @param array $attr
	 * @param WP_Post $attachment
	 * @return array
	 */
	public function optimize_image_attributes( $attr, $attachment = null )
	{
		// maybe initialize the optimizer class
		$this->_maybe_initialize_optimizer();

		// optimize image attributes
		$attr = $this->optimizer->optimize_image_attributes( $attr, $attachment );

		return $attr;
	}
}