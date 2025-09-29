<?php

namespace App\Validators;

use Framework\Interfaces\ValidatorInterface;
use Framework\Requests\httpRequests;

class LoggedInValidator implements ValidatorInterface
{
    public function __construct(private HttpRequests $httpRequests)
    {
    }

    public function validate($input): bool
    {
        if (!isset($this->httpRequests->getSession()['logged_in']) || $this->httpRequests->getSession(
            )['logged_in'] !== true) {
            header('Location: /login');
            exit;
        }
        return true;
    }

    public function getMessages(): array
    {
        return [
            'Du bist nicht eingeloggt.'
        ];
    }
}