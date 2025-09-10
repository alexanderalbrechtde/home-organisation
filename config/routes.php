<?php

use App\Controller\DashboardController;
use App\Controller\ErrorController;
use App\Controller\ImprintController;
use App\Controller\LoginController;
use App\Controller\LogInSubmitController;
use App\Controller\LogoutController;
use App\Controller\LogoutSubmitController;
use App\Controller\RegisterController;
use App\Controller\RegisterSubmitController;
use App\Controller\ReminderDeleteController;
use App\Controller\ReminderSubmitController;
use App\Controller\RoomController;
use App\Controller\RoomsController;
use App\Controller\RoomsSubmitController;
use App\Controller\WarehouseController;
use App\Controller\WarehouseSubmitController;

return [
    'GET' => [
        '/' => DashboardController::class,
        '/login' => LoginController::class,
        '/register' => RegisterController::class,
        '/logout' => LogoutController::class,
        '/impressum' => ImprintController::class,
        '/404' => ErrorController::class,
        '/rooms' => RoomsController::class,
        '/room' => RoomController::class,
        '/warehouse' => WarehouseController::class,
    ],
    'POST' => [
        '/login-submit' => LoginSubmitController::class,
        '/register-submit' => RegisterSubmitController::class,
        '/logout-submit' => LogoutSubmitController::class,
        '/rooms-submit' => RoomsSubmitController::class,
        '/reminder-submit' => ReminderSubmitController::class,
        '/reminder-delete' => ReminderDeleteController::class,
        '/warehouse-submit' => WarehouseSubmitController::class
    ]
];