<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
    exit;

/**
 * Responsive Lightbox folders class.
 *
 * @class Responsive_Lightbox_Folders
 */
class Responsive_Lightbox_Folders {

    private $mode = '';
	private $term_counters = array();

    /**
     * Class constructor.
     *
     * @return	void
     */
    public function __construct( $read_only = false ) {
		// set instance
		Responsive_Lightbox()->folders = $this;

		if ( $read_only )
			return;

		// actions
		add_action( 'init', array( $this, 'detect_library_mode' ), 11 );
		add_action( 'restrict_manage_posts', array( $this, 'restrict_manage_posts' ) );
		add_action( 'wp_enqueue_media', array( $this, 'add_library_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'add_library_scripts' ) );
		add_action( 'post-upload-ui', array( $this, 'post_upload_ui' ) );
		add_action( 'add_attachment', array( $this, 'add_attachment' ) );
		add_action( 'wp_ajax_save-attachment-compat', array( $this, 'ajax_save_attachment_compat' ), 0 );
		add_action( 'wp_ajax_rl-folders-delete-term', array( $this, 'delete_term' ) );
		add_action( 'wp_ajax_rl-folders-rename-term', array( $this, 'rename_term' ) );
		add_action( 'wp_ajax_rl-folders-add-term', array( $this, 'add_term' ) );
		add_action( 'wp_ajax_rl-folders-move-term', array( $this, 'move_term' ) );
		add_action( 'wp_ajax_rl-folders-move-attachments', array( $this, 'move_attachments' ) );
		add_action( 'wp_ajax_rl-folders-load-old-taxonomies', array( $this, 'load_old_taxonomies' ) );

		// filters
		add_filter( 'admin_body_class', array( $this, 'admin_body_class' ) );
		add_filter( 'parse_query', array( $this, 'parse_query' ) );
		add_filter( 'ajax_query_attachments_args', array( $this, 'ajax_query_attachments_args' ) );
		add_filter( 'attachment_fields_to_edit', array( $this, 'attachment_fields_to_edit' ), 10, 2 );
    }

	/**
     * Load previously used media taxonomies via AJAX.
     *
     * @return void
     */
    public function load_old_taxonomies() {
		if ( isset( $_POST['taxonomies'], $_POST['nonce'] ) && is_array( $_POST['taxonomies'] ) && wp_verify_nonce( $_POST['nonce'], 'rl-folders-ajax-taxonomies-nonce' ) ) {
			$fields = $this->get_taxonomies();

			// any results?
			if ( ! empty( $fields ) ) {
				// remove main taxonomy
				if ( ( $key = array_search( 'rl_media_folder', $fields, true ) ) !== false )
					unset( $fields[$key] );

				foreach ( $_POST['taxonomies'] as $taxonomy ) {
					// remove available taxonomy
					if ( ( $key = array_search( $taxonomy, $fields, true ) ) !== false )
						unset( $fields[$key] );
				}
			}

			// send taxonomies, reindex them to avoid casting to an object in js
			wp_send_json_success( array( 'taxonomies' => array_values( $fields ) ) );
		}

		wp_send_json_error();
    }

    /**
     * Detect library mode (list or grid).
     *
     * @global string $pagenow Current page
     * @return void
     */
    public function detect_library_mode() {
		global $pagenow;

		if ( $pagenow === 'upload.php' ) {
			// available modes
			$modes = array( 'grid', 'list' );

			// check $_GET mode
			if ( isset( $_GET['mode'] ) && in_array( $_GET['mode'], $modes, true ) ) {
				$mode = $_GET['mode'];
			} else {
				// get user mode
				$user_mode = get_user_option( 'media_library_mode' );

				// valid user mode?
				if ( in_array( $user_mode, $modes, true ) )
					$mode = $user_mode;
				// default wp mode
				else
					$mode = 'grid';
			}

			// store mode
			$this->mode = $mode;
		}
    }

    /**
     * Admin body classes.
     *
     * @global string $pagenow Current page
     * @param array $classes Admin body classes
     * @return array Changed classes
     */
    public function admin_body_class( $classes ) {
		global $pagenow;

		if ( $pagenow === 'upload.php' ) {
			// append class
			$classes .= ' rl-folders-upload-' . $this->mode . '-mode';
		}

		return $classes;
    }

	/**
     * Get folders dropdown HTML.
     *
	 * @param string $taxonomy Folders taxonomy
	 * @param string $selected Folders taxonomy ID
     * @return string
     */
	private function get_folders( $taxonomy, $selected = 0 ) {
		return wp_dropdown_categories(
			array(
				'orderby'			=> 'name',
				'order'				=> 'asc',
				'show_option_all'	=> __( 'Root Folder', 'responsive-lightbox' ),
				'show_count'		=> false,
				'hide_empty'		=> false,
				'hierarchical'		=> true,
				'hide_if_empty'		=> false,
				'echo'				=> false,
				'selected'			=> (int) $selected,
				'id'				=> 'rl_folders_upload_files',
				'name'				=> 'rl_folders_upload_files_term_id',
				'taxonomy'			=> $taxonomy
			)
		);
	}

    /**
     * Display dropdown at media upload UI screen.
     *
     * @return void
     */
    public function post_upload_ui() {
		// get taxonomy
		$taxonomy = Responsive_Lightbox()->options['folders']['media_taxonomy'];

		// dropdown categories parameters
		echo '<p><label>' . __( 'Upload files to', 'responsive-lightbox' ) . ': ' . wp_dropdown_categories(
			array(
				'orderby'			=> 'name',
				'order'				=> 'asc',
				'show_option_all'	=> __( 'Root Folder', 'responsive-lightbox' ),
				'show_count'		=> false,
				'hide_empty'		=> false,
				'hierarchical'		=> true,
				'hide_if_empty'		=> false,
				'echo'				=> false,
				'selected'			=> isset( $_GET[$taxonomy] ) ? (int) $_GET[$taxonomy] : 0,
				'id'				=> 'rl_folders_upload_files',
				'name'				=> 'rl_folders_upload_files_term_id',
				'taxonomy'			=> $taxonomy
			)
		) . '</label></p>';
    }

    /**
     * Assign attachment to given term.
     *
     * @param int $post_id Current attachment ID
     * @return void
     */
    public function add_attachment( $post_id ) {
		if ( isset( $_POST['rl_folders_upload_files_term_id'] ) ) {
			// cast term id
			$term_id = (int) $_POST['rl_folders_upload_files_term_id'];

			// get taxonomy
			$taxonomy = Responsive_Lightbox()->options['folders']['media_taxonomy'];

			if ( is_array( term_exists( $term_id, $taxonomy ) ) )
				wp_set_object_terms( $post_id, $term_id, $taxonomy, false );
		}
    }

    /**
     * Add filterable dropdown to media library.
     *
     * @global string $pagenow Current page
     * @return void	
     */
    public function restrict_manage_posts() {
		global $pagenow;

		if ( $pagenow === 'upload.php' ) {
			// get taxonomy
			$taxonomy = Responsive_Lightbox()->options['folders']['media_taxonomy'];

			$html = wp_dropdown_categories(
				array(
					'orderby'			=> 'name',
					'order'				=> 'asc',
					'id'				=> 'media-attachment-rl-folders-filters',
					'show_option_all'	=> __( 'All Files', 'responsive-lightbox' ),
					'show_count'		=> false,
					'hide_empty'		=> false,
					'hierarchical'		=> true,
					'selected'			=> ( isset( $_GET[$taxonomy] ) ? (int) $_GET[$taxonomy] : 0 ),
					'name'				=> $taxonomy,
					'taxonomy'			=> $taxonomy,
					'hide_if_empty'		=> true,
					'echo'				=> false
				)
			);

			echo ( $html === '' ? '<select name="' . $taxonomy . '" id="media-attachment-rl-folders-filters" class="postform"><option>' . __( 'All Files', 'responsive-lightbox' ) . '</option></select>' : $html );
		}
    }

    /**
     * Change query to adjust taxonomy if needed.
     *
     * @global	string	$pagenow	Current page
     * @param	object	$query		WP Query
     * @return	object				Modified query
     */
    public function parse_query( $query ) {
		global $pagenow;

		// get taxonomy
		$taxonomy = Responsive_Lightbox()->options['folders']['media_taxonomy'];

		if ( $pagenow === 'upload.php' && isset( $_GET[$taxonomy] ) ) {
			// get tax query
			$tax_query = $query->get( 'tax_query' );

			if ( empty( $tax_query ) || ! is_array( $tax_query ) )
				$tax_query = array();

			// -1 === root, 0 === all files, >0 === term_id
			$term_id = (int) $_GET[$taxonomy];

			if ( $term_id !== 0 && ( $query->is_main_query() || empty( $query->query['rl_folders_root'] ) ) ) {
				$tax = array(
					'taxonomy'	 => $taxonomy,
					'field'		 => 'id'
				);

				// root folder?
				if ( $term_id === -1 ) {
					$tax['terms'] = 0;
					$tax['operator'] = 'NOT EXISTS';
					$tax['include_children'] = false;
					// specified term id
				} else {
					$tax['terms'] = $term_id;
					$tax['include_children'] = false;
				}

				// add new tax query
				$tax_query[] = array( 'relation' => 'AND', $tax );

				// set new tax query
				$query->set( 'tax_query', $tax_query );
			}
		}

		return $query;
    }

    /**
     * Change ajax query parameters to adjust taxonomy in the media library if needed.
     *
     * @param	array	$query	Query arguments
     * @return	array			Modified query arguments
     */
    public function ajax_query_attachments_args( $query ) {
		// get taxonomy
		$taxonomy = Responsive_Lightbox()->options['folders']['media_taxonomy'];

		if ( isset( $_POST['query'][$taxonomy] ) ) {
			if ( $_POST['query'][$taxonomy] === 'all' )
				return $query;

			$term_id = (int) $_POST['query'][$taxonomy];

			if ( $term_id < 0 )
				return $query;

			if ( empty( $query['tax_query'] ) || ! is_array( $query['tax_query'] ) )
				$query['tax_query'] = array();

			$query['tax_query'][] = array(
				'relation' => 'AND',
				array(
					'taxonomy'			=> $taxonomy,
					'field'				=> 'id',
					'terms'				=> $term_id,
					'include_children'	=> ( ! ( isset( $_POST['query']['include_children'] ) && $_POST['query']['include_children'] === 'false' ) ),
					'operator'		 	=> ( $term_id === 0 ? 'NOT EXISTS' : 'IN' )
				)
			);
		}

		return $query;
    }

    /**
     * Filter the array of attachment fields that are displayed when editing an attachment.
     *
     * @param	array	$fields		Attachment fields
     * @param	object	$post		Post object
     * @return	array				Modified attachment fields
     */
    function attachment_fields_to_edit( $fields, $post ) {
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			// get taxonomy option
			$taxonomy = Responsive_Lightbox()->options['folders']['media_taxonomy'];

			// get taxonomy object
			$tax = (array) get_taxonomy( $taxonomy );

			if ( ! empty( $tax ) ) {
				if ( ! $tax['public'] || ! $tax['show_ui'] )
					return $fields;

				if ( empty( $tax['args'] ) )
					$tax['args'] = array();

				// include_once( RESPONSIVE_LIGHTBOX_PATH . 'includes/class-folders-walker.php' );

				$ids = wp_get_post_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );

				$dropdown = wp_dropdown_categories(
					array(
						'orderby'			=> 'name',
						'order'				=> 'asc',
						'show_option_none'	=> __( 'Root Folder', 'responsive-lightbox' ),
						'show_option_all'	=> false,
						'show_count'		=> false,
						'hide_empty'		=> false,
						'hierarchical'		=> true,
						'selected'			=> ( ! empty( $ids ) ? reset( $ids ) : 0 ),
						'name'				=> $taxonomy . '_term',
						'taxonomy'			=> $taxonomy,
						'hide_if_empty'		=> false,
						'echo'				=> false
					)
				);

				$tax['input'] = 'html';
				$tax['html'] = $dropdown;

				$fields[$taxonomy] = $tax;
			}
		}

		return $fields;
    }

