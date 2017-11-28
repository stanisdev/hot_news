<?php
namespace Core;

class Router
{
  private $config;
  private $url;
  
  public function __construct(\Core\Config $config)
  {
    $this->config = $config;
    $this->url = count($_GET) > 0 && isset($_GET["route"]) && gettype($_GET["route"]) == "string" && strlen($_GET["route"]) > 0 ? $_GET["route"] : "/";
  }
  
  public function run()
  {
    foreach($this->config->routes as $url => $params) {
      if ($url == $this->url) {
        $this->loadAction($params);
        break;
      }
    }
  }
  
  private function loadAction($params)
  {
    list($controller, $action) = explode("/", $params["action"]);
    $controllerPath = $this->config->projectDir . "/App/Controllers/${controller}.php";
    require_once($controllerPath);
    $ctrlName = "App\Controllers\\${controller}Ctrl";
    $ctrInstance = new $ctrlName();
    $ctrInstance->{"${action}Action"}();
    $this->loadView("/App/Views/${controller}/${action}.html");
  }
  
  private function loadView($viewPath)
  {
    $viewContent = file_get_contents($this->config->projectDir . $viewPath);
    if ($viewContent === false) {
      throw new \Exception("View '${$viewPath}' file not found");
    }
  }
}