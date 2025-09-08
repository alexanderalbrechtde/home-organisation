<?php
namespace App\Controller;


use App\Interfaces\HtmlRespose;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Responses\HtmlResponse;
use Framework\Services\HtmlRenderer;

class LogoutController implements ControllerInterface
{
    public function __construct(private HtmlRenderer $htmlRenderer)
    {
    }
    function handle($post, $get, $server, &$session): ResponseInterface
    {
        //return $this->htmlRenderer->render('login.phtml', $_POST);
        return new HtmlResponse($this->htmlRenderer->render('login.phtml', $_POST));

    }
}