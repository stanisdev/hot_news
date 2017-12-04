<?php
namespace Core;

use \Core\View;
use \Core\Model;

class Router
{
  private $config;
  private $url;
  
  /**
   * Init Router
   */
  public function __construct(\Core\Config $config)
  {
    $this->config = $config;
    $this->url = count($_GET) > 0 && isset($_GET["route"]) && gettype($_GET["route"]) == "string" && strlen($_GET["route"]) > 0 ? $_GET["route"] : "/";
  }
  
  /**
   * Start
   */
  public function run()
  {
    foreach($this->config->routes as $url => $params) {
      if ($url == $this->url) {
        $this->loadAction($params);
        break;
      }
    }
  }
  
  /**
   * Load controller's action and run it
   */
  private function loadAction($params)
  {
    list($controller, $action) = explode("/", $params["action"]);
    $controllerPath = $this->config->projectDir . "/App/Controllers/${controller}.php";
    require_once($controllerPath);
    $ctrlName = "App\Controllers\\${controller}Ctrl";
    $model = new Model($this->config);
    $ctrInstance = new $ctrlName($model);
    $ctrInstance->{"${action}Action"}();
    $viewPath = "/App/Views/${controller}/${action}.html";
    
    $view = new View($this->config, $ctrInstance, $viewPath);
    $view->buildView();
  }
}