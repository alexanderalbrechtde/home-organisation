<?php

namespace Framework\Interfaces;

use Framework\Requests\httpRequests;

interface ControllerInterface
{
    function handle(httpRequests $httpRequest): ResponseInterface;

}