<?php

//$email = $_POST['email'] ?? '';
//$passwort = $_POST['pwd'] ?? '';
$path = __DIR__ . '/../../../data/users.json';
$json = file_get_contents($path);
$data = json_decode($json, true);

require_once __DIR__ . ('/../functions.php');

empty_data($_POST['email'] ?? '', $_POST['password'] ?? '');

user_found($data, $email = $_POST['email'] ?? '');

header('Location: /');