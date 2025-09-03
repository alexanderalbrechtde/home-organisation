<?php
namespace App\Controller;


use App\Interfaces\ControllerInterface;
use App\Services\HtmlRenderer;

class LogoutController implements ControllerInterface
{
    public function __construct(private HtmlRenderer $htmlRenderer)
    {
    }
    function handle($post, $get, $server, &$session): string
    {
        return $this->htmlRenderer->render('login.phtml', $_POST);
    }
}