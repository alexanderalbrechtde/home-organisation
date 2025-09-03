<?php

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Interfaces\ResponseInterface;
use App\Services\HtmlRenderer;
use App\Services\WarehouseService;
use App\Responses\HtmlResponse;

class WarehouseController implements ControllerInterface
{
    public function __construct(
        private WarehouseService $warehouseService,
        private HtmlRenderer $htmlRenderer
    ) {
    }

    function handle($post, $get, $server, &$session): ResponseInterface
    {
        return new HtmlResponse($this->htmlRenderer->render('warehouse.phtml', [
            'error' => $get['message'] ?? null,
            'items' => $this->warehouseService->getItems(),
        ]));
    }
}