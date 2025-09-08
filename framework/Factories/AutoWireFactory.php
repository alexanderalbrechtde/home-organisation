<?php

namespace Framework\Factories;

/*
 * hat diese Klasse Dependencies
*-> mit Reflection Klasse
*falls Keine = new ClassName
 * für jede Dependency einen Parameter erstellen und in Klasenname geben
 * in Config ändern
 *
 * */

use Framework\Interfaces\FactoryInterface;
use Framework\Services\ObjectManagerService;
use Framework\Services\ResolveParametersService;

class AutoWireFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce($className): object
    {
        $resolveParameters = new ResolveParametersService();
        $parameters = $resolveParameters->resolve($className);

        if ($parameters === []) {
            return new $className();
        }

        $objects = [];


        foreach ($parameters as $object) {
            $objects[] = $this->objectManagerService->get($object);
        }

        return new $className(...$objects);
    }
}