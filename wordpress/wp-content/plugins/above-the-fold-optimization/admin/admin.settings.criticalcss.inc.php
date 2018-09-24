<li class="menu-item menu-item-depth-0 menu-item-page pending menu-item-edit-inactive" style="display: list-item; position: relative; top: 0px;">
<?php

    // get critical css files
    $criticalcss_files = $this->CTRL->criticalcss->get_theme_criticalcss();
    
    //global critical CSS
    $inlinecss = (isset($criticalcss_files['global.css'])) ? $this->CTRL->criticalcss->get_file_contents($criticalcss_files['global.css']['file']) : '';
?>
	<div class="menu-item-bar criticalcss-edit-header" rel="global">
		<div class="menu-item-handle" style="width:auto!important;cursor: pointer;">
			<span class="item-title">
				<span class="menu-item-title">Global</span>
				<span class="is-submenu" ><?php if (trim($inlinecss) !== '') {
    print '<span>'.size_format(strlen($inlinecss), 2).'</span>';
} else {
    print '<span style="color:#f1b70a;">empty</span>';
} ?>
				</span>
				<span class="is-submenu loading-editor" style="display:none;">
					<span style="color:#ea4335;">Loading editor...</span>
				</span>
			</span>
			<span class="item-controls">
				<a class="item-edit" href="javascript:void(0);">^</a>
			</span>
		</div>
	</div>

	<div id="ccss_editor_global" class="ccss_editor">
		<textarea class="abtfcss" id="abtfcss"<?php if (!isset($options['csseditor']) || intval($options['csseditor']) === 1) {
    print 'data-advanced="1"';
} ?> name="abovethefold[css]"><?php echo htmlentities($inlinecss, ENT_COMPAT, 'utf-8'); ?></textarea>

		<!-- .menu-item-settings-->
	
		<div class="criticalcss-buttons">
		<a href="https://www.google.com/search?q=beautify+css+online&amp;hl=<?php print $lgcode;?>" target="_blank" class="button button-secondary button-small">Beautify</a>
		<a href="https://www.google.com/search?q=minify+css+online&amp;hl=<?php print $lgcode;?>" target="_blank" class="button button-secondary button-small">Minify</a>
		<a href="https://jigsaw.w3.org/css-validator/#validate_by_input+with_options" target="_blank" class="button button-secondary button-small">Validate</a>
		<a href="http://csslint.net/#utm_source=wordpress&amp;utm_medium=plugin&amp;utm_term=optimization&amp;utm_campaign=PageSpeed.pro%3A%20Above%20The%20Fold%20Optimization" target="_blank" class="button button-secondary button-small">CSS<span style="color:#768c1c;font-weight:bold;margin-left:1px;">LINT</span></a>
		</div>
		<div class="criticalcss-editorswitch">
			<label><input type="checkbox" name="abovethefold[csseditor]" value="1"<?php if (!isset($options['csseditor']) || intval($options['csseditor']) === 1) {
    print ' checked=""';
} ?>> Use a CSS editor with error reporting (<a href="http://csslint.net/#utm_source=wordpress&amp;utm_medium=plugin&amp;utm_term=optimization&amp;utm_campaign=PageSpeed.pro%3A%20Above%20The%20Fold%20Optimization" target="_blank">CSS Lint</a> using <a href="https://codemirror.net/#utm_source=wordpress&amp;utm_medium=plugin&amp;utm_term=optimization&amp;utm_campaign=PageSpeed.pro%3A%20Above%20The%20Fold%20Optimization" target="_blank">CodeMirror</a>).</label>
		</div>

		<div style="clear:both;height:1px;overflow:hidden;font-size:1px;">&nbsp;</div>

		<ul class="menu-item-transport"></ul>

		<div style="margin-top:1em;">
			<label><input type="checkbox" name="abovethefold[http2_push_criticalcss]" value="1" onclick="if (jQuery(this).is(':checked')) { jQuery('#http2pushnote').show(); } else { jQuery('#http2pushnote').hide(); }"<?php if (isset($options['http2_push_criticalcss']) && intval($options['http2_push_criticalcss']) === 1) {
    print ' checked';
} ?>> Push Critical CSS using HTTP/2 Server Push
</label>
			<p class="description" style="margin-bottom:1em;">When enabled, the critical CSS is not inlined but instead pushed together with the HTML (<a href="https://developers.google.com/web/fundamentals/performance/http2/#server_push" target="_blank">documentation</a>). </p>
			
			<p class="info_yellow" id="http2pushnote" style="margin-bottom:1em;<?php echo ((isset($options['http2_push_criticalcss']) && intval($options['http2_push_criticalcss']) === 1)) ? '' : 'display:none;'; ?>"><strong>Note:</strong> When using this feature, make sure that your server supports HTTP/2 Server Push. See the <a href="<?php echo add_query_arg(array('page'=>'pagespeed-http2'), admin_url('admin.php'));?>">HTTP/2-tab</a> for more information.</p>
		</div>
		
		<hr />
		<?php
            submit_button(__('Save'), 'primary large', 'is_submit', false);
        ?><a name="conditional">&nbsp;</a>

	</div>
</li>