    /**
     * Assign new term IDs to given attachment ID via AJAX in modal attachment edit screen.
     *
     * @return	void
     */
    function ajax_save_attachment_compat() {
		if ( ! isset( $_REQUEST['id'] ) || ( $id = (int) $_REQUEST['id'] ) <= 0 || empty( $_REQUEST['attachments'] ) || empty( $_REQUEST['attachments'][$id] ) )
			wp_send_json_error();

		check_ajax_referer( 'update-post_' . $id, 'nonce' );

		if ( ! current_user_can( 'edit_post', $id ) )
			wp_send_json_error();

		$post = get_post( $id, ARRAY_A );

		if ( $post['post_type'] !== 'attachment' )
			wp_send_json_error();

		$post = apply_filters( 'attachment_fields_to_save', $post, $_REQUEST['attachments'][$id] );

		if ( isset( $post['errors'] ) )
			wp_send_json_error();

		wp_update_post( $post );

		// get taxonomy
		$taxonomy = Responsive_Lightbox()->options['folders']['media_taxonomy'];

		// first if needed?
		if ( isset( $_REQUEST['attachments'][$id][$taxonomy] ) )
			wp_set_object_terms( $id, (int) reset( array_map( 'trim', $_REQUEST['attachments'][$id][$taxonomy] ) ), $taxonomy, false );
		elseif ( isset( $_REQUEST[$taxonomy . '_term'] ) )
			wp_set_object_terms( $id, (int) $_REQUEST[$taxonomy . '_term'], $taxonomy, false );
		else
			wp_set_object_terms( $id, '', $taxonomy, false );

		if ( ! ( $attachment = wp_prepare_attachment_for_js( $id ) ) )
			wp_send_json_error();

		wp_send_json_success( $attachment );
    }

