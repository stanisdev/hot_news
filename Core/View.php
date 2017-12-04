<?php
namespace Core;

class View
{
  private $viewPath;
  private $config;
  private $controller;
  public $data;
  
  public function __construct(\Core\Config $config, \Core\Controller $controller, $viewPath)
  {
    $this->config = $config;
    $this->viewPath = $viewPath;
    $this->controller = $controller;
  }
  
  public function buildView()
  {
    ob_start();
    $data = $this->controller->getData();
    require_once($this->config->projectDir . $this->viewPath);
    $viewContent = ob_get_clean() . "\n";
    require_once($this->config->projectDir . "/App/Views/Layouts/default.html");
  }
}