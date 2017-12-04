<?php
/*
 * Hot news
 * Copyright(c) 2017 Stanislav Zavalishin <javascript.nodejs.developer@gmail.com>
 * MIT Licensed
 */

require_once(__DIR__ . "/Core/Config.php");
$config = new \Core\Config(__DIR__);

$config->loadRoutes();

$router = new \Core\Router($config);
$router->run();