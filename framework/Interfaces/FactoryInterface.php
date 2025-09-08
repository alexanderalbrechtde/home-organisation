<?php

namespace Framework\Interfaces;

interface FactoryInterface
{
    public function produce(string $className): object;
}