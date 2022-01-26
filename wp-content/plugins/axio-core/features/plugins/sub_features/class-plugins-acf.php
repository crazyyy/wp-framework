<?php
/**
 * Class Plugins_Acf
 */
class Axio_Core_Plugins_Acf extends Axio_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_plugins_acf');

    // var: name
    $this->set('name', 'Settings for the ACF plugin');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {

    add_filter('acf/settings/show_admin', array($this, 'axio_core_hide_acf_from_nonadmins'));
    add_filter('render_block_data', array($this, 'axio_core_acf_render_block_data'), 1, 2);

  }

  /**
   * Hide ACF from non-administrator admin menu
   *
   * @param bool $show is ACF shown
   *
   * @return bool is ACF shown
   */
  public static function axio_core_hide_acf_from_nonadmins($show) {
    return current_user_can('administrator');
  }

  /**
   * Force default visibility mode on some blocks
   *
   * Props @k1sul1 for help with recursifying this
   *
   * @param array $parsed_block parsed block data or inner part of parsed block data
   * @param array $forced_block_types list of blocks to force mode on
   *
   * @return array parsed block data
   */
  public static function axio_core_recursive_block_mode_changer(&$parsed_block, $forced_block_types) {

    if (isset($parsed_block['blockName']) && !empty($parsed_block['blockName'])) {
      foreach ($forced_block_types as $block_type => $mode) {
        if (is_string($mode) && is_string($block_type) && $parsed_block['blockName'] == $block_type) {
          $parsed_block['attrs']['mode'] = $mode;
          break;
        }
      }
    }

    if (isset($parsed_block['innerBlocks']) && !empty($parsed_block['innerBlocks'])) {
      foreach ($parsed_block['innerBlocks'] as &$inner_block) {
        self::axio_core_recursive_block_mode_changer($inner_block, $forced_block_types);
      }
    }

  }

  /**
   * Force default visibility mode on some blocks
   *
   * @param array $block_data parsed block data from JSON
   * @param array $source_block an un-modified copy of $parsed_block, as it appeared in the source content.
   *
   * @return array parsed block data
   */
  public static function axio_core_acf_render_block_data($parsed_block, $source_block) {

    $forced_block_types = apply_filters('axio_core_force_block_type_mode', array());

    if (is_array($forced_block_types) && !empty($forced_block_types)) {
      self::axio_core_recursive_block_mode_changer($parsed_block, $forced_block_types);
    }

    return $parsed_block;

  }

}
