<div class="f12-profiler">
	<div class="headline-container">
		<div class="logo">
			<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ); ?>assets/Forge12-Bildmarke.png" alt="Forge12 Interactive" title="Forge12 Interactive"/>
		</div>
		<h1>F12-Profiler</h1>
	</div>
	<form action="" method="post" name="f12_profiler_options">
		<div class="row">
			<div class="left">
				<table width="100%">
					<tr>
						<td colspan="2">
							<h2><?php _e( 'Allgemeine Einstellungen', 'f12_profiler' ); ?></h2>
						</td>
					</tr>
					<tr>
						<td>
							<label for="active">
								<?php _e( 'Activate?', 'f12_profiler' ); ?>
							</label>
						</td>
						<td>
							<input type="checkbox" name="active" value="1" id="active" <?php if ( $atts['active'] == 1 ) {
								echo 'checked="checked"';
							} ?>/>
							<span>
						<?php _e( 'Enable / Disable the F12-Profiler plugin', 'f12_profiler' ); ?>
					</span>
						</td>
					</tr>
					<tr>
						<td>
							<label for="page_metrics">
								<?php _e( 'Show Page Resource Metrics?', 'f12_profiler' ); ?>
							</label>
						</td>
						<td>
							<input type="checkbox" name="page_metrics" value="1"
							       id="page_metrics" <?php if ( $atts['page_metrics'] == 1 ) {
								echo 'checked="checked"';
							} ?>/>
							<span>
						<?php _e( 'Enable / Disable Page Resource Metrics', 'f12_profiler' ); ?>
					</span>
						</td>
					</tr>
					<tr>
						<td>
							<label for="hardware_metrics">
								<?php _e( 'Show Hardware Metrics?', 'f12_profiler' ); ?>
							</label>
						</td>
						<td>
							<input type="checkbox" name="hardware_metrics" value="1"
							       id="hardware_metrics" <?php if ( $atts['hardware_metrics'] == 1 ) {
								echo 'checked="checked"';
							} ?>/>
							<span>
						<?php _e( 'Enable / Disable Hardware Metrics', 'f12_profiler' ); ?>
					</span>
							<p>
								<?php _e( 'Important: This functions are in beta and can affect the performance for users logged in within the backend of your system.', 'f12_profiler' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="submit" name="f12_profiler_save" class="button button-primary" value="<?php _e( 'Save', 'f12_profiler' ); ?>"/>
						</td>
					</tr>
				</table>
			</div>
			<div clas="right">
				<div class="tipps">
					<h2>
						<?php _e( 'Tipps', 'f12_profiler' ); ?>
					</h2>
					<ul>
						<li>
							<?php _e( 'You can let the plugin enabled, it will only affect administrators', 'f12_profiler' ); ?>
						</li>
						<li>
							<?php _e( 'The color of the times indicate how they affect your loading time. Red should be optimized.', 'f12_profiler' ); ?>
						</li>
						<li>
							<?php _e( 'Enable the resource metrics to display the loading time of each file.', 'f12_profiler' ); ?>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</form>

	<?php if ( isset( $atts['hardware'] ) ) {
		echo $atts['hardware'];
	} ?>
</div>