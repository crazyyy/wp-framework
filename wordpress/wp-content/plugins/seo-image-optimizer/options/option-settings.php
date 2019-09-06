<?php $wl_wsio_options = weblizar_wsio_get_options();?>
<div class="col-xs-8 tab-content" id="spa_general"> <!-- plugin dashboard Main class div setting -->
	<div class="tab-pane col-md-12 block ui-tabs-panel active" id="general-option"> <!-- plugin template selection setting -->	
		<div class="col-md-9 option">		
			<h1><?php _e('Images Alt and Title Override Options', WSIO_TEXT_DOMAIN );?></h1>
			<div class="tab-content">             
				<form method="post" id="weblizar_wsio_section_general">
					<div class="col-md-12 form-group">
						<div class="col-md-12 no-pad">
							<div class="col-md-6 no-pad">
								<label><?php _e('Override Existing Title', WSIO_TEXT_DOMAIN );?></label>
								<p class=""><?php _e('Do you want to Over Ride existing title tags?', WSIO_TEXT_DOMAIN ) ?></p>
								<br/><br/>
							</div>
							<div class="col-md-6 no-pad">
								<input data-toggle="toggle" data-offstyle="off" type="checkbox" <?php if($wl_wsio_options['wsio_override_title_value']=='on') echo "checked='checked'"; ?> id="wsio_override_title_value" name="wsio_override_title_value">
							</div>
						</div>
						<div class="col-md-6 no-pad">
						<label><?php _e('Title Value', WSIO_TEXT_DOMAIN );?></label>
							<div class="col-md-12 no-pad">
								<p class=""><?php _e('The Title Tag will be dynamically replaced by the above value.',  WSIO_TEXT_DOMAIN ) ?></p>
								<p class=""><?php _e('You can managed by enable and disable the tag selection option',  WSIO_TEXT_DOMAIN ) ?></p>
							</div>
						</div>
						<div class="col-md-6 no-pad">
							<select id='wsio_title_tag_value' name="wsio_title_tag_value[]" multiple ="multiple" class="form-control">
							<?php $title_tag_value = array('%site_name','%name','%title','%category','%tags'); 
								if (is_array($title_tag_value)) { foreach($title_tag_value as $title_tag) { ?><option value="<?php echo $title_tag; ?>" <?php if (is_array($wl_wsio_options['wsio_title_tag_value'])) { foreach($wl_wsio_options['wsio_title_tag_value'] as $selected_list)
							{if($selected_list == $title_tag) echo 'selected="selected"';}} ?>><?php _e( $title_tag,'CSMM_TEXT_DOMAIN');?></option>
								<?php } }?>
							</select>
							<br/>
							<blockquote><b><?php _e('<b>%Site Name - It will insert Site Name.</b><br> <b>%Image Name - It will insert Image Name.</b><br> <b>%Post Title - It will insert Post Title.</b><br> <b>%Post Category - It will insert Post Categories.</b><br> <b>%Post Tag - It will insert Post Tag.</b>',  WSIO_TEXT_DOMAIN ) ?>
							<br/></blockquote>
						</div>
						<div class="col-md-12 no-pad">
						<br/>
							<div class="col-md-6 no-pad">
								<label><?php _e('Custom Title Value', WSIO_TEXT_DOMAIN );?></label>
								<p class=""><?php _e('Do you want to Over Ride existing Title with custom values?', WSIO_TEXT_DOMAIN ) ?></p>
								<br/><br/>
							</div>
							<div class="col-md-6 no-pad">
								<input placeholder="Add custom title value" class="form-control" type="text" value="" id="wsio_override_title_custom_value" name="wsio_override_title_custom_value">
							</div>
						</div>
					</div>
					<div class="col-md-12 form-group">
						<div class="col-md-12 no-pad">
							<div class="col-md-6 no-pad">
								<label><?php _e('Override Existing Alt Attribute', WSIO_TEXT_DOMAIN );?></label>
								<p class=""><?php _e('Do you want to Over Ride existing alt tags?', WSIO_TEXT_DOMAIN ) ?></p>
								<br/><br/>
							</div>
							<div class="col-md-6 no-pad">
								<input data-toggle="toggle" data-offstyle="off" type="checkbox" <?php if($wl_wsio_options['wsio_override_alt_value']=='on') echo "checked='checked'"; ?> id="wsio_override_alt_value" name="wsio_override_alt_value" >
							</div>
						</div>
						<div class="col-md-6 no-pad">
						<label><?php _e('Alt Attribute Value', WSIO_TEXT_DOMAIN );?></label>
							<div class="col-md-12 no-pad">
								<p class=""><?php _e('The Alt attributes will be dynamically replaced by the above value.',  WSIO_TEXT_DOMAIN ) ?></p>
								<p class=""><?php _e('You can managed by select option and enable/disable the tag attributes from output',  WSIO_TEXT_DOMAIN ) ?></p>
								<br/><br/>
							</div>
						</div>
						<div class="col-md-6 no-pad">
							<select id='wsio_alt_attribute_value' name="wsio_alt_attribute_value[]" multiple ="multiple" class="form-control">
							<?php $alt_attribute_value = array('%site_name','%name','%title','%category','%tags'); 
								if (is_array($alt_attribute_value)) { foreach($alt_attribute_value as $alt_attribute) { ?>																			
								<option value="<?php echo $alt_attribute; ?>" <?php if (is_array($wl_wsio_options['wsio_alt_attribute_value'])) { foreach($wl_wsio_options['wsio_alt_attribute_value'] as $selected_list)
							{if($selected_list == $alt_attribute) echo 'selected="selected"';}} ?>><?php _e( $alt_attribute,'CSMM_TEXT_DOMAIN');?></option>
								<?php } }?>
							</select>
							<br/>
							<blockquote><b><?php _e('<b>%Site Name - It will insert Site Name.</b><br> <b>%Image Name - It will insert Image Name.</b><br> <b>%Post Title - It will insert Post Title.</b><br> <b>%Post Category - It will insert Post Categories.</b><br> <b>%Post Tag - It will insert Post Tag.</b>',  WSIO_TEXT_DOMAIN ) ?>
							</b></blockquote>
						</div>
						<div class="col-md-12 no-pad">
							<br/>
							<div class="col-md-6 no-pad">
								<label><?php _e('Custom Alt Attribute', WSIO_TEXT_DOMAIN );?></label>
								<p class=""><?php _e('Do you want to Over Ride existing alt with custom tags?', WSIO_TEXT_DOMAIN ) ?></p>
								<br/><br/>
							</div>
							<div class="col-md-6 no-pad">
								<input placeholder="Add custom alt value" class="form-control" type="text" id="wsio_override_alt_custom_value" name="wsio_override_alt_custom_value">
							</div>
						</div>
					</div>
					<div class="restore">
						<input type="hidden" value="1" id="weblizar_wsio_settings_save_section_general" name="weblizar_wsio_settings_save_section_general" />
						<input class="button left" type="button" name="reset" value="<?php _e('Restore Defaults', WSIO_TEXT_DOMAIN );?>" onclick="weblizar_wsio_option_data_reset('section_general');">
						<input class="button button-primary left" type="button" value="<?php _e('Save Options', WSIO_TEXT_DOMAIN );?>" onclick="weblizar_wsio_option_data_save('section_general')" >
					</div>
				</form>
			</div>
		</div>
		<div class="col-md-3">			
			<div class="update_pro_button"><a target="_blank" href="https://weblizar.com/plugins/seo-image-optimizer-pro/" ><?php _e('Buy Now $11', WSIO_TEXT_DOMAIN ); ?></a></div> 
			<div class="update_pro_image">
				<img class="wsio_getpro" src="<?php echo plugin_dir_url( __FILE__ ).'images/wsio.jpg'; ?>">
			</div>
			<div class="update_pro_button"><a target="_blank" href="https://weblizar.com/plugins/seo-image-optimizer-pro/" ><?php _e('Buy Now $11', WSIO_TEXT_DOMAIN ); ?></a></div>
		</div>
	</div>

	<div class="tab-pane col-md-12 block ui-tabs-panel deactive" id="image-size-option">		
		<div class="col-md-9 option">
			<h1><?php _e('Images Re-sizing and Compression Options', WSIO_TEXT_DOMAIN );?></h1>
			<div class="tab-content">
				<form method="post" id="weblizar_wsio_image_size_option">
					<div class="col-md-12 form-group">
						<div class="col-md-12 no-pad">
							<label><?php _e('Re-sizing options', WSIO_TEXT_DOMAIN );?></label>
							<p style="max-width:700px"><?php _e('The following settings will apply to only when image uploaded.', WSIO_TEXT_DOMAIN );?></p>
							<br/>
							<div class="col-md-12 no-pad">
								<div class="col-md-4 no-pad">
									<label><?php _e('Enable re-sizing', WSIO_TEXT_DOMAIN );?></label>
								</div>
								<div class="col-md-8 no-pad">
									<input data-toggle="toggle" data-offstyle="off" type="checkbox" <?php if($wl_wsio_options['wsio_image_resize_yesno']=='on') echo "checked='checked'"; ?> id="wsio_image_resize_yesno" name="wsio_image_resize_yesno" >
								</div>								
							</div>
							<br/><br/>
						</div>
						
						<div class="col-md-12 no-pad">
							<div class="col-md-12 no-pad">
								<div class="col-md-4 no-pad">
									<label><?php _e('Max image dimensions', WSIO_TEXT_DOMAIN );?></label>
								</div>
								<div class="col-md-8 no-pad">
									<fieldset><legend class="screen-reader-text"><span><?php _e('Maximum width and height', WSIO_TEXT_DOMAIN );?></span></legend>
										<label><?php _e('Max width : ', WSIO_TEXT_DOMAIN );?></label>
										<input style="margin-right: 10px; display: initial; width: 15%;" class="form-control" name="wsio_image_width" id="wsio_image_width" type="text" value="<?php echo $wl_wsio_options['wsio_image_width']; ?>">
										<label><?php _e('Max height : ', WSIO_TEXT_DOMAIN );?></label>
										<input style="display: initial; width: 15%;" class="form-control" name="wsio_image_height" id="wsio_image_height" type="text" value="<?php echo $wl_wsio_options['wsio_image_height']; ?>">
									</fieldset>
									<br/>
									<blockquote><?php _e('<b>Note :</b> Set to zero or very high value to prevent resizing in that dimension.<br /><b>Recommended values: <code>1200</code></b>', WSIO_TEXT_DOMAIN );?></blockquote>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-12 form-group">
						<label><?php _e('Compression options', WSIO_TEXT_DOMAIN );?></label>
						<p style="max-width:700px"><?php _e('The following settings will apply to only when image uploaded.', WSIO_TEXT_DOMAIN );?></p>
						<br/>
						<div class="col-md-12 no-pad">
							<div class="col-md-4 no-pad">
								<label><?php _e('Force Image re-compression', WSIO_TEXT_DOMAIN );?></label>
							</div>
							<div class="col-md-8 no-pad">
								<?php $wsio_recompress_yesno =$wl_wsio_options['wsio_image_recompress_yesno'];?>
								<select class="form-control" name="wsio_image_recompress_yesno" id="wsio_image_recompress_yesno">
									<option value="off" <?php echo selected($wsio_recompress_yesno, 'off' ); ?> ><?php _e('NO - only re-compress the images if option selected','CSMM_TEXT_DOMAIN'); ?></option>
									<option value="on" <?php echo selected($wsio_recompress_yesno, 'on' ); ?> ><?php _e('YES - re-compress all uploaded images','CSMM_TEXT_DOMAIN'); ?></option>
								</select>
							</div>
							<br/><br/><br/>						
						</div>
						<div class="col-md-12 no-pad">
							<div class="col-md-12 no-pad">
								<div class="col-md-4 no-pad">
									<label><?php _e('Image compression level', WSIO_TEXT_DOMAIN );?></label>
								</div>
								<div class="col-md-8 no-pad">
									<?php $wsio_quality =$wl_wsio_options['wsio_image_quality'];?>
									<input class="form-control hc_range wsio-img-qual" name="wsio-img-comp" id="wsio-img-comp" type="range" step="1" min="1" max="100" value="<?php echo $wl_wsio_options['wsio_image_quality']; ?>" data-rangeSlider>
									<input type="text" class="form-control hc_text" name="wsio_image_quality" value="<?php echo $wl_wsio_options['wsio_image_quality']; ?>" id="wsio_image_quality" readonly >
									<p style="margin:5px 0px;"><b style="margin-left: 5px; font-size: 15px;"><?php _e('%', WSIO_TEXT_DOMAIN );?></b></p>
									<br/>
									<blockquote><b><?php _e('<code>1</code> = low quality (smallest files)<br><code>100</code> = best quality (largest files)<br><code>90 </code> = Recommended value', WSIO_TEXT_DOMAIN );?></b></blockquote>
								</div>
							</div>
						</div>					
					</div>
					 <script>
	                    var slider = document.getElementById("wsio-img-comp");
	                    var output = document.getElementById("wsio-range-val");

	                    var x = slider.value;
	                    var y = x / 1000;
	                    output.innerHTML = y;

	                    slider.oninput = function () {
	                        var x = slider.value;
	                        var y = x / 1000;
	                        output.innerHTML = y;
	                    }
	                </script>
					<div class="restore">
						<input type="hidden" value="1" id="weblizar_wsio_settings_save_image_size_option" name="weblizar_wsio_settings_save_image_size_option" />
						<input class="button left" type="button" name="reset" value="<?php _e('Restore Defaults', WSIO_TEXT_DOMAIN );?>" onclick="weblizar_wsio_option_data_reset('image_size_option');">
						<input class="button button-primary left" type="button" value="<?php _e('Save Options', WSIO_TEXT_DOMAIN );?>" onclick="weblizar_wsio_option_data_save('image_size_option')" >
					</div>
				</form>
			</div>
		</div>
		<div class="col-md-3">			
			<div class="update_pro_button"><a target="_blank" href="https://weblizar.com/plugins/seo-image-optimizer-pro/" ><?php _e('Buy Now $11', WSIO_TEXT_DOMAIN ); ?></a></div> 
			<div class="update_pro_image">
				<img class="wsio_getpro" src="<?php echo plugin_dir_url( __FILE__ ).'images/wsio.jpg'; ?>">
			</div>
			<div class="update_pro_button"><a target="_blank" href="https://weblizar.com/plugins/seo-image-optimizer-pro/" ><?php _e('Buy Now $11', WSIO_TEXT_DOMAIN ); ?></a></div>
		</div>
	</div>	
	<div class="tab-pane col-md-12 block ui-tabs-panel deactive" id="how-work-option">
		<div class="col-md-9 option">
			<div class="tab-content">
				<div class="col-md-12 form-group">
					<label><?php _e('How Does it Work?', WSIO_TEXT_DOMAIN ); ?></label>				
					<ul><li><?php _e('1. The plugin dynamically replaces the alt tags with the pattern specified by you. It makes no changes to the database.', WSIO_TEXT_DOMAIN );?></li>
					<li><?php _e('2. Since there are no changes to the database, one can have different alt tags for same images on different pages / posts.', WSIO_TEXT_DOMAIN );?></li>
					<li><?php _e("3. <b>Site name - </b>The name of the site that is setted up on Wordpress settings",WSIO_TEXT_DOMAIN);?></li>
					<li><?php _e("4. <b>Image name - </b>The title of the image that whas uploaded. <b>( To avoid duplicate names, it's highly recommended always use this option. )</b>",WSIO_TEXT_DOMAIN);?></li>
					<li><?php _e("5. <b>Post title - </b>The title given to your post.",WSIO_TEXT_DOMAIN);?></li>
					<li><?php _e("6. <b>Post category - </b>The name of the category that the post belongs to", WSIO_TEXT_DOMAIN );?></li>
					</ul>
					<blockquote><b><?php _e('<b>%Site Name - It will insert Site Name.</b><br> <b>%Image Name - It will insert Image Name.</b><br> <b>%Post Title - It will insert Post Title.</b><br> <b>%Post Category - It will insert Post Categories.</b><br> <b>%Post Tag - It will insert Post Tag.</b>',  WSIO_TEXT_DOMAIN ) ?>
					<br/></blockquote>
				</div>
				<div class="col-md-12 form-group">
					<label><?php _e('Why Optimize Alt Tags',WSIO_TEXT_DOMAIN);?></label>				
					<ul><li><?php _e('1. According to <a target = "_blank" href = "http://googlewebmastercentral.blogspot.in/2007/12/using-alt-attributes-smartly.html">this post </a> on the Google Webmaster Blog, Google tends to focus on the information in the ALT text. Creating a optimized alt tags can bring more traffic from Search Engines',WSIO_TEXT_DOMAIN);?></li>
					<li><?php _e('2. Take note that the plugin does not makes changes to the database. It dynamically replaces the tags at the times of page load.',WSIO_TEXT_DOMAIN);?></li></ul>
				</div>
				<div class="col-md-12 form-group">
					<label><?php _e('Recommended value for image re-size', WSIO_TEXT_DOMAIN );?></label>	
					<ul><li><?php _e('1. <b>Image dimensions :</b> Set to zero or very high value to prevent resizing in that dimension.', WSIO_TEXT_DOMAIN );?></li>	
					<li><?php _e('2. <b>Recommended values:</b> <code>1200</code>', WSIO_TEXT_DOMAIN );?></li></ul>
				</div>
				<div class="col-md-12 form-group">
					<label><?php _e('Recommended value for image compresstion','naf_TEXT_DOMAIN');?></label>	
					<ul>
					<li><?php _e('1. <b>Smallest files : </b><code>1</code> = low quality (smallest files)', WSIO_TEXT_DOMAIN );?></li>
					<li><?php _e('2. <b>Largest files : </b><code>100</code> = best quality (largest files)', WSIO_TEXT_DOMAIN );?></li>
					<li><?php _e('3. <b>Recommended files : </b><code>90 </code> = Recommended value', WSIO_TEXT_DOMAIN );?></li>
					</ul>
				</div>						
			</div>
		</div>
		<div class="col-md-3">			
			<div class="update_pro_button"><a target="_blank" href="https://weblizar.com/plugins/seo-image-optimizer-pro/" ><?php _e('Buy Now $11', WSIO_TEXT_DOMAIN ); ?></a></div> 
			<div class="update_pro_image">
				<img class="wsio_getpro" src="<?php echo plugin_dir_url( __FILE__ ).'images/wsio.jpg'; ?>">
			</div>
			<div class="update_pro_button"><a target="_blank" href="https://weblizar.com/plugins/seo-image-optimizer-pro/" ><?php _e('Buy Now $11', WSIO_TEXT_DOMAIN ); ?></a></div>
		</div>	
	</div>
	<div class="tab-pane col-md-12 block ui-tabs-panel deactive" id="offers_main_demo">
		<div class="col-md-9 option">
			<h1><?php _e('Our Offers','RCSM_TEXT_DOMAIN');?></h1>
			<div class="tab-content">
				<div id="offers_main" class="tab-pane fade in active">	 <!-- Offers tab -->
					<div class="col-md-12 form-group">
					<?php 
						include('offers.php');?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">			
			<div class="update_pro_button"><a target="_blank" href="https://weblizar.com/plugins/seo-image-optimizer-pro/" ><?php _e('Buy Now $11', WSIO_TEXT_DOMAIN ); ?></a></div> 
			<div class="update_pro_image">
				<img class="wsio_getpro" src="<?php echo plugin_dir_url( __FILE__ ).'images/wsio.jpg'; ?>">
			</div>
			<div class="update_pro_button"><a target="_blank" href="https://weblizar.com/plugins/seo-image-optimizer-pro/" ><?php _e('Buy Now $11', WSIO_TEXT_DOMAIN ); ?></a></div>
		</div>			
	</div>		
</div>