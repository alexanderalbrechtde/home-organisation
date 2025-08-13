<?php

$path = __DIR__ . '/../../../data/user.json';
$data = [];
$mail = $_POST['email'];
$data = json_decode(file_get_contents($path), true);

