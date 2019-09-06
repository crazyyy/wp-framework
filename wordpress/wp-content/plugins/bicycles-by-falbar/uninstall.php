<?php
if(!defined('WP_UNINSTALL_PLUGIN')){

	exit();
}

delete_option('_falbar_bbf_options_params');

/*** OLD VERSION  ***/
delete_option('_falbar_bbf_options_name');
/* END OLD VERSION  */