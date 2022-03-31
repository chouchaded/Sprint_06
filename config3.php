 <?php

if (strcmp($_SERVER['ENVIRONMENT_TYPE'], "distant") == 0) {

    $link = mysqli_connect('109.234.164.161', $_SERVER['DB_USERNAME'], $_SERVER['DB_PASSWORD'], 'sc1lgvu9627_subirats-yannick.sprint-06');

/* Vérification de la connexion */
    if (!$link) {
        printf("Echec de la connexion : %s\n", mysqli_connect_error());
        exit();
    }

    printf("Information sur le serveur : %s\n", mysqli_get_host_info($link));

/* Fermeture de la connexion */
    mysqli_close($link);}
?>