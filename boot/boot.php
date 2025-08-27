<?php

session_start();

//DD
function dd(mixed $var): void
{
    echo '<pre>';
    var_dump($var);
    exit;
}

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

require_once __DIR__ . '/../src/Controller/RoomController.php';
require_once __DIR__ . '/../src/Controller/RoomsController.php';
require_once __DIR__ . '/../src/Controller/RoomsSubmitController.php';

require_once __DIR__ . '/../src/Controller/ReminderSubmitController.php';

require_once __DIR__ . '/../src/Controller/ReminderDeleteController.php';

require_once __DIR__ . '/../src/Controller/WarehouseController.php';
require_once __DIR__ . '/../src/Controller/WarehouseSubmitController.php';


//Services
require_once __DIR__ . '/../src/Services/htmlRenderer.php';
require_once __DIR__ . '/../src/Services/LoginService.php';
require_once __DIR__ . '/../src/Services/UserService.php';
require_once __DIR__ . '/../src/Services/RegisterService.php';
require_once __DIR__ . '/../src/Services/LogoutService.php';
require_once __DIR__ . '/../src/Services/RoomsCreateService.php';
require_once __DIR__ . '/../src/Services/RoomsService.php';
require_once __DIR__ . '/../src/Services/ReminderService.php';
require_once __DIR__ . '/../src/Services/ReminderCreateService.php';
require_once __DIR__ . '/../src/Services/WarehouseService.php';


//Dtos
require_once __DIR__ . '/../src/Dtos/UserDto.php';
require_once __DIR__ . '/../src/Dtos/RoomDto.php';
require_once __DIR__ . '/../src/Dtos/ReminderDto.php';
require_once __DIR__ . '/../src/Dtos/ItemDto.php';
