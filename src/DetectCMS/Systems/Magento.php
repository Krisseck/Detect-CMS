<?php
namespace DetectCMS\Systems;

class Magento extends \DetectCMS\DetectCMS
{

    public $methods = array(
        'mage_cookies_path'
    );

    public function __construct($home_html, $home_headers, $url)
    {
        $this->home_html = $home_html;
        $this->home_headers = $home_headers;
        $this->url = $url;
    }

    /**
     * Magento installs define a Mage.Cookies.path in a script tag in the header
     *
     * @return bool
     */
    public function mage_cookies_path()
    {

        if($this->home_html) {

            libxml_use_internal_errors(true); // stop html5 tags causing errors

            $dom = new \DOMDocument();
            $dom->loadHTML($this->home_html);
            $scripts = $dom->getElementsByTagName('script');
            foreach($scripts as $script) {
                $value = $script->nodeValue;
                if(strstr($value, 'Mage.Cookies.path')) {
                    return true;
                }
            }
            return false;

        }
    }

}
