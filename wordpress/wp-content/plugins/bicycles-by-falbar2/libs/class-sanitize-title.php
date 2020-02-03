<?php
defined('BBF') or die();

class Sanitize_Title{

	private $utf;

	public function __construct(){

		$this->set_utf();

		return false;
	}

	public function init(){

		add_filter(
			'sanitize_title',
			array(
				$this,
				'sanitize_title'
			),
			9
		);

		add_filter(
			'sanitize_file_name',
			array(
				$this,
				'sanitize_file_name'
			)
		);

		$this->sanitize_existing_slugs();

		return false;
	}

	public function sanitize_existing_slugs(){

		global $wpdb;

		$posts = $wpdb->get_results("SELECT ID, post_name FROM {$wpdb->posts} WHERE post_name REGEXP('[^A-Za-z0-9\-]+') AND post_status IN ('publish', 'future', 'private')");

		foreach((array) $posts as $post){

			$sanitized_name = $this->sanitize_title(urldecode($post->post_name));

			if($post->post_name != $sanitized_name && !empty($sanitized_name)){

				$wpdb->update(
					$wpdb->posts,
					array(
						'post_name' => $sanitized_name
					),
					array(
						'ID' => $post->ID
					)
				);
			}
		}

		$terms = $wpdb->get_results("SELECT term_id, slug FROM {$wpdb->terms} WHERE slug REGEXP('[^A-Za-z0-9\-]+')");

		foreach((array) $terms as $term){

			$sanitized_slug = $this->sanitize_title(urldecode($term->slug));

			if($term->slug != $sanitized_slug && !empty($sanitized_slug)){

				$wpdb->update(
					$wpdb->terms,
					array(
						'slug' => $sanitized_slug
					),
					array(
						'term_id' => $term->term_id
					)
				);
			}
		}

		return false;
	}

	public function sanitize_title($title){

		$title = $this->sanitize($title);

		$title = str_replace('.', '-', $title);
		$title = preg_replace('/-{2,}/', '-', $title);

		return $title;
	}

	public function sanitize_file_name($title){

		return $this->sanitize($title);
	}

	private function sanitize($title){

		$title = html_entity_decode($title, ENT_QUOTES, 'utf-8');
		$title = strtr($title, $this->utf);
		$title = trim($title, '-');
		$title = strtolower($title);
		$title = preg_replace('/[^A-Za-z0-9-_.]/', '-', $title);
		$title = preg_replace( '~([=+.-])\\1+~' , '\\1', $title);

		return $title;
	}

	private function set_utf(){

		$this->utf = array(
			'Ä' => 'Ae',
			'ä' => 'ae',
			'Æ' => 'Ae',
			'æ' => 'ae',
			'À' => 'A',
			'à' => 'a',
			'Á' => 'A',
			'á' => 'a',
			'Â' => 'A',
			'â' => 'a',
			'Ã' => 'A',
			'ã' => 'a',
			'Å' => 'A',
			'å' => 'a',
			'ª' => 'a',
			'ₐ' => 'a',
			'ā' => 'a',
			'Ć' => 'C',
			'ć' => 'c',
			'Ç' => 'C',
			'ç' => 'c',
			'Ð' => 'D',
			'đ' => 'd',
			'È' => 'E',
			'è' => 'e',
			'É' => 'E',
			'é' => 'e',
			'Ê' => 'E',
			'ê' => 'e',
			'Ë' => 'E',
			'ë' => 'e',
			'ₑ' => 'e',
			'ƒ' => 'f',
			'ğ' => 'g',
			'Ğ' => 'G',
			'Ì' => 'I',
			'ì' => 'i',
			'Í' => 'I',
			'í' => 'i',
			'Î' => 'I',
			'î' => 'i',
			'Ï' => 'Ii',
			'ï' => 'ii',
			'ī' => 'i',
			'ı' => 'i',
			'I' => 'I',
			'Ñ' => 'N',
			'ñ' => 'n',
			'ⁿ' => 'n',
			'Ò' => 'O',
			'ò' => 'o',
			'Ó' => 'O',
			'ó' => 'o',
			'Ô' => 'O',
			'ô' => 'o',
			'Õ' => 'O',
			'õ' => 'o',
			'Ø' => 'O',
			'ø' => 'o',
			'ₒ' => 'o',
			'Ö' => 'Oe',
			'ö' => 'oe',
			'Œ' => 'Oe',
			'œ' => 'oe',
			'ß' => 'ss',
			'Š' => 'S',
			'š' => 's',
			'ş' => 's',
			'Ş' => 'S',
			'Ù' => 'U',
			'ù' => 'u',
			'Ú' => 'U',
			'ú' => 'u',
			'Û' => 'U',
			'û' => 'u',
			'Ü' => 'Ue',
			'ü' => 'ue',
			'Ý' => 'Y',
			'ý' => 'y',
			'ÿ' => 'y',
			'Ž' => 'Z',
			'ž' => 'z',
			'⁰' => '0',
			'¹' => '1',
			'²' => '2',
			'³' => '3',
			'⁴' => '4',
			'⁵' => '5',
			'⁶' => '6',
			'⁷' => '7',
			'⁸' => '8',
			'⁹' => '9' ,
			'₀' => '0',
			'₁' => '1',
			'₂' => '2',
			'₃' => '3',
			'₄' => '4',
			'₅' => '5',
			'₆' => '6',
			'₇' => '7',
			'₈' => '8',
			'₉' => '9',
			'±' => '-',
			'×' => 'x',
			'₊' => '-',
			'₌' => '=',
			'⁼' => '=',
			'⁻' => '-',
			'₋' => '-',
			'–' => '-',
			'—' => '-',
			'‑' => '-',
			'․' => '.',
			'‥' => '..',
			'…' => '...',
			'‧' => '.',
			' ' => '-',
			' ' => '-',
			'А' => 'A',
			'Б' => 'B',
			'В' => 'V',
			'Г' => 'G',
			'Д' => 'D',
			'Е' => 'E',
			'Ё' => 'YO',
			'Ж' => 'ZH',
			'З' => 'Z',
			'И' => 'I',
			'Й' => 'Y',
			'К' => 'K',
			'Л' => 'L',
			'М' => 'M',
			'Н' => 'N',
			'О' => 'O',
			'П' => 'P',
			'Р' => 'R',
			'С' => 'S',
			'Т' => 'T',
			'У' => 'U',
			'Ф' => 'F',
			'Х' => 'H',
			'Ц' => 'TS',
			'Ч' => 'CH',
			'Ш' => 'SH',
			'Щ' => 'SCH',
			'Ъ' => '',
			'Ы' => 'Y',
			'Ь' => '',
			'Э' => 'E',
			'Ю' => 'YU',
			'Я' => 'YA',
			'а' => 'a',
			'б' => 'b',
			'в' => 'v',
			'г' => 'g',
			'д' => 'd',
			'е' => 'e',
			'ё' => 'yo',
			'ж' => 'zh',
			'з' => 'z',
			'и' => 'i',
			'й' => 'y',
			'к' => 'k',
			'л' => 'l',
			'м' => 'm',
			'н' => 'n',
			'о' => 'o',
			'п' => 'p',
			'р' => 'r',
			'с' => 's',
			'т' => 't',
			'у' => 'u',
			'ф' => 'f',
			'х' => 'h',
			'ц' => 'ts',
			'ч' => 'ch',
			'ш' => 'sh',
			'щ' => 'sch',
			'ъ' => '',
			'ы' => 'y',
			'ь' => '',
			'э' => 'e',
			'ю' => 'yu',
			'я' => 'ya'
		);

		return false;
	}
}