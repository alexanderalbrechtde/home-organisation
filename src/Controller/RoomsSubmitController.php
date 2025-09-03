<?php

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Interfaces\HtmlRespose;
use App\Interfaces\ResponseInterface;
use App\Services\HtmlRenderer;
use App\Services\RoomsCreateService;
use App\Services\RoomsService;
use App\Responses\HtmlResponse;class RoomsSubmitController implements ControllerInterface
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
                'rooms' => $this->roomsService->getRooms(),
                'error' => 'creation_failed'
            ]));


        }

        return new HtmlResponse($this->htmlRenderer->render('rooms.phtml', [
            'rooms' => $this->roomsService->getRooms(),
            'error' => 'creation_success'
        ]));
    }
}