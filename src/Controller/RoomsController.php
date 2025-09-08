<?php

namespace App\Controller;

use App\Services\RoomsService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Responses\HtmlResponse;
use Framework\Services\HtmlRenderer;

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