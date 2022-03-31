<?php
// Inclure le fichier
require_once "config.php";

// Definir les variables
$qte = $qte_achat = $qte_vente = "";
$qte_err = $qteachat_err = $qtevente_err = "";

// verifier la valeur id dans le post pour la mise à jour
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // recuperation du champ chaché
    $id = $_POST["id"];

    $input_qte = trim($_POST["qte"]);
    if (empty($input_qte)) {
        $qte_err = "Veillez entrez la quantité:";
    } elseif (!ctype_digit($input_qte)) {
        $qte_err = "Veillez entrez une valeur positive.";
    } else {
        $qte = $input_qte;
    }

    // verifier les erreurs avant modification
    if (empty($qte_err)) {
        // Prepare an update statement
        $sql = "UPDATE stock SET  qte=? WHERE id=?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind les variables
            mysqli_stmt_bind_param($stmt, "ii", $param_qte, $param_id);

            $param_qte = $qte;
            $param_id = $id;

            // executer
            if (mysqli_stmt_execute($stmt)) {
                // enregistremnt modifié, retourne
                header("location: index.php");
                exit();
            } else {
                echo "Oops! une erreur est survenue.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
} else {
    // si il existe un paramettre id
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // recupere URL parameter
        $id = trim($_GET["id"]);

        // Prepare la requete
        $sql = "SELECT * FROM stock WHERE id = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind les variables
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* recupere l'enregistremnt */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // recupere les champs
                    $reference = $row["reference"];
                    $type_article = $row["vap_liq"];
                    $nom_article = $row["nom_article"];
                    $descri_article = $row["descri_article"];
                    $prix_achat = $row["prix_achat"];
                    $prix_vente = $row["prix_vente"];
                    $qte = $row["qte"];

                } else {
                    // pas de id parametter valid, retourne erreur
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
        // pas de id parametter valid, retourne erreur
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'enregistrement</title>
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
                <div class="col-md-15">
                    <h2 class="mt-2">Mise à jour du Stock</h2>
                    <p>Modifier le champ Quantité et enregistrer</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

                        <div class="form-group">
                        <label><b>Référence</b></label>
                        <p class="form-control"><?php echo $row["reference"]; ?></p>
                    </div>

                    <div class="form-group mt-2">
                        <label><b>Nom article</b></label>
                        <p class="form-control"><?php echo $row["nom_article"]; ?></p>
                    </div>

                        <div class="form-group mt-2">
                            <label><b>Quantité</b></label>
                            <input type="number" name="qte" class="form-control mt-2"
                            <?php echo (!empty($qte_err)) ? 'is-invalid' : ''; ?>
                            value="<?php echo $qte; ?>">
                            <span class="invalid-feedback"><?php echo $qte_err; ?></span>
                        </div>




                           <div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" class="btn btn-primary mt-2" value="Enregistrer">
                        <a href="index.php" class="btn btn-secondary ml-2 mt-2">Annuler</a></form>
                </div>

</div>


        </div>
    </div>
</body>
</html>

                           <!-- <div><form>
                            <label><b>Qte. Achat</b></label>
                            <input type="number" name="qte_achat" class="form-control mt-2">

                            <label><b>Qte. Vente</b></label>
                            <input type="number" name="qte_vente" class="form-control mt-2">

                            <input type="submit"  class="btn btn-light mt-2" value="calculer"></form>
                             <?php
/*$qte_vente = $qte_achat = $result_stockA = $result_stockS = 0;

if (isset($_POST['qte_vente']) && ctype_digit($_POST['qte_vente'])) {
$qte_vente = $_POST['qte_vente'];
$result_stockS = $qte - $qte_vente;}

if (isset($_POST['qte_achat']) && ctype_digit($_POST['qte_achat'])) {
$qte_achat = $_POST['qte_achat'];
$result_stockA = $qte_achat + $qte;
}
;

if (empty($qte_vente)) {echo $result_stockA;}
if (empty($qte_achat)) {echo $result_stockS;}

?>

<input type="number"  class="form-control mt-2 "
value="<?php if (empty($qte_vente)) {echo $result_stockA;}
if (empty($qte_achat)) {echo $result_stockS;}
;?>">
</div>*/
