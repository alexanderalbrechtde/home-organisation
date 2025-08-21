<?php

class RoomController implements ControllerInterface
{
    function handle($post, $get, $server, &$session): string
    {
        $roomService = new RoomsService();
        $room = $roomService->getRoom($get['id']);

        if (!$room) {
            header("Location: /404");
        }

        $htmlRenderer = new htmlRenderer();
        return $htmlRenderer->render('room.phtml', [
            'room' => $room,
        ]);
    }
}