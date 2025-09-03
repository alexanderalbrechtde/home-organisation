<?php

namespace App\Interfaces;

interface FactoryInterface
{
    public function produce(string $className): object;
}