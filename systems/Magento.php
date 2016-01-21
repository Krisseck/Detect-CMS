<?php

class Magento
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
        if(strstr($this->home_html, 'Mage.Cookies.path')) {
            return true;
        }
        return false;
    }

}
