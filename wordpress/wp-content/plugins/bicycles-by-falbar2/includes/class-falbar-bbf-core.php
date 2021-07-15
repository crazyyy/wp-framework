<?php
defined('BBF') or die();

class Falbar_BBF_Core{

	protected $main_file_name;
	protected $main_file_path;
	protected $prefix_db;
	protected $options;

	protected function display_checkbox($type = '', $name = '', $enable = 0){

		$tmp = '';

		if($type && $name){

			$active  = '';
			$checked = '';

			if($enable){

				if(!empty($this->options[$type][$name]['enable']) && $this->options[$type][$name]['enable'] == 1){

					$active  = ' active';
					$checked = ' checked';
				}else{

					$this->options[$type][$name]['enable'] = 0;
				}

				$tmp .= '<div class="checkbox'.$active.'">';
					$tmp .= '<input type="checkbox" name="'.$this->prefix_db.'_options_params['.$type.']['.$name.'][enable]" value="'.$this->options[$type][$name]['enable'].'"'.$checked.' />';
				$tmp .= '</div>';
			}else{

				if(!empty($this->options[$type][$name]) && $this->options[$type][$name] == 1){

					$active  = ' active';
					$checked = ' checked';
				}else{

					$this->options[$type][$name] = 0;
				}

				$tmp .= '<div class="checkbox'.$active.'">';
					$tmp .= '<input type="checkbox" name="'.$this->prefix_db.'_options_params['.$type.']['.$name.']" value="'.$this->options[$type][$name].'"'.$checked.' />';
				$tmp .= '</div>';
			}
		}

		echo($tmp);
	}

	protected function display_textarea($type = '', $name = '', $param = ''){

		$tmp = '';

		if($type && $name && $param){

			if(empty($this->options[$type][$name][$param])){

				$this->options[$type][$name][$param] = '';
			}

			$tmp .= '<textarea name="'.$this->prefix_db.'_options_params['.$type.']['.$name.']['.$param.']">'.htmlspecialchars_decode($this->options[$type][$name][$param], ENT_QUOTES).'</textarea>';
		}

		echo($tmp);
	}

	protected function display_textarea_robots(){

		if(!empty($this->options['seo']['robots_txt']['code'])){

			$value = $this->options['seo']['robots_txt']['code'];
		}else{

			$fbbfoSEO = new Falbar_BBF_Option_SEO();
			$value = $fbbfoSEO->robots_txt_robots_txt('');
		}

		echo('<textarea name="'.$this->prefix_db.'_options_params[seo][robots_txt][code]">'.htmlspecialchars_decode($value, ENT_QUOTES).'</textarea>');
	}

	protected function check_option($type = '', $name = '', $enable = 0){

		if($type && $name){

			if($enable){

				if(!empty($this->options[$type][$name]['enable']) && $this->options[$type][$name]['enable'] == 1){

					return true;
				}
			}else{

				if(!empty($this->options[$type][$name]) && $this->options[$type][$name] == 1){

					return true;
				}
			}
		}

		return false;
	}
}