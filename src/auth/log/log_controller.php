<?php

//$email = $_POST['email'] ?? '';
//$passwort = $_POST['pwd'] ?? '';
$path = __DIR__ . '/../../../data/user.json';
$json = file_get_contents($path);
$data = json_decode($json, true);

require_once __DIR__ . ('/../functions.php');

empty_data($_POST['email'] ?? '', $_POST['pwd'] ?? '');

user_found($email = $_POST['email'] ?? '', $data);

header('Location: /');