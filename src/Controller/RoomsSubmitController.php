<?php

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Services\HtmlRenderer;
use App\Services\RoomsCreateService;
use App\Services\RoomsService;

class RoomsSubmitController implements ControllerInterface
{
    public function __construct(
        private RoomsCreateService $roomsCreateService,
        private HtmlRenderer $htmlRenderer,
        private RoomsService $roomsService
    ) {
    }

    function handle($post, $get, $server, &$session): string
    {
        $create = $this->roomsCreateService->create(
            $session['user_id'],
            $post['room_name'],
            $post['room_description']
        );
        if (!$create) {
            return $this->htmlRenderer->render('rooms.phtml', [
                'rooms' => $this->roomsService->getRooms(),
                'error' => 'creation_failed'
            ]);
        }

        return $this->htmlRenderer->render('rooms.phtml', [
            'rooms' => $this->roomsService->getRooms(),
            'success' => 'creation_success'
        ]);
    }
}