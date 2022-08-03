<?php

class ADBC_Options_List extends WP_List_Table {

	/** Holds the message to be displayed if any */
	private $aDBc_message = "";

	/** Holds the class for the message : updated or error. Default is updated */
	private $aDBc_class_message = "updated";

	/** Holds options that will be displayed */
	private $aDBc_options_to_display = array();

	/** Holds counts + info of options categories */
	private $aDBc_options_categories_info	= array();

	/** Should we display "run search" or "continue search" button (after a timeout failed). Default is "run search" */
	private $aDBc_which_button_to_show = "new_search";
	
	// This array contains belongs_to info about plugins and themes
	private $array_belongs_to_counts = array();

	// Holds msg that will be shown if the scan has finished with success
	private $aDBc_search_has_finished_msg = "";

	// Holds msg that will be shown if folder adbc_uploads cannot be created by the plugin (This is verified after clicking on scan button)
	private $aDBc_permission_adbc_folder_msg = "";	

    function __construct(){

        parent::__construct(array(
            'singular'  => __('Option', 'advanced-database-cleaner'),		//singular name of the listed records
            'plural'    => __('Options', 'advanced-database-cleaner'),	//plural name of the listed records
            'ajax'      => false	//does this table support ajax?
		));

		$this->aDBc_prepare_and_count_options();
		$this->aDBc_print_page_content();
    }