    /**
     * AJAX action to delete term.
     *
     * @return	void
     */
    public function delete_term() {
		if ( isset( $_POST['term_id'], $_POST['nonce'], $_POST['children'] ) && wp_verify_nonce( $_POST['nonce'], 'rl-folders-ajax-library-nonce' ) && ( $term_id = (int) $_POST['term_id'] ) > 0 ) {
			// get taxonomy
			$taxonomy = Responsive_Lightbox()->options['folders']['media_taxonomy'];

			// delete children?
			if ( $_POST['children'] === '1' ) {
				// get term children
				$children = get_term_children( $term_id, $taxonomy );

				// found any children?
				if ( ! empty( $children ) && ! is_wp_error( $children ) ) {
					// reverse array to delete terms with no children first
					foreach ( array_reverse( $children ) as $child_id ) {
						// delete child
						wp_delete_term( $child_id, $taxonomy );
					}
				}
			}

			// delete parent
			if ( ! is_wp_error( wp_delete_term( $term_id, $taxonomy ) ) )
				wp_send_json_success( $this->get_folders( $taxonomy ) );
		}

		wp_send_json_error();
    }

    /**
     * AJAX action to assign new parent of the term.
     *
     * @return	void
     */
    public function move_term() {
		// get taxonomy
		$taxonomy = Responsive_Lightbox()->options['folders']['media_taxonomy'];

		if ( isset( $_POST['parent_id'], $_POST['term_id'], $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'rl-folders-ajax-library-nonce' ) && ! is_wp_error( wp_update_term( (int) $_POST['term_id'], $taxonomy, array( 'parent' => (int) $_POST['parent_id'] ) ) ) )
			wp_send_json_success( $this->get_folders( $taxonomy ) );

		wp_send_json_error();
    }

