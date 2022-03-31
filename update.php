<?php
// Inclure le fichier
require_once "config.php";

// Definir les variables
$reference = $nom_article = $prix_achat = $prix_vente = $descri_article = $qte = "";
$ref_err = $nomarticle_err = $prixachat_err = $prixvente_err = $descriarticle_err = $qte_err = "";

// verifier la valeur id dans le post pour la mise à jour
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // recuperation du champ chaché
    $id = $_POST["id"];

    // Validate name
    $input_ref = trim($_POST["reference"]);
    if (empty($input_ref)) {
        $ref_err = "Veillez entrez une reference.";
    } elseif (!filter_var($input_ref, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9a-zA-Z\s]+$/")))) {
        $ref_err = "Veillez entrez a valid name.";
    } else {
        $reference = $input_ref;
    }

    // $input_typearticle = trim($_POST["vap_liq"]);
    // if (empty($input_typearticle)) {
    //     $typearticle_err = "Veillez entrez un type d'article.";
    // } else {
    //     $type_article = $input_typearticle;
    // }

    // Validate ecole
    $input_nomarticle = trim($_POST["nom_article"]);
    if (empty($input_nomarticle)) {
        $nomarticle_err = "Veillez entrez un nom d'article.";
    } else {
        $nom_article = $input_nomarticle;
    }

    $input_descriarticle = trim($_POST["descri_article"]);
    if (empty($input_descriarticle)) {
        $descriarticle_err = "Veillez entrez la description de l'article.";
    } else {
        $descri_article = $input_descriarticle;
    }

    // Validate age
    $input_prixachat = trim($_POST["prix_achat"]);
    if (empty($input_prixachat)) {
        $prixachat_err = "Veillez entrez le prix d'achat.";
    } elseif (!is_numeric($input_prixachat)) {
        $prixachat_err = "Veillez entrez une valeur positive.";
    } else {
        $prix_achat = $input_prixachat;
    }

    $input_prixvente = trim($_POST["prix_vente"]);
    if (empty($input_prixvente)) {
        $prixvente_err = "Veillez entrez le prix d'achat.";
    } elseif (!is_numeric($input_prixvente)) {
        $prixvente_err = "Veillez entrez une valeur positive.";
    } else {
        $prix_vente = $input_prixvente;
    }

    $input_qte = trim($_POST["qte"]);
    if (empty($input_qte)) {
        $qte_err = "Veillez entrez la quantité:";
    } elseif (!ctype_digit($input_qte)) {
        $qte_err = "Veillez entrez une valeur positive.";
    } else {
        $qte = $input_qte;
    }

    // verifier les erreurs avant modification
    if (empty($ref_err) && empty($nomarticle_err) && empty($descriarticle_err) && empty($prixachat_err) && empty($prixvente_err) && empty($qte_err)) {
        // Prepare an update statement
        $sql = "UPDATE stock SET reference=?,  nom_article=?, descri_article=?, prix_achat=?, prix_vente =?, qte=? WHERE id=?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind les variables
            mysqli_stmt_bind_param($stmt, "sssssii", $param_ref, $param_nomarticle, $param_descriarticle, $param_prixachat, $param_prixvente, $param_qte, $param_id);

            // Set parameters
            $param_ref = $reference;
            // $param_typearticle = $type_article;
            $param_nomarticle = $nom_article;
            $param_descriarticle = $descri_article;
            $param_prixachat = $prix_achat;
            $param_prixvente = $prix_vente;
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
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/2666/2666167.png
">
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
                    <h2 class="mt-5">Mise à jour de l'enregistrement</h2>
                    <p>Modifier les champs et enregistrer</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Reference</label>
                            <input type="text" name="reference" class="form-control <?php echo (!empty($ref_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $reference; ?>">
                            <span class="invalid-feedback"><?php echo $ref_err; ?></span>
                        </div>

 <div class="form-group">
                        <label><b>Type d'article</b></label>
                        <p class="form-control"><?php echo $row["vap_liq"]; ?></p>
                    </div>

                         <!-- <div class="form-group mt-2 ">
                            <label><b>Type d'article</b></label>
                        <select name="vap_liq" class="mt-2 md-2">
     <option value="<?php // echo $vap_liq = 'E-cigarette'; ?>
">E-cigarette</option>
     <option value="<?php // echo $vap_liq = 'E-liquide'; ?>
">E-liquide</option>

</select>
</div> -->
                        <div class="form-group mt-2">
                            <label>Nom article</label>
                            <textarea name="nom_article" class="form-control <?php echo (!empty($nomarticle_err)) ? 'is-invalid' : ''; ?>"><?php echo $nom_article; ?></textarea>
                            <span class="invalid-feedback"><?php echo $nomarticle_err; ?></span>
                        </div>
 <div class="form-group">
                            <label>Description article</label>
                            <textarea name="descri_article" class="form-control <?php echo (!empty($descriarticle_err)) ? 'is-invalid' : ''; ?>"><?php echo $descri_article; ?></textarea>
                            <span class="invalid-feedback"><?php echo $descriarticle_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Prix achat</label>
                            <input type="number" step="0.01" name="prix_achat" class="form-control <?php echo (!empty($prixachat_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $prix_achat; ?>">
                            <span class="invalid-feedback"><?php echo $prixachat_err; ?></span>
                        </div>
                         <div class="form-group">
                            <label>Prix vente</label>
                            <input type="number" step="0.01" name="prix_vente" class="form-control <?php echo (!empty($prixvente_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $prix_vente; ?>">
                            <span class="invalid-feedback"><?php echo $prixvente_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label><b>Quantité</b></label>
                            <input type="number" name="qte" class="form-control <?php echo (!empty($qte_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $qte; ?>">
                            <span class="invalid-feedback"><?php echo $qte_err; ?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary mt-2" value="Enregistrer">
                        <a href="index.php" class="btn btn-secondary ml-2 mt-2">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
