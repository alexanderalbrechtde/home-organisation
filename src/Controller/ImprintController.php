<?php
namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Services\HtmlRenderer;

class ImprintController implements ControllerInterface
{
    public function __construct(private HtmlRenderer $htmlRenderer)
    {
    }

    function handle( $post,  $get,  $server,  &$session): string
    {

        return $this->htmlRenderer->render('imprint.phtml', $_POST);

    }
}