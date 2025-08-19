<?php


class LogoutSubmitController implements ControllerInterface
{
    function handle($post, $get, $server, &$session): string
    {
        if (!empty($post['destroySession'])) {
            $_SESSION = [];
            session_destroy();
            header('Location: /login');
            exit;
        }
        return '';
    }
}