<?php

namespace Framework\Interfaces;

interface ControllerInterface
{
    function handle($post, $get, $server, &$session): ResponseInterface;

}