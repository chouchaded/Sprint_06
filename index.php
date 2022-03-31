<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/2666/2666167.png
">

    <title>Vap Factory</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  <style>
        .wrapper{
            width: 90%;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 140px;
        }
    </style>

</head>
<body style="background-image: url('https://cdn.pixabay.com/photo/2020/07/22/10/10/fog-5428658_1280.jpg');background-position:center center;background-repeat:no-repeat;background-size: cover;">
    <p class="h2 mt-2 pt-2 pb-2 text-center bg-info text-white"><img src="https://c.pxhere.com/images/00/12/fa334b206fd93b10fe2cc961bf5a-1447437.jpg!d" width=auto height="100"> STOCK ET REFERENCEMENT <img src="https://c.pxhere.com/images/00/12/fa334b206fd93b10fe2cc961bf5a-1447437.jpg!d" width=auto height="100"></p>
    <div class="wrapper" >
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 d-flex justify-content-between">
                        <h2 class="pull-left text-white">Liste des articles</h2>
                        <a href="create.php" class="btn btn-success"><i class="bi bi-plus"></i>Ajouter une référence</a>
                    </div>
                    <?php

// Inclure le fichier config
require_once "config.php";

// select query execution
$sql = "SELECT * FROM stock";

if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo '<table class="table table-bordered border-info table-light">';
        echo '<thead class="table-warning">';
        echo "<tr>";
        // echo "<th>#</th>";
        echo "<th>Référence</th>";
        echo "<th>Nom de l'article</th>";
        // echo "<th>Description de l'article</th>";
        // echo "<th class='text-end'>Prix achat</th>";
        echo "<th class='text-end'>Prix vente</th>";
        echo "<th class='text-center'>Type article</th>";
        echo "<th class='text-center'>Qte.</th>";
        echo "<th class='text-center'> Modification Qte.</th>";

        echo "<th class='text-center'>Action</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            // echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['reference'] . "</td>";
            echo "<td>" . $row['nom_article'] . "</td>";
            // echo "<td>" . $row['descri_article'] . "</td>";
            // echo "<td class='text-end'>" . $row['prix_achat'] . " €</td>";
            echo "<td class='text-end'>" . $row['prix_vente'] . " €</td>";
            echo "<td class='text-center'>" . $row['vap_liq'] . "</td>";
            echo "<td class='text-center'>" . $row['qte'] . "</td>";
            echo "<td class='text-center'>";
            echo '<a href="gestionQte.php?id=' . $row['id'] . '" class="me-3" ><span class="bi bi-basket2"></span></a>';

            echo "<td class='text-center'>";
            echo '<a href="read.php?id=' . $row['id'] . '" class="me-3" ><span class="bi bi-eye"></span></a>';
            echo '<a href="update.php?id=' . $row['id'] . '" class="me-3" ><span class="bi bi-pencil"></span></a>';
            echo '<a href="delete.php?id=' . $row['id'] . '" ><span class="bi bi-trash"></span></a>';
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        // Free result set
        mysqli_free_result($result);
    } else {
        echo '<div class="alert alert-danger"><em>Pas d\'enregistrement</em></div>';
    }
} else {
    echo "Oops! Une erreur est survenue";
}

// Fermer connection
mysqli_close($link);
?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>