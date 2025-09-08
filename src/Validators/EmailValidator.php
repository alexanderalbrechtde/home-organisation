<?php

namespace App\Validators;

use Framework\Interfaces\ValidatorInterface;
use PDO;

class EmailValidator implements ValidatorInterface
{

    public function validate($input): bool
    {


        if($input ){
            return false;
        }
        return true;
    }
}