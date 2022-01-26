<?php
/**
 * repositories.php
 *
 * Displays the repository management page.
 *
 * @package   Revisr
 * @license   GPLv3
 * @link      https://revisr.io
 * @copyright Expanded Fronts, LLC
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

// Prepares the Revisr custom list table.
revisr()->repositories_table->prepare_items();

?>

<div class="wrap">

	<h2><?php _e( 'Revisr - Repositories', 'revisr' ); ?></h2>

	<?php
		if ( isset( $_GET['status'] ) && isset( $_GET['repository'] ) ) {
			switch ( $_GET['status'] ) {
				case "create_success":
					$msg = sprintf( esc_html__( 'Successfully created repository: %s.', 'revisr' ), $_GET['repository'] );
					echo '<div id="revisr-alert" class="updated" style="margin-top:20px;"><p>' . $msg . '</p></div>';
					break;
				case "create_error":
					$msg = __( 'Failed to create the new repository.', 'revisr' );
					if ( revisr()->git->is_repository( $_GET['repository'] ) ) {
						$msg = sprintf( esc_html__( 'Failed to create repository: %s (repository already exists).', 'revisr' ), $_GET['repository'] );
					}
					echo '<div id="revisr-alert" class="error" style="margin-top:20px;"><p>' . $msg . '</p></div>';
					break;
				case "delete_success":
					$msg = sprintf( esc_html__( 'Successfully deleted repository: %s.', 'revisr' ), $_GET['repository'] );
					echo '<div id="revisr-alert" class="updated" style="margin-top:20px;"><p>' . $msg . '</p></div>';
					break;
				case "delete_fail":
					$msg = sprintf( esc_html__( 'Failed to delete repository: %s.', 'revisr' ), $_GET['repository'] );
					echo '<div id="revisr-alert" class="error" style="margin-top:20px;"><p>' . $msg . '</p></div>';
				default:
					// Do nothing.
			}
		}
	?>

	<div id="col-container" class="revisr-col-container">

		<div id="col-right">
			<form id="revisr-repository-form">
				<?php revisr()->repositories_table->display(); ?>
			</form>
		</div><!-- /#col-right -->

		<div id="col-left">

			<div id="revisr-add-repository-box" class="postbox">
				<h3><?php _e( 'Add New Repository', 'revisr' ); ?></h3>
				<div class="inside">
					<form id="revisr-add-repository-form" method="post" action="<?php echo get_admin_url() . 'admin-post.php'; ?>">

						<div class="form-field form-required">
							<label for="revisr-repository-name"><strong><?php _e( 'Name', 'revisr' ); ?></strong></label>
							<input id="revisr-repository-name" name="repository_name" type="text" value="" size="40" aria-required="true" />
							<p class="description"><?php _e( 'The name of the new repository.', 'revisr' ); ?></p><br>
						</div>

						<div class="form-field form-required">
							<label for="revisr-repository-path"><strong><?php _e( 'Path', 'revisr' ); ?></strong></label>
							<input id="revisr-repository-path" name="repository_path" type="text" value="" size="40" aria-required="true" />
							<p class="description"><?php _e( 'The full path to the repository.', 'revisr' ); ?></p><br>
						</div>

						<div class="form-field">
							<input id="create-as-submodule" type="checkbox" name="checkout_new_repository" style="width: 17px;">
							<label  id="checkout-label" for="create-as-submodule"><?php _e('Create as submodule?'); ?></label>
							<input type="hidden" name="action" value="process_create_repository">
							<?php wp_nonce_field( 'process_create_repository', 'revisr_create_repository_nonce' ); ?>
							<p id="add-repository-submit" class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Create Repository', 'revisr' ); ?>" style="width:150px;"></p>
						</div>
					</form>
				</div>
			</div>
		</div><!-- /#col-left-->

	</div><!-- /#col-container -->

</div><!-- /.wrap -->
