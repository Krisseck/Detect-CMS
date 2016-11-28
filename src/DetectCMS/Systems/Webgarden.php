<?php
namespace DetectCMS\Systems;

/**
 *
 * @author Vojta Brozek <brozek@thepay.cz>
 */
class Webgarden
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
            'checkHtmlFooter',
        );
    }

    /**
     * @return bool
     */
    public function checkHtmlFooter()
    {
        if(\preg_match("/<li class=\"textlink\"><a href=\"http:\/\/www.webgarden/",$this->home_html))
        {
            return true;
        }

        return false;
    }
} 