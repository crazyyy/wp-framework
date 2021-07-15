<?php
/* Security-Check */
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('pbSettingsFramework_2') ):
	class pbSettingsFramework_2
	{
		var $textDomain = false;
		var $page = false;
		var $section = false;
		var $optionGroup = false;
		var $args = array();

		public function __construct( $args=array() )
		{
			$this->textDomain       = $args['text-domain'] || 'pbSettingsFramework';
			$this->page             = $args['page'];
			$this->section          = $args['section'];
			$this->optionGroup      = $args['option-group'];
			$this->args             = $args;
		}

		/**
		 * Register setting
		 *
		 * @param string $setting
		 */
		public function registerSetting( $setting )
		{
			if( ! isset($this->args['option-group']) ) {
				die(__FUNCTION__.': $args[\'option-group\'] not set!');
			}

			register_setting(
				$this->args['option-group'],
				$setting
			);
		}

		/**
		 * Add settings section
		 *
		 * @param $id
		 * @param $title
		 * @param $callback
		 */
		public function addSettingsSection($id, $title, $callback)
		{
			add_settings_section(
				$id,
				$title,
				$callback,
				$this->args['page']
			);
		}

		/**
		 * Add settings field
		 *
		 * @param $id
		 * @param $title
		 * @param $args
		 * @param array $callback
		 * @param bool $register_setting
		 */
		public function addSettingsField($id, $title, $args, $callback=array(), $register_setting=false)
		{
			if( count($callback) === 0 ) {
				$callback = array($this, 'fieldsHTML');
			}

			if( $register_setting ) {
				//register_setting( $this->args['option-group'], $id, 'esc_attr' );
				$this->registerSetting( $this->optionGroup );
			}

			add_settings_field(
				$id,
				'<label for="'.$id.'">'.$title.'</label>',
				$callback,
				$this->page,
				$this->section,

				array_merge_recursive(
					array(
						'id' => $id,
						'section' => $this->section
					),

					$args
				)
			);
		}

		/**
		 * get array key
		 *
		 * @param $key
		 * @param $array
		 * @return bool
		 */
		public function getArrayKey($key, $array)
		{
			if( array_key_exists($key, $array) ) {
				return $array[$key];
			} else {
				return false;
			}
		}

		/**
		 * html code for fields
		 *
		 * @param $args
		 */
		public function fieldsHTML( $args )
		{
			$option = get_option($this->optionGroup);

			if( isset($option[$args['id']]) ) {
				$option = $option[$args['id']];
			} else {
				$option = null;
			}

			$html = '';

			if( $this->getArrayKey('type', $args) == 'text' || $this->getArrayKey('type', $args) == 'number' ) {

				if ( empty( $option ) ) {
					$val = $this->getArrayKey('default', $args);
				} else {
					$val = $option;
				}

				if( $this->getArrayKey('type', $args) == 'number' ) {
					$input_type = 'number';
				} else {
					$input_type = 'text';
				}

				$html = '<input type="'.$input_type.'" id="' . $args['id'] . '" name="'.$this->optionGroup.'['.$args['id'].']" class="regular-text" value="' . $val . '" '.(($this->getArrayKey('disabled', $args))?'disabled="disabled"':'').' />';

				$desc = $this->getArrayKey('desc', $args);

				if ( ! empty( $desc ) ) {
					$html .= '<p class="description">' . $desc . '</p>';
				}

			} elseif( $args['type'] == 'checkbox' ) {

				if( $option === false ){
					$val = $this->getArrayKey('default', $args);
				}else{
					$val = $option;
				}
				$html = '<input type="checkbox" id="'.$args['id'].'" name="'.$this->optionGroup.'['.$args['id'].']" value="1" '.(($this->getArrayKey('disabled', $args))?'disabled="disabled"':'').' '.checked(1, $val, false).'/>';

				$html .= '<label for="'.$args['id'].'"> '. $this->getArrayKey('desc', $args) .'</label>';

			} elseif( $args['type'] == 'select' ) {

				if ( empty( $option ) ) {
					$val = $this->getArrayKey('default', $args);
				} else {
					$val = $option;
				}

				$html = '<select id="'.$args['id'].'" name="'.$this->optionGroup.'['.$args['id'].']">';
				foreach ($args['select'] as $name => $value ) {
					$html .= '<option value="'.$name.'" '.(($val==$name)?'selected="selected"':'').' '.(($this->getArrayKey('disabled', $args))?'disabled="disabled"':'').'>'.esc_html($value).'</option>';
				}
				$html .= '</select>';

				$desc = $this->getArrayKey('desc', $args);

				if ( ! empty( $desc ) ) {
					$html .= '<p class="description">' . $desc . '</p>';
				}

			}

			echo $html;
		}

		public function doSettingsSections( $page ) {
			global $wp_settings_sections, $wp_settings_fields;

			if ( ! isset( $wp_settings_sections[$page] ) )
				return;

			foreach ( (array) $wp_settings_sections[$page] as $section ) {
				if ( isset($section['prepend']) && !empty($section['prepend']) ){
					echo $section['prepend'];
				}

				if ( isset($section['title']) && !empty($section['title']) ) {
					echo "<h2 class='pb-section-title'>{$section['title']}</h2>\n";
				}

				if ( isset($section['callback']) && !empty($section['callback']) ) {
					call_user_func( $section['callback'], $section );
				}

				if ( ! isset( $wp_settings_fields ) || !isset( $wp_settings_fields[$page] ) || !isset( $wp_settings_fields[$page][$section['id']] ) )
					continue;

				echo '<div id="'.$section['id'].'" class="pb-section-wrap">';
				echo '<table class="form-table">';
				do_settings_fields( $page, $section['id'] );
				echo '</table>';
				echo '</div>';

				if ( isset($section['append']) && !empty($section['append']) ) {
					echo $section['append'];
				}
			}
		}
	}
endif;