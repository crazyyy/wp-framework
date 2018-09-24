<?php

?><form method="post" action="<?php echo admin_url('admin-post.php?action=abtf_html_update'); ?>" class="clearfix" enctype="multipart/form-data">
	<?php wp_nonce_field('abovethefold'); ?>
	<div class="wrap abovethefold-wrapper">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder">
				<div id="post-body-content">
					<div class="postbox">
						<h3 class="hndle">
							<span><?php _e('HTML Optimization', 'abovethefold'); ?></span>
						</h3>
						<div class="inside testcontent">

							<table class="form-table">
	<tr valign="top">
		<th scope="row">Minify HTML</th>
		<td>
			<label><input type="checkbox" name="abovethefold[html_minify]" value="1"<?php if (isset($options['html_minify']) && intval($options['html_minify']) === 1) {
    print ' checked';
} ?> /> Enabled</label>
			<p class="description">Compress HTML using an enhanced version of <a href="https://github.com/mrclay/minify/blob/master/lib/Minify/HTML.php" target="_blank">HTML.php</a>. This option will reduce the size of HTML but may require a full page cache to maintain an optimal server speed.</p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">Strip HTML comments</th>
		<td>
			<label><input type="checkbox" name="abovethefold[html_comments]" value="1"<?php if (isset($options['html_comments']) && intval($options['html_comments']) === 1) {
    print ' checked';
} ?> /> Enabled</label>
			<p class="description">Remove HTML comments from HTML, e.g. <code>&lt;!-- comment --&gt;</code>.</p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">&nbsp;</th>
		<td style="padding-top:0px;">
			<h5 class="h">&nbsp;Preserve List</h5>
			<textarea class="json-array-lines" name="abovethefold[html_comments_preserve]"><?php if (isset($options['html_comments_preserve'])) {
    echo $this->CTRL->admin->newline_array_string($options['html_comments_preserve']);
} ?></textarea>
			<p class="description">Enter (parts of) HTML comments to exclude from removal. One string per line.</p>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="2" style="padding:0px;">
<?php
submit_button(__('Save'), 'primary large', 'is_submit', false);
?>
		</td>
	</tr>
</table>

<h3 style="margin-bottom:0px;padding-left: 0px;padding-bottom: 0px;">Search &amp; Replace<a name="searchreplace">&nbsp;</a></h3>

<p class="description">This option enables to replace strings in the HTML. Enter an array of JSON objects.</p>
<div id="html_search_replace"><div class="loading-json-editor"><?php print __('Loading JSON editor...', 'pagespeed'); ?></div></div>
<input type="hidden" name="abovethefold[html_search_replace]" id="html_search_replace_src" value="<?php if (isset($options['html_search_replace']) && is_array($options['html_search_replace'])) {
    echo esc_attr(json_encode($options['html_search_replace']));
} ?>"  />

<div class="info_yellow"><strong>Example:</strong> <code id="html_search_replace_example" class="clickselect" data-example-text="show string" title="<?php print esc_attr('Click to select', 'pagespeed'); ?>" style="cursor:copy;">{"search":"string to match","replace":"newstring"}</code> (<a href="javascript:void(0);" data-example="html_search_replace_example" data-example-html="<?php print esc_attr(__('{"search":"|string to (match)|i","replace":"newstring $1","regex":true}', 'pagespeed')); ?>">show regular expression</a>)</div>

<p>You can also add a search and replace configuration using the WordPress filter hook <code>abtf_html_replace</code>.</p>

<div id="wp_html_search_replace_example">
<pre style="padding:10px;border:solid 1px #efefef;">function your_html_search_and_replace( &amp;$search, &amp;$replace, &amp;$search_regex, &amp;$replace_regex ) {

	# regular string replace
	$search[] = 'string';
	$replace[] = '';

	# regex replace
	$search_regex[] = '|regex (string)|i';
	$replace_regex[] = '$1';

	return $search; // required
}

add_filter( 'abtf_html_replace', 'your_html_search_and_replace', 10, 4 );</pre>
</div>
<hr />
<?php
    submit_button(__('Save'), 'primary large', 'is_submit', false);

    ?>


						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</form>
