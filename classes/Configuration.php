<?php
class Configuration{
  private $bundle;
  private static $_oSelf = NULL;

  private function __construct(){
    $this->bundle = array();
  }

  public static function getConfiguration(){
    if(!self::$_oSelf instanceof self){
      return self::$_oSelf = new self();
    }
  }

  public function set($key,$value){
    if(!isset($this->bundle[$key])){
      $this->bundle[$key] = $value;
    }
  }

  public function get($key){
    if(isset($this->bundle[$key])){
      return $this->bundle[$key];
    }
  }
}
?>