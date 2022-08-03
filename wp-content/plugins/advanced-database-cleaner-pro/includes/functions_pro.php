<?php

/** Prepare args: current page number, order by, LIMIT, OFFSET...
	$default_order_by contains the default column for ORDER BY
	$search_key is the column name in which we will search if the user choose the first radio in the form
	$search_value is the column name in which we will search if the user choose the second radio in the form
	args by WP: paged, order_by, order, 
	args be aDBc: per_page, s, in
 */
function aDBc_get_search_sql_arg($search_in_key, $search_in_value){

		// Prepare LIKE sql clause
		$search_like = "";
		if(!empty($_GET['s']) && trim($_GET['s']) != ""){
			$search = esc_sql(sanitize_text_field($_GET['s']));
			$in = $search_in_key;
			if(!empty($_GET['in'])){
				$in = ($_GET['in'] == "key") ? $search_in_key : $search_in_value;
			}
			$search_like = " AND $in LIKE '%{$search}%'";
		}

		return $search_like;
}

/***********************************************************************************
* This function filters the array containing results according to users args
***********************************************************************************/
function aDBc_filter_results_in_all_items_array(&$aDBc_all_items, $aDBc_tables_name_to_optimize, $aDBc_tables_name_to_repair){

	if(function_exists('is_multisite') && is_multisite()){

		// Filter according to sites
		if(!empty($_GET['site'])){
			foreach($aDBc_all_items as $item_name => $item_info){
				foreach($item_info['sites'] as $site_id => $site_item_info){
					if($site_id != $_GET['site']){
						unset($aDBc_all_items[$item_name]['sites'][$site_id]);
					}
				}
			}
		}

		// Filter according to search
		if(!empty($_GET['s']) && trim($_GET['s']) != ""){
			$search = esc_sql(sanitize_text_field($_GET['s']));
			foreach($aDBc_all_items as $item_name => $item_info){
				foreach($item_info['sites'] as $site_id => $site_item_info){
					$table_prefix_if_exists = empty($site_item_info['prefix']) ? "" : $site_item_info['prefix'];
					if(strpos($table_prefix_if_exists . $item_name, $search) === false){
						unset($aDBc_all_items[$item_name]['sites'][$site_id]);
					}
				}
			}
		}

		// Filter according to tables types (to optimize, to repair...)
		if(!empty($_GET['t_type']) && $_GET['t_type'] != "all"){
			$type = esc_sql($_GET['t_type']);
			if($type == 'optimize'){
				$array_names = $aDBc_tables_name_to_optimize;
			}else{
				$array_names = $aDBc_tables_name_to_repair;
			}
			foreach($aDBc_all_items as $item_name => $item_info){
				foreach($item_info['sites'] as $site_id => $site_item_info){
					if(!in_array($site_item_info['prefix'] . $item_name, $array_names)){
						unset($aDBc_all_items[$item_name]['sites'][$site_id]);
					}
				}
			}
		}

		// Filter according to autoload
		if(!empty($_GET['autoload']) && $_GET['autoload'] != "all"){
			$autoload_param = esc_sql($_GET['autoload']);
			foreach($aDBc_all_items as $item_name => $item_info){
				foreach($item_info['sites'] as $site_id => $site_item_info){
					if($site_item_info['autoload'] != $autoload_param){
						unset($aDBc_all_items[$item_name]['sites'][$site_id]);
					}
				}
			}
		}

		// Filter according to belongs_to
		if(!empty($_GET['belongs_to']) && $_GET['belongs_to'] != "all"){
			$belongs_to_param = esc_sql($_GET['belongs_to']);
			$names_to_delete = array();
			foreach($aDBc_all_items as $item_name => $item_info){
				$belongs_to_value = explode("(", $item_info['belongs_to'], 2);
				$belongs_to_value = trim($belongs_to_value[0]);
				$belongs_to_value = str_replace(" ", "-", $belongs_to_value);
				if($belongs_to_value != $belongs_to_param){
					array_push($names_to_delete, $item_name);
				}
			}
			// Loop over the names to delete and delete them for the array
			foreach($names_to_delete as $name){
				unset($aDBc_all_items[$name]);
			}
		}
		

	}else{

		// Prepare an array containing names of items to delete
		$names_to_delete = array();

		// Filter according to search parameter
		$filter_on_search = !empty($_GET['s']) && trim($_GET['s']) != "";
		if($filter_on_search){
			$search = esc_sql(sanitize_text_field($_GET['s']));
		}

		// Filter according to tables types (to optimize, to repair...)
		$filter_on_t_type = !empty($_GET['t_type']) && $_GET['t_type'] != "all";
		if($filter_on_t_type){
			$type = esc_sql($_GET['t_type']);
			if($type == "optimize"){
				$array_names = $aDBc_tables_name_to_optimize;
			}else{
				$array_names = $aDBc_tables_name_to_repair;
			}			
		}

		// Filter according to autoload
		$filter_on_autoload = !empty($_GET['autoload']) && $_GET['autoload'] != "all";
		if($filter_on_autoload){
			$autoload_param = esc_sql($_GET['autoload']);
		}
		
		// Filter according to belongs_to
		$filter_on_belongs_to = !empty($_GET['belongs_to']) && $_GET['belongs_to'] != "all";
		if($filter_on_belongs_to){
			$belongs_to_param = esc_sql($_GET['belongs_to']);
		}

		foreach($aDBc_all_items as $item_name => $item_info){

			if($filter_on_search){
				$aDBc_prefix = empty($item_info['sites'][1]['prefix']) ? "" : $item_info['sites'][1]['prefix'];
				if(strpos($aDBc_prefix . $item_name, $search) === false){
					array_push($names_to_delete, $item_name);
				}
			}

			if($filter_on_t_type){
				if(!in_array($item_info['sites'][1]['prefix'] . $item_name, $array_names)){
					array_push($names_to_delete, $item_name);
				}
			}
			
			if($filter_on_autoload){
				if($item_info['sites'][1]['autoload'] != $autoload_param){
					array_push($names_to_delete, $item_name);
				}
			}			

			if($filter_on_belongs_to){
				$belongs_to_value = explode("(", $item_info['belongs_to'], 2);
				$belongs_to_value = trim($belongs_to_value[0]);
				$belongs_to_value = str_replace(" ", "-", $belongs_to_value);
				if($belongs_to_value != $belongs_to_param){
					array_push($names_to_delete, $item_name);
				}
			}			

		}

		// Loop over the names to delete and delete them for the array
		foreach($names_to_delete as $name){
			unset($aDBc_all_items[$name]);
		}

	}

}

// Display progress of scan
function aDBc_get_progress_bar_width(){

	//if(isset($_REQUEST)){

		$progress 		= 0;
		$total_files	= 0;

		if(!isset($_SESSION))
			session_start();

		if(!empty($_SESSION['aDBc_total_items']))
			$total_files 	= $_SESSION['aDBc_total_items'];

		if(!empty($_SESSION['aDBc_progress']))
			$progress 		= $_SESSION['aDBc_progress'];

		$status = array(
			'aDBc_progress' 	=> $progress,
			'aDBc_total_items' 	=> $total_files
		 );

		echo json_encode($status);

	//}

	wp_die();
}