    /**
     * AJAX action to add new term.
     *
     * @return	void
     */
    public function add_term() {
		if ( isset( $_POST['parent_id'], $_POST['name'], $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'rl-folders-ajax-library-nonce' ) ) {
			// get taxonomy
			$taxonomy = Responsive_Lightbox()->options['folders']['media_taxonomy'];

			// prepare data
			$original_slug = $slug = sanitize_title( $_POST['name'] );
			$parent_id = (int) $_POST['parent_id'];

			// get all term slugs
			$terms = get_terms(
				array(
					'taxonomy'	 => $taxonomy,
					'hide_empty'	 => false,
					'number'	 => 0,
					'fields'	 => 'id=>slug',
					'hierarchical'	 => true
				)
			);

			// any terms?
			if ( ! is_wp_error( $terms ) && is_array( $terms ) && ! empty( $terms ) ) {
				$i = 2;

				// slug already exists? create unique one
				while ( in_array( $slug, $terms, true ) ) {
					$slug = $original_slug . '-' . $i ++;
				}
			}

			// add new term
			$term = wp_insert_term(
				$_POST['name'],
				$taxonomy,
				array(
					'parent' => $parent_id,
					'slug'	 => $slug
				)
			);

			// no errors?
			if ( ! is_wp_error( $term ) ) {
				$term = get_term( $term['term_id'], $taxonomy );

				// no errors?
				if ( ! is_wp_error( $term ) )
					wp_send_json_success( array( 'name' => $term->name, 'term_id' => $term->term_id, 'url' => admin_url( 'upload.php?mode=' . $this->mode . '&' . $taxonomy . '=' . $term->term_id ), 'select' => $this->get_folders( $taxonomy, $term->term_id ) ) );
			}
		}

		wp_send_json_error();
    }

    /**
     * AJAX action to rename term.
     *
     * @return	void
     */
    public function rename_term() {
		if ( isset( $_POST['term_id'], $_POST['name'], $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'rl-folders-ajax-library-nonce' ) && ( $term_id = (int) $_POST['term_id'] ) > 0 ) {
			// get taxonomy
			$taxonomy = Responsive_Lightbox()->options['folders']['media_taxonomy'];

			// update term
			if ( ! is_wp_error( wp_update_term( $term_id, $taxonomy, array( 'name' => $_POST['name'] ) ) ) ) {
				$term = get_term( $term_id, $taxonomy );

				// no errors?
				if ( ! is_wp_error( $term ) )
					wp_send_json_success( array( 'name' => $term->name, 'select' => $this->get_folders( $taxonomy, $term_id ) ) );
			}
		}

		wp_send_json_error();
    }

