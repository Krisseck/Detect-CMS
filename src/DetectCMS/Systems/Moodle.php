<?php
namespace DetectCMS\Systems;

class Moodle extends \DetectCMS\DetectCMS {

	public $methods = array(
		"readme"
	);

	public $home_html = "";
        public $home_headers = array();
	public $url = "";

        function __construct($home_html, $home_headers, $url) {
                $this->home_html = $home_html;
                $this->home_headers = $home_headers;
		$this->url = $url;
        }

	/*
	 * See if README.txt exists, and contains Moodle line
	 * @return [boolean]
	 */
	public function readme() {

		if($data = $this->fetch($this->url."/README.txt")) {

			/*
			 * Search "Moodle" text
			 */
			$lines = explode(PHP_EOL, $data);

			for($i=0;$i<count($lines);$i++) {
				if(strpos($lines[$i], "Moodle") !== FALSE) {
					return TRUE;
				}

			}

		}

		return FALSE;

	}
}
