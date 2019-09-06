<?php
global $post, $redux_builder_amp;
do_action('ampforwp_above_related_post',$this); //Above Related Posts
$string_number_of_related_posts = $redux_builder_amp['ampforwp-number-of-related-posts'];
$int_number_of_related_posts = (int) $string_number_of_related_posts;

// declaring this variable here to prevent debug errors
$args = null;
$orderby = 'ID';
// declaring this variable for counting number of related post
$r_count = 1;
// Check for the order of related posts
if( isset( $redux_builder_amp['ampforwp-single-order-of-related-posts'] ) && $redux_builder_amp['ampforwp-single-order-of-related-posts'] ){
	$orderby = 'rand';
}
// Custom Post types 
if( $current_post_type = get_post_type( $post )) {
// The query arguments
	if($current_post_type != 'page'){
    $args = array(
        'posts_per_page'=> $int_number_of_related_posts,
        'order' => 'DESC',
        'orderby' => $orderby,
        'post_type' => $current_post_type,
        'post__not_in' => array( $post->ID )
    );  
  } 			
}//end of block for custom Post types
// code block for categories
if($redux_builder_amp['ampforwp-single-select-type-of-related']==2) {
	$categories = get_the_category($post->ID);
	if ($categories) {
			$category_ids = array();
			foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
			$args=array(
					'category__in' 		 => $category_ids,
					'post__not_in' 		 => array($post->ID),
					'posts_per_page'	 => $int_number_of_related_posts,
					'ignore_sticky_posts'=> 1,
					'has_password'		 => false ,
					'post_status'  		 => 'publish',
					'orderby'      		 => $orderby
			);
	}
} //end of block for categories

//code block for tags
if($redux_builder_amp['ampforwp-single-select-type-of-related']==1) {
	$ampforwp_tags = get_the_tags($post->ID);
	if ($ampforwp_tags) {
			$tag_ids = array();
			foreach($ampforwp_tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
			$args=array(
			 	'tag__in' 		 	 => $tag_ids,
				'post__not_in' 	 	 => array($post->ID),
				'posts_per_page' 	 => $int_number_of_related_posts,
				'ignore_sticky_posts'=> 1,
				'has_password' 		 => false ,
				'post_status'		 => 'publish',
				'orderby'    		 => $orderby,
				'no_found_rows'		 => true
			);
	}
}//end of block for tags
// Related Posts Based on Past few Days #2132
if ( isset($redux_builder_amp['ampforwp-related-posts-days-switch']) && true == $redux_builder_amp['ampforwp-related-posts-days-switch'] ) {
	$date_range = strtotime ( '-' . $redux_builder_amp['ampforwp-related-posts-days-text'] .' day' );
	$args['date_query'] = array(
				            array(
				                'after' => array(
				                    'year'  => date('Y', $date_range ),
				                    'month' => date('m', $date_range ),
				                    'day'   => date('d', $date_range ),
				                	),
				            	)
				       		); 
}
if( isset($redux_builder_amp['ampforwp-single-related-posts-switch']) && $redux_builder_amp['ampforwp-single-related-posts-switch'] && $redux_builder_amp['ampforwp-single-select-type-of-related'] ){
	$my_query = new wp_query( $args );
	if( $my_query->have_posts() ) { ?>
		<div class="amp-wp-content relatedpost">
		    <div class="related_posts">
		    	<span><?php echo esc_attr(ampforwp_translation( $redux_builder_amp['amp-translator-related-text'], 'Related Post' )); ?></span>
				<ol class="clearfix">
					<?php
			    	while( $my_query->have_posts() ) {
					    $my_query->the_post();				
						$related_post_permalink = ampforwp_url_controller( get_permalink() );
						if ( ampforwp_get_setting('ampforwp-single-related-posts-link') ) {
							$related_post_permalink = get_permalink();
						}
							  ?> 
						<li class="<?php if ( ampforwp_has_post_thumbnail() ) { echo'has_related_thumbnail'; } else { echo 'no_related_thumbnail'; } ?>">
							<?php if ( ampforwp_has_post_thumbnail() ) {
								if ( true == $redux_builder_amp['ampforwp-single-related-posts-image'] ) {
									$width = 150;
									$height = 150;
									$image_args = array("tag"=>'div','image_size'=>'full','image_crop'=>'true','image_crop_width'=>$width,'image_crop_height'=>$height,'responsive'=> 'true' );
									amp_loop_image($image_args);
								} 
							}?>
			                <div class="related_link">
			                    <?php $title = get_the_title(); ?>
			                    <a href="<?php echo esc_url( $related_post_permalink ); ?>" title="<?php echo esc_html( $title ); ?>" ><?php the_title(); ?></a>
			                    <?php
				                    if ( isset($redux_builder_amp['ampforwp-single-related-posts-excerpt']) && true == $redux_builder_amp['ampforwp-single-related-posts-excerpt'] ) {
										if(has_excerpt()){
											$content = get_the_excerpt();
										}else{
											$content = get_the_content();
										} ?> 
			                    		<p><?php echo wp_trim_words( strip_shortcodes( $content ) , 15 ); ?></p>
			                    	<?php } ?>
			                </div>
			            </li>
							<?php
							do_action('ampforwp_between_related_post',$r_count,$this);
     							 $r_count++;
					} ?>
				</ol>
			</div>
		</div> <?php
	}
}
		wp_reset_postdata();
?>
<?php do_action('ampforwp_below_related_post',$this);