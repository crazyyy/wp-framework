<?php
class EHSSL_Config
{
    public $configs;
    public $message_stack;
    static $_this;

    public function __construct()
    {
        $this->message_stack = new stdClass();
    }

    public function load_config()
    {
        $this->configs = get_option('ehssl_configs');
    }

    public function get_value($key)
    {
        return isset($this->configs[$key]) ? $this->configs[$key] : '';
    }

    public function set_value($key, $value)
    {
        $this->configs[$key] = $value;
    }

    public function add_value($key, $value)
    {
        if (array_key_exists($key, $this->configs)) {
            //Don't update the value for this key
        } else { //It is safe to update the value for this key
            $this->configs[$key] = $value;
        }
    }

    public function save_config()
    {
        update_option('ehssl_configs', $this->configs);
    }

    public function get_stacked_message($key)
    {
        if (isset($this->message_stack->{$key})) {
            return $this->message_stack->{$key};
        }

        return "";
    }

    public function set_stacked_message($key, $value)
    {
        $this->message_stack->{$key} = $value;
    }

    public static function get_instance()
    {
        if (empty(self::$_this)) {
            self::$_this = new EHSSL_Config();
            self::$_this->load_config();
            return self::$_this;
        }
        return self::$_this;
    }
}
