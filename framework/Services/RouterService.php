<?php

namespace Framework\Services;

use App\Controller\ErrorController;
use Framework\Interfaces\ControllerInterface;
use Framework\Requests\httpRequests;

class RouterService
{
    private ObjectManagerService $objectManager;


    public function __construct(ObjectManagerService $objectManager, private array $routes)
    {
        $this->objectManager = $objectManager;
    }


    public function route($httpRequest)
    {
        $method = strtoupper($httpRequest->getMethod() ?? 'GET');

        $methodRoutes = $this->routes[$method] ?? [];

        $path = $this->matchRoute($httpRequest);

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

    private function matchRoute(httpRequests $httpRequest): ?string
    {
        $path = $httpRequest->getPathinfo();

        $pathParts = explode('/', $path);

        $methodRoutes = $this->routes[$httpRequest->getMethod()] ?? [];

        foreach ($methodRoutes as $route => $config) {

            $routeParameters = [];

            $routeParts = explode('/', $route);
            if (count($routeParts) !== count($pathParts)) {
                continue;
            }

            $status = true;
            foreach ($routeParts as $index => $routePart) {
                $pathPart = $pathParts[$index];

                if ($routePart === $pathPart) {
                    continue;
                }

                if (str_starts_with($routePart, ':')) {
                    $paramName = substr($routePart, 1);
                    $expectedType = $config[$paramName] ?? 'string';

                    $routeParameters[$paramName] = $pathPart;

                    if (!$this->is_type($pathPart, $expectedType)) {
                        $status = false;
                        break;
                    }
                    continue;
                }

                $status = false;
                break;
            }

            if ($status) {
                $httpRequest->setRouteParameters($routeParameters);
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