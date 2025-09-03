<?php

namespace App\Services;

use ReflectionClass;

class ResolveParametersService
{

    public function resolve(string $className): array
    {
        $reflection = new ReflectionClass($className);
        $constructor = $reflection->getConstructor();

        $parameters = $constructor->getParameters();

        $parameterNames = [];

        foreach ($parameters as $parameter) {
            $parameterNames[] = $parameter->getType()->getName();
        }

        return $parameterNames;
    }
}