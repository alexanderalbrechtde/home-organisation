<?php

class ErrorController implements ControllerInterface
{
    function handle( $post,  $get,  $server,  &$session): string
    {
        $htmlRenderer = new HtmlRenderer();
        return $htmlRenderer->render('error.phtml', $_POST);

    }
}