    /**
     * AJAX action to assign new term to an attachment(s).
     *
     * @return	void
     */
    public function move_attachments() {
		if ( isset( $_POST['attachment_ids'], $_POST['old_term_id'], $_POST['new_term_id'], $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'rl-folders-ajax-library-nonce' ) && is_array( $_POST['attachment_ids'] ) && ! empty( $_POST['attachment_ids'] ) ) {
			// get taxonomy
			$taxonomy = Responsive_Lightbox()->options['folders']['media_taxonomy'];

			// prepare data
			$ids = $all_terms = array();
			$attachments = array(
				'success'	 => array(),
				'failure'	 => array(),
				'duplicated'	 => array()
			);

			// get only numeric values first
			foreach ( $_POST['attachment_ids'] as $id ) {
				if ( is_numeric( $id ) )
					$ids[] = (int) $id;
			}

			// filter unwanted data
			$ids = array_unique( array_filter( $ids ) );

			// no ids?
			if ( empty( $ids ) )
				wp_send_json_error();

			// prepare term ids
			$old_term_id = (int) $_POST['old_term_id'];
			$new_term_id = (int) $_POST['new_term_id'];

			// moving to root folder?
			if ( $new_term_id === 0 ) {
				foreach ( $ids as $id ) {
					// get attachment's term ids
					$all_terms[$id] = wp_get_object_terms( $id, $taxonomy, array( 'fields' => 'ids' ) );

					// remove all terms assigned to attachment
					if ( ! is_wp_error( wp_set_object_terms( $id, null, $taxonomy, false ) ) )
						$attachments['success'][] = $id;
					else
						$attachments['failure'][] = $id;
				}
			} else {
				foreach ( $ids as $id ) {
					// get attachment's term ids
					$terms = wp_get_object_terms( $id, $taxonomy, array( 'fields' => 'ids' ) );

					// got terms?
					if ( ! is_wp_error( $terms ) ) {
						// save existing term (attachment already assigned to this term)
						if ( in_array( $new_term_id, $terms, true ) )
							$attachments['duplicated'][] = $id;

						// update attachment's term
						if ( ! is_wp_error( wp_set_object_terms( $id, $new_term_id, $taxonomy, false ) ) )
							$attachments['success'][] = $id;
						else
							$attachments['failure'][] = $id;
					}
				}
			}

			if ( ! empty( $attachments['success'] ) )
				wp_send_json_success( array( 'attachments' => $attachments, 'terms' => $all_terms ) );
		}

		wp_send_json_error();
		/*if ( isset( $_POST['attachment_ids'], $_POST['old_term_id'], $_POST['new_term_id'], $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'rl-folders-ajax-library-nonce' ) && is_array( $_POST['attachment_ids'] ) && ! empty( $_POST['attachment_ids'] ) ) {
			// get taxonomy
			$taxonomy = Responsive_Lightbox()->options['folders']['media_taxonomy'];

			// prepare data
			$ids = $all_terms = array();
			$attachments = array(
				'success'	 => array(),
				'failure'	 => array(),
				'duplicated'	 => array()
			);

			// get only numeric values first
			foreach ( $_POST['attachment_ids'] as $id ) {
				if ( is_numeric( $id ) )
					$ids[] = (int) $id;
			}

			// filter unwanted data
			$ids = array_unique( array_filter( $ids ) );

			// no ids?
			if ( empty( $ids ) )
				wp_send_json_error();

			// prepare term ids
			$old_term_id = (int) $_POST['old_term_id'];
			$new_term_id = (int) $_POST['new_term_id'];

			$folders = array(
				$old_term_id	=> 0,
				$new_term_id	=> 0
			);

			$update_terms = array();

			// moving to root folder?
			if ( $new_term_id === 0 ) {
				foreach ( $ids as $id ) {
					// get attachment's term ids
					$all_terms[$id] = wp_get_object_terms( $id, $taxonomy, array( 'fields' => 'ids' ) );

					// remove all terms assigned to attachment
					if ( ! is_wp_error( wp_set_object_terms( $id, null, $taxonomy, false ) ) )
						$attachments['success'][] = $id;
					else
						$attachments['failure'][] = $id;
				}
			} else {
				foreach ( $ids as $id ) {
					// get attachment's term ids
					$terms = wp_get_object_terms( $id, $taxonomy, array( 'fields' => 'ids' ) );

					// got terms?
					if ( ! is_wp_error( $terms ) ) {
						

						// save existing term (attachment already assigned to this term)
						if ( in_array( $new_term_id, $terms, true ) )
							$attachments['duplicated'][] = $id;

						// update attachment's term
						if ( ! is_wp_error( wp_set_object_terms( $id, $new_term_id, $taxonomy, false ) ) ) {
							$attachments[$new_term_id]['success'][] = $id;
							// if ( $old_term_id === -1 ) {
								// foreach ( $terms as $term ) {
									// $update_terms[$term] 
								// }
							// }
						} else
							$attachments['failure'][] = $id;
					}
				}
			}

/*
			$folders[0] = 0;

			$folders = array(
				$old_term_id	=> 0,
				$new_term_id	=> 0
			);

			foreach ( $ids as $id ) {
				// get attachment's term ids
				$terms = wp_get_object_terms( $id, $taxonomy, array( 'fields' => 'ids' ) );
// var_dump( $terms );
				// got terms?
				if ( ! is_wp_error( $terms ) ) {
					if ( $new_term_id === 0 ) {
						if ( ! empty( $terms ) ) {
							foreach ( $terms as $term ) {
								// ignore 'all files' folder
								if ( $term < 0 )
									continue;

								if ( ! array_key_exists( $term, $folders ) )
									$folders[$term] = 0;

								if ( ! in_array( $new_term_id, $terms, true ) )
									$folders[$term]--;
							}

							// save existing term (attachment already assigned to this term)
							if ( in_array( $new_term_id, $terms, true ) ) {
								$attachments['duplicated'][] = $id;

								continue;
							}
						} else {
							// $attachments['duplicated'][] = $id;
						}

						// update attachment's term
						if ( ! is_wp_error( wp_set_object_terms( $id, null, $taxonomy, false ) ) ) {
							if ( $old_term_id >= 0 )
								$folders[$old_term_id]--;

							$folders[$new_term_id]++;

							$attachments['success'][] = $id;
						} else
							$attachments['failure'][] = $id;
					} else {
						if ( ! empty( $terms ) ) {
							$old_term = $terms[0];

							foreach ( $terms as $term ) {
								if ( ! array_key_exists( $term, $folders ) )
									$folders[$term] = 0;

								if ( $term !== $new_term_id )
									$folders[$term]--;
							}

							// save existing term (attachment already assigned to this term)
							// if ( in_array( $new_term_id, $terms, true ) ) {
								// $attachments['duplicated'][] = $id;
						} else {
							$old_term = 0;
							$folders[0]--;
						}
var_dump( $old_term );
						// update attachment's term
						if ( ! is_wp_error( wp_set_object_terms( $id, $new_term_id, $taxonomy, false ) ) ) {
							// if ( $old_term_id >= 0 )
								// $folders[$old_term_id]--;

							if ( $old_term !== $new_term_id )
								$folders[$new_term_id]++;

							$attachments['success'][] = $id;
						} else {
							$attachments['failure'][] = $id;
						}
					}
				}
			}
var_dump( $attachments );
var_dump( $folders );
			if ( ! empty( $attachments['success'] ) )
				wp_send_json_success( array( 'attachments' => $attachments, 'folders' => $folders ) );
		}

		wp_send_json_error();
		*/
    }

    /**
     * Change wp_list_categories HTML link.
     *
     * @param	array	$matches	Matched link
     * @return	string				Changed link with term ID
     */
    public function replace_folders_href( $matches ) {
		// get taxonomy
		$taxonomy = Responsive_Lightbox()->options['folders']['media_taxonomy'];

		if ( ! empty( $matches[1] ) ) {
			$params = parse_url( html_entity_decode( urldecode( $matches[1] ) ) );

			if ( isset( $params['query'] ) ) {
				parse_str( $params['query'], $atts );

				if ( isset( $atts['term'] ) ) {
					$term = get_term_by( 'slug', $atts['term'], $taxonomy );

					if ( $term !== false ) {
						$this->term_counters['keys'][] = $term->term_id;

						return 'href="' . esc_url( admin_url( 'upload.php?mode=' . $this->mode . '&' . $taxonomy . '=' . $term->term_id ) ) . '" data-term_id="' . $term->term_id . '"';
					}
				}
			}
		}

		return 'href="' . admin_url( 'upload.php?mode=' . $this->mode . '&' . $taxonomy . '=0' ) . '" data-term_id="-1"';
    }

