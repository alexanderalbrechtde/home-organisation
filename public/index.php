<?php

declare(strict_types=1);

use App\Interfaces\ControllerInterface;
use App\Services\ObjectManagerService;

require __DIR__ . '/../boot/boot.php';

$routes = require_once('../config/routes.php');

if ($path = $_SERVER['PATH_INFO'] ?? '/') {
    $controllerName = $routes[$path] ?? 'ErrorController';

    $objectManagerService = new ObjectManagerService(require_once('../config/factories.php'));

    /** @var ControllerInterface $controller */
    $controller = $objectManagerService->get($controllerName);

    echo $controller->handle($_POST, $_GET, $_SERVER, $_SESSION);
}

