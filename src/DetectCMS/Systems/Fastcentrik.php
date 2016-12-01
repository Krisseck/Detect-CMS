<?php
namespace DetectCMS\Systems;

/**
 *
 * @author Vojta Brozek <brozek@thepay.cz>
 */
class Fastcentrik
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
        if(\preg_match("/<div class=\"vc-content_appinfo\"><a href=\"https:\/\/www\.fastcentrik\.cz\" target=\"_blank\" title=\"FastCentrik&#174; - Pron&#225;jem e-shopu\">FastCentrik® - Pronájem e-shopu<\/a><\/div>/",$this->home_html))
        {
            return true;
        }

        if(\strpos($this->home_html,'<a href="http://www.fastcentrik.cz" target="_blank" title="FastCentrik&amp;#174; - Pron') !== false)
        {
            return true;
        }

        if(\strpos($this->home_html,'<a href="http://www.fastcentrik.cz"  target="_blank" title="FastCentrik') !== false)
        {
            return true;
        }

        return false;
    }
}