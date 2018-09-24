<?php

	/**
	 * Conditional Options
	 */
	$conditional_options = $this->CTRL->admin->criticalcss->get_default_conditional_options();

?>
<script>
window.conditional_options = <?php print json_encode($conditional_options,true); ?>;
</script>
<li>

	<h3 style="padding:0px;margin:0px;margin-top:1em;margin-bottom:10px;">Conditional Critical Path CSS</h3>

	<p class="description" style="margin-bottom:0px;"><?php _e('Configure tailored critical path CSS for individual posts, pages, post types, categories or templates.', 'abovethefold'); ?></p>

	<p style="margin-top:1em;margin-bottom:1em;">
		<button type="button" id="addcriticalcss" class="button" style="margin-right:0.5em;">Add Conditional Critical CSS</button>
		</p>

		<div id="addcriticalcss-form" class="edit-conditional-critical-css" style="background:#f1f1f1;border:solid 1px #e5e5e5;margin-bottom:1em;display:none;">

			<h3 class="hndle" style="border-bottom:solid 1px #e5e5e5;"><span>Add Conditional Critical CSS</span></h3>

			<div class="inside" style="padding-bottom:0px;">
				<table class="form-table add-form" style="margin-bottom:5px;">
					<tr valign="top">
						<td>
							<input type="text" name="" id="addcc_name" value="" placeholder="Name" style="width:100%;" />
						</td>
					</tr>
					<tr valign="top">
						<td>
							<input type="text" id="addcc_conditions" rel="selectize" />
							<p class="description">Type <code>filter:your_filter_function</code> to add a custom filter condition. You can add a comma separated list with JSON encoded values to be passed to the filter by appending <code>:1,2,3,"variable","var"</code>. The filter function should return true or false.</p>
						</td>
					</tr>
				</table>
				<button type="button" class="button button-yellow button-small" id="addcc_save"><?php _e('Save'); ?></button>

				<div style="height:10px;clear:both;overflow:hidden;font-size:1px;">&nbsp;</div>
			</div>

		</div>
