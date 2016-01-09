<?php

class Wordpress extends DetectCMS {

	public $methods = array(
		"readme",
		"generator_header",
		"generator_meta",
		"button_css"
	);

	public $home_html = "";
        public $home_headers = array();

        function __construct($home_html, $home_headers) {
                $this->home_html = $home_html;
                $this->home_headers = $home_headers;
        }

	/**
	 * See if readme.html exists, and contains Wordpress title
	 * @param  [string] $url
	 * @return [boolean]
	 */
	public function readme($url) {

		if($data = $this->fetch($url."/readme.html")) {

			require_once(dirname(__FILE__)."/../thirdparty/simple_html_dom.php");

			if($html = str_get_html($data)) {

				if($title = $html->find("title",0)) {

					return strpos($title->plaintext, "WordPress &rsaquo; ReadMe") !== FALSE;

				}

			}

		}

		return FALSE;

	}

	/**
	 * Check for Generator header
	 * @return [boolean]
	 */
	public function generator_header() {

		if(is_array($this->home_headers)) {

			foreach($this->home_headers as $line) {

				if(strpos($line, "X-Generator") !== FALSE) {

					return strpos($line, "WordPress") !== FALSE;

				}

			}

		}

		return FALSE;

	}

	/**
	 * Check meta tags for generator
	 * @return [boolean]
	 */
	public function generator_meta() {

		if($this->home_html) {

			require_once(dirname(__FILE__)."/../thirdparty/simple_html_dom.php");

			if($html = str_get_html($this->home_html)) {

				if($meta = $html->find("meta[name='generator']",0)) {

					return strpos($meta->content, "WordPress") !== FALSE;

				}

			}

		}

		return FALSE;

	}

	/**
	 * Check /wp-includes/css/buttons.css content
	 * @param  [string] $url
	 * @return [boolean]
	 */
	public function button_css($url) {

		if($data = $this->fetch($url."/wp-includes/css/buttons.css")) {

			/**
			 * 9th line always has Wordpress-style Buttons
			 */
			$lines = explode(PHP_EOL, $data);

			return strpos($lines[8], "WordPress-style Buttons") !== FALSE;
		}

		return FALSE;

	}

}
