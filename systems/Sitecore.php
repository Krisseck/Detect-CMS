<?php

class Sitecore extends DetectCMS
{

    public $methods = array(
      'admin_login',
      'sc_fields_header'
    );

    public function __construct($home_html, $home_headers, $url)
    {
      $this->home_html = $home_html;
      $this->home_headers = $home_headers;
      $this->url = $url;
    }

    /**
     * Check admin login page
     *
     * @return [boolean]
     */
    public function admin_login() {

      if($data = $this->fetch($this->url."/sitecore/admin/login.aspx")) {

        if($html = str_get_html($data)) {

          if($title = $html->find("h1",0)) {

            return strpos($title->innertext, "Sitecore") !== FALSE;

          }

        }

      }

    }

    /**
   * Check for common SC fields in header
   * @return [boolean]
   */
  public function sc_fields_header() {

    if(is_array($this->home_headers)) {

      $tokenFound = FALSE;

      foreach($this->home_headers as $key => $line) {

        if(strpos($key, "Set-Cookie") !== FALSE) {

          if(strpos($line, "sc_expview") !== FALSE || strpos($line, "SC_ANALYTICS_GLOBAL_COOKIE") !== FALSE) {

            $tokenFound = TRUE;

          }

        }

      }

      return $tokenFound;

    }

    return FALSE;

  }

}
