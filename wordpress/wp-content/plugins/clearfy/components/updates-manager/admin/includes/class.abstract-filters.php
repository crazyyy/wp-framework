<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

abstract class WUPM_AbstractFilters
{
    protected $plugin;
    protected $update_filters;
    protected $is_disable_updates;
    protected $is_auto_updates;
    protected $is_disable_translation_updates;


    function __construct(Wbcr_Factory409_Plugin $plugin)
    {
        $this->plugin = $plugin;
        $this->load();
    }

    /**
     * disable all updates for item
     * @param $item_slug string - theme or plugin slug (without main file path)
     */
    public function disableUpdates($item_slug)
    {
        if (!$this->is_disable_updates) {


            if (!empty($item_slug)) {
                if (isset($this->update_filters['disable_updates'])) {
                    if (!isset($this->update_filters['disable_updates'][$item_slug])) {
                        $this->update_filters['disable_updates'][$item_slug] = true;
                    }
                } else {
                    $this->update_filters['disable_updates'] = array();
                    $this->update_filters['disable_updates'][$item_slug] = true;
                }

                $this->save();
            }
        }
    }

    /**
     * enable all updates for item
     * @param $item_slug string - theme or plugin slug (without main file path)
     */
    public function enableUpdates($item_slug)
    {
        if (!$this->is_disable_updates) {
            if (!empty($item_slug)) {
                if (isset($this->update_filters['disable_updates']) && isset($this->update_filters['disable_updates'][$item_slug])) {
                    unset($this->update_filters['disable_updates'][$item_slug]);
                    $this->save();
                }
            }
        }
    }

    /**
     * disable auto-update for item
     * @param $item_slug string - theme or plugin slug (without main file path)
     */
    public function disableAutoUpdates($item_slug)
    {
        if ($this->is_auto_updates) {
            if (!empty($item_slug)) {
                if (isset($this->update_filters['disable_auto_updates'])) {
                    if (!isset($this->update_filters['disable_auto_updates'][$item_slug])) {
                        $this->update_filters['disable_auto_updates'][$item_slug] = true;
                    }
                } else {
                    $this->update_filters['disable_auto_updates'] = array();
                    $this->update_filters['disable_auto_updates'][$item_slug] = true;
                }
                $this->save();
            }
        }
    }

    /**
     * enable auto-update for item
     * @param $item_slug string - theme or plugin slug (without main file path)
     */
    public function enableAutoUpdates($item_slug)
    {
        if ($this->is_auto_updates) {
            if (!empty($item_slug)) {
                if (isset($this->update_filters['disable_auto_updates']) && isset($this->update_filters['disable_auto_updates'][$item_slug])) {
                    unset($this->update_filters['disable_auto_updates'][$item_slug]);
                    $this->save();
                }
            }
        }
    }

    /**
     * enable translation updates for item
     * @param $item_slug string - theme or plugin slug (without main file path)
     */
    public function enableTranslationUpdates($item_slug)
    {
        if (!$this->is_disable_translation_updates) {
            if (!empty($item_slug)) {
                if (isset($this->update_filters['disable_translation_updates']) && isset($this->update_filters['disable_translation_updates'][$item_slug])) {
                    unset($this->update_filters['disable_translation_updates'][$item_slug]);
                    $this->save();
                }
            }
        }
    }

    /**
     * disable translation updates for item
     * @param $item_slug string - theme or plugin slug (without main file path)
     */
    public function disableTranslationUpdates($item_slug)
    {
        if (!$this->is_disable_translation_updates) {
            if (!empty($item_slug)) {
                if (!isset($this->update_filters['disable_translation_updates'])) {
                    $this->update_filters['disable_translation_updates'] = array();
                }
                $this->update_filters['disable_translation_updates'][$item_slug] = true;
                $this->save();
            }
        }
    }

    /**
     * Default filters data
     * @return array
     */
    protected function getDefaultOptions(){
        return array(
            'disable_updates' => array(),
            'disable_auto_updates' => array(),
            'disable_translation_updates' => array(),
            'disable_display' => array(),
        );

    }

    /**
     * load filters data from db
     */
    abstract public function load();

    /**
     * save filters data to db
     */
    abstract public function save();


}