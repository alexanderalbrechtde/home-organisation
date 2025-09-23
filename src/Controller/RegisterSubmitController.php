<?php

namespace App\Controller;

use App\Services\RegisterService;

//use App\Validators\PasswordIdentValidator;
use App\Validators\NameValidator;
use App\Validators\PasswordLengthValidator;
use App\Validators\EmptyValidator;
use App\Validators\PasswordSpecialCharValidator;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Requests\httpRequests;
use Framework\Responses\RedirectResponse;
use Framework\Services\UserService;

class RegisterSubmitController implements ControllerInterface
{

    public function __construct(
        private RegisterService $registerService,
        private EmptyValidator $emptyValidator,
        private UserService $userService,
        private PasswordLengthValidator $passwordLengthValidator,
        private PasswordSpecialCharValidator $passwordSpecialCharValidator,
        private NameValidator $nameValidator,
        //private PasswordIdentValidator $passwordIdentValidator
    )
    {
    }

    function handle(httpRequests $httpRequest): ResponseInterface
    {
        $inputs = [
            $httpRequest->getPayload()['fName'],
            $httpRequest->getPayload()['lName'],
            $httpRequest->getPayload()['email'],
            $httpRequest->getPayload()['password'],
            $httpRequest->getPayload()['password2']
        ];

        foreach ($inputs as $input) {
            if (!$this->emptyValidator->validate($input)) {
                return new RedirectResponse('/register?error=failed_empty_input');
            }
        }

        if ($this->userService->userExist($httpRequest->getPayload()['email'])) {
            return new RedirectResponse('/register?error=failed_email_already_exists');
        }

        if (!$this->passwordLengthValidator->validate($httpRequest->getPayload()['password'])) {
            return new RedirectResponse('/register?error=failed_password_length');
        }
        if (!$this->passwordSpecialCharValidator->validate($httpRequest->getPayload()['password'])) {
            return new RedirectResponse('/register?error=failed_password_specialchar');
        }
        if (!$this->nameValidator->validate($httpRequest->getPayload()['fName'])) {
            return new RedirectResponse('/register?error=failed_name_length');
        }
        if (!$this->nameValidator->validate($httpRequest->getPayload()['lName'])) {
            return new RedirectResponse('/register?error=failed_name_length');
        }
        //ausgesetzt wegen Unklarheit mit $input
        //if(!$this->passwordIdentValidator->validate($post['password'], $post['password2'])) {
        //    return new RedirectResponse('/register?error=failed_passwords_not_identical');
            //}

        $this->registerService->register(...$inputs);


        return new RedirectResponse('/login?register=success');
    }
}