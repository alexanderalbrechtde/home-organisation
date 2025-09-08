<?php

namespace App\Controller;

use App\Services\RegisterService;
use App\Validators\PasswordLengthValidator;
use App\Validators\EmptyValidator;
use App\Validators\PasswordSpecialCharValidator;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
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
    ) {
    }

    function handle($post, $get, $server, &$session): ResponseInterface
    {
        $inputs = [
            $post['fName'],
            $post['lName'],
            $post['email'],
            $post['password'],
            $post['password2']
        ];

        foreach ($inputs as $input) {
            if (!$this->emptyValidator->validate($input)) {
                return new RedirectResponse('/register?error=failed_empty_input');
            }
        }

        if ($this->userService->userExist($post['email'])) {
            return new RedirectResponse('/register?error=failed_email_already_exists');
        }


        if (!$this->passwordLengthValidator->validate($post['password'])) {
            return new RedirectResponse('/register?error=failed_password_length');
        }
        if (!$this->passwordSpecialCharValidator->validate($post['password'])) {
            return new RedirectResponse('/register?error=failed_password_specialchar');
        }

        $this->registerService->register(...$inputs);


        return new RedirectResponse('/login?register=success');


        // if (!$register) {
        //     return new RedirectResponse('/register?error=register_failed');
        // }
        // return new RedirectResponse('/login?register=success');
    }
}