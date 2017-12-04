<?php
namespace Core;

class Config
{
  public $db = [
    dialect => "mysql", 
    host => "localhost", 
    name => "hot_news", 
    username => "root", 
    password => "", 
    charset => "utf8"
  ];
  public $projectDir;
  public $coreDir;
  public $routes;
  
  /**
   * Point entry
   */
  public function __construct($projectDir)
  {
    $this->projectDir = $projectDir;
    $this->coreDir = $projectDir . "/Core";
    $this->hookClassCalling();
  }
  
  /**
   * Load routes from .json file
   */
  public function loadRoutes()
  {
    $routes = file_get_contents($this->coreDir . "/routes.json");
    if ($routes === false) {
      throw new \Exception("Routes file cannot be opened");
    }
    $this->routes = json_decode($routes, true);
    if ($this->routes === NULL) {
      throw new \Exception("Routes file cannot be parsed or contains not JSON-representation");
    }
  }
  
  /**
   * Include calling class
   */
  private function hookClassCalling()
  {
    spl_autoload_register(function($className) {
      $classPath = $this->projectDir . "/" . str_replace("\\", "/", $className) . ".php";
      require_once($classPath);
    });
  }
}