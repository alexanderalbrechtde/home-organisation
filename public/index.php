<?php

declare(strict_types=1);

use App\Controller\ErrorController;
use Framework\Interfaces\ControllerInterface;
use Framework\Services\ObjectManagerService;

require __DIR__ . '/../boot/boot.php';

$routes = require_once('../config/routes.php');

if ($path = $_SERVER['PATH_INFO'] ?? '/') {
    $controllerName = $routes[$path] ?? ErrorController::class;
    $objectManagerService = new ObjectManagerService(require_once('../config/factories.php'));


    /** @var ControllerInterface $controller */
    $controller = $objectManagerService->get($controllerName);

    $response = $controller->handle($_POST, $_GET, $_SERVER, $_SESSION);
    $response->send();
}

