<?php

namespace DetectCMS\Systems;

class Squarespace extends \DetectCMS\DetectCMS
{

    public $methods = [
        "comment",
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
     * Check for "This is Squarespace" comment
     * Reference: https://answers.squarespace.com/questions/87467/how-can-i-tell-if-a-website-was-built-in-squarespace.html
     * @return [boolean]
     */
    public function comment()
    {
        return strpos($this->home_html, "<!-- This is Squarespace. -->") !== false;
    }

}
