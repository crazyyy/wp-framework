<?php

	/**
	 * The page Settings.
	 *
	 * @since 1.0.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}


	class WbcrCmp_DeleteCommentsPage extends Wbcr_FactoryClearfy206_PageBase {

		/**
		 * The id of the page in the admin menu.
		 *
		 * Mainly used to navigate between pages.
		 * @see FactoryPages410_AdminPage
		 *
		 * @since 1.0.0
		 * @var string
		 */
		public $id = "delete_comments";
		public $type = "page";
		public $page_parent_page = "comments";
		public $page_menu_dashicon = 'dashicons-testimonial';
		/**
		 * Доступена для мультисайтов
		 * @var bool
		 */
		public $available_for_multisite = true;

		/**
		 * @param Wbcr_Factory409_Plugin $plugin
		 */
		public function __construct(Wbcr_Factory409_Plugin $plugin)
		{
			$this->menu_title = __('Comments cleaner', 'comments-plus');

			parent::__construct($plugin);
		}

		/**
		 * We register notifications for some actions
		 *
		 * @see libs\factory\pages\themplates\FactoryPages410_ImpressiveThemplate
		 * @param $notices
		 * @param Wbcr_Factory409_Plugin $plugin
		 * @return array
		 */
		public function getActionNotices($notices)
		{

			$notices[] = array(
				'conditions' => array(
					'wbcr_cmp_clear_comments' => 1
				),
				'type' => 'success',
				'message' => __('All comments have been deleted.', 'comments-plus')
			);

			$notices[] = array(
				'conditions' => array(
					'wbcr_cmp_clear_comments_error' => 1,
					'wbcr_cmp_code' => 'interal_error'
				),
				'type' => 'danger',
				'message' => __('An error occurred while trying to delete comments. Internal error occured. Please try again later.', 'comments-plus')
			);

			return $notices;
		}
		
		public function getStats()
		{
			if( WCM_Plugin::app()->isNetworkActive() ) {
				$stats = $this->getMultisiteStats();
			} else {
				$stats = $this->getSiteStats();
			}

			return $stats;
		}

		public function getMultisiteStats()
		{
			$stats = array();
			foreach(WCM_Plugin::app()->getActiveSites() as $site) {
				switch_to_blog($site->blog_id);
				$site_stats = $this->getSiteStats();
				$stats = $this->mergeStats($stats, $site_stats);
				restore_current_blog();
			}

			return $stats;
		}
		
		public function mergeStats($current_stats, $new_stats)
		{
			if( !isset($current_stats['stat_data']) ) {
				$current_stats['stat_data'] = $new_stats['stat_data'];
			} else {
				$comment_fields = array('total_comments', 'order_notes_count', 'spamcount', 'unpcount', 'trashcount');
				foreach($comment_fields as $comment_field) {
					if( is_null($current_stats['stat_data'][0]->$comment_field) ) {
						$current_stats['stat_data'][0]->$comment_field = 0;
					}
					if( is_null($new_stats['stat_data'][0]->$comment_field) ) {
						$new_stats['stat_data'][0]->$comment_field = 0;
					}
					if( $new_stats['stat_data'][0]->$comment_field ) {
						$current_stats['stat_data'][0]->$comment_field = $current_stats['stat_data'][0]->$comment_field + $new_stats['stat_data'][0]->$comment_field;
					}
				}
			}
			
			if( !isset($current_stats['post_types']) ) {
				$current_stats['post_types'] = $new_stats['post_types'];
			} else {
				foreach($new_stats['post_types'] as $post_type_key => $post_type) {
					if( array_key_exists($post_type_key, $current_stats['post_types']) ) {
						$current_stats['post_types'][$post_type_key]['comments_count'] += $new_stats['post_types'][$post_type_key]['comments_count'];
					} else {
						$current_stats['post_types'][$post_type_key] = $new_stats['post_types'][$post_type_key];
					}
				}
			}
			
			return $current_stats;
		}
		
		
		public function getSiteStats()
		{
			global $wpdb;
			$stat_data = $wpdb->get_results("SELECT count(*) as total_comments,
						SUM(comment_type='order_note') as order_notes_count,
						SUM(comment_approved='spam') as spamcount,
						SUM(comment_approved='0') as unpcount,
						SUM(comment_approved='trash') as trashcount
						FROM {$wpdb->prefix}comments");

			$stat_data_by_post_type = $wpdb->get_results("SELECT
						SUM(comment_count) as type_comments_count, post_type
						FROM $wpdb->posts
						GROUP BY post_type");

			$types = get_post_types(array('public' => true), 'objects');

			$post_types = array();
			foreach((array)$types as $type_name => $type) {
				$comments_count = 0;
				if( !empty($stat_data_by_post_type) ) {
					foreach((array)$stat_data_by_post_type as $post_type_stat_value) {
						if( $post_type_stat_value->post_type == $type_name ) {
							$comments_count = $post_type_stat_value->type_comments_count;
						}
					}
				}

				$post_types[$type_name] = array('label' => $type->label, 'comments_count' => $comments_count);
			}

			return array(
				'stat_data' => $stat_data,
				'post_types' => $post_types
			);
		}

		/**
		 * Prints the content of the page
		 *
		 * @see libs\factory\pages\themplates\FactoryPages410_ImpressiveThemplate
		 */
		public function showPageContent()
		{
			$stats = $this->getStats();
			$stat_data = $stats['stat_data'];
			$post_types = $stats['post_types'];

			?>
			<script>
				/**
				 * Select all types by one click.
				 */
				jQuery(document).ready(function($) {
					updateCommentsCounter();

					var allTypesCheckbox = $('#wbcr-cmp-all-types-checkbox');

					allTypesCheckbox.click(function() {
						$('.wbcr-cmp-post-type-checkbox').prop("checked", $(this).prop("checked"));
						updateCommentsCounter()
					});

					$('.wbcr-cmp-post-type-checkbox').click(function() {
						if( !$(this).prop("checked") ) {
							allTypesCheckbox.prop("checked", false);
						}
						updateCommentsCounter();
					});

					$('input[name="wbcr_cmp_delete_order_notes"]').click(function() {
						updateCommentsCounter();
					});

					$('.wbcr-cmp-delete-comments-button').click(function() {
						var confrimDelete = confirm('<?php _e('Are you sure you want to delete comments from the database without restoring?', 'comments-plus'); ?>');

						if( !confrimDelete ) {
							return false;
						}

						$(this).submit();
					});

					function updateCommentsCounter() {
						var commentsCount = 0;
						$('.wbcr-cmp-post-type-checkbox:checked, input[name="wbcr_cmp_delete_order_notes"]:checked').each(function() {
							commentsCount += $(this).data('comments-number');
						});

						$('.wbcr-cmp-delete-comments-button').val('<?php _e('Delete ', 'comments-plus') ?>(' + commentsCount + ')');
					}
				});
			</script>

			<div class="wbcr-factory-page-group-header" style="margin-top:0;">
				<strong><?php _e('Comments clearing tools', 'comments-plus') ?></strong>

				<p>
					<?php _e('These functions can be useful for global disabling comments or bulk cleaning spam comments.', 'comments-plus') ?>
				</p>
			</div>

			<form method="post" action="<?= $this->getActionUrl('delete-all-comments') ?>" style="padding: 20px;">
				<h5><?php _e('Remove all comments', 'comments-plus'); ?></h5>

				<p><?php _e('You can delete all comments in your database with one click.', 'comments-plus'); ?></p>

				<p><strong><?php _e('Choose post types', 'comments-plus'); ?></strong>

				<div style="height:150px; width:400px; padding:10px 10px 0; background: #fff; border:1px solid #ccc; overflow-y: scroll; overflow-x:hidden;">
					<p>
						<label>
							<input type="checkbox" id="wbcr-cmp-all-types-checkbox" name="wbcr_cmp_post_type[]" value="all" checked/> <?php _e('Select all', 'comments-plus'); ?>
						</label>
					</p>
					<?php foreach((array)$post_types as $key => $type): ?>
						<p>
							<label>
								<input type="checkbox" data-comments-number="<?= $type['comments_count'] ?>" class="wbcr-cmp-post-type-checkbox" name="wbcr_cmp_post_type[]" value="<?= esc_attr($key) ?>" checked/> <?= $type['label'] ?>
								(<?= $type['comments_count'] ?>)
							</label>
						</p>
					<?php endforeach; ?>
				</div>

				<?php if( class_exists('WooCommerce') ):
					?>
					<p style="margin:15px 0 0">
						<label>
							<input type="checkbox" data-comments-number="<?= $stat_data[0]->order_notes_count ?>" name="wbcr_cmp_delete_order_notes" value="1"/> <?php printf(__('Delete Woocommerce order notices? (%d)', 'comments-plus'), $stat_data[0]->order_notes_count); ?>
						</label>
					</p>
				<?php endif;
				?>
				<p style="margin-top:15px;">
					<input type="submit" name="wbcr_cmp_delete_all" class="button button-default wbcr-cmp-delete-comments-button" value="<?php printf(__('Delete (%s)', 'comments-plus'), $stat_data[0]->total_comments); ?>">
				</p>
				<?php wp_nonce_field($this->getResultId() . '_delete_all_comments') ?>
			</form>

			<div style="padding: 20px;">
				<hr/>
				<h5><?php _e('Remove spam comments', 'comments-plus'); ?></h5>

				<p><?php _e('You can remove only spam comments from the database with one click.', 'comments-plus'); ?></p>
				<a href="<?= wp_nonce_url($this->getActionUrl('delete-spam-comments'), $this->getResultId() . '_delete_spam_comments') ?>" class="button button-default wbcr-cmp-delete-comments-button">
					<?php printf(__('Delete (%d)', 'comments-plus'), $stat_data[0]->spamcount); ?>
				</a>
				<hr/>
				<h5><?php _e('Remove unapproved comments', 'comments-plus'); ?></h5>

				<p><?php _e('You can remove only unapproved comments from the database with one click.', 'comments-plus'); ?></p>
				<a href="<?= wp_nonce_url($this->getActionUrl('delete-unaproved-comments'), $this->getResultId() . '_delete_unaproved_comments') ?>" class="button button-default wbcr-cmp-delete-comments-button">
					<?php printf(__('Delete (%d)', 'comments-plus'), $stat_data[0]->unpcount); ?>
				</a>
				<hr/>
				<h5><?php _e('Remove trashed comments', 'comments-plus'); ?></h5>

				<p><?php _e('You can remove only trashed comments from the database with one click.', 'comments-plus'); ?></p>
				<a href="<?= wp_nonce_url($this->getActionUrl('delete-trash-comments'), $this->getResultId() . '_delete_trash_comments') ?>" class="button button-default wbcr-cmp-delete-comments-button">
					<?php printf(__('Delete (%d)', 'comments-plus'), $stat_data[0]->trashcount); ?>
				</a>
			</div>
		<?php
		}

		/**
		 * @return bool
		 */
		protected function deleteAllComments()
		{
			global $wpdb;
			$delete_order_notes = $this->request->post('wbcr_cmp_delete_order_notes', false, 'intval');

			if( $wpdb->query("TRUNCATE $wpdb->commentmeta") != false ) {
				$delete_all_sql = "TRUNCATE $wpdb->comments";
				if( class_exists('WooCommerce') ) {
					if( !$delete_order_notes ) {
						$delete_all_sql = "DELETE FROM $wpdb->comments WHERE comment_type != 'order_note'";
					}
				}
				if( $wpdb->query($delete_all_sql) != false ) {
					$wpdb->query("UPDATE $wpdb->posts SET comment_count = 0 WHERE post_author != 0");
					$wpdb->query("OPTIMIZE TABLE $wpdb->commentmeta");
					$wpdb->query("OPTIMIZE TABLE $wpdb->comments");

					return true;
				}
			}

			return false;
		}

		/**
		 * @param string $post_type
		 * @return bool
		 */
		protected function deleteCommentsByPostType($post_type = 'post')
		{
			global $wpdb;

			$delete_order_notes = $this->request->post('wbcr_cmp_delete_order_notes', false, 'intval');

			$wpdb->query("DELETE cmeta FROM $wpdb->commentmeta cmeta INNER JOIN $wpdb->comments comments ON cmeta.comment_id=comments.comment_ID INNER JOIN $wpdb->posts posts ON comments.comment_post_ID=posts.ID WHERE posts.post_type = '%s'");

			$delete_certain_sql = "DELETE comments FROM $wpdb->comments comments INNER JOIN $wpdb->posts posts ON comments.comment_post_ID=posts.ID WHERE posts.post_type = '%s'";

			if( class_exists('WooCommerce') ) {
				if( !$delete_order_notes ) {
					$delete_certain_sql .= " and comment_type != 'order_note'";
				}
			}

			$wpdb->query($wpdb->prepare($delete_certain_sql, $post_type));
			$wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET comment_count = 0 WHERE post_author != 0 AND post_type = '%s'", $post_type));

			return true;
		}

		/**
		 * @param $post_types
		 * @return bool
		 */
		protected function deleteCommentsByPostTypes($post_types)
		{
			global $wpdb;

			if( empty($post_types) || !is_array($post_types) ) {
				return false;
			}

			foreach($post_types as $post_type) {
				$this->deleteCommentsByPostType($post_type);
			}

			$wpdb->query("OPTIMIZE TABLE $wpdb->commentmeta");
			$wpdb->query("OPTIMIZE TABLE $wpdb->comments");

			return true;
		}

		/**
		 * This action deletes all comments from the database without restoring.
		 */
		public function deleteAllCommentsAction()
		{
			check_admin_referer($this->getResultId() . '_delete_all_comments');

			if( isset($_POST['wbcr_cmp_delete_all']) ) {
				$post_types = $this->request->post('wbcr_cmp_post_type', array(), true);

				$result = false;

				if( empty($post_types) || in_array('all', $post_types) ) {
					if( WCM_Plugin::app()->isNetworkActive() ) {
						foreach(WCM_Plugin::app()->getActiveSites() as $site) {
							switch_to_blog($site->blog_id);
							$result = $this->deleteAllComments();
							restore_current_blog();
						}
					} else {
						$result = $this->deleteAllComments();
					}
				} else {
					if( WCM_Plugin::app()->isNetworkActive() ) {
						foreach(WCM_Plugin::app()->getActiveSites() as $site) {
							switch_to_blog($site->blog_id);
							$result = $this->deleteCommentsByPostTypes($post_types);
							restore_current_blog();
						}
					} else {
						$result = $this->deleteCommentsByPostTypes($post_types);
					}
				}
				
				if( $result ) {
					$this->redirectToAction('index', array(
						'wbcr_cmp_clear_comments' => '1'
					));
				} else {
					$this->redirectToAction('index', array(
						'wbcr_cmp_clear_comments_error' => '1',
						'wbcr_cmp_code' => 'interal_error',
					));
				}
			}

			$this->redirectToAction('index');
		}

		/**
		 * The basic function of deleting comments.
		 *
		 * @param int|string $type
		 */
		public function deleteComments($type = 0)
		{
			if( in_array($type, array('spam', 'trash', 0)) ) {
				
				if( WCM_Plugin::app()->isNetworkActive() ) {
					foreach(WCM_Plugin::app()->getActiveSites() as $site) {
						switch_to_blog($site->blog_id);
						$this->deleteCommentsByType($type);
						restore_current_blog();
					}
				} else {
					$this->deleteCommentsByType($type);
				}

				$this->redirectToAction('index', array(
					'wbcr_cmp_clear_comments' => '1'
				));
			}
		}

		/**
		 * @param int $type
		 * @return false|int
		 */
		private function deleteCommentsByType($type = 0)
		{
			global $wpdb;

			$wpdb->query("DELETE cmeta
				FROM $wpdb->commentmeta cmeta
				INNER JOIN {$wpdb->comments} comments ON cmeta.comment_id=comments.comment_ID
				WHERE comment_approved='{$type}'");

			$res = $wpdb->query("DELETE FROM {$wpdb->comments} WHERE comment_approved='{$type}'");

			if( $res ) {
				$wpdb->query("OPTIMIZE TABLE {$wpdb->comments}");
				$wpdb->query("OPTIMIZE TABLE {$wpdb->commentmeta}");
			}

			return $res;
		}

		/**
		 * This action deletes spam comments
		 */
		public function deleteSpamCommentsAction()
		{
			check_admin_referer($this->getResultId() . '_delete_spam_comments');

			$this->deleteComments('spam');
		}

		/**
		 * This action deletes unaproved comments
		 */
		public function deleteUnaprovedCommentsAction()
		{
			check_admin_referer($this->getResultId() . '_delete_unaproved_comments');

			$this->deleteComments();
		}

		/**
		 * This action deletes trash comments
		 */
		public function deleteTrashCommentsAction()
		{
			check_admin_referer($this->getResultId() . '_delete_trash_comments');

			$this->deleteComments('trash');
		}
	}
