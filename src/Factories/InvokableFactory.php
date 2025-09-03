<?php

//ruft Klasse auf, welcher Nichts übergeben wird
//HTML-Renderer
//PDO_Factory
namespace App\Factories;

use App\Interfaces\FactoryInterface;

class InvokableFactory implements FactoryInterface
{
    public function produce($className): object
    {
        return new $className();
    }
}