<?php
namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Interfaces\HtmlRespose;
use App\Interfaces\ResponseInterface;
use App\Services\HtmlRenderer;
use App\Responses\HtmlResponse;class ErrorController implements ControllerInterface
{
    public function __construct(private HtmlRenderer $htmlRenderer)
    {
    }
    function handle( $post,  $get,  $server,  &$session): ResponseInterface
    {
        //return $this->htmlRenderer->render('error.phtml', $_POST);
        return new HtmlResponse($this->htmlRenderer->render('error.phtml', $_POST));


    }
}