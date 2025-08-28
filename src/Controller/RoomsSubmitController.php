<?php

class RoomsSubmitController implements ControllerInterface
{

    function handle($post, $get, $server, &$session): string
    {
        $roomsService = new RoomsCreateService();
        $create = $roomsService->create(
            $session['user_id'],
            $post['room_name'],
            $post['room_description']
        );
        if (!$create) {
            $htmlRenderer = new HtmlRenderer();
            return $htmlRenderer->render('rooms.phtml', [
                'rooms' => (new RoomsService())->getRooms(),
                'error' => 'creation_failed'
            ]);
        }

        $htmlRenderer = new HtmlRenderer();
        return $htmlRenderer->render('rooms.phtml', [
            'rooms' => (new RoomsService())->getRooms(),
            'success' => 'creation_success'
        ]);
    }
}