    /**
     * Change wp_list_categories HTML link by adding attachment counter.
     *
     * @param	array	$matches	Matched link
     * @return	string				Changed link with counter
     */
    public function replace_folders_count( $matches ) {
		if ( isset( $matches[1] ) ) {
			$count = (int) str_replace( array( ' ', '&nbsp;' ), '', $matches[1] );
			$this->term_counters['values'][] = $count;

			return ' (' . $count . ')</a>';
		}

		return '</a>';
    }

    /**
     * Change wp_list_categories HTML output by adding jsTree attributes if needed.
     *
     * @param	array	$matches	Matched element
     * @return	string				Changed element
     */
    public function open_folders( $matches ) {
		if ( isset( $matches[0] ) ) {
			// open parent term
			if ( isset( $matches[0] ) && strpos( $matches[0], 'current-cat-ancestor' ) !== false )
				return $matches[0] . ' data-jstree=\'{ "opened": true }\'';

			// select current term
			if ( strpos( $matches[0], 'current-cat' ) !== false )
				return $matches[0] . ' data-jstree=\'{ "selected": true }\'';
		}
    }

    /**
     * Enqueue all needed scripts and styles for media library and modal screens.
     *
     * @global	string	$pagenow		Current page
     * @global	string	$wp_list_table	WP List Table instance
     * @param	string	$page			Current page similar to $pagenow depends on from which filter function was called
     * @return	void
     */
    public function add_library_scripts( $page ) {
		// count how many times function was executed, allow this only once
		static $run = 0;

		// allow only wp media scripts (empty $page), upload.php or media-new.php
		if ( ! ( ( $page === '' || $page === 'upload.php' || $page === 'media-new.php' ) && $run < 1 ) )
			return;

		global $pagenow;

		$run++;

		// change page for wp_enqueue_media
		if ( $page === '' ) {
			if ( $pagenow === 'upload.php' )
				$page = 'upload.php';
			else
				$page = 'media';
		}

		// include styles
		wp_enqueue_style( 'responsive-lightbox-folders-admin-css', RESPONSIVE_LIGHTBOX_URL . '/css/admin-folders.css' );
		wp_enqueue_style( 'responsive-lightbox-folders-perfect-scrollbar', RESPONSIVE_LIGHTBOX_URL . '/assets/perfect-scrollbar/perfect-scrollbar' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.css' );
		// wp_enqueue_style( 'responsive-lightbox-folders-jstree', RESPONSIVE_LIGHTBOX_URL . '/assets/jstree/themes/' . Responsive_Lightbox()->options['folders']['jstree_style'] . '/style' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.css' );
		wp_enqueue_style( 'responsive-lightbox-folders-jstree', RESPONSIVE_LIGHTBOX_URL . '/assets/jstree/themes/default/style' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.css' );
		
		// get color scheme global
		global $_wp_admin_css_colors;

		// get current admin color scheme name
		$current_color_scheme = get_user_option( 'admin_color' );

		// get all available colors from scheme name
		$colors = $_wp_admin_css_colors[$current_color_scheme]->colors;
		
		// print_r( Responsive_Lightbox()->hex2rgb( $colors[2] ) ); exit;
		
		$custom_css = '
		#rl-folders-tree-container .jstree .rl-folders-state-active.rl-folders-state-hover {
			background: #fff !important;
		}
		#rl-folders-tree-container .jstree-container-ul .jstree-wholerow-clicked,
		#rl-folders-tree-container .jstree-container-ul:not(.jstree-wholerow-ul) .jstree-clicked {
			background: rgba(' . implode( ',', Responsive_Lightbox()->hex2rgb( $colors[3] ) ) . ', 0.15);
		}
		#rl-folders-tree-container .jstree-container-ul .jstree-wholerow-hovered,
		#rl-folders-tree-container .jstree-container-ul:not(.jstree-wholerow-ul) .jstree-hovered {
			background: rgba(' . implode( ',', Responsive_Lightbox()->hex2rgb( $colors[3] ) ) . ', 0.05);
		}
		';
        wp_add_inline_style( 'responsive-lightbox-folders-jstree', $custom_css );
		
		// print_r( $colors ); exit;

		// prepare variables
		$no_items = '';
		$childless = false;

		// filterable media folders taxonomy
		$taxonomy = get_taxonomy( Responsive_Lightbox()->options['folders']['media_taxonomy'] );

		// list categories parameters
		$categories = array(
			'orderby'				=> 'name',
			'order'					=> 'asc',
			'show_count'			=> true,
			'show_option_all'		=> '',
			'show_option_none'		=> '',
			'use_desc_for_title'	=> false,
			'title_li'				=> '',
			'hide_empty'			=> false,
			'hierarchical'			=> true,
			'taxonomy'				=> $taxonomy->name,
			'hide_title_if_empty'	=> true,
			'echo'					=> false
		);

