<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <?php include "./includes/head.inc.html"; ?>
</head>

<body>
<header>
    <?php include "./includes/header.inc.html"; ?>
</header>
<div>
    <div class="row">
        <nav class="col-sm-4 col-lg-2 m-2">
            <a href="index.php">
                <button type="button" class="btn btn-outline-secondary col-12">Home</button>
            </a>
            <?php
            if (!empty($_SESSION['table'])) {
                include "./includes/ul.inc.html";
            }
            if (empty($_SESSION['table']) && (isset($_GET['del']) || isset($_GET['debugging']) || isset($_GET['concatenation']) || isset($_GET['loop']) || isset($_GET['function']))) {
                header("Location:index.php");
            }
            ?>
        </nav>
        <section class="m-2 col-sm-4 col-lg-8">

            <?php

            if (isset($_GET['add'])) {
                include "./includes/form.inc.html";
            } else if (isset($_POST['enregistrer'])) {
                $prenom = htmlentities($_POST['prenom']);
                $nom = htmlentities($_POST['nom']);
                $age = htmlentities($_POST['age']);
                $taille = htmlentities($_POST['taille']);
                $radio = htmlentities($_POST['radio']);

                $table = array(
                    'prenom' => $prenom,
                    'nom' => $nom,
                    'age' => $age,
                    'taille' => $taille,
                    'situation' => $radio
                );
                $_SESSION['table'] = $table;
                if (isset($_SESSION['table'])) {
                    echo "<h1>Données enregistrées</h1>";
                }
            } else if (isset($_GET['del'])) {
                unset($_SESSION['table']);
                if (empty($_SESSION['table'])) {
                    echo "<h1>Les données ont bien été supprimées</h1>";
                }

            } else if (isset($_GET['debugging'])) {
                $table = $_SESSION['table'];
                echo "<h1>Débogage</h1>";
                echo "<p>===> Lecture du tableau à l'aide de la fonction print_r()</p>";
                print "<pre>";
                print_r($table);
                print "</pre>";
            } else if (isset($_GET['concatenation'])) {
                $table = $_SESSION['table'];
                echo "<h1>Concaténation</h1>";
                echo "<p>===> Construction d'une phrase avec le contenu du tableau :</p>";
                echo "<h2>$table[prenom] $table[nom]</h2>";
                echo "<p>$table[age] ans, je mesure $table[taille]m et je fais partie des $table[situation]s de la promo Simplon</p><br>";
                $table['prenom'] = ucfirst($table['prenom']);
                $table['nom'] = strtoupper($table['nom']);
                echo "<p>===> Construction d'une phrase après MAJ du tableau :</p>";
                echo "<h2>$table[prenom] $table[nom]</h2>";
                echo "<p>$table[age] ans, je mesure $table[taille]m et je fais partie des $table[situation]s de la promo Simplon</p><br>";
                echo "<p>===> Affichage d'une virgule à la place du point pour la taille :</p>";
                echo "<h2>$table[prenom] $table[nom]</h2>";
                echo "<p>$table[age] ans, je mesure " . str_replace('.', ',', $table['taille']) . "m et je fais partie des $table[situation]s de la promo Simplon</p>";
            } else if (isset($_GET['loop'])) {
                $table = $_SESSION['table'];
                echo "<h1>Boucle</h1>";
                echo "===> Lecture du tableau à l'aide d'une boucle foreach<br>";
                $i = 0;
                foreach ($table as $item => $value) {
                    echo "<p>à la ligne n°$i correspond à la clé '$item' et contient '$value'</p>";
                    $i++;
                }
            } else if (isset($_GET['function'])) {
                $table = $_SESSION['table'];
                echo "<h1>Fonction</h1>";
                echo "===> J'utilise ma fonction readTable()<br>";
                readTable($table);
            } else {
                echo "
                <a href='index.php?add' class='btn btn-primary px-2'>Ajouter des données</a>
                ";
            }
            function readTable($tableau)
            {
                $i = 0;
                foreach ($tableau as $item => $value) {
                    echo "<p>à la ligne n°$i correspond à la clé '$item' et contient '$value'</p>";
                    $i++;
                }
            }

            ?>

        </section>
    </div>
</div>

</body>
<footer>
    <?php include "./includes/footer.inc.html"; ?>
</footer>
</html>