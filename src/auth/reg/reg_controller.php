<?php

$path = __DIR__ . '/../../../data/user.json';
$data = [];
$mail = $_POST['email'];
$data = json_decode(file_get_contents($path), true);

require_once __DIR__ . '/../functions.php';

$mail = isset($_POST['email']) ? trim($_POST['email']) : '';

user_exists($mail, $data);

empty_register($_POST['fName'], $_POST['lName'], $_POST['email'], $_POST['pwd'], $_POST['pwd2']);

equal_pwd($_POST['pwd'], $_POST['pwd2']);

password_usage($_POST['pwd']);

create_user($path);

header('Location: /login');