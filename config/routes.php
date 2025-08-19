<?php

return [
    '/' => 'DashboardController',
    //'/header' => 'HeaderController',
    //'/footer' => 'FooterController',
    '/login' => 'LoginController', //nach Implementierung das hier überprüfen
    '/register' => 'RegisterController',
    '/logout' => 'LogoutController',
    '/impressum' => 'ImprintController',
    '/404' => 'ErrorController',
    '/konto' => 'KontoController',

    '/kitchen' => 'KitchenController',
    '/bathroom' => 'BathroomController',
    '/bedroom' => 'BedroomController',

    '/login-submit' => 'LoginSubmitController',
    '/register-submit' => 'RegisterSubmitController',
    '/logout-submit' => 'LogoutSubmitController',


//    '/login' => __DIR__ . '/../src/Auth/Log/log_Overlay.php',
//    '/login_controller' => __DIR__ . '/../src/Auth/Log/log_controller.php',
//    '/register' => __DIR__ . '/../src/Auth/Reg/reg_Overlay.php',
//    '/reg_controller' => __DIR__ . '/../src/Auth/Reg/reg_controller.php',
//    '/impressum' =>  __DIR__ . '/../src/pages/impressum.php',
//    '/user_exist' => __DIR__ . '/../src/Auth/Log/user_exist.php',
//
//    '/bath' => __DIR__ . '/../src/pages/categories/bathroom.php',
//    '/kitchen' => __DIR__ . '/../src/pages/categories/kitchen.php',
//    '/bedroom' => __DIR__ . '/../src/pages/categories/bedroom.php',
];