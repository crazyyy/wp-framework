<?php

/**
 * Woody Dropdown List Control
 *
 * Main options:
 *  name            => a name of the control
 *  value           => a value to show in the control
 *  default         => a default value of the control if the "value" option is not specified
 *  items           => a callback to return items or an array of items to select
 *
 * @author Artem Prihodko <webtemyk@ya.ru>
 * @copyright (c) 2021, CreativeMotion
 *
 * @package factory-forms
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WINP_FactoryForms_Dropdown' ) ) {

	class WINP_FactoryForms_Dropdown extends Wbcr_FactoryForms447_DropdownControl {

		public $type = 'winp-dropdown';

		/**
		 * @param array $items
		 * @param null $selected
		 */
		protected function printItems( $items, $selected = null ) {
			foreach ( (array) $items as $item ) {
				$subitems = array();
				$data     = null;

				// this item is an associative array
				if ( isset( $item['type'] ) || isset( $item['value'] ) ) {
					$type     = isset( $item['type'] ) ? $item['type'] : 'option';
					$disabled = isset( $item['disabled'] ) && $item['disabled'] == 'disabled' ? 'disabled' : '';

					if ( 'group' === $type ) {
						$subitems = isset( $item['items'] ) ? $item['items'] : array();
					}

					$value = isset( $item['value'] ) ? $item['value'] : '';
					$title = isset( $item['title'] ) ? $item['title'] : __( '- empty -', 'wbcr_factory_forms_447' );

					$data = isset( $item['data'] ) ? $item['data'] : null;
				} else {
					$type = ( count( $item ) == 3 && $item[0] === 'group' ) ? 'group' : 'option';
					if ( 'group' === $type ) {
						$subitems = $item[2];
					}

					$title = $item[1];
					$value = esc_attr( $item[0] );
				}

				if ( 'group' === $type ) {
					?>
                    <optgroup label="<?php echo $title ?>" <?php echo $disabled; ?>>
						<?php $this->printItems( $subitems, $selected ); ?>
                    </optgroup>
					<?php
				} else {
					$attr    = ( $selected == $value ) ? 'selected="selected"' : '';
					$strData = '';

					if ( ! empty( $data ) ) {
						foreach ( $data as $key => $values ) {
							$strData = $strData . ' data-' . $key . '="' . ( is_array( $values ) ? implode( ',', $values ) : $values ) . '"';
						}
					}

					?>
                    <option value='<?php echo $value ?>' <?php echo $attr ?> <?php echo $strData ?>>
						<?php echo $title ?>
                    </option>
					<?php
				}
			}
		}
	}
}