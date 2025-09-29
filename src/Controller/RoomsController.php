<?php

namespace App\Controller;

use App\Services\RoomsService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Requests\httpRequests;
use Framework\Responses\HtmlResponse;
use Framework\Services\HtmlRenderer;

class RoomsController implements ControllerInterface
{
    public function __construct(
        private RoomsService $roomsService,
        private HtmlRenderer $htmlRenderer
    ) {
    }

    function handle(httpRequests $httpRequest): ResponseInterface
    {
        if (!$httpRequest->getSessionLoggedIn()) {
            header('Location: /login');
            exit;
        }

        $rooms = $this->roomsService->getRooms($httpRequest->getSession()['user_id']);

        return new HtmlResponse($this->htmlRenderer->render('rooms.phtml', [
            'rooms' => $rooms
        ]));
    }
}