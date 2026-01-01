<?php

namespace App\Controller;

use App\Entities\TaskEntity;
use App\Services\AccountService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Requests\httpRequests;
use Framework\Responses\HtmlResponse;
use Framework\Services\HtmlRenderer;
use Framework\Services\OrmService;

class AccountController implements ControllerInterface
{
    public function __construct(
        private HtmlRenderer   $htmlRenderer,
        private AccountService $accountService
    )
    {
    }

    function handle(httpRequests $httpRequest): ResponseInterface
    {
        $user = $this->accountService->showParameters($httpRequest->getSession()['user_id']);

        return new HtmlResponse(
            $this->htmlRenderer->render(
                'account.phtml',
                [
                    'user' => $user,
                ]
            )
        );
    }
}