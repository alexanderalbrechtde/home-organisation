<?php

namespace Framework\Factories;

use Framework\Interfaces\FactoryInterface;
use Framework\Services\EventManager;
use Framework\Services\ObjectManagerService;

class EventManagerFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(string $className): object
    {
        return new EventManager(
            require_once __DIR__ . '/../../config/observables.php',
            $this->objectManagerService
        );
    }
}