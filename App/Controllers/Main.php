<?php
namespace App\Controllers;

class MainCtrl extends \Core\Controller
{
  public $name = "44444";
  
  public function indexAction()
  {
    $this->data->name = "JOHN";
    echo "IndexAction";
  }
}