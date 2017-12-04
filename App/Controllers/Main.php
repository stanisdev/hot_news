<?php
namespace App\Controllers;

class MainCtrl extends \Core\Controller
{ 
  public function indexAction()
  {
    $this->data->name = "JOHN";
    $this->data->surname = "SMITH";
  }
}