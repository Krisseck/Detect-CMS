<?php

class Joomla extends DetectCMS {

	public $methods = array(
		"readme",
		"generator_header",
		"generator_meta",
		"core_js"
	);

	/**
	 * See if README.txt exists, and contains Joomla line
	 * @param  [string] $url
	 * @return [boolean]
	 */
	public function readme($url) {

		if($data = $this->fetch($url."/README.txt")) {

			/**
			 * Loop first 10 lines and look for Joomla text
			 */
			$lines = explode(PHP_EOL, $data);

			for($i=0;$i<10;$i++) {

				if(strpos($lines[$i], "2- What is Joomla?") !== FALSE) {
					return TRUE;
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

					return strpos($line, "Joomla!") !== FALSE;

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

					return strpos($meta->content, "Joomla!") !== FALSE;

				}

			}

		}

		return FALSE;

	}

	/**
	 * Check /media/system/js/core.js content
	 * @param  [string] $url
	 * @return [boolean]
	 */
	public function core_js($url) {

		if($data = $this->fetch($url."/media/system/js/core.js")) {

			/**
			 * 4th line always has Joomla declaration
			 */
			$lines = explode(PHP_EOL, $data);

			return strpos($lines[3], "var Joomla={};") !== FALSE;
		}

		return FALSE;

	}

}