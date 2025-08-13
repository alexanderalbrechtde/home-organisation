<?php

//reg_controller--------------------------------------------------------------------------------------------------------
function already_exists($mail, $data)
{
    return array_key_exists($mail, $data);
}

function empty_register()
{
    if (empty($_POST['fName']) || empty($_POST['lName']) || empty($_POST['email']) || empty($_POST['pwd']) || empty($_POST['pwd2'])) {
        return false;
    } else {
        return true;
    }
}

function password_usage($path, $data, $mail): bool
{
    if ((strlen($_POST['pwd']) < 8)) {
        return false;
    } else {
        return true;
    }
}

function create_user($path)
{
    $username = $_POST['email'];
    $newUser = [
        'first_Name' => $_POST['fName'],
        'last_Name' => $_POST['lName'],
        'email' => $username,
        'password' => $_POST['pwd']
    ];
    $data = json_decode(file_get_contents($path), true);
    $data[$username] = $newUser;
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($path, $jsonData);

    //header('Location: /login');
}


/* old Code (funktioniert aber)
if (array_key_exists($mail, $data)) {
    header('Location: /register?alreadyRegistered');
} elseif (empty($_POST['fName']) || empty($_POST['lName']) || empty($_POST['email']) || empty($_POST['pwd']) || empty($_POST['pwd2'])) {
    header('Location: /register?invalidInput');
    exit;
} else {
    if ($_POST['pwd'] != $_POST['pwd2']) {
        header('Location: /register?invalid_psswrd');
        exit;
    } else {
        if (strlen($_POST['pwd']) < 8) {
            header('Location: /register?password_too_short');
            exit;
        } else {
            $username = $_POST['email'];
            $newUser = [
                'first_Name' => $_POST['fName'],
                'last_Name' => $_POST['lName'],
                'email' => $username,
                'password' => $_POST['pwd']
            ];

            $data = json_decode(file_get_contents($path), true);
            $data[$username] = $newUser;
            $jsonData = json_encode($data, JSON_PRETTY_PRINT);
            file_put_contents($path, $jsonData);

            header('Location: /login');
        }
    }
}
 */