<?php

namespace DetectCMS\Systems;

class Typo3 extends \DetectCMS\DetectCMS
{

    public $methods = array(
        "generator_meta",
        "scripts"
    );

    public $home_html = "";
    public $home_headers = array();
    public $url = "";

    function __construct($home_html, $home_headers, $url)
    {
        $this->home_html = $home_html;
        $this->home_headers = $home_headers;
        $this->url = $url;
    }

    /**
     * Check meta tags for generator
     * @return boolean
     */
    public function generator_meta()
    {

        if ($this->home_html) {

            require_once(dirname(__FILE__) . "/../Thirdparty/simple_html_dom.php");

            if ($html = str_get_html($this->home_html)) {
                if ($meta = $html->find("meta[name='generator']", 0)) {
                    return strpos($meta->content, "TYPO3") !== FALSE;
                }
            }

        }

        return false;

    }

    /**
     * Check for Typo3 scripts
     * @return boolean
     */
    public function scripts()
    {

        if ($this->home_html) {

            require_once(dirname(__FILE__) . "/../Thirdparty/simple_html_dom.php");

            if ($html = str_get_html($this->home_html)) {
                foreach ($html->find('script') as $element) {
                    if (strpos($element->src, 'typo3conf') !== FALSE) {
                        return true;
                    }
                }
            }

        }

        return false;

    }

}
