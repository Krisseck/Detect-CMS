<?php

class ExpressionEngine extends DetectCMS
{

    public $methods = array(
      'admin_logo',
      'csrf_token_header'
    );

    public function __construct($home_html, $home_headers, $url)
    {
      $this->home_html = $home_html;
      $this->home_headers = $home_headers;
      $this->url = $url;
    }

    /**
     * Check admin logo image
     *
     * @return [boolean]
     */
    public function admin_logo() {

      return $this->fetch($this->url."/themes/cp_global_images/ee_logo_branding.gif");

    }

    /**
   * Check for CSRF Token in header
   * @return [boolean]
   */
  public function csrf_token_header() {

    if(is_array($this->home_headers)) {

      $tokenFound = FALSE;

      foreach($this->home_headers as $key => $line) {

        if(strpos($key, "Set-Cookie") !== FALSE) {

          if(strpos($line, "exp_csrf_token") !== FALSE) {

            $tokenFound = TRUE;

          }

        }

      }

      return $tokenFound;

    }

    return FALSE;

  }

}
