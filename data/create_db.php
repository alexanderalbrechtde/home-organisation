<?php

$pdo = new PDO('sqlite:' . __DIR__ . '/home-organisation.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec(
    "CREATE TABLE user(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
   first_Name TEXT(30) NOT NULL,
   last_Name TEXT(30) NOT NULL,
   email TEXT(30) NOT NULL,
   password TEXT(30) NOT NULL
)"
);

