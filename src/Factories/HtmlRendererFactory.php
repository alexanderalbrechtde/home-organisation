<?php

namespace App\Factories;

use App\Interfaces\FactoryInterface;
use App\Services\HtmlRenderer;
use App\Services\ObjectManagerService;

class HtmlRendererFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(): object
    {
        return new HtmlRenderer();
    }
}