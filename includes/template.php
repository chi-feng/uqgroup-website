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

  public $header;
  public $footer;
  public $title;
  public $content;
  public $sidebar;
  public $tab;

  public function render() {
    global $articles,$conferences,$pages,$tabs,$announcements,$events,$links,$people;
    include $this->header;
    echo $this->content;
    include $this->footer;
  }

}

?>