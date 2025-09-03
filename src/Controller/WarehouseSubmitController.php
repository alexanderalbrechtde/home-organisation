<?php

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Services\WarehouseService;

class WarehouseSubmitController implements ControllerInterface
{
    public function __construct(private WarehouseService $warehouseService)
    {
    }
    function handle($post, $get, $server, &$session): string
    {
        $warehouse = $this->warehouseService->edit(
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