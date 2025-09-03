<?php

namespace App\Factories;

use App\Controller\ImprintController;
use App\Interfaces\FactoryInterface;
use App\Services\HtmlRenderer;
use App\Services\ObjectManagerService;

class ImprintControllerFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(): object
    {
        return new ImprintController($this->objectManagerService->get(HtmlRenderer::class));
    }
}