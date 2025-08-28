<?php


class LogoutController implements ControllerInterface
{
    function handle($post, $get, $server, &$session): string
    {
        $htmlRenderer = new HtmlRenderer();
        return $htmlRenderer->render('login.phtml', $_POST);
    }
}