<?php

session_start();

//Utilities
//require_once __DIR__ . '/../src/functions.php';


//Interfaces
require_once __DIR__ . '/../src/Interfaces/ControllerInterface.php';


//Controllers
require_once __DIR__ . '/../src/Controller/DashboardController.php';
require_once __DIR__ . '/../src/Controller/ErrorController.php';
require_once __DIR__ . '/../src/Controller/ImprintController.php';

require_once __DIR__ . '/../src/Controller/LoginController.php';
require_once __DIR__ . '/../src/Controller/LogInSubmitController.php';
require_once __DIR__ . '/../src/Controller/RegisterController.php';
require_once __DIR__ . '/../src/Controller/RegisterSubmitController.php';
require_once __DIR__ . '/../src/Controller/LogoutController.php';
require_once __DIR__ . '/../src/Controller/LogoutSubmitController.php';


require_once __DIR__ . '/../src/Controller/RoomsController.php';
require_once __DIR__ . '/../src/Controller/RoomsSubmitController.php';
require_once __DIR__ . '/../src/Controller/RoomController.php';


//Services
require_once __DIR__ . '/../src/Services/htmlRenderer.php';
require_once __DIR__ . '/../src/Services/LoginService.php';
require_once __DIR__ . '/../src/Services/UserService.php';
require_once __DIR__ . '/../src/Services/RegisterService.php';
require_once __DIR__ . '/../src/Services/LogoutService.php';
require_once __DIR__ . '/../src/Services/RoomsCreateService.php';
require_once __DIR__ . '/../src/Services/RoomsService.php';


//Dtos
require_once __DIR__ . '/../src/Dtos/UserDto.php';