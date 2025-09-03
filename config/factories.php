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
use App\Factories\DashboardControllerFactory;
use App\Factories\DashboardServiceFactory;
use App\Factories\ErrorControllerFactory;
use App\Factories\HtmlRendererFactory;
use App\Factories\ImprintControllerFactory;
use App\Factories\LoginControllerFactory;
use App\Factories\LoginServiceFactory;
use App\Factories\LogInSubmitControllerFactory;
use App\Factories\LogoutControllerFactory;
use App\Factories\LogoutServiceFactory;
use App\Factories\LogoutSubmitControllerFactory;
use App\Factories\PDOFactory;
use App\Factories\RegisterControllerFactory;
use App\Factories\RegisterServiceFactory;
use App\Factories\RegisterSubmitControllerFactory;
use App\Factories\ReminderCreateServiceFactory;
use App\Factories\ReminderDeleteControllerFactory;
use App\Factories\ReminderServiceFactory;
use App\Factories\ReminderSubmitControllerFactory;
use App\Factories\RoomControllerFactory;
use App\Factories\RoomsControllerFactory;
use App\Factories\RoomsCreateServiceFactory;
use App\Factories\RoomsServiceFactory;
use App\Factories\RoomsSubmitControllerFactory;
use App\Factories\UserServiceFactory;
use App\Factories\WarehouseControllerFactory;
use App\Factories\WarehouseServiceFactory;
use App\Factories\WarehouseSubmitControllerFactory;
use App\Services\DashboardService;
use App\Services\HtmlRenderer;
use App\Services\LoginService;
use App\Services\LogoutService;
use App\Services\RegisterService;
use App\Services\ReminderCreateService;
use App\Services\ReminderService;
use App\Services\RoomsCreateService;
use App\Services\RoomsService;
use App\Services\UserService;
use App\Services\WarehouseService;

return [
    DashboardController::class => DashboardControllerFactory::class,
    ErrorController::class => ErrorControllerFactory::class,
    ImprintController::class => ImprintControllerFactory::class,
    LoginController::class => LoginControllerFactory::class,
    LogInSubmitController::class => LogInSubmitControllerFactory::class,
    LogoutController::class => LogoutControllerFactory::class,
    LogoutSubmitController::class => LogoutSubmitControllerFactory::class,
    RegisterController::class => RegisterControllerFactory::class,
    RegisterSubmitController::class => RegisterSubmitControllerFactory::class,
    ReminderDeleteController::class => ReminderDeleteControllerFactory::class,
    ReminderSubmitController::class => ReminderSubmitControllerFactory::class,
    RoomController::class => RoomControllerFactory::class,
    RoomsController::class => RoomsControllerFactory::class,
    RoomsSubmitController::class => RoomsSubmitControllerFactory::class,
    WarehouseController::class => WarehouseControllerFactory::class,
    WarehouseSubmitController::class => WarehouseSubmitControllerFactory::class,
    DashboardService::class => DashboardServiceFactory::class,
    HtmlRenderer::class  => HtmlRendererFactory::class,
    LoginService::class => LoginServiceFactory::class,
    LogoutService::class => LogoutServiceFactory::class,
    RegisterService::class => RegisterServiceFactory::class,
    ReminderService::class => ReminderServiceFactory::class,
    ReminderCreateService::class => ReminderCreateServiceFactory::class,
    RoomsService::class => RoomsServiceFactory::class,
    RoomsCreateService::class => RoomsCreateServiceFactory::class,
    UserService::class => UserServiceFactory::class,
    WarehouseService::class => WarehouseServiceFactory::class,
    PDO::class => PDOFactory::class
];