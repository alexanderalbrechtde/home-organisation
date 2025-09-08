<?php

namespace App\Validators;

use Framework\Interfaces\ValidatorInterface;

class EmptyValidator implements ValidatorInterface
{

    public function validate($input): bool
    {
        if($input === ''|| $input === null){
            return false;
        }else{
            return true;
        }
    }
}