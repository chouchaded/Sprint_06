<?php
// Inclure le fichier config
require_once "config.php";

// Definir les variables
$reference = $nom_article = $descri_article = $prix_achat = $prix_vente = $vap_liq = $qte = "";
$ref_err = $nomarticle_err = $descriarticle_err = $prixachat_err = $prixvente_err = $vapliq_err = $qte_err = "";

// Traitement
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate reference
    $input_ref = trim($_POST["reference"]);
    if (empty($input_ref)) {
        $ref_err = "Veillez entrez une référence:";
    } elseif (!filter_var($input_ref, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9a-zA-Z\s]+$/")))) {
        $ref_err = "Veillez entrez une référence valide.";
    } else {
        $reference = $input_ref;
    }

    $input_vapliq = trim($_POST["vap_liq"]);
    if (empty($input_vapliq)) {
        $vapliq_err = "Veillez entrez un type";
    } else {
        $vap_liq = $input_vapliq;
    }

    // Validate nom article
    $input_nom = trim($_POST["nom_article"]);
    if (empty($input_nom)) {
        $nomarticle_err = "Veillez entrez un nom d'article:";
    } else {
        $nom_article = $input_nom;
    }

    // Validate description article
    $input_descri = trim($_POST["descri_article"]);
    if (empty($input_descri)) {
        $descriarticle_err = "Veillez entrez le descriptif de l'article:";
    } else {
        $descri_article = $input_descri;
    }

    // Validate prix achat
    $input_prixachat = trim($_POST["prix_achat"]);
    if (empty($input_prixachat)) {
        $prixachat_err = "Veillez entrez le prix d'achat:";
    } elseif (!is_numeric($input_prixachat)) {
        $prixachat_err = "Veillez entrez une valeur positive.";
    } else {
        $prix_achat = $input_prixachat;
    }

    // Validate prix vente
    $input_prixvente = trim($_POST["prix_vente"]);
    if (empty($input_prixvente)) {
        $prixvente_err = "Veillez entrez le prix de vente:";
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

    // verifiez les erreurs avant enregistrement
    if (empty($ref_err) && empty($nomarticle_err) && empty($descriarticle_err) && empty($prixachat_err) && empty($prixvente_err) && empty($vapliq_err) && empty($qte_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO stock (reference, nom_article, descri_article, prix_achat, prix_vente, vap_liq, qte) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind les variables à la requette preparée
            mysqli_stmt_bind_param($stmt, "sssddsi", $param_ref, $param_nomarticle, $param_descriarticle, $param_prixachat, $param_prixvente, $param_vapliq, $param_qte);

            // Set parameters
            $param_ref = $reference;
            $param_nomarticle = $nom_article;
            $param_descriarticle = $descri_article;
            $param_prixachat = $prix_achat;
            $param_prixvente = $prix_vente;
            $param_vapliq = $vap_liq;
            $param_qte = $qte;

            // executer la requette
            if (mysqli_stmt_execute($stmt)) {
                // opération effectuée, retour
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
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>enregistrement Article</title>
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
                    <h2 class="mt-5 text-light">Créer un enregistrement</h2>
                    <p>Remplir le formulaire pour enregistrer l'article dans la base de données</p>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label><b>Référence</b></label>
                            <input type="text" name="reference" class="form-control <?php echo (!empty($ref_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $reference; ?>">
                            <span class="invalid-feedback"><?php echo $ref_err; ?></span>
                        </div>
                            <div class="form-group mt-2 ">
                            <label><b>Type d'article</b></label>
                        <select name="vap_liq" class="mt-2 md-2">
     <option value="<?php echo $vap_liq = 'E-cigarette'; ?>
">E-cigarette</option>
     <option value="<?php echo $vap_liq = 'E-liquide'; ?>
">E-liquide</option>

</select>
</div>
                        <div class="form-group mt-2">
                            <label><b>Nom de l'article</b></label>
                            <textarea name="nom_article" class="form-control <?php echo (!empty($nomarticle_err)) ? 'is-invalid' : ''; ?>"><?php echo $nom_article; ?></textarea>
                            <span class="invalid-feedback"><?php echo $nomarticle_err; ?></span>
                        </div>
                            <div class="form-group">
                            <label><b>Description de l'article</b></label>
                            <textarea name="descri_article" class="form-control <?php echo (!empty($descriarticle_err)) ? 'is-invalid' : ''; ?>"><?php echo $descri_article; ?></textarea>
                            <span class="invalid-feedback"><?php echo $descriarticle_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label><b>Prix achat</b></label>
                            <input type="number" step="0.01" name="prix_achat" class="form-control <?php echo (!empty($prixachat_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $prix_achat; ?>">
                            <span class="invalid-feedback"><?php echo $prixachat_err; ?></span>
                        </div>

                            <div class="form-group">
                            <label><b>Prix vente</b></label>
                            <input type="number" step="0.01" name="prix_vente" class="form-control <?php echo (!empty($prixvente_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $prix_vente; ?>">
                            <span class="invalid-feedback"><?php echo $prixvente_err; ?></span>
                        </div>
 <div class="form-group">
                            <label><b>Quantité</b></label>
                            <input type="number" name="qte" class="form-control <?php echo (!empty($qte_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $qte; ?>">
                            <span class="invalid-feedback"><?php echo $qte_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary mt-2" value="Enregistrer">
                        <a href="index.php" class="btn btn-secondary ml-2 mt-2">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>