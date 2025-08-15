<?php


class KitchenController implements ControllerInterface
{

    function handle($post, $get, $server, &$session): string
    {
        $htmlRenderer = new htmlRenderer();
        return $htmlRenderer->render('category_kitchen.phtml', $_POST);
    }

}