<?php

try {
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'aqw1zsx2');
    define('DB_NAME', 'vapfactory');

    if (strcmp($_SERVER['ENVIRONMENT_TYPE'], "local") == 0) {

        $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    }

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
