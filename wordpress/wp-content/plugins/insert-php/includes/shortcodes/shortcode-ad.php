<?php
/**
 * Advertisement Shortcode
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WINP_SnippetShortcodeAdvert extends WINP_SnippetShortcode {

	public $shortcode_name = 'wbcr_advert_snippet';

	/**
	 * Content render
	 *
	 * @param array $attr
	 * @param string $content
	 * @param string $tag
	 */
	public function html( $attr, $content, $tag ) {
		$id = $this->getSnippetId( $attr, WINP_SNIPPET_TYPE_AD );

		if( !$id ) {
			echo '<span style="color:red">' . __('[' . esc_html( $tag ) . ']: Advertisement snippets error (not passed the snippet ID)', 'insert-php') . '</span>';

			return;
		}

		$snippet      = get_post( $id );
		$snippet_meta = get_post_meta( $id, '' );

		if ( ! $snippet || empty( $snippet_meta ) ) {
			return;
		}

		$is_activate   = $this->getSnippetActivate( $snippet_meta );
		$snippet_scope = $this->getSnippetScope( $snippet_meta );
		$is_condition  = WINP_Plugin::app()->getExecuteObject()->checkCondition( $id );

		if ( ! $is_activate || $snippet_scope != 'shortcode' || ! $is_condition ) {
			return;
		}

		$post_content = $snippet->post_content;
		if ( WINP_Plugin::app()->getOption( 'execute_shortcode' ) ) {
			$post_content = do_shortcode( $post_content );
		}

		echo str_replace( '{{SNIPPET_CONTENT}}', $content, $post_content );
	}

}