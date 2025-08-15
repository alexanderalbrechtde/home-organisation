<?php


class RegisterController implements ControllerInterface
{
    function handle($post, $get, $server, &$session): string
    {
        $htmlRenderer = new htmlRenderer();
        return $htmlRenderer->render('register.phtml', $_POST);
    }
}