<?php

class DetectCMS {

	public $systems = array("Drupal","Wordpress","Joomla","Liferay","vBulletin");

	private $common_methods = array("generator_header","generator_meta");

	public $home_html = "";

	public $home_headers = array();

	public $url = "";
	
	public $result = FALSE;

	function __construct($url) {
		$this->url = $url;
		$this->home_html = $this->fetch();
                $this->home_headers = $this->fetchHeaders();
		$this->result = $this->check();
	}

	public function check() {

		/*
		 * Common, easy way first: check for Generator metatags or Generator headers
		 */
				
		foreach($this->systems as $system_name) {

			require_once(dirname(__FILE__)."/systems/".$system_name.".php");

			$system = new $system_name($this->home_html, $this->home_headers);

			foreach($this->common_methods as $method) {

				if(method_exists($system,$method)) {

					if($system->$method()) {

                                        	return $system_name;

                                        }

				}

			}

		}

		/*
		 * Didn't find it yet, let's just use regular tricks
		 */
		foreach($this->systems as $system_name) {

			require_once(dirname(__FILE__)."/systems/".$system_name.".php");

			$system = new $system_name($this->home_html, $this->home_headers);

			foreach($system->methods as $method) {

				if(!in_array($method,$this->common_methods)) {

					if($system->$method()) {

						return $system_name;

					}

				}

			}

		}

		return FALSE;

	}

	public function getResult() {

		return $this->result;

	}

	protected function fetch() {

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);

		$return = curl_exec($ch);

		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if($httpCode == 404) {
			curl_close($ch);
			return FALSE;
		}

		curl_close($ch);
	
		return $return;

	}

	protected function fetchHeaders() {

		$ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $this->url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HEADER, 1);

                $response = curl_exec($ch);

		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                if($httpCode == 404) {
                        curl_close($ch);
          		return FALSE;
                } else {

			$headers = array();

    			$header_text = substr($response, 0, strpos($response, "\r\n\r\n"));

    			foreach (explode("\r\n", $header_text) as $i => $line)
        		if ($i === 0) {
            			$headers['http_code'] = $line;
        		} else {
        			list ($key, $value) = explode(': ', $line);

            			$headers[$key] = $value;
        		}

		}

                curl_close($ch);

                return $headers;

	}

}
