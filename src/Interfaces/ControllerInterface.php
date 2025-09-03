<?php

namespace App\Interfaces;

use App\Responses\HtmlResponse;

interface ControllerInterface
{
    function handle($post, $get, $server, &$session): ResponseInterface;

}