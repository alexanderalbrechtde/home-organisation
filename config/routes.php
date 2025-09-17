<?php

use App\Controller\AccountController;
use App\Controller\AccountSubmitController;
use App\Controller\AllTasksController;
use App\Controller\DashboardController;
use App\Controller\ErrorController;
use App\Controller\ImprintController;
use App\Controller\LoginController;
use App\Controller\LogInSubmitController;
use App\Controller\LogoutController;
use App\Controller\LogoutSubmitController;
use App\Controller\RegisterController;
use App\Controller\RegisterSubmitController;
use App\Controller\TaskDeleteController;
use App\Controller\TaskSubmitController;
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
        '/account' => AccountController::class,
        '/all-tasks' => AllTasksController::class,
    ],
    'POST' => [
        '/login-submit' => LoginSubmitController::class,
        '/register-submit' => RegisterSubmitController::class,
        '/logout-submit' => LogoutSubmitController::class,
        '/rooms-submit' => RoomsSubmitController::class,
        '/task-submit' => TaskSubmitController::class,
        '/task-delete' => TaskDeleteController::class,
        '/warehouse-submit' => WarehouseSubmitController::class,
        '/account-submit' => AccountSubmitController::class,
    ]
];