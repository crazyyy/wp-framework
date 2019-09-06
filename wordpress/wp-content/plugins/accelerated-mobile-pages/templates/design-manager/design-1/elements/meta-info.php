<?php do_action('ampforwp_before_meta_info_hook',$this); ?>
<?php global $redux_builder_amp;
if ( is_single() || (is_page() && $redux_builder_amp['meta_page']) ) : ?>
<div class="amp-wp-article-header ampforwp-meta-info <?php if( is_page() && ! $redux_builder_amp['meta_page'] ) {?> hide-meta-info <?php  }?>">

	<?php $post_author = $this->get( 'post_author' ); ?>
	<?php
	if ( $post_author ) : ?>
		<div class="amp-wp-meta amp-wp-byline">
		<?php
			$author_image = get_avatar_url( $post_author->user_email, array( 'size' => 24 ) );
			 if ( function_exists( 'get_avatar_url' ) && ( $author_image ) ) {  
			 if( is_single()) { ?>
				<amp-img <?php if(ampforwp_get_data_consent()){?>data-block-on-consent <?php } ?> src="<?php echo esc_url($author_image); ?>" width="24" height="24" layout="fixed"></amp-img>
				<?php  
				echo ampforwp_get_author_details( $post_author , 'meta-info' );
			  } 
			 if( is_page() && $redux_builder_amp['meta_page'] ) { 	?>
				<amp-img <?php if(ampforwp_get_data_consent()){?>data-block-on-consent <?php } ?> src="<?php echo esc_url($author_image); ?>" width="24" height="24" layout="fixed"></amp-img>
				<?php  
					echo ampforwp_get_author_details( $post_author , 'meta-info' );
				 }
			} ?>
		</div>
	<?php endif; ?>

	<div class="amp-wp-meta amp-wp-posted-on">
		<time datetime="<?php echo esc_attr( date( 'c', $this->get( 'post_publish_timestamp' ) ) ); ?>">
		<?php if( is_single() || ( is_page() && $redux_builder_amp['meta_page'] ) ) {
			global $redux_builder_amp;
			$date = get_the_date( get_option( 'date_format' ));
			if( 2 == $redux_builder_amp['ampforwp-post-date-global'] ){
				$date = get_the_modified_date( get_option( 'date_format' )) . ', ' . get_the_modified_time() ;
			}
			echo esc_attr(apply_filters('ampforwp_modify_post_date', ampforwp_translation($redux_builder_amp['amp-translator-on-text'], 'On') . ' ' . $date ));
			}?>
		</time>
	</div>

</div>
<?php endif; ?>
<?php do_action('ampforwp_after_meta_info_hook',$this);