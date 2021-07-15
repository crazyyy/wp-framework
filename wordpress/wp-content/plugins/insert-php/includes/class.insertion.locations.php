<?php
/**
 * Insertion locations
 *
 * @author        Artem Prihodko <webtemyk@yandex.ru>
 * @copyright (c) 2021, Creative Motion
 * @version       1.0
 * @since         2.4
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WINP_Insertion_Locations {

	public $locations = [];

	/**
	 * Constructor.
	 */
	public function __construct() {
		$locations = [
			'everywhere'  => [
				'header' => [
					__( 'Header', 'insert-php' ),
					__( 'Snippet will be placed in the source code before </head>.', 'insert-php' ),
					[
						'hide' => '.factory-control-snippet_p_number',
						'show' => '',
					]
				],
				'footer' => [
					__( 'Footer', 'insert-php' ),
					__( 'Snippet will be placed in the source code before </body>.', 'insert-php' ),
					[
						'hide' => '.factory-control-snippet_p_number',
						'show' => '',
					]
				],
			],
			'posts'       => [
				'before_post'      => [
					__( 'Insert Before Post', 'insert-php' ),
					__( 'Snippet will be placed before the title of the post/page.', 'insert-php' ),
					[
						'hide' => '.factory-control-snippet_p_number',
						'show' => '',
					]
				],
				'before_content'   => [
					__( 'Insert Before Content', 'insert-php' ),
					__( 'Snippet will be placed before the content of the post/page.', 'insert-php' ),
					[
						'hide' => '.factory-control-snippet_p_number',
						'show' => '',
					]
				],
				'before_paragraph' => [
					__( 'Insert Before Paragraph', 'insert-php' ),
					__( 'Snippet will be placed before the paragraph, which number you can specify in the Location number field.', 'insert-php' ),
					[
						'hide' => '',
						'show' => '.factory-control-snippet_p_number',
					]
				],
				'after_paragraph'  => [
					__( 'Insert After Paragraph', 'insert-php' ),
					__( 'Snippet will be placed after the paragraph, which number you can specify in the Location number field.', 'insert-php' ),
					[
						'hide' => '',
						'show' => '.factory-control-snippet_p_number',
					]
				],
				'after_content'    => [
					__( 'Insert After Content', 'insert-php' ),
					__( 'Snippet will be placed after the content of the post/page.', 'insert-php' ),
					[
						'hide' => '.factory-control-snippet_p_number',
						'show' => '',
					]
				],
				'after_post'       => [
					__( 'Insert After Post', 'insert-php' ),
					__( 'Snippet will be placed in the very end of the post/page.', 'insert-php' ),
					[
						'hide' => '.factory-control-snippet_p_number',
						'show' => '',
					]
				],
			],
			'pages'       => [
				'before_excerpt' => [
					__( 'Insert Before Excerpt', 'insert-php' ),
					__( 'Snippet will be placed before the excerpt of the post/page.', 'insert-php' ),
					[
						'hide' => '.factory-control-snippet_p_number',
						'show' => '',
					]
				],
				'after_excerpt'  => [
					__( 'Insert After Excerpt', 'insert-php' ),
					__( 'Snippet will be placed after the excerpt of the post/page.', 'insert-php' ),
					[
						'hide' => '.factory-control-snippet_p_number',
						'show' => '',
					]
				],
				'between_posts'  => [
					__( 'Between Posts', 'insert-php' ),
					__( 'Snippet will be placed between each post.', 'insert-php' ),
					[
						'hide' => '.factory-control-snippet_p_number',
						'show' => '',
					]
				],
				'before_posts'   => [
					__( 'Before post', 'insert-php' ),
					__( 'Snippet will be placed before the post, which number you can specify in the Location number field.', 'insert-php' ),
					[
						'hide' => '',
						'show' => '.factory-control-snippet_p_number',
					]
				],
				'after_posts'    => [
					__( 'After post', 'insert-php' ),
					__( 'Snippet will be placed after the post, which number you can specify in the Location number field.', 'insert-php' ),
					[
						'hide' => '',
						'show' => '.factory-control-snippet_p_number',
					]
				],
			],
			'woocommerce' => [
				'woo_before_shop_loop'               => [
					__( 'Before the list of products', 'insert-php' ),
					__( 'Snippet will be placed before the list of products.', 'insert-php' ),
					[
						'hide' => '.factory-control-snippet_p_number',
						'show' => '',
					]
				],
				'woo_after_shop_loop'                => [
					__( 'After the list of products', 'insert-php' ),
					__( 'Snippet will be placed after the list of products.', 'insert-php' ),
					[
						'hide' => '.factory-control-snippet_p_number',
						'show' => '',
					]
				],
				'woo_before_single_product'          => [
					__( 'Before a single product', 'insert-php' ),
					__( 'Snippet will be placed before a single product', 'insert-php' ),
					[
						'hide' => '.factory-control-snippet_p_number',
						'show' => '',
					]
				],
				'woo_after_single_product'           => [
					__( 'After a single product', 'insert-php' ),
					__( 'Snippet will be placed after a single product', 'insert-php' ),
					[
						'hide' => '.factory-control-snippet_p_number',
						'show' => '',
					]
				],
				'woo_before_single_product_summary'  => [
					__( 'Before a single product summary', 'insert-php' ),
					__( 'Snippet will be placed before a single product summary', 'insert-php' ),
					[
						'hide' => '.factory-control-snippet_p_number',
						'show' => '',
					]
				],
				'woo_after_single_product_summary'   => [
					__( 'After a single product summary', 'insert-php' ),
					__( 'Snippet will be placed after a single product summary', 'insert-php' ),
					[
						'hide' => '.factory-control-snippet_p_number',
						'show' => '',
					]
				],
				'woo_single_product_summary_title'   => [
					__( 'After a product title', 'insert-php' ),
					__( 'Snippet will be placed after a product title', 'insert-php' ),
					[
						'hide' => '.factory-control-snippet_p_number',
						'show' => '',
					]
				],
				'woo_single_product_summary_price'   => [
					__( 'After a product price', 'insert-php' ),
					__( 'Snippet will be placed after a product price', 'insert-php' ),
					[
						'hide' => '.factory-control-snippet_p_number',
						'show' => '',
					]
				],
				'woo_single_product_summary_excerpt' => [
					__( 'After a product excerpt', 'insert-php' ),
					__( 'Snippet will be placed after a product excerpt', 'insert-php' ),
					[
						'hide' => '.factory-control-snippet_p_number',
						'show' => '',
					]
				],
			],
		];

		/**
		 * Filters the  insertion locations.
		 *
		 *  [
		 *      'before_2'   => [
		 *            __( 'Before 2', 'insert-php' ),
		 *            __( 'Before 2 desc.', 'insert-php' ),
		 *          [
		 *              'hide' => '.factory-control-snippet_p_number',
		 *              'show' => '',
		 *          ]
		 *      ]
		 *  ]
		 *
		 * @param array The array of custom location data.
		 *
		 * @since 2.4
		 */
		$custom_data = apply_filters( 'wbcr/woody/add_custom_location', [] );

		if ( ! empty( $custom_data ) && is_array( $custom_data ) ) {
			$locations['custom'] = $custom_data;
		}

		$this->locations = $locations;
	}

	/**
	 * @param $name
	 *
	 * @return array|array[]
	 */
	public function __get( $name ) {
		return $this->getLocation( $name );
	}

	/**
	 * @param string $insertion
	 *
	 * @return array
	 */
	public function getInsertion( $insertion ) {
		return $this->locations[ $insertion ] ?? [];
	}

	/**
	 * @param string $location
	 * @param string $insertion
	 *
	 * @return array
	 */
	public function getLocation( $location, $insertion = '' ) {
		if ( ! empty( $insertion ) ) {
			return $this->locations[ $insertion ][ $location ] ?? [];
		} else {
			foreach ( $this->locations as $k => $loc ) {
				foreach ( $loc as $key => $item ) {
					if ( $key == $location ) {
						return [ $key => $item ];
					}
				}
			}
		}

		return [];
	}

	/**
	 *
	 * @return array
	 */
	public function getList() {
		$list = [];
		foreach ( $this->locations as $k => $loc ) {
			foreach ( $loc as $key => $item ) {
				$list[ $key ] = $item;
			}
		}

		return $list;
	}

	/**
	 * @param string $insertion
	 *
	 * @return array
	 */
	public function getInsertionForOptions( $insertion ) {
		$return = [];
		foreach ( $this->locations[ $insertion ] ?? [] as $key => $locations ) {
			$return[] = [ $key, $locations[0] ?? '', $locations[1] ?? '' ];
		}

		return $return;
	}

	/**
	 * @return array
	 */
	public function getEventsForOptions() {
		$return = [];
		$list   = $this->getList();
		foreach ( $list as $key => $locations ) {
			if ( isset( $locations[2] ) && is_array( $locations[2] ) ) {
				$return[ $key ] = $locations[2];
			} else {
				$return[ $key ] = [
					'hide' => '.factory-control-snippet_p_number',
					'show' => '',
				];
			}
		}

		return $return;
	}

}