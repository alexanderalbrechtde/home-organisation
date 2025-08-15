<?php


class BedroomController implements ControllerInterface
{

    function handle($post, $get, $server, &$session): string
    {
        $htmlRenderer = new htmlRenderer();
        return $htmlRenderer->render('category_bedroom.phtml', $_POST);
    }

}