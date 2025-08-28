<?php

class WarehouseSubmitController implements ControllerInterface
{
    function handle($post, $get, $server, &$session): string
    {
        $service = new WarehouseService();
        $warehouse = $service->edit(
            $post['name'],
            $post['category'],
            $post['amount']
        );
        if (!$warehouse) {
            header('Location: /warehouse?message=creation_failed');
        }

        header('Location: /warehouse?message=creation_success');
        return '';
    }
}