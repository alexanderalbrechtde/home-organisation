<?php

declare(strict_types=1);

require __DIR__ . '/../boot/boot.php';

$routes = require_once('../config/routes.php');
$path = $_SERVER['PATH_INFO'] ?? '/';

$controllerName = $routes[$path];

/** @var ControllerInterface $controller */
$controller = new $controllerName();
$html = $controller->handle($_POST, $_GET, $_SERVER, $SESSION);
echo $html;
