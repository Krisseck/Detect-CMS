<?php

class Liferay extends DetectCMS {

	public $methods = array(
		"core_js_variable"
	);

	public $home_html = "";
        public $home_headers = array();

        function __construct($home_html, $home_headers) {
                $this->home_html = $home_html;
                $this->home_headers = $home_headers;
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
