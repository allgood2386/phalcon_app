<?php

use Phalcon\Mvc\Router;

/**
 * @file
 * Routes
 */
$router = new Router();

$router->add(
  "/:controller/:int",
  array(
    "controller" => 1,
    "action"     => 'show',
    "params"     => 2
  )
);

return $router;