	/** Prepare options to display and count options for each category */
	function aDBc_prepare_and_count_options(){

		// If the search has finished, show a msg success to users + button to double check results against our server database
		$this->aDBc_search_has_finished_msg = aDBc_get_msg_double_check("options");

		// Verify if the adbc_uploads cannot be created
		$adbc_folder_permission = get_option("aDBc_permission_adbc_folder_needed");
		if(!empty($adbc_folder_permission)){
			$this->aDBc_permission_adbc_folder_msg = sprintf(__('The plugin needs to create the following directory "%1$s" to save the scan results but this was not possible automatically. Please create that directory manually and set correct permissions so it can be writable by the plugin.','advanced-database-cleaner'), ADBC_UPLOAD_DIR_PATH_TO_ADBC);
			// Once we display the msg, we delete that option from DB
			delete_option("aDBc_permission_adbc_folder_needed");
		}

		// Verify if the user wants to edit the categorization of an option. This block test comes from edit_item_categorization.php
		if(isset($_POST['aDBc_cancel'])){

			// If the user cancels the edit, remove the temp file
			if(file_exists(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/options_manually_correction_temp.txt"))
				unlink(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/options_manually_correction_temp.txt");

		}else if(isset($_POST['aDBc_correct'])){

			// Get the new belongs to of items
			$new_belongs_to = $_POST['new_belongs_to'];

			// Get value of checkbox to see if user wants to send correction to the server
			if(isset($_POST['aDBc_send_correction_to_server'])){
				$this->aDBc_message = aDBc_edit_categorization_of_items("options", $new_belongs_to, 1);
			}else{
				$this->aDBc_message = aDBc_edit_categorization_of_items("options", $new_belongs_to, 0);
			}
			// Remove the temp file
			if(file_exists(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/options_manually_correction_temp.txt"))
				unlink(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/options_manually_correction_temp.txt");
		}

		// Process bulk action if any before preparing options to display
		$this->process_bulk_action();

		// Prepare data
		aDBc_prepare_items_to_display(
			$this->aDBc_options_to_display,
			$this->aDBc_options_categories_info,
			$this->aDBc_which_button_to_show,
			array(),
			array(),
			$this->array_belongs_to_counts,
			$this->aDBc_message,
			$this->aDBc_class_message,
			"options"
		);

		// Call WP prepare_items function
		$this->prepare_items();
	}

	/** WP: Get columns */
	function get_columns(){
		$aDBc_belongs_to_toolip = "<span class='aDBc-tooltips-headers'>
									<img class='aDBc-info-image' src='".  ADBC_PLUGIN_DIR_PATH . '/images/information2.svg' . "'/>
									<span>" . __('Indicates the creator of the option: either a plugin, a theme or WordPress itself. If not sure about the creator, an estimation (%) will be displayed. The higher the percentage is, the more likely that the option belongs to that creator.','advanced-database-cleaner') ." </span>
								  </span>";

		$aDBc_option_size_toolip = "<span class='aDBc-tooltips-headers' style='position: absolute;margin-left:15px'>
									<img class='aDBc-info-image' src='".  ADBC_PLUGIN_DIR_PATH . '/images/information2.svg' . "'/>
									<span>" . __('The size is in Bits! This is an estimation, not a precise value!','advanced-database-cleaner') ." </span>
								  </span>";	

		$columns = array(
			'cb'          		=> '<input type="checkbox" />',
			'option_name' 		=> __('Option name','advanced-database-cleaner'),
			'option_value' 		=> __('Value','advanced-database-cleaner'),
			'option_size' 		=> __('Size','advanced-database-cleaner') . $aDBc_option_size_toolip,
			'option_autoload' 	=> __('Autoload','advanced-database-cleaner'),
			'site_id'   		=> __('Site','advanced-database-cleaner'),
			'option_belongs_to' => __('Belongs to','advanced-database-cleaner') . $aDBc_belongs_to_toolip
		);
		return $columns;
	}

	function get_sortable_columns() {

		$sortable_columns = array(
			'option_name'   	=> array('option_name',false),
			'option_size'   	=> array('option_size',false),
			'option_autoload'   => array('option_autoload',false),
			'site_id'    		=> array('site_id',false)
		);

		return $sortable_columns;
	}

	/** WP: Prepare items to display */
	function prepare_items() {
		$columns 	= $this->get_columns();
		$hidden 	= $this->get_hidden_columns();
		$sortable 	= $this->get_sortable_columns();
		$this->_column_headers  = array($columns, $hidden, $sortable);
		$per_page 	= 50;
		if(!empty($_GET['per_page'])){
			$per_page = absint($_GET['per_page']);
		}		
		$current_page = $this->get_pagenum();
		// Prepare sequence of options to display
		$display_data = array_slice($this->aDBc_options_to_display,(($current_page-1) * $per_page), $per_page);
		$this->set_pagination_args( array(
			'total_items' => count($this->aDBc_options_to_display),
			'per_page'    => $per_page
		));
		$this->items = $display_data;
	}

	/** WP: Get columns that should be hidden */
    function get_hidden_columns(){
		// If MU, nothing to hide, else hide Side ID column
		if(function_exists('is_multisite') && is_multisite()){
			return array();
		}else{
			return array('site_id');
		}
    }	

	/** WP: Column default */
	function column_default($item, $column_name){
		switch($column_name){
			case 'option_name':
			case 'option_value':
			case 'option_size':
			case 'option_autoload':
			case 'site_id':
			case 'option_belongs_to':
			  return $item[$column_name];
			default:
			  return print_r($item, true) ; //Show the whole array for troubleshooting purposes
		}
	}

	/** WP: Column cb for check box */
	function column_cb($item) {
		return sprintf('<input type="checkbox" name="aDBc_elements_to_process[]" value="%s" />', $item['site_id']."|".$item['option_name']);
	}

	/** WP: Get bulk actions */
	function get_bulk_actions() {
		$actions = array(
			'scan_selected' 		=> __('Scan selected options','advanced-database-cleaner'),
			'edit_categorization' 	=> __('Edit categorization','advanced-database-cleaner'),
			'autoload_yes'  		=> __('Set autoload to yes','advanced-database-cleaner'),
			'autoload_no'  			=> __('Set autoload to no','advanced-database-cleaner'),
			'delete'    			=> __('Delete','advanced-database-cleaner'),
		);
		return $actions;
	}

	/** WP: Message to display when no items found */
	function no_items() {
		_e('No options found!','advanced-database-cleaner');
	}

	/** WP: Process bulk actions */
    public function process_bulk_action() {
        // security check!
        if (isset($_POST['_wpnonce']) && !empty($_POST['_wpnonce'])){
            $nonce  = filter_input(INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING);
            $action = 'bulk-' . $this->_args['plural'];
            if (!wp_verify_nonce( $nonce, $action))
                wp_die('Security check failed!');
        }else{
			// If $_POST['_wpnonce'] is not set, return
			return;
		}

		// Check role
		if(!current_user_can('administrator'))
			wp_die('Security check failed!');

        $action = $this->current_action();

        if($action == 'delete'){
			// If the user wants to clean the options he/she selected
			if(isset($_POST['aDBc_elements_to_process'])){
				if(function_exists('is_multisite') && is_multisite()){
					// Prepare options to delete in organized array to minimize switching from blogs
					$options_to_delete = array();
					foreach($_POST['aDBc_elements_to_process'] as $option){
						$option_info 	= explode("|", $option);
						$site_id 		= sanitize_html_class($option_info[0]);
						$option_name 	= sanitize_text_field($option_info[1]);
						if(is_numeric($site_id)){
							if(empty($options_to_delete[$site_id])){
								$options_to_delete[$site_id] = array();
							}
							// We delete some characters we believe they should not appear in the name: & < > = # ( ) [ ] { } ? " ' 
							$option_name = preg_replace("/[&<>=#\(\)\[\]\{\}\?\"\' ]/", '', $option_name);
							array_push($options_to_delete[$site_id], $option_name);
						}
					}
					// Delete options
					foreach($options_to_delete as $site_id => $options){
						switch_to_blog($site_id);
						foreach($options as $option) {
							delete_option($option);
						}
						restore_current_blog();
					}
				}else{
					foreach($_POST['aDBc_elements_to_process'] as $option) {
						$aDBc_option_info 	= explode("|", $option);
						$option_name 		= sanitize_text_field($aDBc_option_info[1]);
						// We delete some characters we believe they should not appear in the name: & < > = # ( ) [ ] { } ? " ' 
						$option_name 		= preg_replace("/[&<>=#\(\)\[\]\{\}\?\"\' ]/", '', $option_name);
						delete_option($option_name);
					}
				}
				// Update the message to show to the user
				$this->aDBc_message = __('Selected options cleaned successfully!', 'advanced-database-cleaner');
			}
        }else if($action == 'autoload_yes' || $action == 'autoload_no'){

			if($action == 'autoload_yes'){
				$autoload_value = "yes";
			}else{
				$autoload_value = "no";
			}

			// If the user wants to change autoload to yes for selected options
			// xxx, changing autoload using update_option works only on WP 4.2 and newer. Should I set minimum required wp to 4.2 in my plugin header?
			if(isset($_POST['aDBc_elements_to_process'])){
				$additional_msg = "";
				if(function_exists('is_multisite') && is_multisite()){
					// Prepare options to process in organized array to minimize switching from blogs
					$options_to_process = array();
					foreach($_POST['aDBc_elements_to_process'] as $option){
						$option_info 	= explode("|", $option);
						$site_id 		= sanitize_html_class($option_info[0]);
						$option_name 	= sanitize_text_field($option_info[1]);	
						if(is_numeric($site_id)){
							if(empty($options_to_process[$site_id])){
								$options_to_process[$site_id] = array();
							}
							// We delete some characters we believe they should not appear in the name: & < > = # ( ) [ ] { } ? " ' 
							$option_name = preg_replace("/[&<>=#\(\)\[\]\{\}\?\"\' ]/", '', $option_name);
							array_push($options_to_process[$site_id], $option_name);
						}
					}
					// Change autoload
					foreach($options_to_process as $site_id => $options){
						switch_to_blog($site_id);
						foreach($options as $option){
							// In adbc-edd-sample-plugin, EDD deletes aDBc_edd_license_status if aDBc_edd_license_key has been changed
							// This means that we should not change its value to prevent this to happen
							if($option != "aDBc_edd_license_key"){
								$options_value = get_option($option);
								update_option($option, "xyz");
								update_option($option, $options_value, $autoload_value);
							}else{
								$additional_msg = "<span style='color:orange'>" . __('For technical concerns, the option aDBc_edd_license_key cannot be changed!', 'advanced-database-cleaner') . "</span>";
							}
						}
						restore_current_blog();
					}
				}else{
					foreach($_POST['aDBc_elements_to_process'] as $option) {
						$aDBc_option_info 	= explode("|", $option);
						$option_name 		= sanitize_text_field($aDBc_option_info[1]);
						// We delete some characters we believe they should not appear in the name: & < > = # ( ) [ ] { } ? " ' 
						$option_name 		= preg_replace("/[&<>=#\(\)\[\]\{\}\?\"\' ]/", '', $option_name);						
						// In adbc-edd-sample-plugin, EDD deletes aDBc_edd_license_status if aDBc_edd_license_key has been changed
						// This means that we should not change its value to prevent this to happen
						if($option_name != "aDBc_edd_license_key"){
							$options_value = get_option($option_name);
							// Wordpress does not allow to change to autoload if the value have not been changed as well
							// We should change the value to something such as xyz, then change it back again to its original value
							update_option($option_name, "xyz");
							update_option($option_name, $options_value, $autoload_value);
						}else{
							$additional_msg = "<span style='color:orange'>" . __('For technical concerns, the option aDBc_edd_license_key cannot be changed!', 'advanced-database-cleaner') . "</span>";
						}
					}
				}
				// Update the message to show to the user
				$this->aDBc_message = __('Autoload value successfully changed!', 'advanced-database-cleaner') . " " . $additional_msg;
			}
		}else if($action == 'edit_categorization'){
			// If the user wants to edit categorization of the options he/she selected
			if(isset($_POST['aDBc_elements_to_process'])){
				// Create a temp file containing options names to change categorization for
				$aDBc_path_items = fopen(ADBC_UPLOAD_DIR_PATH_TO_ADBC . "/options_manually_correction_temp.txt", "w");
				if($aDBc_path_items){
					foreach($_POST['aDBc_elements_to_process'] as $option){
						$option_info = explode("|", $option);
						$option_name = sanitize_text_field($option_info[1]);
						// We delete some characters we believe they should not appear in the name: & < > = # ( ) [ ] { } ? " ' 
						$option_name = preg_replace("/[&<>=#\(\)\[\]\{\}\?\"\' ]/", '', $option_name);						
						fwrite($aDBc_path_items, $option_name . "\n");
					}
					fclose($aDBc_path_items);
				}
			}
		}
    }

	/** Print the page content */
	function aDBc_print_page_content(){
		// Print a message if any
		if($this->aDBc_message != ""){
			echo '<div id="aDBc_message" class="' . $this->aDBc_class_message . ' notice is-dismissible"><p>' . $this->aDBc_message . '</p></div>';
		}

		// If the search has finished, show a msg success to users + button to double check results against our server database
		echo $this->aDBc_search_has_finished_msg;

		// If the folder adbc_uploads cannot be created, show a msg to users
		if(!empty($this->aDBc_permission_adbc_folder_msg)){
			echo '<div class="error notice is-dismissible"><p>' . $this->aDBc_permission_adbc_folder_msg . '</p></div>';
		}		

		?>
		<div class="aDBc-content-max-width">

		<?php
		// If options_manually_correction_temp.txt exist, this means that user want to edit categorization
		if(file_exists(ADBC_UPLOAD_DIR_PATH_TO_ADBC . '/options_manually_correction_temp.txt')){

			include_once 'edit_item_categorization.php';

		// If not, we print the options normally
		}else{

			// Print a notice/warning according to each type of options
			if($_GET['aDBc_cat'] == 'o' && $this->aDBc_options_categories_info['o']['count'] > 0){
				echo '<div class="aDBc-box-warning-orphan">' . __('Options below seem to be orphan! However, please delete only those you are sure to be orphan!','advanced-database-cleaner') . '</div>';
			}else if(($_GET['aDBc_cat'] == 'all' || $_GET['aDBc_cat'] == 'u') && $this->aDBc_options_categories_info['u']['count'] > 0){
				echo '<div class="aDBc-box-info">' . __('Some of your options are not categorized yet! Please click on the button below to categorize them!','advanced-database-cleaner') . '</div>';
			} ?>

			<div class="aDBc-clear-both" style="margin-top:15px"></div>

			<!-- Code for "run new search" button + Show loading image -->
			<div style="float:left;">
				<?php
				if($this->aDBc_which_button_to_show == "new_search" ){
					$aDBc_search_text  		= __('Scan options','advanced-database-cleaner');
				}else{
					$aDBc_search_text  		= __('Continue scannig ...','advanced-database-cleaner');
				}
				?>

				<!-- This hidden input is used by ajax to know which item type we are dealing with -->
				<input type="hidden" id="aDBc_item_type" value="options"/>
				<?php
				// These hidden inputs are used by ajax to see if we should execute scanning process automatically by ajax after reloading a page
				$iteration = get_option("aDBc_temp_last_iteration_options");
				?>
				<input type="hidden" id="aDBc_iteration" value="<?php echo $iteration; ?>"/>
				<input type="hidden" id="aDBc_count_uncategorized" value="<?php echo $this->aDBc_options_categories_info['u']['count']; ?>"/>
				<input type="hidden" id="aDBc_count_all_items" value="<?php echo $this->aDBc_options_categories_info['all']['count']; ?>"/>

				<input id="aDBc_new_search_button" type="submit" class="aDBc-run-new-search" value="<?php echo $aDBc_search_text; ?>"  name="aDBc_new_search_button" />

			</div>

			<!-- Print numbers of options found in each category -->
			<div class="aDBc-category-counts">
				<?php
				$aDBc_new_URI = $_SERVER['REQUEST_URI'];
				// Remove the paged parameter to start always from the first page when selecting a new category of tables
				$aDBc_new_URI = remove_query_arg('paged', $aDBc_new_URI);
				$iterations = 0;
				foreach($this->aDBc_options_categories_info as $abreviation => $category_info){
					$iterations++;
					$aDBc_new_URI = add_query_arg('aDBc_cat', $abreviation, $aDBc_new_URI);?>
					<span class="<?php echo $abreviation == $_GET['aDBc_cat'] ? 'aDBc-selected-category' : ''?>" style="<?php echo $abreviation == $_GET['aDBc_cat'] ? 'border-bottom: 1px solid ' . $category_info['color'] : '' ?>">

						<?php
						$aDBc_link_style = "color:" . $category_info['color'];
						$aDBc_category_info_count = "(". $category_info['count'] . ")";
						?>

						<span class="aDBc_premium_tooltip">
							<a href="<?php echo $aDBc_new_URI; ?>" class="aDBc-category-counts-links" style="<?php echo $aDBc_link_style ; ?>">
								<span><?php echo $category_info['name']; ?></span>
								<span><?php echo $aDBc_category_info_count ;?></span>
							</a>
						</span>

					</span>
					<?php
					if($iterations < 6){
						echo '<span class="aDBc-category-separator">|</span>';
					}
				}?>
			</div>

			<div class="aDBc-clear-both"></div>

			<div id="aDBc_progress_container">
				<div style="background:#ccc;width:100%;height:20px">
					<div id="aDBc-progress-bar" class="aDBc_progress-bar"></div>
				</div>
				<a id="aDBc_stop_scan" href="#" style="color:red"><?php _e('Stop the scan','advanced-database-cleaner') ?></a>
				<span id="aDBc_stopping_msg" style="display: none;"><?php _e('Stopping...','advanced-database-cleaner') ?></span>
			</div>

			<?php include_once 'header_page_filter.php'; ?>

			<div class="aDBc-clear-both"></div>

			<form id="aDBc_form" action="" method="post">
				<?php
				// Print the options
				$this->display();
				?>
			</form>
		<?php
		}
		?>
		</div>
	<?php
	}
}

new ADBC_Options_List();

?>