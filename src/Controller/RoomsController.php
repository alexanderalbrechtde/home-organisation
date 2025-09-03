<?php

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Services\HtmlRenderer;
use App\Services\RoomsService;

class RoomsController implements ControllerInterface
{
    public function __construct(
        private RoomsService $roomsService,
        private HtmlRenderer $htmlRenderer
    ) {
    }

    function handle($post, $get, $server, &$session): string
    {
        $rooms = $this->roomsService->getRooms();

        return $this->htmlRenderer->render('rooms.phtml', [
            'rooms' => $rooms
        ]);
    }
}