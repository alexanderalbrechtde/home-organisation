<?php

class WarehouseController implements ControllerInterface
{
    function handle($post, $get, $server, &$session): string
    {
        $htmlRenderer = new htmlRenderer();
        return $htmlRenderer->render('warehous.phtml');
    }
}