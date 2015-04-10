<?php

class AIOWPSecurity_Deactivation
{
    static function run_deactivation_tasks()
    {	
        global $wpdb;
        global $aio_wp_security;
        
        //Let's first save the current aio_wp_security_configs options in a temp option
        update_option('aiowps_temp_configs', $aio_wp_security->configs->configs);
        
        //Deactivate all firewall and other .htaccess rules
        AIOWPSecurity_Configure_Settings::turn_off_all_firewall_rules();
    }
    
    static function get_original_file_contents($key_description)
    {
        global $wpdb;
        $aiowps_global_meta_tbl_name = AIOWPSEC_TBL_GLOBAL_META_DATA;
        $resultset = $wpdb->get_row("SELECT * FROM $aiowps_global_meta_tbl_name WHERE meta_key1 = '$key_description'", OBJECT);
        if($resultset){
            $file_contents = maybe_unserialize($resultset->meta_value2);
            return $file_contents;
        }
        else
        {
            return false;
        }
    }
}
