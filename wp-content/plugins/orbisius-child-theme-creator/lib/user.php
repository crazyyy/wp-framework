<?php

class orbisius_child_theme_creator_user {
    private $api_meta_key = '_orb_ctc_cloud_api_key';
    private $meta_cloud_plan = '_orb_ctc_cloud_plan';
    private $meta_cloud_email = '_orb_ctc_cloud_email';

    /**
     * Singleton pattern i.e. we have only one instance of this obj
     *
     * @staticvar type $instance
     * @return \cls
     */
    public static function get_instance() {
        static $instance = null;

        // This will make the calling class to be instantiated.
        // no need each sub class to define this method.
        if (is_null($instance)) {
            // We do a late static binding. i.e. the instance is the subclass of this one.
            $instance = new self(); // leave only this line and not the hack.
        }

        return $instance;
    }
    
    /**
     * 
     * @param str/opt $key
     * @return str
     */
    public function api_key($key = null) {
        static $val = null;

        if (!is_null($val) && is_null($key)) { // get
            return $val;
        }
        
        $user_id = $this->get_user_id();
        
        if (!empty($key)) {
            $up_status = update_user_meta($user_id, $this->api_meta_key, $key);
            $val = get_user_meta($user_id, $this->api_meta_key, true);
        } elseif (!is_null($key)) { // empty string so delete
            delete_user_meta($user_id, $this->api_meta_key);
            $val = null;
        } else {
            $val = get_user_meta($user_id, $this->api_meta_key, true);
        }

        return $val;
    }
    
    /**
     * 
     * @param str/opt $data
     * @return str
     */
    public function plan($data = null) {
        static $val = null;
        
        if (!is_null($val) && is_null($data)) { // get
            return $val;
        }
        
        $user_id = $this->get_user_id();
        
        if (!empty($data)) {
            $up_status = update_user_meta($user_id, $this->meta_cloud_plan, $data);
            $val = get_user_meta($user_id, $this->meta_cloud_plan, true);
        } elseif (!is_null($data)) { // empty string so delete
            delete_user_meta($user_id, $this->meta_cloud_plan);
            $val = null;
        } else {
            $val = get_user_meta($user_id, $this->meta_cloud_plan, true);
        }

        return $val;
    }
    
    /**
     * 
     * @param str/opt $key
     * @return str
     */
    public function email($key = null) {
        static $val = null;
        
        if (!is_null($val) && is_null($key)) { // get
            return $val;
        }
        
        $user_id = $this->get_user_id();
        
        if (!empty($key)) {
            $up_status = update_user_meta($user_id, $this->meta_cloud_email, $key);
            $val = get_user_meta($user_id, $this->meta_cloud_email, true);
        } elseif (!is_null($key)) { // empty string so delete
            delete_user_meta($user_id, $this->meta_cloud_email);
            $val = null;
        } else {
            $val = get_user_meta($user_id, $this->meta_cloud_email, true);
        }

        return $val;
    }
    
    /**
     * 
     * @param str/opt $key
     * @return str
     */
    public function get_user_id() {
        $user_id = get_current_user_id();
        return $user_id;
    }

    /**
     * Clears some plan related info so it's fresh for next time.
     */
    public function clear_account_data() {
        $this->plan('');
        $this->email('');
        $this->api_key('');
    }

}
