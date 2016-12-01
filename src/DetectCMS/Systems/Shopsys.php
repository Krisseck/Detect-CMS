<?php
namespace DetectCMS\Systems;

/**
 *
 * @author Vojta Brozek <brozek@thepay.cz>
 */
class Shopsys
{
    public $methods;

    /** @var  string */
    public $home_html;
    public $home_headers;
    /** @var string */
    public $url;

    /**
     * @param string $home_html
     * @param $home_headers
     * @param string $url
     */
    public function __construct($home_html, $home_headers, $url)
    {
        $this->home_headers = $home_headers;
        $this->home_html = $home_html;
        $this->url = $url;

        $this->methods = array(
            'checkHtmlHeader',
            'checkHtmlFooter',
        );
    }

    /**
     * @return bool
     */
    public function checkHtmlHeader()
    {
        if(\preg_match("/<meta name=\"Author\" content=\"ShopSys\.cz/",$this->home_html))
        {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function checkHtmlFooter()
    {
        if(\strpos($this->home_html,'<a href="https://www.shopsys.sk/" title="ShopSys">') !== false)
        {
            return true;
        }

        if(\strpos($this->home_html,'<a href="https://www.shopsys.cz/" title="ShopSys">') !== false)
        {
            return true;
        }

        return false;
    }
} 