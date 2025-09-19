<?php

namespace App\Controller;

use App\Services\RoomsCreateService;
use App\Services\RoomsService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
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

    function handle($post, $get, $server, &$session): ResponseInterface
    {
        $create = $this->roomsCreateService->create(
            $session['user_id'],
            $post['room_name'],
            $post['room_description']
        );
        if (!$create) {
            return new HtmlResponse($this->htmlRenderer->render('rooms.phtml', [
                'rooms' => $this->roomsService->getRooms($session['user_id']),
                'error' => 'creation_failed'
            ]));
        }

        return new HtmlResponse($this->htmlRenderer->render('rooms.phtml', [
            'rooms' => $this->roomsService->getRooms($session['user_id']),
            'error' => 'creation_success'
        ]));
    }
}