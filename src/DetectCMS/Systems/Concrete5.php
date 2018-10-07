<?php

namespace DetectCMS\Systems;

class Concrete5 extends \DetectCMS\DetectCMS
{
    public $methods = array(
        'license',
        'meta'
    );

    public function __construct($home_html, $home_headers, $url)
    {
        $this->home_html = $home_html;
        $this->home_headers = $home_headers;
        $this->url = $url;
    }

    /**
     * Check meta tags and find generator
     *
     * @return boolean
     */
    public function meta()
    {
        if ($this->isValid()) {
            require_once __DIR__ . '/../Thirdparty/simple_html_dom.php';

            $html = str_get_html($this->home_html);

            if ($generator = $html->find("meta[name='generator']", false)) {
                return stripos($generator->content, 'concrete5') !== false;
            }
        }

        return false;
    }

    /**
     * Check if robots.txt exists and has the CCM identifier rules like ccm captcha and ccm token
     *
     * @return boolean
     */
    public function license()
    {
        if ($this->isValid()) {
            $search = array('/*&ccm_token=*', '/ccm/system/captcha/picture');

            if ($txt = $this->fetch($this->url . '/robots.txt')) {
                foreach (explode(PHP_EOL, $txt) as $line) {
                    foreach ($search as $s) {
                        if (stripos($line, $s) !== false) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    private function isValid()
    {
        return !empty($this->home_html);
    }
}
