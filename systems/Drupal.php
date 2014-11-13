<?php

class Drupal extends DetectCMS {

	private $methods = array(
		"changelog",
		"generator_header"
	);

	public function check($url) {

		foreach($this->methods as $method) {

			if($this->$method($url)) {

				return TRUE;

			}

		}

		return FALSE;

	}

	/**
	 * See if CHANGELOG.TXT exists, and check for Drupal
	 * @param  [string] $url
	 * @return [boolean]
	 */
	private function changelog($url) {

		if($data = $this->fetch($url."/CHANGELOG.txt")) {

			/**
			 * Changelog always starts from the second line
			 */
			$lines = explode(PHP_EOL, $data);

			return strpos($lines[1], "Drupal") !== FALSE;
		}

		return FALSE;

	}

	/**
	 * Check for headers, especially X-Generator
	 * @param  [string] $url
	 * @return [boolean]
	 */
	private function generator_header($url) {

		if($headers = $this->fetchHeaders($url)) {

			if(is_array($headers)) {

				foreach($headers as $line) {

					if(strpos($line, "X-Generator") !== FALSE) {

						return strpos($line, "Drupal") !== FALSE;

					}

				}

			}

		}

		return FALSE;

	}

}