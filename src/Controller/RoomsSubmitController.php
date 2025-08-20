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
            header("Location: /rooms?error=creation_failed");
            exit;
        }
        header("Location: /rooms?error=creation_success");
        return '';
    }
}