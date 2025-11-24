<?php

namespace Framework\Services;

use Framework\Interfaces\ObserverInterface;

class EventManager
{
    public function __construct(private array $observers, private ObjectManagerService $objectManagerService)
    {
    }

    public function notify(object $observable): void
    {

        $observableClass = get_class($observable);

        foreach ($this->observers[$observableClass] as $observerClass) {
            if (class_exists($observerClass)) {
                $observerInstance = $this->objectManagerService->get($observerClass);
                $observerInstance->run($observable);
            }
        }
    }
}