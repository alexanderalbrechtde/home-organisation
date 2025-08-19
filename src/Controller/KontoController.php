<?php


use ControllerInterface;

class KontoController implements ControllerInterface
{

    function handle($post, $get, $server, &$session): string
    {
        $htmlRenderer = new htmlRenderer();
        return $htmlRenderer->render('konto.phtml', $_POST);
    }
}