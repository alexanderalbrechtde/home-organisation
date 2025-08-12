<?php
function userExists($email): void
{
    if (array_key_exists("login", $_GET) && $_GET['login'] === 'true') {
        echo "Benutzer gefunden!";
    } else {
        if (array_key_exists("login", $_GET) && $_GET['login'] === 'false') {
            echo "Benutzer nicht gefunden!";
        }
    }
}