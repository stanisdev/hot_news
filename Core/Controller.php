<?php

namespace Core;

abstract class Controller
{
  protected $data;
  
  public function __construct()
  {
    $this->data = new \StdClass();
  }
}