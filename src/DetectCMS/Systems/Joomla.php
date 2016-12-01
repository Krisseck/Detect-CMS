<?php
namespace DetectCMS\Systems;

class Joomla extends \DetectCMS\DetectCMS {

	public $methods = array(
		"readme",
		"generator_header",
		"generator_meta",
		"core_js"
	);

	public $home_html = "";
        public $home_headers = array();
	public $url = "";

        function __construct($home_html, $home_headers, $url) {
                $this->home_html = $home_html;
                $this->home_headers = $home_headers;
		$this->url = $url;
        }

	/**
	 * See if README.txt exists, and contains Joomla line
	 * @return [boolean]
	 */
	public function readme() {

		if($data = $this->fetch($this->url."/README.txt")) {

			/**
			 * Loop first 10 lines and look for Joomla text
			 */
			$lines = explode(PHP_EOL, $data);

			for($i=0;$i<count($lines);$i++) {

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

			require_once(dirname(__FILE__)."/../Thirdparty/simple_html_dom.php");

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
	 * @return [boolean]
	 */
	public function core_js() {

		if($data = $this->fetch($this->url."/media/system/js/core.js")) {

			/**
			 * 4th line always has Joomla declaration
			 */
			$lines = explode(PHP_EOL, $data);
            if(array_key_exists(3,$lines))
            {
                return strpos($lines[3], "var Joomla={};") !== FALSE;
            }
		}

		return FALSE;

	}

}
