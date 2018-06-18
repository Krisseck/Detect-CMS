<?php

namespace DetectCMS\Systems;

class Laravel extends \DetectCMS\DetectCMS
{

    public $methods = [
        "cookie",
    ];

    public $home_html = "";
    public $home_headers = [];
    public $url = "";

    function __construct($home_html, $home_headers, $url)
    {
        $this->home_html = $home_html;
        $this->home_headers = $home_headers;
        $this->url = $url;
    }

    /**
     * Check for Laravel session cookie
     * @return [boolean]
     */
    public function cookie()
    {
        if (isset($this->home_headers['Set-Cookie']) && strpos($this->home_headers['Set-Cookie'], 'laravel') !== false) {
            return true;
        }

        return false;
    }

}
