<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WINP_SnippetsViewTable extends Wbcr_FactoryViewtables413_Viewtable {

	public function configure() {
		/**
		 * Columns
		 */
		$this->columns->clear();
		//$this->columns->add('status', __('Status', 'insert-php'));
		$this->columns->add( 'winp_actions', __( 'Status', 'insert-php' ) );
		$this->columns->add( 'title', __( 'Snippet title', 'insert-php' ) );
		$this->columns->add( 'winp_description', __( 'Description', 'insert-php' ) );
		$this->columns->add( 'winp_where_use', __( 'Where use?', 'insert-php' ) );
		$this->columns->add( 'winp_taxonomy', __( 'Tags', 'insert-php' ) );
		$this->columns->add( 'winp_priority', __( 'Priority', 'insert-php' ) );
		$this->columns->add( 'winp_snippet_type', '' );

		/**
		 * Scripts & styles
		 */
		$this->styles->add( WINP_PLUGIN_URL . '/admin/assets/css/list-table.css' );
		$this->scripts->add( WINP_PLUGIN_URL . '/admin/assets/js/snippet-list.js' );
		$this->scripts->localize( 'winp_ajax', [ 'nonce' => wp_create_nonce( 'winp_ajax' ) ] );
		$this->runActions();

		add_filter( 'manage_edit-' . WINP_SNIPPETS_POST_TYPE . '_sortable_columns', array(
			$this,
			'sortable_columns'
		) );
		add_action( 'wp_ajax_change_priority', [ $this, 'change_priority' ] );
		add_action( 'wp_ajax_change_snippet_status', [ $this, 'change_snippet_status' ] );
	}


	/**
	 * Column 'Type'
	 *
	 * @param $post
	 */
	public function columnWinp_snippet_type( $post ) {
		$type  = WINP_Helper::getMetaOption( $post->ID, 'snippet_type', WINP_SNIPPET_TYPE_PHP );
		$class = 'wbcr-inp-type-' . esc_attr( $type );
		$type  = $type == 'universal' ? 'uni' : $type;
		$type  = $type == 'advert' ? 'ad' : $type;

		echo '<div class="wbcr-inp-snippet-type-label ' . esc_attr( $class ) . '">' . esc_html( $type ) . '</div>';
	}

	public function columnWinp_description( $post ) {
		echo esc_html( WINP_Helper::getMetaOption( $post->ID, 'snippet_description' ) );
	}

	/**
	 * Column 'Where_use'
	 *
	 * @param $post
	 */
	public function columnWinp_where_use( $post ) {
		$click         = "";
		$snippet_scope = WINP_Helper::getMetaOption( $post->ID, 'snippet_scope' );
		if ( $snippet_scope == 'shortcode' ) {
			$click = "onclick='this.setSelectionRange(0, this.value.length)'";
		}

		$value = WINP_Helper::get_where_use_text( $post );
		echo "<input type='text' name='wbcr_inp_shortcode_input' class='wbcr_inp_shortcode_input' value='{$value}' readonly='readonly' {$click}>";
	}

	/**
	 * Column 'Priority'
	 *
	 * @param $post
	 *
	 * @since 2.4.0
	 *
	 */
	public function columnWinp_taxonomy( $post ) {
		$post_cat = get_the_terms( $post->ID, WINP_SNIPPETS_TAXONOMY );
		$result   = [];
		if ( is_array( $post_cat ) ) {
			foreach ( $post_cat as $item ) {
				$href     = admin_url( "edit.php?post_type=" . WINP_SNIPPETS_POST_TYPE . "&winp_filter_tag={$item->slug}" );
				$result[] = "<a href='{$href}' class='winp-taxonomy-href'>{$item->name}</a>";
			}
		}
		echo implode( ', ', $result );
	}

	/**
	 * Column 'Priority'
	 *
	 * @param $post
	 *
	 * @since 2.4.0
	 *
	 */
	public function columnWinp_priority( $post ) {
		$snippet_priority = WINP_Helper::getMetaOption( $post->ID, 'snippet_priority' );
		echo "<input type='number' name='wbcr_inp_input_priority' class='wbcr_inp_input_priority'
 			  data-snippet-id='{$post->ID}' value='{$snippet_priority}'>";
	}

	/**
	 * Column 'Actions'
	 *
	 * @param $post
	 */
	public function columnWinp_actions( $post ) {
		$post_id     = (int) $post->ID;
		$is_activate = (int) WINP_Helper::getMetaOption( $post_id, 'snippet_activate', 0 );
		$css_class   = 'winp-inactive';

		if ( $is_activate ) {
			$css_class = '';
		}

		echo "<a class='winp-snippet-active-switch {$css_class}' id='winp-snippet-status-switch' data-snippet-id='{$post_id}' href='" . wp_nonce_url( admin_url( 'edit.php?post_type=' . WINP_SNIPPETS_POST_TYPE . '&amp;post=' . $post_id . '&amp;action=wbcr_inp_activate_snippet' ), 'wbcr_inp_snippert_' . $post_id . '_action_nonce' ) . "'>&nbsp;</a>";
		//echo '<a class="wbcr-inp-enable-snippet-button button" href="' . wp_nonce_url( admin_url( 'edit.php?post_type=' . WINP_SNIPPETS_POST_TYPE . '&amp;post=' . $post_id . '&amp;action=wbcr_inp_activate_snippet' ), 'wbcr_inp_snippert_' . $post_id . '_action_nonce' ) . '"><span class="dashicons ' . esc_attr( $icon ) . '"></span></a>';
	}

	/*
	 * Activate/Deactivate snippet
	 */
	protected function runActions() {
		if ( WINP_Plugin::app()->request->get( 'post_type', '', true ) == WINP_SNIPPETS_POST_TYPE ) {
			$post   = WINP_Plugin::app()->request->get( 'post', 0 );
			$action = WINP_Plugin::app()->request->get( 'action', '', 'sanitize_key' );

			if ( ! empty( $action ) && ! empty( $post ) && 'wbcr_inp_activate_snippet' == $action ) {
				$post_id = (int) $post;
				$wpnonce = WINP_Plugin::app()->request->get( '_wpnonce', '' );

				if ( ! wp_verify_nonce( $wpnonce, 'wbcr_inp_snippert_' . $post_id . '_action_nonce' ) || ! WINP_Plugin::app()->currentUserCan() ) {
					wp_die( 'Permission error. You can not edit this page.' );
				}

				$is_activate   = (int) WINP_Helper::getMetaOption( $post_id, 'snippet_activate', 0 );
				$snippet_scope = WINP_Helper::getMetaOption( $post_id, 'snippet_scope' );
				$snippet_type  = WINP_Helper::get_snippet_type( $post_id );

				/**
				 * Prevent activation of the snippet if it contains an error. This will not allow the user to break his site.
				 *
				 * @since 2.0.5
				 */
				if ( ( 'evrywhere' == $snippet_scope || 'auto' == $snippet_scope ) && $snippet_type != WINP_SNIPPET_TYPE_TEXT && $snippet_type != WINP_SNIPPET_TYPE_AD && $snippet_type != WINP_SNIPPET_TYPE_CSS && $snippet_type != WINP_SNIPPET_TYPE_JS && ! $is_activate ) {
					if ( WINP_Plugin::app()->getExecuteObject()->getSnippetError( $post_id ) ) {
						wp_safe_redirect( add_query_arg( [
							'action'                       => 'edit',
							'post'                         => $post_id,
							'wbcr_inp_save_snippet_result' => 'code-error',
						], admin_url( 'post.php' ) ) );
						exit;
					}
				}

				$status = ! $is_activate;

				update_post_meta( $post_id, $this->plugin->getPrefix() . 'snippet_activate', $status );

				$redirect_url = add_query_arg( [
					'post_type'                => WINP_SNIPPETS_POST_TYPE,
					'wbcr_inp_snippet_updated' => 1,
				], admin_url( 'edit.php' ) );

				wp_safe_redirect( $redirect_url );
				exit;
			}
		}
	}

	/**
	 * @param $sortable_columns
	 */
	public function sortable_columns( $sortable_columns ) {
		$sortable_columns['winp_priority'] = 'winp_priority';

		return $sortable_columns;
	}

	/**
	 * AJAX action for change priority
	 */
	public function change_priority() {
		check_ajax_referer( 'winp_ajax' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json( array( 'error_message' => __( "You don't have enough capability to edit this information.", 'insert-php' ) ) );
		}

		if ( isset( $_POST['snippet_id'] ) && isset( $_POST['priority'] ) ) {
			if ( is_numeric( $_POST['priority'] ) ) {
				WINP_Helper::updateMetaOption( $_POST['snippet_id'], 'snippet_priority', $_POST['priority'] );

				wp_send_json( [
					'message' => __( "Priority successfully changed", "insert-php" ),
				] );
			} else {
				wp_send_json( [
						'error_message' => __( "Priority is not changed! It's must be a number", 'insert-php' ),
					] );
			}

		} else {
			wp_send_json( [
					'error_message' => __( 'Priority is not changed!', 'insert-php' ),
				] );
		}
	}

	/**
	 * AJAX action for change priority
	 */
	public function change_snippet_status() {
		check_ajax_referer( 'winp_ajax' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json( array( 'error_message' => __( "You don't have enough capability to edit this information.", 'insert-php' ) ) );
		}

		if ( isset( $_POST['snippet_id'] ) ) {
			$snippet_id    = $_POST['snippet_id'];
			$is_activate   = (int) WINP_Helper::getMetaOption( $snippet_id, 'snippet_activate', 0 );
			$snippet_scope = WINP_Helper::getMetaOption( $snippet_id, 'snippet_scope' );
			$snippet_type  = WINP_Helper::get_snippet_type( $snippet_id );

			/**
			 * Prevent activation of the snippet if it contains an error. This will not allow the user to break his site.
			 *
			 * @since 2.0.5
			 */
			if ( ( 'evrywhere' == $snippet_scope || 'auto' == $snippet_scope ) && $snippet_type != WINP_SNIPPET_TYPE_TEXT && $snippet_type != WINP_SNIPPET_TYPE_AD && $snippet_type != WINP_SNIPPET_TYPE_CSS && $snippet_type != WINP_SNIPPET_TYPE_JS && ! $is_activate ) {
				if ( WINP_Plugin::app()->getExecuteObject()->getSnippetError( $snippet_id ) ) {
					wp_send_json( [
							'alert'         => true,
							'error_message' => __( "The snippet is not activated because errors were detected in the snippet code!", 'insert-php' ),
						] );
				}
			}

			$status = ! $is_activate;

			$ok = update_post_meta( $snippet_id, $this->plugin->getPrefix() . 'snippet_activate', $status );

			if ( $ok ) {
				wp_send_json( [
					'message' => __( "Snippet status changed", "insert-php" ),
				] );
			} else {
				wp_send_json( [
						'error_message' => __( 'Snippet status not changed.', 'insert-php' ),
					] );

			}

		} else {
			wp_send_json( [
					'error_message' => __( 'Snippet status not changed. No snippet ID', 'insert-php' ),
				] );
		}
	}
}
