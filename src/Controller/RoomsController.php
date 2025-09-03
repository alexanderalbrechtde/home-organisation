<?php

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Interfaces\ResponseInterface;
use App\Services\HtmlRenderer;
use App\Services\RoomsService;
use App\Responses\HtmlResponse;

class RoomsController implements ControllerInterface
{
    public function __construct(
        private RoomsService $roomsService,
        private HtmlRenderer $htmlRenderer
    ) {
    }

    function handle($post, $get, $server, &$session): ResponseInterface
    {
        $rooms = $this->roomsService->getRooms();

        return new HtmlResponse($this->htmlRenderer->render('rooms.phtml', [
            'rooms' => $rooms
        ]));
    }
}