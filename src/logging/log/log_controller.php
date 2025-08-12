<?php
$email = $_POST['email'] ?? '';
$passwort = $_POST['pwd'] ?? '';
if (empty($email) || empty($passwort)) {
    header('Location: /login?invalidInput');
}

$email = $_POST['email'] ?? '';

$path = __DIR__ . '/../../../data/user.json';

$json = file_get_contents($path);
$data = json_decode($json, true);

if (is_array($data)) {
    $found = false;
    foreach ($data as $entry) {
        if (isset($entry['email']) && $entry['email'] === $email) {
            $found = true;
            break;
        }
    }
    if ($found) {
        $_SESSION['is_login'] = true;
        header('Location: /');
        exit;
    } else if(isset($_SESSION['is_login']) && $_SESSION['is_login']) {
        header('Location: /');
    } else {
        header('Location: /login?login=false');
        exit;
    }
}