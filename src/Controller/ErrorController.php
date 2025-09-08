<?php
namespace App\Controller;

use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Responses\HtmlResponse;
use Framework\Services\HtmlRenderer;

class ErrorController implements ControllerInterface
{
    public function __construct(private HtmlRenderer $htmlRenderer)
    {
    }
    function handle( $post,  $get,  $server,  &$session): ResponseInterface
    {
        return new HtmlResponse($this->htmlRenderer->render('error.phtml', $_POST));


    }
}