<?php
// Verifiez si le paramettre id existe
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Inclure le fichier config
    require_once "config.php";

    // Preparer la requete
    $sql = "SELECT * FROM stock WHERE id = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind les variables
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute la requette
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                /* recuperer l'enregistrement */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // recuperer les champs
                $reference = $row["reference"];
                $nom_article = $row["nom_article"];
                $descri_article = $row["descri_article"];
                $prix_achat = $row["prix_achat"];
                $prix_vente = $row["prix_vente"];
                $vap_liq = $row["vap_liq"];
                $qte = $row["qte"];

            } else {
                // Si pas de id correct retourne la page d'erreur
                header("location: error.php");
                exit();
            }

        } else {
            echo "Oops! une erreur est survenue.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($link);
} else {
    // Si pas de id correct retourne la page d'erreur
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Voir l'enregistrement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .wrapper{
            width: 700px;
            margin: 0 auto;
        }
    </style>
</head>
<body style="background-image: url('https://cdn.pixabay.com/photo/2020/07/22/10/10/fog-5428658_1280.jpg');background-position:center center;background-repeat:no-repeat;background-size: cover;">
    <p class="h2 mt-2 pt-2 pb-2 text-center bg-info text-white"><img src="https://c.pxhere.com/images/00/12/fa334b206fd93b10fe2cc961bf5a-1447437.jpg!d" width=auto height="100"> STOCK ET REFERENCEMENT <img src="https://c.pxhere.com/images/00/12/fa334b206fd93b10fe2cc961bf5a-1447437.jpg!d" width=auto height="100"></p>
    <div class="wrapper">
        <div class="container-fluid text-light">
            <div class="row">
                <div class="col-md-12">
                                        <h1 class="mt-5 mb-3">Voir la référence</h1>
                    <div class="form-group">
                        <label><b>Référence</b></label>
                        <p class="form-control"><?php echo $row["reference"]; ?></p>
                    </div>
                           <div class="form-group">
                        <label><b>Type d'article</b></label>
                        <p class="form-control"><?php echo $row["vap_liq"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label><b>Nom article</b></label>
                        <p class="form-control"><?php echo $row["nom_article"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label><b>Description article</b></label>
                        <p class="form-control"><?php echo $row["descri_article"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label><b>Prix achat</b></label>
                        <p class="form-control"><?php echo $row["prix_achat"]; ?> €</p>
                    </div>
                    <div class="form-group">
                        <label><b>Prix vente</b></label>
                        <p class="form-control"><?php echo $row["prix_vente"]; ?> €</p>
                    </div>
 <div class="form-group">
                        <label><b>Quantité</b></label>
                        <p class="form-control"><?php echo $row["qte"]; ?> €</p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Retour</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
