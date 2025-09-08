<?php

//ruft Klasse auf, welcher Nichts übergeben wird
//HTML-Renderer
//PDO_Factory
namespace Framework\Factories;

use Framework\Interfaces\FactoryInterface;

class InvokableFactory implements FactoryInterface
{
    public function produce($className): object
    {
        return new $className();
    }
}