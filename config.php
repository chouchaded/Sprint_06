<?php
/* Database connexion */
// define('DB_SERVER', 'localhost');
// define('DB_USERNAME', 'root');
// define('DB_PASSWORD', 'aqw1zsx2');
// define('DB_NAME', 'vapfactory');

/* Connexion à la base de données */
// $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
// $link = mysqli_connect('localhost', 'root', 'aqw1zsx2', 'vapfactory');

// verifier connection
// if ($link === false) {
//     die("ERROR: Could not connect. " . mysqli_connect_error());
// }
try {
// local config
    if (strcmp($_SERVER['ENVIRONMENT_TYPE'], "local") == 0) {
    $link = mysqli_connect('localhost', 'root', 'aqw1zsx2', 'vapfactory');

}
// distant config
    if (strcmp($_SERVER['ENVIRONMENT_TYPE'], "distant") == 0) {

// /* Connexion à la base de données */

        $link = mysqli_connect('109.234.164.161', $_SERVER['DB_USER'], $_SERVER['DB_PASSWORD'], 'sc1lgvu9627_subirats-yannick.sprint-06');
    }
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
}