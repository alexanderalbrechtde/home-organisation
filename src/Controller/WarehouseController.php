<?php

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Services\HtmlRenderer;
use App\Services\WarehouseService;

class WarehouseController implements ControllerInterface
{
    public function __construct(
        private WarehouseService $warehouseService,
        private HtmlRenderer $htmlRenderer
    ) {
    }

    function handle($post, $get, $server, &$session): string
    {
        return $this->htmlRenderer->render('warehouse.phtml', [
            'error' => $get['message'] ?? null,
            'items' => $this->warehouseService->getItems(),
        ]);
    }
}