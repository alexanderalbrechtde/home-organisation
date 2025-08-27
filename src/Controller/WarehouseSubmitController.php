<?php

class WarehouseSubmitController implements ControllerInterface
{

    function handle($post, $get, $server, &$session): string
    {
        $WarehouseService = new WarehouseService();
        $warehouse = $WarehouseService->edit(
            $post['name'],
            $post['category'],
            $post['amount']
        );



        if (!$warehouse) {
            $htmlRenderer = new htmlRenderer();
            return $htmlRenderer->render('warehouse.phtml', [
                //'warehouse' => (new WarehouseService()->getItem()),
                'error' => 'creation_failed'
            ]);
        }
        $htmlRenderer = new htmlRenderer();
        return $htmlRenderer->render('warehouse.phtml', [
            'success' => 'creation_success'
        ]);
    }
}