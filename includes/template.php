<?php

class Template {
  
  // singleton instance
  private static $instance;
  
  // private constructor
  private function __construct() { 
    $this->sidebar = true;
  }

  // get singleton instance
  public static function getInstance() {
    if (!self::$instance) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  // location of header.php
  public $header;

  // location of footer.php
  public $footer;
  
  // page title
  public $title;

  // page content
  public $content;

  // toggle sidebar (boolean)
  public $sidebar;

  // name of active tab
  public $tab;

  public function render() {
    include $this->header;
    echo $this->content;
    include $this->footer;
  }

}

?>