<?php

class DetectCMS {

	public $systems = array("Drupal","Wordpress","Joomla");

	private $common_methods = array("generator_header","generator_meta");

	protected $home_html = "";

	protected $home_headers = array();

	public function check($url) {

		/*
		 * Common, easy way first: check for Generator metatags or Generator headers
		 */
				
		$this->home_html = $this->fetch($url);

		$this->home_headers = $this->fetchHeaders($url);

		foreach($this->systems as $system_name) {

			require_once(dirname(__FILE__)."/systems/".$system_name.".php");

			$system = new $system_name();

			foreach($this->common_methods as $method) {

				if($system->$method()) {

					return $system_name;

				}

			}

		}

		/*
		 * Didn't find it yet, let's just use regular tricks
		 */
		foreach($this->systems as $system_name) {

			require_once(dirname(__FILE__)."/systems/".$system_name.".php");

			$system = new $system_name();

			foreach($system->methods as $method) {

				if(!in_array($method,$this->common_methods)) {

					if($system->$method($url)) {

						return $system_name;

					}

				}

			}

		}

		return FALSE;

	}

	protected function fetch($url) {

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);

		$return = curl_exec($ch);

		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if($httpCode == 404) {

			curl_close($ch);
		    return FALSE;
		}

		curl_close($ch);
	
		return $return;

	}

	protected function fetchHeaders($url) {

		return get_headers($url);


	}

}