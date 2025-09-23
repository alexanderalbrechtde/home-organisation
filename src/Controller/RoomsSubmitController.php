<?php

namespace App\Controller;

use App\Services\RoomsCreateService;
use App\Services\RoomsService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Requests\httpRequests;
use Framework\Responses\HtmlResponse;
use Framework\Services\HtmlRenderer;

class RoomsSubmitController implements ControllerInterface
{
    public function __construct(
        private RoomsCreateService $roomsCreateService,
        private HtmlRenderer $htmlRenderer,
        private RoomsService $roomsService
    ) {
    }

    function handle(httpRequests $httpRequest): ResponseInterface
    {
        $create = $this->roomsCreateService->create(
            $httpRequest->getSession()['user_id'],
            $httpRequest->getPayload()['room_name'],
            $httpRequest->getPayload()['room_description']
        );
        if (!$create) {
            return new HtmlResponse($this->htmlRenderer->render('rooms.phtml', [
                'rooms' => $this->roomsService->getRooms($httpRequest->getSession()['user_id']),
                'error' => 'creation_failed'
            ]));
        }

        return new HtmlResponse($this->htmlRenderer->render('rooms.phtml', [
            'rooms' => $this->roomsService->getRooms($httpRequest->getSession()['user_id']),
            'error' => 'creation_success'
        ]));
    }
}