<?php
namespace DetectCMS\Systems;

class Liferay extends \DetectCMS\DetectCMS {

	public $methods = array(
		"core_js_variable"
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
	 * Check for core Javascript variable declaration
	 * @return [boolean]
	 */
	public function core_js_variable() {
	
		if($this->home_html) {

			return strpos($this->home_html, "var Liferay = {") !== FALSE;

		}

		return FALSE;

	}

}
