<?php

namespace App\Controller;

use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Responses\RedirectResponse;

class LogoutSubmitController implements ControllerInterface
{

    function handle($post, $get, $server, &$session): ResponseInterface
    {
        if (!empty($post['destroySession'])) {
            $_SESSION = [];
            session_destroy();
            return new RedirectResponse('login');
        }
        //return '';
    }
}