/************************************************************************************
* Searches for any item name in the "$items_to_search_for" in all files of WordPress
************************************************************************************/
function aDBc_new_run_search_for_items(){

	// Step 0, Since scan results will be saved in files, test if 'aDBc_uploads' exists. If no, show error msg and exit
	if(!file_exists(ADBC_UPLOAD_DIR_PATH_TO_ADBC)){
		update_option("aDBc_permission_adbc_folder_needed", "yes");
		return;
	}

	/***************************************************************************************************************************************
	* This function can be called by two different buttons: 
	* (1) The normal scan button, (2) the "Apply" button represented by "#doaction" and "#doaction2"
	* In the case the call comes from (1), we will scan all items from scratch, unless the user selected to scan only "uncategorized" items
	* In case the call comes from (2), we will scan only checked items and append results to the results file
	****************************************************************************************************************************************/

    // The $_REQUEST contains all the data sent via ajax
    if(isset($_REQUEST)){

		// First thing to do, reset progress to always start from 0
		session_start();
		$_SESSION['aDBc_progress'] = 0;
		session_write_close();

		// $items_type is sent by both buttons (normal scan button and "apply" button)
		$items_type = $_REQUEST['aDBc_item_type'];

		/**********************************************************************************************************************
		* Prepare all paths to files that will be used during the process
		***********************************************************************************************************************/
		$path_file_categorization 	= ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/" . $items_type . ".txt";
		$path_file_to_categorize 	= ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/" . $items_type . "_to_categorize.txt";
		$path_file_all_php_files	= ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/all_files_paths.txt";

		// Contains the global list of items we will scan
		global $items_to_search_for;
		$items_to_search_for = array();

		// This global variable is used by the shutdown function when timeout. We send the item type to that function via a global variable
		global $item_type_for_shutdown;
		$item_type_for_shutdown = $items_type;

		// Stores the current line that should be processed in "to_categorize.txt". Default value is 1, unless a timeout has occured
		global $aDBc_item_line;
		$item_line 			= get_option("aDBc_temp_last_item_line_" . $items_type);
		$aDBc_item_line 	= empty($item_line)? 1 : $item_line;

		// Stores the current line that have been reached in "all_files_paths.txt". Default value is 1, unless a timeout has occured
		global $aDBc_file_line;
		$file_line 			= get_option("aDBc_temp_last_file_line_" . $items_type);
		$aDBc_file_line 	= empty($file_line)? 1 : $file_line;

		// Stores the iteration number: either 1 or 2. Default is one, unless a timeout has occured, it maybe 2 at that time
		global $aDBc_iteration;
		// Test if we should load and override the iteration if a timeout has been occured
		$iteration 			= get_option("aDBc_temp_last_iteration_" . $items_type);
		$aDBc_iteration 	= empty($iteration)? 1 : $iteration;

		// Stores if the search has finished or not to be used in shutdown function. When this function is called, always set this to "no"
		global $aDBc_search_has_finished;
		$aDBc_search_has_finished = "no";

		// Create an array that will hundle already categorized items
		$items_already_categorized = array();

		// Save total files found
		$saved_total = get_option("aDBc_temp_total_files_" . $items_type);
		$aDBc_total_files = empty($saved_total) ? 0 : $saved_total;

		/***********************************************************************************************************************
		* This section prepares files to run a new search. If aDBc_temp_last_iteration_ already exists, this means that we have
		* started a search and not finish it yet, just skip this section then
		***********************************************************************************************************************/
		if(empty($iteration)){

			/*-----------------------------------------------------------------------
			Load items that will be scanned
			---------------------------------------------------------------------- */
			// $aDBc_items_to_scan is an array sent only by the "apply" button
			$aDBc_items_to_scan = isset($_REQUEST['aDBc_items_to_scan']) ? $_REQUEST['aDBc_items_to_scan'] : "";

			// $aDBc_scan_type is a string sent only by the "Scan" button. It may be "scan_all" or "scan_uncategorized"
			$aDBc_scan_type 	= isset($_REQUEST['aDBc_scan_type']) ? $_REQUEST['aDBc_scan_type'] : "";

			// If $aDBc_items_to_scan is empty => the call comes from "scan" blue button. Otherwise => from "apply" button
			if(empty($aDBc_items_to_scan)){

				// If the user wants to scan all items or uncategorized ones
				if($aDBc_scan_type == "scan_all" || $aDBc_scan_type == "scan_uncategorized"){

					// First, we prepare an array containing all items
					switch($items_type){
						case 'tasks' :
							$items_to_search_for = aDBc_get_all_scheduled_tasks();
							break;
						case 'options' :
							$items_to_search_for = aDBc_get_all_options();
							break;
						case 'tables' :
							$items_to_search_for = aDBc_get_all_tables();
							break;
					}

					// If the user wants to scan only uncategorized items, then unset categorized ones from the array
					if($aDBc_scan_type == "scan_uncategorized"){

						// Test if results file exists
						if(file_exists($path_file_categorization)){
							// Get all categorized items and unset them
							$results_file = fopen($path_file_categorization, "r");
							while(($item = fgets($results_file)) !== false){
								$item_name = explode(":", trim($item), 2);
								$item_name = str_replace("+=+", ":", $item_name[0]);
								unset($items_to_search_for[$item_name]);
							}
							fclose($results_file);
						}
					}
				}

			}else{

				// Loop over items to scan and add them to the array. Delete duplicated items to prevent adding duplicates in case of MU
				foreach($aDBc_items_to_scan as $item_to_scan){
					$columns = explode("|", trim($item_to_scan));
					$item_name = trim($columns[1]);
					if(!array_key_exists($item_name, $items_to_search_for)){
						$items_to_search_for[$item_name] = array('belongs_to' => '', 'maybe_belongs_to' => '');
					}
				}
			}

			// Get the list of WP core items that are already categorized by default
			if($items_type == "tasks"){
				$aDBc_core_items = aDBc_get_core_tasks();
			}else if($items_type == "options"){
				$aDBc_core_items = aDBc_get_core_options();
			}else if($items_type == "tables"){
				$aDBc_core_items = aDBc_get_core_tables();
			}

			// Get the list of the ADBC core active options names
			$aDBc_my_plugin_core_items = aDBc_get_ADBC_options_and_tasks_names();

			// Delete option of success from database
			delete_option("aDBc_last_search_ok_" . $items_type);

			// Refresh "all_files_paths.txt" containing all wordpress php files paths
			aDBc_refresh_and_create_php_files_paths();

			// Count total files number
			$total_files_urls = fopen($path_file_all_php_files, "r");
			while(($item = fgets($total_files_urls)) !== false){
				$aDBc_total_files++;
			}
			fclose($total_files_urls);

			// To calculate progress of research, we will base on total files x2. Because we have 2 iterations in which we go through all files.
			update_option("aDBc_temp_total_files_" . $items_type, ($aDBc_total_files * 2), "no");
			$aDBc_total_files = $aDBc_total_files * 2;

			// If the user wants to run full scan, delete the results file first. Otheriwse, just append results 
			if($aDBc_scan_type == "scan_all" && file_exists($path_file_categorization)){
				unlink($path_file_categorization);
			}

			// Open the file that will contains scan results. If it does not exist, it will be created
			$myfile_categorization = fopen($path_file_categorization, "a");

			// Create the file named $items_type."to_categorize.txt" containing all $items_type to categorize while searching for orphans. Then fill it
			$myfile_to_categorize = fopen($path_file_to_categorize, "a");

			// Add all items to $myfile_to_categorize + categorize directly in core
			foreach($items_to_search_for as $aDBc_item => $aDBc_info){
				fwrite($myfile_to_categorize, $aDBc_item . "\n");
				// If the item belong to core, categorize it directly
				if(in_array($aDBc_item, $aDBc_core_items)){

					fwrite($myfile_categorization, str_replace(":", "+=+", $aDBc_item) . ":w:w" . "\n");
					array_push($items_already_categorized, $aDBc_item);
					// We fill belongs to to prevent processing this item later since it is already categorized
					$items_to_search_for[$aDBc_item]['belongs_to'] = "ok";

				// If the item belong to ADBC plugin, categorize it directly
				}else if(in_array($aDBc_item, $aDBc_my_plugin_core_items)){

					fwrite($myfile_categorization, str_replace(":", "+=+", $aDBc_item) . ":advanced-database-cleaner-pro:p" . "\n");
					array_push($items_already_categorized, $aDBc_item);
					// We fill belongs to to prevent processing this item later since it is already categorized
					$items_to_search_for[$aDBc_item]['belongs_to'] = "ok";

				}
			}

			fclose($myfile_categorization);
			fclose($myfile_to_categorize);

		}else{

			/**********************************************************************************************************************
			* If we continue after timeout, we will do some adjustments
			***********************************************************************************************************************/			

			// Get the list of items that should be scanned
			$myfile_to_categorize = fopen($path_file_to_categorize, "r");
			while(($item = fgets($myfile_to_categorize)) !== false){
				if(!empty(trim($item)))
					$items_to_search_for[trim($item)] = array('belongs_to' => '', 'maybe_belongs_to' => '');
			}
			fclose($myfile_to_categorize);

			// In $items_to_search_for, mark all items that are already categorized as ok to save time in iteration 1
			$myfile_categorization = fopen($path_file_categorization, "r");
			while(($item = fgets($myfile_categorization)) !== false){
				$item_name = explode(":", trim($item), 2);
				$item_name = str_replace("+=+", ":", $item_name[0]);
				if(array_key_exists($item_name, $items_to_search_for)){
					$items_to_search_for[$item_name]['belongs_to'] = "ok";
				}
				array_push($items_already_categorized, $item_name);
			}
			fclose($myfile_categorization);

		}

		/**********************************************************************************************************************
		* 
		* We proceed to iteration through all files, items....
		*
		***********************************************************************************************************************/	

		// Count total items in memory
		$total_items_in_memory 	= count($items_to_search_for);

		// Prepare an array containing all items we will iterate through
		$myfile_to_categorize = fopen($path_file_to_categorize, "r");
		$to_categorize_array = array();
		while(($item = fgets($myfile_to_categorize)) !== false){
			array_push($to_categorize_array, trim($item));
		}
		fclose($myfile_to_categorize);

		// Prepare an array containing all files we will iterate through
		$all_files_paths = fopen($path_file_all_php_files, "r");
		$all_files_array = array();
		while(($file_path = fgets($all_files_paths)) !== false){
			array_push($all_files_array, trim($file_path));
		}
		fclose($all_files_paths);

		// Get the number of items processed until now
		$processed_items = count($items_already_categorized);

		// Open the file in which we will save searching results as and when
		$myfile_categorization = fopen($path_file_categorization, "a");

		// Iteration 1: Search in all files for exact match for all items

		// We save start time to save progressing data into DB each 2 secs
		$start_time = time();

		if($aDBc_iteration == 1){

			$file_line_index = 1;

			foreach($all_files_array as $file_path){

				// We write the progress for ajax. We write each 2 sec to load fast. Then we save current status to DB to load it in case of timeout
				if(time() - $start_time >= 2){

					// Test if the user wants to stop the scan
					if(file_exists(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/stop_scan_" . $items_type . ".txt")){

						// Delete temp options and files
						aDBc_delete_temp_options_files_of_scan($items_type);

						// Prevent shutdown function to not load (because this function loads after a script has finished even without timeout error)
						$aDBc_search_has_finished = "yes";

						// Die and stop the scan
						wp_die();
					}

					session_start();
					$_SESSION['aDBc_progress'] 		= $file_line_index;
					$_SESSION['aDBc_total_items'] 	= $aDBc_total_files;
					session_write_close();

					update_option("aDBc_temp_last_item_line_" . $items_type, $aDBc_item_line, "no");
					update_option("aDBc_temp_last_file_line_" . $items_type, $aDBc_file_line, "no");
					update_option("aDBc_temp_last_iteration_" . $items_type, $aDBc_iteration, "no");
					$start_time = time();

				}

				// Skip until we found the last file before timeout
				if($file_line_index < $aDBc_file_line){
					$file_line_index++;
					continue;
				}

				$aDBc_file_content = file_get_contents($file_path);

				$item_line_index = 1;

				foreach($to_categorize_array as $item_name){

					// Skip until we found the last item before timeout
					if($item_line_index < $aDBc_item_line){
						$item_line_index++;
						continue;
					}

					// Before scaning the item, we test if the item has not been already categorized 
					if(array_key_exists($item_name, $items_to_search_for) && $items_to_search_for[$item_name]['belongs_to'] != "ok"){
						// If exact match found
						if(strpos($aDBc_file_content, $item_name) !== false){
							// We update data, identify plugin or theme names,....
							$owner_name_type = aDBc_get_owner_name_from_path($item_name, $file_path);
							fwrite($myfile_categorization, str_replace(":", "+=+", $item_name) . ":" . $owner_name_type[0] . ":" . $owner_name_type[1] . "\n");
							$processed_items++;
							// Put ok in belongs_to
							$items_to_search_for[$item_name]['belongs_to'] = "ok";
							// If we have categorized all items, break from all loops (2 loops)
							if($processed_items >= $total_items_in_memory){
								break 2;
							}
						}
					}

					$aDBc_item_line++;
					$item_line_index++;

				}

				$aDBc_item_line = 1;

				$file_line_index++;
				$aDBc_file_line++;

			}

			// If we have not categorized all items in iteration 1, we should execute iteration 2	
			if($processed_items < $total_items_in_memory){
				$aDBc_iteration = 2;
				$aDBc_file_line = 1;
				$aDBc_item_line = 1;
			}
		}

		// Iteration 2: Search in all files for partial match for items that are not categorized in iteration 1
		if($aDBc_iteration == 2){

			// If we are in iteration 2, we start by verifying if maybe_scores option exists, if so, load its data to $items_to_search_for
			$maybe_scores_option = get_option("aDBc_temp_maybe_scores_" . $items_type);
			if(!empty($maybe_scores_option)){

				$maybe_array = json_decode($maybe_scores_option, true);
				foreach($maybe_array as $item){
					$info = explode(":", trim($item), 2);
					$name = str_replace("+=+", ":", $info[0]);
					if(array_key_exists($name, $items_to_search_for)){
						$items_to_search_for[$name]['maybe_belongs_to'] = $info[1];
					}
				}
				// Once we finish, we delete this option
				delete_option("aDBc_temp_maybe_scores_" . $items_type);

			}

			$file_line_index = 1;
			$half_files = $aDBc_total_files / 2;
			foreach($all_files_array as $file_path){

				// We write the progress for ajax. We write each 2 sec to load fast. Then we save current status to DB to load it in case of timeout
				if(time() - $start_time >= 2){

					// Test if the user wants to stop the scan
					if(file_exists(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/stop_scan_" . $items_type . ".txt")){

						// Delete temp options and files
						aDBc_delete_temp_options_files_of_scan($items_type);

						// Prevent shutdown function to not load (because this function loads after a script has finished even without timeout error)
						$aDBc_search_has_finished = "yes";

						// Die and stop the scan
						wp_die();
					}

					session_start();
					$_SESSION['aDBc_progress'] = $half_files + $file_line_index;
					$_SESSION['aDBc_total_items'] 	= $aDBc_total_files;
					session_write_close();

					update_option("aDBc_temp_last_item_line_" . $items_type, $aDBc_item_line, "no");
					update_option("aDBc_temp_last_file_line_" . $items_type, $aDBc_file_line, "no");
					update_option("aDBc_temp_last_iteration_" . $items_type, $aDBc_iteration, "no");
					// Update maybe scores in DB since we are in iteration 2
					$maybe_array = array();
					foreach($items_to_search_for as $aDBc_item => $aDBc_info){
						if($aDBc_info['belongs_to'] != "ok" && !empty($aDBc_info['maybe_belongs_to'])){
							array_push($maybe_array, str_replace(":", "+=+", $aDBc_item) . ":" . $aDBc_info['maybe_belongs_to']);
						}
					}
					if(!empty($maybe_array)){
						// xxx saving a huge amount of data in the database may cause DB size issue when timeout occurs!
						update_option("aDBc_temp_maybe_scores_" . $items_type, json_encode($maybe_array), "no");
					}

					$start_time = time();

				}

				// Skip until we found the last file before timeout
				if($file_line_index < $aDBc_file_line){
					$file_line_index++;
					continue;
				}
				$aDBc_file_content = strtolower(file_get_contents($file_path));
				$item_line_index = 1;
				foreach($to_categorize_array as $item_name){
					// Skip until we found the last item before timeout
					if($item_line_index < $aDBc_item_line){
						$item_line_index++;
						continue;
					}

					// Before scaning the item, we test if the item has not been already categorized
					if(array_key_exists($item_name, $items_to_search_for) && $items_to_search_for[$item_name]['belongs_to'] != "ok"){
						// Find partial match. If found, add it directly to maybe_belongs_to in $items_to_search_for
						aDBc_search_for_partial_match($item_name, $aDBc_file_content, $file_path, $items_to_search_for);
					}

					$aDBc_item_line++;
					$item_line_index++;
				}
				$aDBc_item_line = 1;
				$file_line_index++;
				$aDBc_file_line++;
			}

			// After finishing all partial matches. Write results to file
			foreach($items_to_search_for as $aDBc_item => $aDBc_info){

				if($aDBc_info['belongs_to'] != "ok"){

					$aDBc_maybe_belongs_to_parts = explode("/", $aDBc_info['maybe_belongs_to']);

					// If the part1 is not empty, we will use it, else use the part 2
					if(!empty($aDBc_maybe_belongs_to_parts[0])){

						$aDBc_maybe_belongs_to_info = explode("|", $aDBc_maybe_belongs_to_parts[0]);
						$belongs_to = $aDBc_maybe_belongs_to_info[0] == "w" ? "" : $aDBc_maybe_belongs_to_info[0];
						// If $aDBc_maybe_belongs_to_info[2] equals to 100%, then delete pourcentage
						if($aDBc_maybe_belongs_to_info[2] != "100"){
							$belongs_to .= " (".$aDBc_maybe_belongs_to_info[2]."%)";
						}
						$type = $aDBc_maybe_belongs_to_info[1];	

					}else if(!empty($aDBc_maybe_belongs_to_parts[1])){

						$aDBc_maybe_belongs_to_info = explode("|", $aDBc_maybe_belongs_to_parts[1]);
						$belongs_to = $aDBc_maybe_belongs_to_info[0] == "w" ? "" : $aDBc_maybe_belongs_to_info[0];
						// If $aDBc_maybe_belongs_to_info[2] equals to 100%, then delete pourcentage
						if($aDBc_maybe_belongs_to_info[2] != "100"){
							$belongs_to .= " (".$aDBc_maybe_belongs_to_info[2]."%)";
						}
						$type = $aDBc_maybe_belongs_to_info[1];

					}else{

						// As final step, make all items to orphan if they have an empty "belong_to"
						$belongs_to = "o";
						$type = "o";
					}

					$aDBc_items_status = str_replace(":", "+=+", $aDBc_item) . ":" . $belongs_to . ":" . $type;
					fwrite($myfile_categorization, $aDBc_items_status . "\n");

				}
			}
		}

		fclose($myfile_categorization);

		// After the search has been finished, close files and delete the all temp options that have been added to DB
		// First, we process the results file to delete any duplicated entries caused by scanning selected items that are already scanned
		// I have added this tests to prevent the case in which the results file is deleted then the page refresh, we will loose data!
		$path_temp_results = ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/" . $items_type . "_temp.txt";
		if(file_exists($path_file_categorization)){
			$unique_items = array();
			$total_duplicated = 0;
			// Get all categorized items and add them to any array. New ones will overwide old ones to keep the newest scan results
			$results_file = fopen($path_file_categorization, "r");
			while(($item = fgets($results_file)) !== false){
				$columns = explode(":", trim($item), 2);
				if(!empty($unique_items[$columns[0]])){
					$total_duplicated++;
				}
				$unique_items[$columns[0]] = $columns[1];
			}
			fclose($results_file);

			// If duplicated found, proceed, otherwise do nothing
			if($total_duplicated > 0){
				// We start be deleting the temp file to prevent apend results in it
				if(file_exists($path_temp_results))
					unlink($path_temp_results);
				// Write results to a temp file
				$temp_file = fopen($path_temp_results, "a");
				foreach($unique_items as $item_name => $scan){
					fwrite($temp_file, $item_name . ":" . $scan . "\n");
				}
				fclose($temp_file);

				// Delete old results file and rename new one
				unlink($path_file_categorization);
				rename($path_temp_results, $path_file_categorization);
			}
		}else{
			// If the results files does not exists, test if temp one exists and rename it
			if(file_exists($path_temp_results))
				rename($path_temp_results, $path_file_categorization);
		}

		// Delete temp options and files
		aDBc_delete_temp_options_files_of_scan($items_type);

		// Create an option in database to show a message that the search has finished and let users opt for double check against our server
		update_option("aDBc_last_search_ok_" . $items_type, "1", "no");

		// Let know shutdown function to not load (because the shutdown function loads after a script has finished without needing timeout error)
		$aDBc_search_has_finished = "yes";

		// Always die in functions echoing ajax content
        wp_die();
	}
}

/************************************************************************************************
* This fuction stops a running scan/search
************************************************************************************************/
function aDBc_stop_search(){

	// We create a temp file so that the function of scan knows that we want to stop the scan

    // The $_REQUEST contains all the data sent via ajax
    if(isset($_REQUEST)){

		// Get item_type
		$items_type = $_REQUEST['aDBc_item_type'];

		fopen(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/stop_scan_" . $items_type . ".txt", "a");

		// Always die in functions echoing ajax content
		wp_die();
	}
}

/**************************************************************************
* This function deletes all temps options and files of a scan process 
***************************************************************************/
function aDBc_delete_temp_options_files_of_scan($items_type){

	delete_option("aDBc_temp_last_item_line_" 	. $items_type);
	delete_option("aDBc_temp_last_file_line_" 	. $items_type);
	delete_option("aDBc_temp_last_iteration_" 	. $items_type);
	delete_option("aDBc_temp_total_files_" 		. $items_type);
	delete_option("aDBc_temp_maybe_scores_" 	. $items_type);

	// Delete temp files
	if(file_exists(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/all_files_paths.txt"))
		    unlink(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/all_files_paths.txt");

	if(file_exists(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/" . $items_type . "_to_categorize.txt"))
	        unlink(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/" . $items_type . "_to_categorize.txt");

	// Delete stop_scan file in case it was created after the two itereations in the scan function. In this case that file will not have any effect and should be deleted at the end of the scan function
	if(file_exists(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/stop_scan_" . $items_type . ".txt"))
		    unlink(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/stop_scan_" . $items_type . ".txt");
}

/**************************************************************************
* This function is executed if timeout is reached 
***************************************************************************/
function aDBc_shutdown_due_to_timeout(){

	global $aDBc_search_has_finished;

	if($aDBc_search_has_finished == "no"){

		// Stores the item type we are dealing with: tables, options or tasks
		global $item_type_for_shutdown;		

		// Stores the last line that have been processed
		global $aDBc_item_line;
		// Stores the last line that have been reached
		global $aDBc_file_line;		
		// Stores the iteration number: either 1 or 2
		global $aDBc_iteration;

		update_option("aDBc_temp_last_item_line_" . $item_type_for_shutdown, $aDBc_item_line, "no");
		update_option("aDBc_temp_last_file_line_" . $item_type_for_shutdown, $aDBc_file_line, "no");
		update_option("aDBc_temp_last_iteration_" . $item_type_for_shutdown, $aDBc_iteration, "no");

		// If we are in iteration 2, we save maybe scores to DB to reload them later
		if($aDBc_iteration == 2){

			// Get array containing scan results
			global $items_to_search_for;

			// Get maybe scores
			$maybe_array = array();
			foreach($items_to_search_for as $aDBc_item => $aDBc_info){
				if($aDBc_info['belongs_to'] != "ok" && !empty($aDBc_info['maybe_belongs_to'])){
					array_push($maybe_array, str_replace(":", "+=+", $aDBc_item) . ":" . $aDBc_info['maybe_belongs_to']);
				}
			}

			// Save temp maybe scores in DB
			// xxx saving a huge amount of data in the database may cause DB size issue when timeout occurs!
			if(empty($maybe_array)){
				update_option("aDBc_temp_maybe_scores_" . $item_type_for_shutdown, "", "no");
			}else{
				update_option("aDBc_temp_maybe_scores_" . $item_type_for_shutdown, json_encode($maybe_array), "no");
			}
		}
	}
}

/************************************************************************************************
* This fuction tries to find any partial match of the item_name in the current file then returns:
************************************************************************************************/
function aDBc_search_for_partial_match($aDBc_item_name, $aDBc_file_content, $file_path, &$items_to_search_for){

	// call the last best maybe score
	$aDBc_maybe_score = empty($items_to_search_for[$aDBc_item_name]['maybe_belongs_to']) ? "/" : $items_to_search_for[$aDBc_item_name]['maybe_belongs_to'];

	$aDBc_maybe_belongs_to_parts = explode("/", $aDBc_maybe_score);

	// In itereation 2, change name to lowercase
	$item_name = strtolower($aDBc_item_name);

	$aDBc_item_name_len = strlen($item_name);
	$aDBc_is_new_score_found = 0;

	$aDBc_percent1 = 35;
	$aDBc_item_part1 = substr($item_name, 0, (($aDBc_percent1 * $aDBc_item_name_len) / 100));
	$aDBc_percent2 = 75;
	$aDBc_item_part2 = substr($item_name, -(($aDBc_percent2 * $aDBc_item_name_len) / 100));

	// If aDBc_item_part1 appears in the file content
	if(strpos($aDBc_file_content, $aDBc_item_part1) !== false){
		
		$aDBc_maybe_belongs_to_info_part1 = explode("|", $aDBc_maybe_belongs_to_parts[0]);
		$aDBc_maybe_best_score_found = empty($aDBc_maybe_belongs_to_info_part1[2]) ? $aDBc_percent1 : $aDBc_maybe_belongs_to_info_part1[2];
		// Search for all combinations starting from the beginning of the item name
		for ($i = $aDBc_item_name_len; $i > 1; $i--) {
			$aDBc_substring = substr($item_name, 0, $i);
			$aDBc_percent = (strlen($aDBc_substring) * 100) / $aDBc_item_name_len;
			if($aDBc_percent > $aDBc_maybe_best_score_found){
				if(strpos($aDBc_file_content, $aDBc_substring) !== false){
					// Bingo, we have find a percent %
					$aDBc_maybe_best_score_found = round($aDBc_percent, 2);
					$aDBc_is_new_score_found = 1;
					// Break after the first item found, since it is the longest
					break;
				}
			}else{
				break;
			}
		}

	}

	// If aDBc_item_part2 appears in the file content
	if(strpos($aDBc_file_content, $aDBc_item_part2) !== false){

		$aDBc_maybe_belongs_to_info_part2 = explode("|", $aDBc_maybe_belongs_to_parts[1]);
		$aDBc_maybe_best_score_found = empty($aDBc_maybe_belongs_to_info_part2[2]) ? $aDBc_percent2 : $aDBc_maybe_belongs_to_info_part2[2];
		// Search for all combinations starting from the end of the item name
		for ($i = 0; $i < $aDBc_item_name_len; $i++) {
			$aDBc_substring = substr($item_name, $i);
			$aDBc_percent = (strlen($aDBc_substring) * 100) / $aDBc_item_name_len;
			if($aDBc_percent > $aDBc_maybe_best_score_found){
				if(strpos($aDBc_file_content, $aDBc_substring) !== false){
					// Bingo, we have find a percent %
					$aDBc_maybe_best_score_found = round($aDBc_percent, 2);
					$aDBc_is_new_score_found = 2;
					// Break after the first item found, since it is the longest
					break;
				}
			}else{
				break;
			}
		}

	}

	// Test is new score was found in order to update data
	if($aDBc_is_new_score_found){
		$aDBc_type_detected = 0;
		// Is a plugin?
		if(strpos($file_path, ADBC_WP_PLUGINS_DIR_PATH) !== false){
			$aDBc_path = str_replace(ADBC_WP_PLUGINS_DIR_PATH."/", "", $file_path);
			$plugin_name = explode("/", $aDBc_path, 2);
			// If the new score is >= 100%, fill belongs_to directly instead of maybe_belongs_to to win time
			$aDBc_new_part = $plugin_name[0] . "|p|" . $aDBc_maybe_best_score_found;
			if($aDBc_is_new_score_found == "1"){
				$items_to_search_for[$aDBc_item_name]['maybe_belongs_to'] = $aDBc_new_part . "/" . $aDBc_maybe_belongs_to_parts[1];
			}else{
				$items_to_search_for[$aDBc_item_name]['maybe_belongs_to'] = $aDBc_maybe_belongs_to_parts[0] . "/" . $aDBc_new_part;
			}
			$aDBc_type_detected = 1;
		}
		// If not a plugin, then is a theme?
		if(!$aDBc_type_detected){

			// Prepare WP Themes directories paths (useful to detect if an item belongs to a theme and detect the theme name)
			global $wp_theme_directories;
			$aDBc_themes_paths_array = array();
			foreach($wp_theme_directories as $aDBc_theme_path){
				array_push($aDBc_themes_paths_array, str_replace('\\' ,'/', $aDBc_theme_path));
			}

			foreach($aDBc_themes_paths_array as $aDBc_theme_path){
				if(strpos($file_path, $aDBc_theme_path) !== false){
					$aDBc_path = str_replace($aDBc_theme_path."/", "", $file_path);
					$theme_name = explode("/", $aDBc_path, 2);
					// If the new score is >= 100%, fill belongs_to directly instead of maybe_belongs_to to win time
					$aDBc_new_part = $theme_name[0] . "|t|" . $aDBc_maybe_best_score_found;
					if($aDBc_is_new_score_found == "1"){
						$items_to_search_for[$aDBc_item_name]['maybe_belongs_to'] = $aDBc_new_part . "/" . $aDBc_maybe_belongs_to_parts[1];
					}else{
						$items_to_search_for[$aDBc_item_name]['maybe_belongs_to'] = $aDBc_maybe_belongs_to_parts[0] . "/" . $aDBc_new_part;
					}
					$aDBc_type_detected = 1;
					break;
				}
			}
		}
		// xxx If not a plugin and not a theme, then affect it to WP?
		if(!$aDBc_type_detected){
			// If the new score is >= 100%, fill belongs_to directly instead of maybe_belongs_to to win time
			$aDBc_new_part = "w|w|" . $aDBc_maybe_best_score_found;
			if($aDBc_is_new_score_found == "1"){
				$items_to_search_for[$aDBc_item_name]['maybe_belongs_to'] = $aDBc_new_part . "/" . $aDBc_maybe_belongs_to_parts[1];
			}else{
				$items_to_search_for[$aDBc_item_name]['maybe_belongs_to'] = $aDBc_maybe_belongs_to_parts[0] . "/" . $aDBc_new_part;
			}
		}
	}
}

/************************************************************************************
* Double check items against our server database to enhance the accuracy of results
* xxx If the scan file is very big, should I split it into chunks before sending to server for double checking results?
************************************************************************************/
/*function aDBc_double_check_items(){

	// parameters of this function : $items_type

    // The $_REQUEST contains all the data sent via ajax
    //if(isset($_REQUEST)){

		$items_type = $_REQUEST['aDBc_item_type'];

		// Prepare data to send to the API route
		$site_url = home_url();
		$license_key = trim(get_option('aDBc_edd_license_key'));

		// Prepare an array containing items to process
		$saved_items_file = @fopen(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/" . $items_type . ".txt", "r");
		$items_as_array = array();
		if ($saved_items_file) {
			while(($item = fgets($saved_items_file)) !== false) {
				if(trim($item) != ""){
					array_push($items_as_array, trim($item));
				}
			}
		}

		// Convert items array to json for better hundle
		$items_as_json = json_encode($items_as_array);

		// Prepare array data to send to the server
		$data = array('site_url' => $site_url, 'license_key' => $license_key, 'items_file_content' => $items_as_json, 'items_type' => $items_type);

		// The API route URL that will double check items
		$url_api_route = 'https://www.wpfindit.com/wp-json/advanced_db_cleaner/v1/check';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url_api_route);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		// xxx if I enable ssl verification, curl does not work on localhost and it works on sigmaplugins!! Verify why
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		//curl_setopt( $ch, CURLOPT_HTTPHEADER, ['Content-Disposition: form-data; filename="options.txt"'] );
		$result = curl_exec($ch);

		// If the curl call has failed for any reason, show error msg?
		if(curl_errno($ch)){

			// In case unknown error, update aDBc_last_search_ok_x variable and set value = unknown_error. This means that an error has occured
			update_option("aDBc_last_search_ok_" . $items_type, "unknown_error");

			//xxx this block should be deleted
			//$aDBc_temp_scan_corrections = @fopen(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/" . $items_type . "_2.txt", "a");
			//fwrite($aDBc_temp_scan_corrections, curl_error($ch) . "\n");
			//fclose($aDBc_temp_scan_corrections);

		}else{

			// Test if the double check has been rejected
			$decoded_results = json_decode($result);

			if(is_string($decoded_results)){

				// If the returned result is string, therefore wen conclude that an error has occured
				if($decoded_results == "invalid_license" || 
					$decoded_results == "error_invalid_call_0" || 
					$decoded_results == "error_invalid_call_1" || 
					substr($decoded_results, 0, 13) === "limit_reached" || 
					substr($decoded_results, 0, 4) === "wait" || 
					$decoded_results == "service_unavailable"){

					// We update aDBc_last_search_ok_x variable and set value = returned error
					update_option("aDBc_last_search_ok_" . $items_type, trim($decoded_results));
				}

			}else{

				// If we are here, this means that the remote call has been performed with success. Update scan results
				// Get server results in array
				$aDBc_server_results 		= json_decode($result, true);
				$total_correction_by_server = 0;

				// Path to scan results of the plugin
				$aDBc_path_saved_items_file = ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/" . $items_type . ".txt";

				// We proceed only if the server returned some results and that the scan file exists
				if(!empty($aDBc_server_results) && file_exists($aDBc_path_saved_items_file)){

					// Fist, prepare 2 arrays: one containing all installed plugins folderes names, the second all themes folders names
					$plugins_folders_names 	= aDBc_get_plugins_folder_names();
					$themes_folders_names 	= aDBc_get_themes_folder_names();

					// Load all categorization made by the plugin to correct them if needed
					$aDBc_saved_items_file 	= @fopen($aDBc_path_saved_items_file, "r");

					if($aDBc_saved_items_file){

						// Create a new temp file in which we will save new scan with corrections
						$aDBc_temp_scan_corrections = @fopen(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/" . $items_type . "_2.txt", "w");

						while(($item = fgets($aDBc_saved_items_file)) !== false) {

							$columns = explode(":", trim($item));
							// We replace +=+ by : because names that contain ":" have been transformed to +=+
							$item_name = str_replace("+=+", ":", $columns[0]);

							// Verify if the server has returned a correction for this item_name
							if(array_key_exists($item_name, $aDBc_server_results)){

								// We will provide correction only to items is orphan or with %
								if(trim($columns[2]) == "o" || strpos($columns[1], '%') !== false){

									// We decode content of the correction
									$different_corrections = json_decode($aDBc_server_results[$item_name], true);

									// Test if the item belongs indeed to an installed plugin/theme with "1" identifier
									$sure_about_it = 0;
									foreach($different_corrections as $correction){
										$correction = explode(":", $correction);
										// Test if item belongs to WordPress
										if($correction[0] == "w" && $correction[2] == "1"){
											fwrite($aDBc_temp_scan_corrections, $columns[0] . ":w:w" . "\n");
											$sure_about_it = 1;
											$total_correction_by_server++;
											break;
										// Test if item belongs to a plugin that is installed
										}else if(in_array($correction[0], $plugins_folders_names) && $correction[2] == "1"){
											fwrite($aDBc_temp_scan_corrections, $columns[0] . ":" . $correction[0] . ":" . "p" . "\n");
											$sure_about_it = 1;
											$total_correction_by_server++;
											break;
										// Test if item belongs to a theme that is installed
										}else if(in_array($correction[0], $themes_folders_names) && $correction[2] == "1"){
											fwrite($aDBc_temp_scan_corrections, $columns[0] . ":" . $correction[0] . ":" . "t" . "\n");
											$sure_about_it = 1;
											$total_correction_by_server++;
											break;
										}										
									}

									// Test if the item belongs indeed to an installed plugin/theme with "0" identifier
									if($sure_about_it == 0){
										foreach($different_corrections as $correction){
											$correction = explode(":", $correction);
											// Test if item belongs to WordPress						
											if($correction[0] == "w"){
												fwrite($aDBc_temp_scan_corrections, $columns[0] . ":w:w" . "\n");
												$sure_about_it = 1;
												$total_correction_by_server++;
												break;
											// Test if item belongs to a plugin that is installed
											}else if(in_array($correction[0], $plugins_folders_names)){
												fwrite($aDBc_temp_scan_corrections, $columns[0] . ":" . $correction[0] . ":" . "p" . "\n");
												$sure_about_it = 2;
												$total_correction_by_server++;
												break;
											// Test if item belongs to a theme that is installed
											}else if(in_array($correction[0], $themes_folders_names)){
												fwrite($aDBc_temp_scan_corrections, $columns[0] . ":" . $correction[0] . ":" . "t" . "\n");
												$sure_about_it = 2;
												$total_correction_by_server++;
												break;
											}
										}
									}

									// If we did not find any valid correction, prepare info to display to users
									if($sure_about_it == 0){
										// For orphaned items, return the list of plugins/themes to which the item may be belonging
										if(trim($columns[2]) == "o"){
											fwrite($aDBc_temp_scan_corrections, $columns[0] . ":" . $columns[1] . ":" . $columns[2] . ":" . $aDBc_server_results[$item_name] . "\n");											
										}
										// For items with %, just return the line as it is
										if(strpos($columns[1], '%') !== false){
											fwrite($aDBc_temp_scan_corrections, trim($item) . "\n");
										}
									}
								}
							}else{
								// If no correction found, write the item scan as it is
								fwrite($aDBc_temp_scan_corrections, trim($item) . "\n");
							}
						}
						fclose($aDBc_temp_scan_corrections);
						fclose($aDBc_saved_items_file);

		// xxx Delete old file and rename new file "items_2.txt" to "items.txt"
		rename(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/" . $items_type . ".txt", ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/" . $items_type . "_3.txt");
		rename(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/" . $items_type . "_2.txt", ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/" . $items_type . ".txt");
		rename(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/" . $items_type . "_3.txt", ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/" . $items_type . "_2.txt");	
						
					}
				}

				// Once we finish, we update aDBc_last_search_ok_x and set value = double_check_finished:n
				update_option("aDBc_last_search_ok_" . $items_type, "double_check_finished:" . $total_correction_by_server);
			}
		}
		// Close cURL
		curl_close($ch);
		// Always die in functions echoing ajax content
        wp_die();
	//}

}*/

/******************************************************************************************************************
* Verify if the scan search has finished to let user know about it and invite it to double check against our server
* xxx if we ignore double check message then click directly on "scan"...the double check is not shown because the URL contains the parameter to ignore the double check! Try to correct this using ajax instead. This does not cause any issues for now since this module is inactive
******************************************************************************************************************/
function aDBc_get_msg_double_check($items_type){

	$search_finished = get_option("aDBc_last_search_ok_" . $items_type);

	// If nothing there, return empty string
	if(empty($search_finished))
		return "";

	// If the double check API call has been rejected, prepare a msg
	$msg_reject = "";

	// If $search_finished == "double_check_finished:n", this means that double check has finished with success
	/*if(substr($search_finished, 0, 21) === "double_check_finished"){

		// Get the number of corrections by the server
		$columns = explode(":", $search_finished);
		// We delete the aDBc_last_search_ok_x variable to hide all messages
		delete_option("aDBc_last_search_ok_" . $items_type);
		return "<div class='updated notice is-dismissible'><p>" . __("The double check process has finished with success!", "advanced-database-cleaner") . " " . sprintf(__('%s corrections provided by the server!', 'advanced-database-cleaner'), $columns[1]) . "</p></div>";

	}else if($search_finished == "unknown_error"){

		$msg_reject = __('An unknown error has occurred, please try again later! If the problem persists, please contact us!', 'advanced-database-cleaner');

	}else if($search_finished == "invalid_license"){

		$msg_reject = __('Please activate your license first to be able to double check your results!', 'advanced-database-cleaner');

	}else if($search_finished == "error_invalid_call_0"){

		$msg_reject  = __('Invalid request!', 'advanced-database-cleaner') . " Error_invalid_call_0";

	}else if($search_finished == "error_invalid_call_1"){

		$msg_reject  = __('Invalid request!', 'advanced-database-cleaner') . " Error_invalid_call_1";

	}else if(substr($search_finished, 0, 13) === "limit_reached"){

		$columns = explode(":", $search_finished);
		$msg_reject = sprintf(__('Daily limit reached! You can call the remote database %s times/24h for a given category! Please try again later. If you need assistance, contact us!', 'advanced-database-cleaner'), $columns[1]);

	}else if(substr($search_finished, 0, 4) === "wait"){

		$columns = explode(":", $search_finished);
		$msg_reject = sprintf(__('Please wait %s seconds before making another call to the remote database!', 'advanced-database-cleaner'), $columns[2]);

	}else if($search_finished == "service_unavailable"){

		// xxx Add a link here for service availabity
		$msg_reject = sprintf(__('The remote service is currently unavailable for maintenance! Please try again later. You can check the <a href="%s" target="_blank">service availability here</a>', 'advanced-database-cleaner'), "xxx");

	}*/

	// If $msg_reject is not empty, this means that an error or limit has occured
	if(!empty($msg_reject)){
		$msg_reject = "<div class='error notice is-dismissible'><p style='color:red'>" . $msg_reject . "</p></div>";
		// We update the option to 1 to hide the rejection msg when the page is refreshed and show double check again
		update_option("aDBc_last_search_ok_" . $items_type, "1");
	}

	// If we are here, this means that $search_finished contains data and the double check has not finished with success
	// We show msg success + button to invite users double check their tables remotly against our database
	// xxx delete this box via ajax instead of form submit
	$msg = "<div class='updated notice' style='border-top:1px solid #ccc;border-bottom:1px solid #ccc;border-right:1px solid #ccc'>";
	$msg .= "<p>";
	$msg .= sprintf( __('The process of scanning %s has finished with success!', 'advanced-database-cleaner'), $items_type);
	$msg .= "<br/><span style='color:#E97F31'>";
	//$msg .= "<b>" . __('However, we HIGHLY recommend to double check your local scan results against our server database results to increase the accuracy', 'advanced-database-cleaner') . "</b></span>";
	// xxx correct url in read more. 
	//$msg .= " <a href='#'>[" . __('Read more here', 'advanced-database-cleaner') . "]</a>";
	// Test if curl in installed before showing the button to double check. If curl is not installed, we add a warning
	/*if(in_array ('curl', get_loaded_extensions())){
		$msg .= "</p><p><input id='aDBc_double_check' type='submit' class='aDBc-double-check' style='border:1px solid green;background-color:green' value='" . __('Double check','advanced-database-cleaner') ."' name='aDBc_double_check' /></p>";

		$msg .= "<p id='aDBc_double_check_sentence' style='display:none'><span style='color:grey'>" . __('This will take few seconds, please wait...','advanced-database-cleaner') . "</span></p>";
	}else{
		$msg .= "<br><span style='color:red'>" . __('To execute this double check, please install cURL extension on your server!','advanced-database-cleaner') . "</span></p>";
	}*/
	// Add ignore msg link
	// Get the current URI
	/*$aDBc_new_URI = $_SERVER['REQUEST_URI'];
	$aDBc_new_URI = add_query_arg('ignore-double-check-' . $items_type, '0', $aDBc_new_URI);
	$msg .= "<p id='aDBc_double_check_ignore_link'><a href='".$aDBc_new_URI."'>". __('Not now. Just hide this!','advanced-database-cleaner') . "</a></p>";*/
	$msg .= "</div>";

	delete_option("aDBc_last_search_ok_" . $items_type);
	return $msg_reject . $msg;

}

/**************************************************************************************************************
* Return an array containing the name and the type of the owner of the item in parameter based on the file path
**************************************************************************************************************/
function aDBc_get_owner_name_from_path($item_name, $full_path){

	$owner_name_type = array();

	// Is a plugin?
	if(strpos($full_path, ADBC_WP_PLUGINS_DIR_PATH) !== false){
		$aDBc_path = str_replace(ADBC_WP_PLUGINS_DIR_PATH."/", "", $full_path);
		$plugin_name = explode("/", $aDBc_path, 2);
		$owner_name_type[0] = $plugin_name[0];
		$owner_name_type[1] = "p";
		return $owner_name_type;
	}

	// If not a plugin, then is a theme?
	// Prepare WP Themes directories paths (useful to detect if an item belongs to a theme and detect the theme name)
	global $wp_theme_directories;
	$aDBc_themes_paths_array = array();
	foreach($wp_theme_directories as $aDBc_theme_path){
		array_push($aDBc_themes_paths_array, str_replace('\\' ,'/', $aDBc_theme_path));
	}

	foreach($aDBc_themes_paths_array as $aDBc_theme_path){
		if(strpos($full_path, $aDBc_theme_path) !== false){
			$aDBc_path = str_replace($aDBc_theme_path."/", "", $full_path);
			$theme_name = explode("/", $aDBc_path, 2);
			$owner_name_type[0] = $theme_name[0];
			$owner_name_type[1] = "t";
			return $owner_name_type;
		}
	}

	// If not a plugin and not a theme, then affect it to WP? Maybe later I should return the file name instead of affect it to WP
	$owner_name_type[0] = "w";
	$owner_name_type[1] = "w";
	return $owner_name_type;
}

/******************************************************************
* Create list of all php files in the wordpress installation
*******************************************************************/
function aDBc_refresh_and_create_php_files_paths(){

	// We start by deleting old file containing paths
	@unlink(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/all_files_paths.txt");

	// For every none categorized table/option/task, create all php files paths starting from ADBC_ABSPATH
	$myfile = fopen(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/all_files_paths.txt", "a");
	aDBc_create_php_files_urls(ADBC_ABSPATH, $myfile);

	// Search also in WP-content if it is outside ADBC_ABSPATH
	if(is_dir(ADBC_WP_CONTENT_DIR_PATH)){
		if(strpos(ADBC_WP_CONTENT_DIR_PATH, ADBC_ABSPATH) === false){
			aDBc_create_php_files_urls(ADBC_WP_CONTENT_DIR_PATH, $myfile);
		}
	}

	// Search also in MU must use plugins if it is outside ADBC_ABSPATH and ADBC_WP_CONTENT_DIR_PATH
	if(is_dir(ADBC_WPMU_PLUGIN_DIR_PATH)){
		if(strpos(ADBC_WPMU_PLUGIN_DIR_PATH, ADBC_ABSPATH) === false && strpos(ADBC_WPMU_PLUGIN_DIR_PATH, ADBC_WP_CONTENT_DIR_PATH) === false){
			aDBc_create_php_files_urls(ADBC_WPMU_PLUGIN_DIR_PATH, $myfile);
		}
	}

	// Search in plugins directory if it is outside ADBC_WP_CONTENT_DIR_PATH and ADBC_ABSPATH
	if(is_dir(ADBC_WP_PLUGINS_DIR_PATH)){
		if(strpos(ADBC_WP_PLUGINS_DIR_PATH, ADBC_ABSPATH) === false && strpos(ADBC_WP_PLUGINS_DIR_PATH, ADBC_WP_CONTENT_DIR_PATH) === false){
			aDBc_create_php_files_urls(ADBC_WP_PLUGINS_DIR_PATH, $myfile);
		}
	}

	// Search in themes directories if they are outside ADBC_WP_CONTENT_DIR_PATH and ADBC_ABSPATH
	global $wp_theme_directories;
	foreach($wp_theme_directories as $aDBc_theme_path){
		$path = str_replace('\\' ,'/', $aDBc_theme_path);
		if(is_dir($path)){
			if(strpos($path, ADBC_ABSPATH) === false && strpos($path, ADBC_WP_CONTENT_DIR_PATH) === false){
				aDBc_create_php_files_urls(ADBC_WP_PLUGINS_DIR_PATH, $myfile);
			}
		}
	}

	fclose($myfile);

}

/******************************************************************
* Create list of all php files starting from the path in parameter
* $path_to_start_from : path to start searching from
* $myfile is the file where to save files paths
******************************************************************/
function aDBc_create_php_files_urls($path_to_start_from, $myfile){

		$aDBc_fp = opendir($path_to_start_from);

		while($aDBc_f = readdir($aDBc_fp)){

			// Ignore symbolic links
			if(preg_match("#^\.+$#", $aDBc_f)){
				continue;
			}

			// Create the full path for the current file/folder
			$full_path = $path_to_start_from . "/" . $aDBc_f;

			// If the current path is a folder, then call recursive function
			if(is_dir($full_path)) {

				// Skip upload directory while searching
				if(strpos($full_path, ADBC_UPLOAD_DIR_PATH) !== false){
					continue;
				}
				aDBc_create_php_files_urls($full_path, $myfile);

			}else{

				// Ignore all files that are not php
				if(strpos($aDBc_f, ".php") === false){
					continue;
				}

				// Save the file URL
				fwrite($myfile, str_replace('\\' ,'/', $full_path) . "\n");

			}
		}
}

/*************************************************************************************************************
* This functions refreshes the categorization file after delete process to keep only valid entries in the file
*************************************************************************************************************/
function aDBc_refresh_categorization_file_after_delete($names_deleted, $items_type){

	// Get the file path
	$path_file_categorization = ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/" . $items_type . ".txt";

	// Test if there are any items that have been deleted to prevent waisting time && moreover the file exists
	if(count($names_deleted) > 0 && file_exists($path_file_categorization)){

		$file_categorization = fopen($path_file_categorization, "r");
	
		// Prepare an array containing new file info
		$array_new_file = array();

		// Count total lines in file
		$total_lines = 0;

		while(($item = fgets($file_categorization)) !== false){
			$total_lines++;
			$item_name = explode(":", trim($item), 2);
			$item_name = str_replace("+=+", ":", $item_name[0]);
			if(!in_array($item_name, $names_deleted)){
				array_push($array_new_file, trim($item));
			}
		}
		fclose($file_categorization);

		// We will refresh the file only if the number of new lines is lover than number of old files. To prevent refreshing the file when deleting items not existing in file
		if(count($array_new_file) < $total_lines){
			// Delete old file
			@unlink($path_file_categorization);

			// Create a new file which will hold new info
			$file_categorization = fopen($path_file_categorization, "a");

			foreach($array_new_file as $aDBc_item){
				fwrite($file_categorization, $aDBc_item . "\n");
			}
			fclose($file_categorization);
		}
	}
}

/*************************************************************************************************************
* This functions retrieves the list of plugins folders names
*************************************************************************************************************/
function aDBc_get_plugins_folder_names(){
	// Get all plugins info
	$all_plugins = get_plugins();
	// Prepare an array that will contain plugins folders names
	$plugins_folders = array();
	foreach(array_keys($all_plugins) as $plugin_file){
		$plugin_data = explode("/", $plugin_file);
		array_push($plugins_folders, $plugin_data[0]);
	}
	return $plugins_folders;
}

/*************************************************************************************************************
* This functions retrieves the list of themes folders names
*************************************************************************************************************/
function aDBc_get_themes_folder_names(){
	// Get all themes info
	$all_themes = wp_get_themes();
	// Prepare an array that will contain themes folders names
	$themes_folders = array();
	foreach(array_keys($all_themes) as $theme_file){
		$theme_data = explode("/", $theme_file);
		array_push($themes_folders, $theme_data[0]);
	}
	return $themes_folders;
}

/*************************************************************************************************************
* Prepares a list of plugins/themes to which an orphaned item may belong after double check
*************************************************************************************************************/
function aDBc_get_correction_info_for_orphaned_items($json_info){

	$info_array = json_decode($json_info, true);

	// If array contains 0 elements, return empty string (this situation should not happen, just to be sure...)
	if(count($info_array) == 0)
		return "";

	$toolip = "<span class='aDBc-tooltips-headers'>
				<img class='aDBc-info-image' src='".  ADBC_PLUGIN_DIR_PATH . '/images/information_orange.svg' . "'/>
				<span>";

	if(count($info_array) == 1){
		$toolip .= __('Belongs to:','advanced-database-cleaner');
	}else if(count($info_array) > 1){
		$toolip .= __('Belongs to one of these:','advanced-database-cleaner');
	}

	foreach($info_array as $info){
		$columns = explode(":", $info);
		$toolip .= "<div style='background:#fff;color:#000;border-radius:1px;padding:3px;margin:2px'>";
		$toolip .= $columns[0];
		$toolip .= " (";
		$toolip .= $columns[1] == "p" ? "<font color='#00BAFF'>" . __('plugin','advanced-database-cleaner') . "</font>" : "<font color='#45C966'>" . __('theme','advanced-database-cleaner') . "</font>";
		$toolip .= " - <font color='red'>" . __('Not installed','advanced-database-cleaner') . "</font>)";
		$toolip .= "</div>";
	}
	$toolip .= "</span></span>";

	return $toolip;
}

/*************************************************************************************************************
* Edits the categorization of selected items
*************************************************************************************************************/
function aDBc_edit_categorization_of_items($items_type, $new_belongs_to, $send_data_to_server_or_not){

	// Open the file in which the items to edit have been saved
	$path_items_manually = @fopen(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/" . $items_type . "_manually_correction_temp.txt", "r");
	if($path_items_manually){

		// Get the new belongs_to info made by the user
		$columns = explode("|", trim($new_belongs_to));
		$belongs_to = sanitize_html_class($columns[0]) . ":" . sanitize_html_class($columns[1]);

		// Prepare an array containing new categorizations
		$items_correction_array = array();
		while(($item = fgets($path_items_manually)) !== false) {
			if(!empty(trim($item))){
				$items_correction_array[trim($item)] = $belongs_to;
			}
		}

		/* First, we verify if there are items in the $items_correction_array but do not exist in the scan official categorization file
		In this case, we add missing items first to that file. Otherwise, manual corrections will not be loaded for missing items and they will still be marked as "uncategorized". Because the plugin loads categorizations only for scanned items */
		$path_to_scan_file = ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/" . $items_type . ".txt";
		// Prepare an array containing all scanned items names
		$scanned_items_array = array();
		if(file_exists($path_to_scan_file)){
			$scan_file = fopen($path_to_scan_file, "r");
			while(($item = fgets($scan_file)) !== false) {
				if(!empty(trim($item))){
					$columns = explode(":", trim($item), 2);
					// We replace +=+ by :
					$item_name = str_replace("+=+", ":", $columns[0]);
					array_push($scanned_items_array, $item_name);
				}
			}
			fclose($scan_file);
		}
		// Append missing items to the scan file. In case it does not exist, create it.
		$scan_file = fopen($path_to_scan_file, "a");
		foreach($items_correction_array as $item => $belongs_to){
			// Test if this item exists in the scan file or should we add it
			if(!in_array($item, $scanned_items_array)){
				fwrite($scan_file, str_replace(":", "+=+", $item) . ":" . $belongs_to . "\n");
			}
		}
		fclose($scan_file);

		// Get the old categorization made by the user
		$old_corrections_path = ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/" . $items_type ."_corrected_manually.txt";
		if(file_exists($old_corrections_path)){
			$old_corrections_array = json_decode(trim(file_get_contents($old_corrections_path)), true);
			// Loop over the new categorization and add/edit corresponding ones in old file
			foreach($items_correction_array as $item => $belongs_to){
				// If the new categorization exist, it will be overwide. Otherwise, it will be added to the array
				$old_corrections_array[$item] = $belongs_to;
			}
			// Save the array containing old and new categorizations
			$new_file = @fopen($old_corrections_path, "w");
			if($new_file){
				fwrite($new_file, json_encode($old_corrections_array));
				fclose($new_file);
			}

		}else{
			// If old categorization does not exist, then just save the new ones
			$new_file = @fopen($old_corrections_path, "w");
			if($new_file){
				fwrite($new_file, json_encode($items_correction_array));
				fclose($new_file);
			}
		}

		// xxx Test if user has checked the checkbox to send correction to server
		/*if($send_data_to_server_or_not == 1){
			// maybe not for now. Just hide checkbox
		}*/

		fclose($path_items_manually);
		return __("Modifications saved successfully!", "advanced-database-cleaner");
	}
	return "";
}

?>