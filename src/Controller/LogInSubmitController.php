<?php

class LogInSubmitController implements ControllerInterface
{
    function handle($post, $get, $server, &$session): string
    {
        $LoginService = new LoginService();
        $isLoggedin = $LoginService->login($post['email'], $post['password'], $post['username']);

        if (!$isLoggedin) {
            header('Location: login?error=login-failed');
            return '';
        }
        header('Location: /');
        return '';
    }
}