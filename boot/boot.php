<?php

session_start();

spl_autoload_register(function (string $class) {

    $class = str_replace('App' , 'src', $class);
    $class = str_replace('\\' , '/', $class);
    $filePath = __DIR__ .  '/../' . $class . '.php';
        if (file_exists($filePath)) {
            require_once($filePath);
            return '';
        }
});


//DD
function dd(mixed $var): void
{
    echo '<pre>';
    var_dump($var);
    exit;
}

