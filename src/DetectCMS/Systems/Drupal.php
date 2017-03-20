<?php
namespace DetectCMS\Systems;

class Drupal extends \DetectCMS\DetectCMS {

	public $methods = array(
		"readme_d6",
		"changelog",
		"changelog_d8",
		"generator_header",
		"generator_meta",
		"node_css",
		"settings_json"
	);

	public $home_html = "";
	public $home_headers = array();
	public $url = "";

	function __construct($home_html, $home_headers, $url) {
    		$this->home_html = $home_html;
    		$this->home_headers = $home_headers;
		$this->url = $url;
  	}
        
	public function readme_d6() {
        /*
         * See if README.TXT exists, and check for Drupal 6.xx
         * @return [boolean]
         */
                if($data = $this->fetch($this->url."/sites/all/README.txt")) {
                    $lines = explode(PHP_EOL, $data);
                    for($i=0;$i<count($lines);$i++) {
                        if(strpos($lines[$i], "Drupal") !== FALSE) {
                            return TRUE;
                        }
                    }
                return FALSE;
                }
        }
	/**
	 * See if CHANGELOG.TXT exists, and check for Drupal
	 * @return [boolean]
	 */
	public function changelog() {

		if($data = $this->fetch($this->url."/CHANGELOG.txt")) {

			/**
			 * Changelog always starts from the second line
			 */
			$lines = explode(PHP_EOL, $data);
            if(array_key_exists(1,$lines))
            {
                return strpos($lines[1], "Drupal") !== FALSE;
            }


		}

		return FALSE;

	}

	/**
	 * See if core/CHANGELOG.TXT exists, and check for Drupal
	 * @return [boolean]
	 */
	public function changelog_d8() {

		if($data = $this->fetch($this->url."/core/CHANGELOG.txt")) {

			/**
			 * Changelog always starts from the second line
			 */
			$lines = explode(PHP_EOL, $data);

			return strpos($lines[0], "Drupal") !== FALSE;
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

					return strpos($line, "Drupal") !== FALSE;

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

				if($meta = $html->find("meta[name='generator'], meta[name='Generator']",0)) {

					return strpos($meta->content, "Drupal") !== FALSE;

				}

			}

		}

		return FALSE;

	}

	/**
	 * Check modules/node/node.css content
	 * @return [boolean]
	 */
	public function node_css() {

		if($data = $this->fetch($this->url."/modules/node/node.css")) {

			/**
			 * Second line always has .node-* css
			 */

			$lines = preg_split("/\\r\\n|\\r|\\n/",$data);

            if(array_key_exists(1,$lines))
            {
			    return strpos($lines[1], ".node-") !== FALSE;
            }
		}

		return FALSE;

	}

	/**
	* Check if the homepage has Drupal 8 settings JSON
	* @return [boolean]
	*/ 
	public function settings_json() {

		if($this->home_html) {

			require_once(dirname(__FILE__)."/../Thirdparty/simple_html_dom.php");

			if($html = str_get_html($this->home_html)) {

				return $html->find("script[data-drupal-selector]",0);

			}

		}

		return FALSE;

	}

}
