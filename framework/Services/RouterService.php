<?php

namespace Framework\Services;

use App\Controller\ErrorController;
use Framework\Interfaces\ControllerInterface;

class RouterService
{
    private ObjectManagerService $objectManager;


    public function __construct(ObjectManagerService $objectManager, private array $routes)
    {
        $this->objectManager = $objectManager;
    }


    public function route($httpRequest)
    {
        $method = strtoupper($httpRequest->getServer()['REQUEST_METHOD'] ?? 'GET');

        $methodRoutes = $this->routes[$method] ?? [];

        $Path = $server['PATH_INFO'] ?? (isset($httpRequest->getServer()['REQUEST_URI']) ? parse_url(
            $httpRequest->getServer()['REQUEST_URI'],
            PHP_URL_PATH
        ) : '/');
        $path = $this->matchRoute($Path, $methodRoutes);

        if (!$path) {
            $controllerName = ErrorController::class;
        } else {
            $routeConfig = $methodRoutes[$path] ?? null;

            if (!$routeConfig || strtoupper($routeConfig['requestMethod']) !== $method) {
                $controllerName = ErrorController::class;
            } else {
                $controllerName = $routeConfig['Controller'] ?? ErrorController::class;
            }
        }

        /** @var ControllerInterface $controller */
        $controller = $this->objectManager->get($controllerName);

        return $controller->handle($httpRequest);
    }

    private function matchRoute(string $path, array $methodRoutes): ?string
    {
        $pathParts = explode('/', $path);

        foreach ($methodRoutes as $route => $config) {
            $routeParts = explode('/', $route);
            if (count($routeParts) !== count($pathParts)) {
                continue;
            }

            $status = true;
            foreach ($routeParts as $index => $part) {
                $seg = $pathParts[$index];

                if ($part === $seg) {
                    continue;
                }

                if (str_starts_with($part, ':')) {
                    $paramName = substr($part, 1);
                    $expectedType = $config[$paramName] ?? 'string';
                    if (!$this->is_type($seg, $expectedType)) {
                        $status = false;
                        break;
                    }
                    continue;
                }

                $status = false;
                break;
            }

            if ($status) {
                return $route;
            }
        }

        return null;
    }

    private function is_type(mixed $value, string $type): bool
    {
        return match ($type) {
            'int' => (is_int($value) || (is_string($value) && ctype_digit($value))),
            'string' => is_string($value),
            default => false,
        };
    }
}