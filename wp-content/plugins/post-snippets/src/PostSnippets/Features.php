<?php

namespace PostSnippets;

/**
 * Post Snippets Features.
 *
 *
 * @author   GreenTreeLabs <info at postsnippets dot com>
 * @link     https://www.postsnippets.com
 */

class Features {

	public function showFeatures() {
		$html = '';
		ob_start();
?>
		<div class="wrap">
				<div id="pt-features">
						<div id="pt-features-content">

								<div class="ps_features_wrap">



								</div>

						</div>
						<!-- .pt-features-content -->
				</div>
				<!-- .pt-features -->
		</div><!-- .wrap -->
	<?php

	$html .= ob_get_contents();
	ob_end_clean();

	return $html;
	}
}
