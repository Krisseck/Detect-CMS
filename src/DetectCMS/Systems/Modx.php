<?php
namespace DetectCMS\Systems;

class Modx extends \DetectCMS\DetectCMS {

        public $methods = array(
                "config"
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
         * See if core/docs/config.inc.tpl  exists, and contains MODX line
         * @return [boolean]
         */
        public function config() {

                if($data = $this->fetch($this->url."/core/docs/config.inc.tpl")) {
                        /*
                         * Search "MODX" text
                         */
                        $lines = explode(PHP_EOL, $data);
                        for($i=0;$i<count($lines);$i++) {
                                if(strpos($lines[$i], "MODX") !== FALSE) {
                                        return TRUE;
                                }
                        }
                }
                return FALSE;
        }
}
