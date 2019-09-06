<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

require_once "class.abstract-filters.php";


class WUPM_ThemeFilters extends WUPM_AbstractFilters
{

    public function load()
    {
        $updates_mode = $this->plugin->getPopulateOption('theme_updates');

        $this->is_disable_updates = $updates_mode == 'disable_theme_updates';
        $this->is_auto_updates = $updates_mode == 'enable_theme_auto_updates';
        $this->is_disable_translation_updates = $this->plugin->getPopulateOption('auto_tran_update');

        $default_options = $this->getDefaultOptions();
        $options = $this->plugin->getPopulateOption('themes_update_filters');
        $this->update_filters = array_merge($default_options, (array)$options);
    }

    public function save()
    {
        $this->plugin->updatePopulateOption('themes_update_filters', $this->update_filters);
    }

    public function disableUpdates($item_slug)
    {
        parent::disableUpdates($item_slug);
        $this->clearThemeUpdateCache();
    }

    public function enableUpdates($item_slug)
    {
        parent::enableUpdates($item_slug);
        $this->clearThemeUpdateCache();
    }

    public function clearThemeUpdateCache(){
        $last_update = get_site_transient('update_themes');
        if ( ! is_object($last_update) ){
            $last_update = new stdClass;
        }
        // set expired time
        $last_update->last_checked = 0;
        set_site_transient( 'update_themes', $last_update );
    }


}