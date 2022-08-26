<h2>
	Hardware
</h2>

<table>
	<tr>
		<td>
			<?php _e( 'CPU', 'f12_profiler' ); ?>
		</td>
		<td>
			<?php echo json_decode( $atts['hardware']['CPU'] )[0]; ?> %
		</td>
	</tr>
	<tr>
		<td>
			<?php _e( 'RAM', 'f12_profiler' ); ?>
		</td>
		<td>
			<?php echo $atts['hardware']['RAM_USAGE'][0]; ?> GB
			(<?php echo json_decode( $atts['hardware']['RAM_PERCENTAGE'] )[0]; ?>%)
			/ <?php echo $atts['hardware']['RAM_TOTAL']; ?> GB
		</td>
	</tr>
	<tr>
		<td>
			<?php _e( 'RAM (PHP)', 'f12_profiler' ); ?>
		</td>
		<td>
			<?php echo json_decode( $atts['hardware']['RAM_PHP'] )[0]; ?> MB
		</td>
	</tr>
</table>

<div class="hardware">
	<div class="cpu">
		<canvas id="canvas_cpu"></canvas>
		<div class="data" style="display:none;">
			<?php
			/**
			 * Output the Hardware CPU Data as a JSON formated string.
			 */
			echo $atts['hardware']['CPU'];
			?>
		</div>
	</div>

	<div class="ram">
		<canvas id="canvas_ram"></canvas>
		<div class="data" style="display:none;">
			<?php
			/**
			 * Output the Hardware RAM Data as a JSON formated string.
			 */
			echo $atts['hardware']['RAM_PERCENTAGE'];
			?>
		</div>
	</div>

	<div class="ram_php">
		<canvas id="canvas_ram_php"></canvas>
		<div class="data" style="display:none;">
			<?php
			/**
			 * Output the Hardware RAM PHP Data as a JSON formated string.
			 */
			echo $atts['hardware']['RAM_PHP'];
			?>
		</div>
	</div>
</div>