<?php

namespace App\Services;

use App\Interfaces\FactoryInterface;
use RuntimeException;

class ObjectManagerService
{
    private array $objects = [];

    public function __construct(private array $factories)
    {
    }

    public function get(string $className)
    {
        if (!array_key_exists($className, $this->objects)) {
            $object = $this->build($className);
            $this->objects[$className] = $object;
        }

        return $this->objects[$className];
    }

    public function build(string $className)
    {
        $factoryName = $this->factories[$className];
        $factory = new $factoryName($this);

        if (!$factory instanceof FactoryInterface) {
            throw new RuntimeException('Missing FactoryInterface' . $factoryName);
        }
        return $factory->produce($className);
    }
}



//function string