		// get current term id
		$term_id = isset( $_GET[$taxonomy->name] ) ? (int) $_GET[$taxonomy->name] : 0;

		// list mode?
		if ( $this->mode === 'list' ) {
			// get global wp list table instance
			global $wp_list_table;

			// empty instance?
			if ( is_null( $wp_list_table ) )
				$wp_list_table = _get_list_table( 'WP_Media_List_Table' );

			// start buffering
			ob_start();

			// display "no media" table row
			echo '<tr class="no-items"><td class="colspanchange" colspan="' . $wp_list_table->get_column_count() . '">';

			$wp_list_table->no_items();

			echo '</td></tr>';

			// save "no media" table row
			$no_items = ob_get_contents();

			// clear the buffer
			ob_end_clean();

			// valid term?
			if ( $term_id > 0 ) {
				$children = get_term_children( $term_id, $taxonomy->name );

				// found any children?
				$childless = ! ( ! empty( $children ) && ! is_wp_error( $children ) );
			}
		}

		// set current term id
		if ( $term_id > 0 )
			$categories['current_category'] = $term_id;

		// hide filter for grid
		if ( $page !== 'media' && $this->mode !== 'list' )
			wp_add_inline_style( 'responsive-lightbox-folders-admin-css', '#media-attachment-rl-folders-filters { display: none; }' );

		// get taxonomy html output
		$html = wp_list_categories( $categories );

		if ( $html !== '' ) {
			// fix for urls
			$html = preg_replace_callback( '/href=(?:\'|")(.*?)(?:\'|")/', array( $this, 'replace_folders_href' ), $html );

			// fix for counters
			$html = preg_replace_callback( '/<\/a> \(((?:\d+|&nbsp;)+)\)/', array( $this, 'replace_folders_count' ), $html );

			// open all needed folders at start
			if ( $term_id > 0 )
				$html = preg_replace_callback( '/class="cat-item cat-item-(\d+)(?:[a-z\s0-9-]+)?"/', array( $this, 'open_folders' ), $html );

			$counters = array_combine( $this->term_counters['keys'], $this->term_counters['values'] );
		}

		// all attachments query
		$count = wp_count_posts( 'attachment' );

		// root folder query
		$root_query = new WP_Query(
			array(
				'rl_folders_root'	=> true,
				'posts_per_page'	=> -1,
				'post_type'			=> 'attachment',
				'post_status'		=> 'inherit,private',
				'fields'			=> 'ids',
				'no_found_rows'		=> true,
				'tax_query'			=> array(
					array(
						'relation' => 'AND',
						array(
							'taxonomy'			=> $taxonomy->name,
							'field'				=> 'id',
							'terms'				=> 0,
							'include_children'	=> false,
							'operator'			=> 'NOT EXISTS'
						)
					)
				)
			)
		);

		$counters[-1] = (int) $count->inherit;
		$counters[0] = (int) $root_query->post_count;

