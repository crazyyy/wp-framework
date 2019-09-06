<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

require_once "class.abstract-filters.php";


class WUPM_PluginFilters extends WUPM_AbstractFilters
{

    public function load()
    {
        $updates_mode = $this->plugin->getPopulateOption('plugin_updates');

        $this->is_disable_updates = $updates_mode == 'disable_plugin_updates';
        $this->is_auto_updates = $updates_mode == 'enable_plugin_auto_updates';
        $this->is_disable_translation_updates = $this->plugin->getPopulateOption('auto_tran_update');

        $default_options = $this->getDefaultOptions();
        $options = $this->plugin->getPopulateOption('plugins_update_filters');
        $this->update_filters = array_merge($default_options, (array)$options);
        $this->update_filters = apply_filters('wbcr/upm/plugin_filters', $this->update_filters);
        $this->ignorePersistentPlugins($this->update_filters);
    }

    public function save()
    {
        $this->plugin->updatePopulateOption('plugins_update_filters', $this->update_filters);
    }

    /**
     * Disable plugin display in default page Plugins
     * @param $item_slug - plugin slug (without main file path)
     */
    public function disableDisplay($item_slug)
    {
        if (!empty($item_slug)) {
            if (isset($this->update_filters['disable_display'])) {
                if (!isset($this->update_filters['disable_display'][$item_slug])) {
                    $this->update_filters['disable_display'][$item_slug] = true;
                }
            } else {
                $this->update_filters['disable_display'] = array();
                $this->update_filters['disable_display'][$item_slug] = true;
            }

            $this->save();
        }
    }

    /**
     * Enable plugin display in default page Plugins
     * @param $item_slug - plugin slug (without main file path)
     */
    public function enableDisplay($item_slug)
    {
        if (!empty($item_slug)) {
            if (isset($this->update_filters['disable_display']) && isset($this->update_filters['disable_display'][$item_slug])) {
                unset($this->update_filters['disable_display'][$item_slug]);
                $this->save();
            }
        }
    }

    public function getFilters(){
        return $this->update_filters;
    }

    /**
     * Метод возвращает список вычесленных опций для переданных плагинов
     * @param array|bool $plugin_list - list of plugin slug
     * @return array
     */
    public function getPlugins($plugin_list = false){
        // get all plugins
        if($plugin_list === false){
            $plugin_list = array();
            $all_plugins = get_plugins();
            foreach ($all_plugins as $slug => $plugin){
                $slug_parts = explode('/', $slug);
                $actual_slug = array_shift($slug_parts);
                $plugin_list[] = $actual_slug;
            }
        }

        $result = $this->getDefaultOptions();
        $all_update_disabled = $this->plugin->getPopulateOption('plugin_updates') === 'disable_plugin_updates';
        $update_tran_disabled = $this->plugin->getPopulateOption('auto_tran_update');
        $auto_update_disabled = $this->plugin->getPopulateOption('plugin_updates') !== 'enable_plugin_auto_updates';;

        foreach ($plugin_list as $plugin_slug){
            // individual rules
            $result['disable_updates'][$plugin_slug] = false;
            if(isset($this->update_filters['disable_updates'][$plugin_slug]) and $this->update_filters['disable_updates'][$plugin_slug]){
                $result['disable_updates'][$plugin_slug] = true;
            }
            $result['disable_auto_updates'][$plugin_slug] = false;
            if(isset($this->update_filters['disable_auto_updates'][$plugin_slug]) and $this->update_filters['disable_auto_updates'][$plugin_slug]){
                $result['disable_auto_updates'][$plugin_slug] = true;
            }
            $result['disable_translation_updates'][$plugin_slug] = false;
            if(isset($this->update_filters['disable_translation_updates'][$plugin_slug]) and $this->update_filters['disable_translation_updates'][$plugin_slug]){
                $result['disable_translation_updates'][$plugin_slug] = true;
            }
            if(isset($this->update_filters['disable_display'][$plugin_slug]) and $this->update_filters['disable_display'][$plugin_slug]){
                $result['disable_updates'][$plugin_slug] = true;
                $result['disable_auto_updates'][$plugin_slug] = true;
                $result['disable_translation_updates'][$plugin_slug] = true;
            }

            // global rules
            if($all_update_disabled){
                $result['disable_updates'][$plugin_slug] = true;
                $result['disable_auto_updates'][$plugin_slug] = true;
                $result['disable_translation_updates'][$plugin_slug] = true;
            }else{
                if($update_tran_disabled){
                    $result['disable_translation_updates'][$plugin_slug] = true;
                }
                if($auto_update_disabled){
                    $result['disable_auto_updates'][$plugin_slug] = true;
                }
            }
        }
        $result = $this->ignorePersistentPlugins($result);

        return $result;
    }

    /** исключает специальные плагины из фильтров
     * @param $plugins
     * @return mixed
     */
    private function ignorePersistentPlugins($plugins){
        $persistPlugins = self::getPersistentPlugins();
        foreach ($persistPlugins as $persistPlugin){
            $slug_parts = explode('/', $persistPlugin);
            $actual_slug = array_shift($slug_parts);
            if(array_key_exists($actual_slug, (array)$plugins['disable_updates'])){
                unset($plugins['disable_updates'][$actual_slug]);
            }
        }
        return $plugins;
    }

    /**
     * @return array список специальных плагинов
     */
    static public function getPersistentPlugins(){
        return array(
            "wp-plugin-clearfy/clearfy.php",
            "clearfy/clearfy.php",
            "wp-plugin-update-manager/webcraftic-updates-manager.php",
            "webcraftic-updates-manager/webcraftic-updates-manager.php"
        );
    }

}