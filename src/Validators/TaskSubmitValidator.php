<?php

namespace App\Validators;

use Framework\Validators\PayloadValidator;
use Framework\Validators\ValidatorChain;

class TaskSubmitValidator extends PayloadValidator
{
    public function __construct(array $validators = [])
    {
        parent::__construct([
            'task_title' => new ValidatorChain([
                new NotEmptyValidator()
            ]),
            'task_notes' => new ValidatorChain([
                new NotEmptyValidator(),
            ])
        ]);
    }

}