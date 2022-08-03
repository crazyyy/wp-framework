<div style="width:685px;">

	<form id="aDBc_form" action="" method="post">

		<div style="text-align:center;margin-top:10px;padding:8px;background:#f0f5fa"><?php echo  __('Manual correction of the categorization','advanced-database-cleaner'); ?> </div>

		<?php
		// Get the current tab
		$item_type = $_GET['aDBc_tab'];
		// We change tha cron tab name to tasks. No problem with tables and options
		if($item_type == "cron"){
			$item_type = "tasks";
		}

		// Open the file in which the items to edit have been saved
		$aDBc_path_items_manually = @fopen(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/" . $item_type . "_manually_correction_temp.txt", "r");
		if($aDBc_path_items_manually){
			echo "<div style='margin-top:30px'>";
			$items_to_correct_array = array();
			while(($item = fgets($aDBc_path_items_manually)) !== false) {
				if(!empty(trim($item))){
					array_push($items_to_correct_array, trim($item));
					echo "<span class='aDBc-correction-item'>" . $item . "</span>";
				}
			}
			echo "</div>";
			fclose($aDBc_path_items_manually);
		}
		?>

		<div style="background:#ffa5002e;padding:10px;margin-top:30px">

			<div>
				<?php
				if($item_type == "tables"){
					echo  __('The tables above belong to','advanced-database-cleaner');
				}else if($item_type == "options"){
					echo  __('The options above belong to','advanced-database-cleaner');
				}else if($item_type == "tasks"){
					echo  __('The cron tasks above belong to','advanced-database-cleaner');
				}
				?>
			</div>

			<?php
				$plugins_folders_names 	= aDBc_get_plugins_folder_names();
				$themes_folders_names 	= aDBc_get_themes_folder_names();
			?>

			<select name="new_belongs_to" style="font-size:14px;width:250px;height:30px;border:1px solid #ccc;border-radius:2px;margin-top:10px">
				<optgroup label="<?php echo __('Plugins','advanced-database-cleaner') ?>">
					<?php 
						foreach($plugins_folders_names as $plugin){
							echo "<option value='$plugin|p'>" . $plugin . "</option>";
						}
					?>
				</optgroup>
				<optgroup label="<?php echo __('Themes','advanced-database-cleaner') ?>">
					<?php 
						foreach($themes_folders_names as $theme){
							echo "<option value='$theme|t'>" . $theme . "</option>";
						}
					?>
				</optgroup>				
			</select>
		</div>

		<!--<div style="margin-top:15px">
			<div>
				<input type="checkbox" name="aDBc_send_correction_to_server"/>
				<span id="send_manual_correction_to_server">
					<?php //_e("Send this correction to the plugin server? (by sending this correction, you benefit from others' corrections)","advanced-database-cleaner") ?>
				</span>
			</div>-->
			<!-- xxx I should add link to read more -->
			<!--<div style="color:grey;margin-left:25px;">
				<?php //echo __("No sensitive info is sent","advanced-database-cleaner") . " <a href='#'>[" . __("Read more here", "advanced-database-cleaner") . "]</a>"; ?>
			</div>

		</div>-->

		<div class="aDBc-clear-both"></div>

		<div style="margin-top:60px;margin-bottom:100px">
			<span style="padding-left:5px;margin-right:10px">
				<input name="aDBc_correct" style="width:80px;height:30px;" class="button-primary" type="submit" value="<?php _e('Save','advanced-database-cleaner') ?>"/>
			</span>
			<span style="width:60px;padding-left:5px;">
				<input name="aDBc_cancel" style="width:80px;height:30px;" class="button-secondary" type="submit" value="<?php _e('Cancel','advanced-database-cleaner') ?>"/>
			</span>
		</div>

	</form>

</div>