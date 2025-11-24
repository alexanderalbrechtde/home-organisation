<?php

namespace App\Observer;

use App\Services\LoginService;
use Framework\Interfaces\ObserverInterface;

class LoginObserver implements ObserverInterface
{

    public function __construct(private LoginService $loginService)
    {
    }

    public function run(object $observable): void
    {
        $this->loginService->login($observable->getUserEmail(), $observable->getUserPassword());
    }
}