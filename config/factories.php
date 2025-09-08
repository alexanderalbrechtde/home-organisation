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
use App\Factories\PDOFactory;
use App\Services\DashboardService;
use App\Services\LoginService;
use App\Services\LogoutService;
use App\Services\RegisterService;
use App\Services\ReminderCreateService;
use App\Services\ReminderService;
use App\Services\RoomsCreateService;
use App\Services\RoomsService;
use App\Services\WarehouseService;
use App\Validators\EmailValidator;
use App\Validators\EmptyValidator;
use App\Validators\PasswordLengthValidator;
use App\Validators\PasswordSpecialCharValidator;
use Framework\Factories\AutoWireFactory;
use Framework\Factories\InvokableFactory;
use Framework\Services\HtmlRenderer;
use Framework\Services\UserService;


return [
    DashboardController::class => AutoWireFactory::class,
    ErrorController::class => AutoWireFactory::class,
    ImprintController::class => AutoWireFactory::class,
    LoginController::class => AutoWireFactory::class,
    LogInSubmitController::class => AutoWireFactory::class,
    LogoutController::class => AutoWireFactory::class,
    LogoutSubmitController::class => InvokableFactory::class,
    RegisterController::class => AutoWireFactory::class,
    RegisterSubmitController::class => AutoWireFactory::class,
    ReminderDeleteController::class => AutoWireFactory::class,
    ReminderSubmitController::class => AutoWireFactory::class,
    RoomController::class => AutoWireFactory::class,
    RoomsController::class => AutoWireFactory::class,
    RoomsSubmitController::class => AutoWireFactory::class,
    WarehouseController::class => AutoWireFactory::class,
    WarehouseSubmitController::class => AutoWireFactory::class,
    DashboardService::class => AutoWireFactory::class,
    HtmlRenderer::class  => InvokableFactory::class,
    LoginService::class => AutoWireFactory::class,
    LogoutService::class => InvokableFactory::class,
    RegisterService::class => AutoWireFactory::class,
    ReminderService::class => AutoWireFactory::class,
    ReminderCreateService::class => AutoWireFactory::class,
    RoomsService::class => AutoWireFactory::class,
    RoomsCreateService::class => AutoWireFactory::class,
    UserService::class => AutoWireFactory::class,
    WarehouseService::class => AutoWireFactory::class,
    PDO::class => PDOFactory::class,
    EmptyValidator::class => InvokableFactory::class,
    EmailValidator::class => InvokableFactory::class,
    PasswordLengthValidator::class => InvokableFactory::class,
    PasswordSpecialCharValidator::class => InvokableFactory::class,
];