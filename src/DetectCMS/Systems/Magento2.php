<?php
namespace DetectCMS\Systems;

class Magento2
{

    public $home_html;
    public $home_headers;
    public $url;

    public $methods = array(
        'x_magento_init',
    );

    public function __construct($home_html, $home_headers, $url)
    {
        $this->home_html = $home_html;
        $this->home_headers = $home_headers;
        $this->url = $url;
    }

    /**
     * Check for script tags with the x-magento-init type used in Magento 2
     *
     * @return bool
     */
    public function x_magento_init()
    {
        if($this->home_html) {
            libxml_use_internal_errors(true);
            $dom = new \DOMDocument();
            $dom->loadHTML($this->home_html);
            $scripts = $dom->getElementsByTagName('script');
            foreach($scripts as $script) {
                if($script->getAttribute('type') === 'text/x-magento-init') {
                    return true;
                }
            }
        }

        return false;
    }

}
