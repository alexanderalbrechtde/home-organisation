<?php

class WarehouseController implements ControllerInterface
{
    function handle($post, $get, $server, &$session): string
    {
        $service = new WarehouseService();
        $htmlRenderer = new HtmlRenderer();
        return $htmlRenderer->render('warehouse.phtml', [
            'error' => $get['message'] ?? null,
            'items' => $service->getItems(),
        ]);
    }
}