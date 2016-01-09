<?php

class Liferay extends DetectCMS {

	public $methods = array(
		"core_js_variable"
	);

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
