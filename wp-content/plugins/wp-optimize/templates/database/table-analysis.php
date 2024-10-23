<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>

<div id="wp-optimize-database-table-analysis" class="wpo_section wpo_group premium-only">
	<div class="wpo-fieldgroup">
		<div class="switch-container">
			<label class="switch">
				<input id="enable-db-analysis" name="enable-db-analysis" type="checkbox" value="true">
				<span class="slider round"></span>
			</label>
			<label for="enable-db-analysis">
				<?php esc_html_e('Run the query analysis for all executed queries in this site', 'wp-optimize'); ?>
			</label>
		</div>

		<button disabled=disabled id="wpo-wipe-table-usage-data" class="button"><?php esc_html_e('Wipe usage information', 'wp-optimize'); ?></button>
		
		<label style="margin-top: 5px; display: block;">
			<?php esc_html_e('Delete all the information about queries that are currently stored in the database', 'wp-optimize'); ?>
		</label>
		
		<div id="wpo-save-options-response" class="hidden"></div>
	
	</div>
	<div class="wpo-table-usage__premium-mask">
		<a class="wpo-table-usage__premium-link" href="<?php echo esc_url($wp_optimize->premium_version_link); ?>" target="_blank"><?php esc_html_e('Enable table usage analysis with WP-Optimize Premium.', 'wp-optimize'); ?></a>
	</div>
</div><!-- end #wp-optimize-database-table-analysis -->
