<?php


class RegisterController implements ControllerInterface
{
    function handle($post, $get, $server, &$session): string
    {
        $htmlRenderer = new HtmlRenderer();
        return $htmlRenderer->render('register.phtml', $_POST);
    }
}