		$html = '
			<ul>
				<li class="cat-item cat-item-all"' . ( $term_id === 0 ? ' data-jstree=\'{ "selected": true }\'' : '' ) . '>
				<a href="' . admin_url( 'upload.php?mode=' . $this->mode . '&' . $taxonomy->name . '=0' ) . '" data-term_id="all">' . __( 'All Files', 'responsive-lightbox' ) . ' (' . (int) $count->inherit . ')</a>
				</li>
				<li class="cat-item cat-item-0" data-jstree=\'{ "opened": true' . ( $term_id === -1 ? ', "selected": true ' : '' ) . ' }\'>
				<a href="' . admin_url( 'upload.php?mode=' . $this->mode . '&' . $taxonomy->name . '=-1' ) . '" data-term_id="0">' . __( 'Root Folder', 'responsive-lightbox' ) . ' (' . (int) $root_query->post_count . ')</a>
				<ul>' . $html . '</ul>
				</li>
			</ul>';

		// register scripts
		wp_register_script( 'responsive-lightbox-folders-jstree', RESPONSIVE_LIGHTBOX_URL . '/assets/jstree/jstree' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.js', array(), Responsive_Lightbox()->defaults['version'], false );
		wp_register_script( 'responsive-lightbox-folders-perfect-scrollbar', RESPONSIVE_LIGHTBOX_URL . '/assets/perfect-scrollbar/perfect-scrollbar' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.js', array(), Responsive_Lightbox()->defaults['version'], false );

		wp_enqueue_script( 'responsive-lightbox-folders-admin', RESPONSIVE_LIGHTBOX_URL . '/js/admin-folders.js', array( 'jquery', 'jquery-ui-draggable', 'jquery-ui-droppable', 'media-views', 'responsive-lightbox-folders-jstree', 'responsive-lightbox-folders-perfect-scrollbar' ), Responsive_Lightbox()->defaults['version'], false );

		wp_localize_script(
			'responsive-lightbox-folders-admin',
			'rlFoldersArgs',
			array(
				'remove_children'	=> (int) Responsive_Lightbox()->options['folders']['folders_removal'],
				'wholerow'			=> (int) Responsive_Lightbox()->options['folders']['jstree_wholerow'],
				// 'theme'				=> Responsive_Lightbox()->options['folders']['jstree_style'],
				'theme'				=> 'default',
				'counters'			=> $counters,
				'taxonomy'			=> $taxonomy->name,
				'page'				=> $page,
				'no_media_items'	=> $no_items,
				'all_terms'			=> __( 'All Files', 'responsive-lightbox' ),
				'root'				=> __( 'Root Folder', 'responsive-lightbox' ),
				'new_folder'		=> __( 'New Folder', 'responsive-lightbox' ),
				'delete_term'		=> __( 'Are you sure you want to delete this folder?', 'responsive-lightbox' ),
				'delete_terms'		=> __( 'Are you sure you want to delete this folder with all subfolders?', 'responsive-lightbox' ),
				'nonce'				=> wp_create_nonce( 'rl-folders-ajax-library-nonce' ),
				'terms'				=> wp_dropdown_categories(
					array(
						'orderby'			=> 'name',
						'order'				=> 'asc',
						'show_option_all'	=> __( 'All Files', 'responsive-lightbox' ),
						'show_count'		=> false,
						'hide_empty'		=> false,
						'hierarchical'		=> true,
						'selected'			=> ( isset( $_GET[$taxonomy->name] ) ? (int) $_GET[$taxonomy->name] : 0 ),
						'name'				=> $taxonomy->name,
						'taxonomy'			=> $taxonomy->name,
						'hide_if_empty'		=> true,
						'echo'				=> false
					)
				),
				'template'			=> '
					<div id="rl-folders-tree-container">
						<div class="media-toolbar wp-filter">
						<div class="view-switch rl-folders-action-links">
							<a href="#" title="' . $taxonomy->labels->add_new_item . '" class="dashicons dashicons-plus rl-folders-add-new-folder' . ( $this->mode === 'list' && ( $term_id === -1 || $term_id > 0 ) ? '' : ' disabled-link' ) . '"></a>
							<a href="#" title="' . sprintf( __( 'Save new %s', 'responsive-lightbox' ), $taxonomy->labels->singular_name ) . '" class="dashicons dashicons-yes rl-folders-save-new-folder" style="display: none;"></a>
							<a href="#" title="' . sprintf( __( 'Cancel adding new %s', 'responsive-lightbox' ), $taxonomy->labels->singular_name ) . '" class="dashicons dashicons-no rl-folders-cancel-new-folder" style="display: none;"></a>
							<a href="#" title="' . $taxonomy->labels->edit_item . '" class="dashicons dashicons-edit rl-folders-rename-folder' . ( $this->mode === 'list' && $term_id > 0 ? '' : ' disabled-link' ) . '"></a>
							<a href="#" title="' . sprintf( __( 'Save %s', 'responsive-lightbox' ), $taxonomy->labels->singular_name ) . '" class="dashicons dashicons-yes rl-folders-save-folder" style="display: none;"></a>
							<a href="#" title="' . sprintf( __( 'Cancel renaming %s', 'responsive-lightbox' ), $taxonomy->labels->singular_name ) . '" class="dashicons dashicons-no rl-folders-cancel-folder" style="display: none;"></a>
							<a href="#" title="' . sprintf( __( 'Delete %s', 'responsive-lightbox' ), $taxonomy->labels->singular_name ) . '" class="dashicons dashicons-trash rl-folders-delete-folder' . ( $this->mode === 'list' && $term_id > 0 ? '' : ' disabled-link' ) . '"></a>
							<a href="#" title="' . sprintf( __( 'Expand %s', 'responsive-lightbox' ), $taxonomy->labels->singular_name ) . '" class="dashicons dashicons-arrow-down-alt2 rl-folders-expand-folder' . ( $this->mode === 'list' && ! $childless && ( $term_id === -1 || $term_id > 0 ) ? '' : ' disabled-link' ) . '"></a>
							<a href="#" title="' . sprintf( __( 'Collapse %s', 'responsive-lightbox' ), $taxonomy->labels->singular_name ) . '" class="dashicons dashicons-arrow-up-alt2 rl-folders-collapse-folder' . ( $this->mode === 'list' && ! $childless && ( $term_id === -1 || $term_id > 0 ) ? '' : ' disabled-link' ) . '"></a>
							</div>
						</div>
						<div id="rl-folders-tree">' . esc_html( $html ) . '</div>
						</div>
					</div>'
			)
		);

		add_action( 'admin_print_styles', array( $this, 'admin_print_media_styles' ) );
	}

	/**
	 * CSS fix for media folders checklist.
	 *
	 * @return	void
	 */
	public function admin_print_media_styles() {
		echo '<style>.rl_media_folder li .selectit input[type="checkbox"] { margin: 0 3px; }</style>';
    }

	/**
     * Get all previously used media taxonomies.
     *
     * @global object $wpdb Database handler
     * @return array Old unused taxonomies
     */
    public function get_taxonomies() {
		global $wpdb;

		$fields = $wpdb->get_col( '
			SELECT DISTINCT tt.taxonomy
			FROM ' . $wpdb->prefix . 'term_taxonomy tt
			LEFT JOIN ' . $wpdb->prefix . 'term_relationships tr ON tt.term_taxonomy_id = tr.term_taxonomy_id
			LEFT JOIN ' . $wpdb->prefix . 'posts p ON p.ID = tr.object_id
			WHERE p.post_type = \'attachment\'
			ORDER BY tt.taxonomy ASC'
		);

		if ( ! empty( $fields ) ) {
			// remove polylang taxonomy
			if ( ( $key = array_search( 'language', $fields, true ) ) !== false )
				unset( $fields[$key] );
		}

		return $fields;
    }
}
