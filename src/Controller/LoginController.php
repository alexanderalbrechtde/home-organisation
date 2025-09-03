<?php
namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Interfaces\ResponseInterface;
use App\Services\HtmlRenderer;
use App\Responses\HtmlResponse;class LoginController implements ControllerInterface
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