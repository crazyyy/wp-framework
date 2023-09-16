<!-- START: Post Snippets UI Dialog -->
<?php // Setup the dialog divs ?>
<div class="hidden">
    <div id="post-snippets-dialog" title="Post Snippets">
        <?php // Init the tabs div ?>
        <div id="post-snippets-tabs">

                <?php

                if ( empty($snippets)) {
                    echo sprintf(__('No snippets found, to create them go to &nbsp;&nbsp; %sPost Snippets &rarr;%s', 'post-snippets'), '<a href="'. admin_url( 'admin.php?page=post-snippets-edit') .'" class="button-primary">', '</a>');
                } else {
                    ?>
                <ul>
                    <?php
	                // Create a tab for each available snippet
	                foreach ( $snippets as $key => $snippet ) {
		                ?>
                        <li><a href="#ps-tabs-<?php echo $key;
			                ?>"><?php echo $snippet['snippet_title'];
				                ?></a></li>
		                <?php
	                }
	                ?>
                </ul>
              <?php
                }

            // Create a panel with form fields for each available snippet
            foreach ($snippets as $key => $snippet) {
                ?>
                <div id="ps-tabs-<?php echo $key;
                ?>">
                <?php
                // Print a snippet description is available
                if (isset($snippet['snippet_desc']) && !empty( $snippet['snippet_desc'] ) ) {
                    ?>
                    <p class="howto"><?php echo esc_html__( "Description:","post-snippets" ). "<br/>" . $snippet['snippet_desc'];
                    ?></p>
                <?php

                }
                
                $snippet_vars = PostSnippets\Shortcode::filterVars( $snippet['snippet_vars'] );
                if ( !empty($snippet_vars) ) {
                    foreach ($snippet_vars as $name => $val) {
                        ?>
                        <label for="var_<?php echo $key.'_'.$name;
                        ?>"><?php echo $name;
                        ?>:</label>
                        <input type="text" id="var_<?php echo $key.'_'.$name;
                        ?>" name="var_<?php echo $key.'_'.$name;
                        ?>" value="<?php echo $val;
                        ?>" style="width: 190px" />
                        <br/><br>
                    <?php

                    }
                }
                
                
                else {
                    // If no variables and no description available, output a text
                    // to inform the user that it's an insert snippet only.
                    if (empty($snippet['snippet_desc'])) {
                        ?>
                        <p class="howto"><?php _e('This snippet is insert only, no variables defined.', 'post-snippets');
                        ?></p>
                    <?php

                    }
                }
                ?>
                </div><!-- #ps-tabs-<?php echo $key;
                ?> -->
            <?php

            }
        // Close the tabs and dialog divs ?>
        </div><!-- #post-snippets-tabs -->
    </div><!-- #post-snippets-dialog -->
</div><!-- .hidden -->
<!-- END: Post Snippets UI Dialog -->
