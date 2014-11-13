<?php

class DetectCMS {

	public $systems = array("Drupal","Wordpress");

	public function check($url) {

		foreach($this->systems as $system_name) {

			require_once("systems/".$system_name.".php");

			$system = new $system_name();

			if($system->check($url)) {

				return $system_name;

			}

		}

		return false;

	}

	protected function fetch($url) {

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$return = curl_exec($ch);
		
		curl_close($ch);

		return $return;

	}

	protected function fetchHeaders($url) {

		$headers = get_headers($url);

		return $headers;

	}

}