<?php

class ImprintController implements ControllerInterface
{
    function handle( $post,  $get,  $server,  &$session): string
    {
        $htmlRenderer = new HtmlRenderer();
        return $htmlRenderer->render('imprint.phtml', $_POST);

    }
}