<?php
$email = $_POST['email'] ?? '';
echo '<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="/style/style.css">
    <title>Login</title>
</head>
<body>
<h1>Login</h1>
<body class="login-overlay">
<p> Bitte loggen Sie sich ein!
<form action="/login_controller" method="POST">
    <label for="email">Email:</label><br>
    <input type="text" id="email" name="email"><br>
    <label for="pwd">Passwort:</label><br>
    <input type="text" id="pwd" name="pwd"><br>
    <br>
    <input type="submit" value="Abschicken">
    <br>
    <br>
    <a href="/register">Registrieren</a>
</form>    ';

if (isset($_SESSION['is_login']) && $_SESSION['is_login'] === true) {
    header('Location: /');
    exit;
}

require __DIR__ . '/user_exist.php';
userExists($email);

echo '</body></html>';