<?php

namespace Core;

abstract class Controller
{
  protected $data;
  protected $model;
  
  public function __construct(\Core\Model $model)
  {
    $this->data = new \StdClass();
    $this->model = $model;
  }
  
  public function getData()
  {
    return $this->data;
  }
}