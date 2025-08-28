<?php

class DashboardController implements ControllerInterface
{

    function handle($post, $get, $server, &$session): string
    {
        if (!$_SESSION['logged_in']) {
            header('Location: /login');
        }


        $htmlRenderer = new HtmlRenderer();
        return $htmlRenderer->render('home.phtml', $_POST);
    }

}