</li>
<?php 

	foreach ($criticalcss_files as $file => $config) {

		if ($file === 'global.css') {
			continue 1;
		}

		// critical CSS
		$inlinecss = $this->CTRL->criticalcss->get_file_contents($config['file']);

		// conditions
		$conditions = (isset($config['conditions'])) ? $this->CTRL->admin->criticalcss->get_condition_values($config['conditions']) : array();

		$condition_values = array();
		foreach ($conditions as $condition) {
			$condition_values[] = $condition['value'];
		}

		$condition_values = implode('|==abtf==|',$condition_values);

?>
	<li class="menu-item menu-item-depth-0 menu-item-page pending" style="display: list-item; position: relative; top: 0px;">
		<div class="menu-item-bar criticalcss-edit-header" rel="<?php print htmlentities(md5($file),ENT_COMPAT,'utf-8'); ?>" data-file="<?php print htmlentities($file,ENT_COMPAT,'utf-8'); ?>">
			<div class="menu-item-handle" style="width:auto!important;cursor: pointer;">
				<span class="item-title" title="<?php print str_replace(home_url(),'',$this->CTRL->theme_dir( '', 'critical-css' ) . htmlentities($file,ENT_COMPAT,'utf-8')); ?>">
					<span class="menu-item-title"><?php print htmlentities($config['name'],ENT_COMPAT,'utf-8'); ?></span> 
					<span class="is-submenu" ><?php if (trim($inlinecss) !== '') { print '<span>'.size_format(strlen($inlinecss),2).'</span>'; } else { print '<span style="color:#f1b70a;">empty</span>';} ?> <span style="float:right;">Weight: <?php if (isset($config['weight'])) { print $config['weight']; } else { print '1'; } ?></span></span>
					<span class="is-submenu loading-editor" style="display:none;">
						<span style="color:#ea4335;">Loading editor...</span>
					</span>
				</span>
				<span class="item-controls">
					<a class="item-delete button button-small button-del" title="Delete conditional Critical CSS" href="javascript:void(0);" data-confirm="<?php echo htmlentities(__('Are you sure you want to delete this conditional Critical CSS?', 'abovethefold'),ENT_COMPAT,'utf-8'); ?>">&#x2717;</a>
					<a class="item-edit" href="javascript:void(0);">^</a>
				</span>
			</div>
		</div>

		<div id="ccss_editor_<?php print htmlentities(md5($file),ENT_COMPAT,'utf-8'); ?>" class="ccss_editor" style="display:none;">
			<textarea class="abtfcss" name="abovethefold[conditional_css][<?php print htmlentities($file,ENT_COMPAT,'utf-8'); ?>][css]"><?php echo htmlentities($inlinecss,ENT_COMPAT,'utf-8'); ?></textarea>
			<div class="conditions edit-conditional-critical-css">
				
				<table cellspacing="0" cellpadding="0" border="0" style="margin-bottom:5px;margin-top:0px;">
					<tr>
						<td style="padding:0px;padding-right:10px;">
							<div class="criticalcss-buttons">
								<a href="https://www.google.com/search?q=beautify+css+online&amp;hl=<?php print $lgcode;?>" target="_blank" class="button button-secondary button-small">Beautify</a>
								<a href="https://www.google.com/search?q=minify+css+online&amp;hl=<?php print $lgcode;?>" target="_blank" class="button button-secondary button-small">Minify</a>
								<a href="https://jigsaw.w3.org/css-validator/#validate_by_input+with_options" target="_blank" class="button button-secondary button-small">Validate</a>
								<a href="http://csslint.net/#utm_source=wordpress&amp;utm_medium=plugin&amp;utm_term=optimization&amp;utm_campaign=PageSpeed.pro%3A%20Above%20The%20Fold%20Optimization" target="_blank" class="button button-secondary button-small">CSS<span style="color:#768c1c;font-weight:bold;margin-left:1px;">LINT</span></a>
							</div>
						</td>
						<td style="padding:0px;padding-right:10px;">
							<label><input type="checkbox" name="abovethefold[conditional_css][<?php print htmlentities($file,ENT_COMPAT,'utf-8'); ?>][appendToAny]" value="1" <?php if (isset($config['appendToAny'])) { print ' checked="checked"'; } ?> /> Append to any</label>
						</td>
						<td style="padding:0px;padding-right:10px;">
							<label><input type="checkbox" name="abovethefold[conditional_css][<?php print htmlentities($file,ENT_COMPAT,'utf-8'); ?>][prependToAny]" value="1" <?php if (isset($config['prependToAny'])) { print ' checked="checked"'; } ?> /> Prepend to any</label>
						</td>
						<td style="padding:0px;padding-right:10px;">
							Weight: <input type="number" size="3" min="1" style="width:50px;" name="abovethefold[conditional_css][<?php print htmlentities($file,ENT_COMPAT,'utf-8'); ?>][weight]" value="<?php print (isset($config['weight']) ? intval($config['weight']) : '1'); ?>" placeholder="..." />
							&nbsp;(higher weight is selected over lower weight conditions)
						</td>
					</tr>	
				</table>
				<input type="text" name="abovethefold[conditional_css][<?php print htmlentities($file,ENT_COMPAT,'utf-8'); ?>][conditions]" rel="conditions" multiple="multiple" data-conditions="<?php print htmlentities(json_encode($conditions,true),ENT_COMPAT,'utf-8'); ?>" value="<?php print htmlentities($condition_values,ENT_COMPAT,'utf-8'); ?>" />
				
				<div style="margin-top:5px;margin-bottom:0px;">
					The configuration is stored in <code><?php print str_replace(home_url(),'',$this->CTRL->theme_dir( '', 'critical-css' ) . '<strong>' . htmlentities($file,ENT_COMPAT,'utf-8')); ?></strong></code> and is editable via FTP. 
					<p style="margin-top:7px;margin-bottom:0px;">You can append or prepend relative links to CSS files using <code>@append</code> and <code>@prepend</code>, e.g. <em>../../style.css</em>. Use <code>@matchType</code> (any or all) to match any or all condtions.</p>
				</div>
			</div>
			<div style="height:10px;clear:both;overflow:hidden;font-size:1px;">&nbsp;</div>
		</div>
		<ul class="menu-item-transport"></ul>
	</li>
<?php
	}
?>
	<li>
		<br />
		<?php
			submit_button( __( 'Save' ), 'primary large', 'is_submit', false );
		?>
	</li>
