<?php

namespace App\Validators;

use Framework\Validators\PayloadValidator;
use Framework\Validators\ValidatorChain;

class LoggedInSubmitValidator extends PayloadValidator
{
public function __construct(array $validators = [])
{
    parent::__construct([
        'logged_in' => new ValidatorChain([
            new LoggedInValidator(),
        ])
    ]);
}
}