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
<div class="container">
    <div class="row">
        <nav class="col-sm-4 col-lg-3 m-2">
            <a href="index.php">
                <button type="button" class="btn btn-outline-secondary col-12">Home</button>
            </a>
            <?php
            //Vérification d'une session vide pour affichage de l'ul
            if(!empty($_SESSION['table'])) {
                include "./includes/ul.inc.html";
                $table = $_SESSION['table'];
            }
            //Sécurité
            if (empty($_SESSION['table']) && (isset($_GET['del']) || isset($_GET['debugging']) || isset($_GET['concatenation']) || isset($_GET['loop']) ||          isset($_GET['function']))) {
                header("Location:index.php");
            }
            ?>
        </nav>
        <section class="m-2 col-sm-4 col-lg-8">

            <?php
            //Si on est sur add on affiche le formulaire
            if (isset($_GET['add'])) {
                include "./includes/form.inc.html";
                //Si on clique sur enregistrer
            } else if (isset($_POST['enregistrer'])) {
                //Déclaration des variables
                $prenom = htmlentities($_POST['prenom']);
                $nom = htmlentities($_POST['nom']);
                $age = htmlentities($_POST['age']);
                $taille = htmlentities($_POST['taille']);
                $radio = htmlentities($_POST['radio']);

                $table = array(
                    'first_name' => $prenom,
                    'last_name' => $nom,
                    'age' => $age,
                    'size' => $taille,
                    'situation' => $radio
                );
                //Attribution de la session
                $_SESSION['table'] = $table;
                //Echo du msg
                if (isset($_SESSION['table'])) {
                    echo "<h1>Données enregistrées</h1>";
                }
            } else if (isset($_GET['del'])) {
                //Suppresion de la session table
                unset($_SESSION['table']);
                //Vérification si la session est vide pour afficher le msg
                if (empty($_SESSION['table'])) {
                    echo "<h1>Les données ont bien été supprimées</h1>";
                }

            } else if (isset($_GET['debugging'])) {
                //Affichage du tableau
                echo "<h1>Débogage</h1>";
                echo "<p>===> Lecture du tableau à l'aide de la fonction print_r()</p>";
                print "<pre>";
                print_r($table);
                print "</pre>";
            } else if (isset($_GET['concatenation'])) {

                echo "<h1>Concaténation</h1><br>";

                //Concaténation sans modifs
                echo "<p>===> Construction d'une phrase avec le contenu du tableau :</p>";
                echo "<h2>".$table["first_name"]." ".$table["last_name"]. "</h2>";
                echo "<p>".$table["age"]." ans, je mesure ".$table["size"]."m et je fais partie des ".$table["situation"]."s de la promo Simplon</p><br>";

                //MAJ Du tableau
                $table['first_name'] = ucfirst($table['first_name']);
                $table['last_name'] = strtoupper($table['last_name']);
                echo "<p>===> Construction d'une phrase après MAJ du tableau :</p>";
                echo "<h2>".$table["first_name"]." ".$table["last_name"]."</h2>";
                echo "<p>".$table["age"]." ans, je mesure ".$table["size"]."m et je fais partie des ".$table["situation"]."s de la promo Simplon</p><br>";

                //Remplacement du point par la virgule
                echo "<p>===> Affichage d'une virgule à la place du point pour la taille :</p>";
                echo "<h2>".$table["first_name"]." ".$table["last_name"]."</h2>";
                echo "<p>".$table["age"]." ans, je mesure " . str_replace('.', ',', $table['size']) . "m et je fais partie des". $table['situation']                ."s de la promo Simplon</p>";

            } else if (isset($_GET['loop'])) {

                echo "<h1>Boucle</h1><br>";
                echo "===> Lecture du tableau à l'aide d'une boucle foreach<br><br>";
                //Déclaration d'un compteur
                $i = 0;

                //Pour chaque élements du tableau
                foreach ($table as $item => $value) {
                    //Affichage
                    echo '<div>à la ligne n°'.$i.' correspond à la clé "'.$item.'" et contient "'.$value.'"</div>';
                    $i++;
                }
            } else if (isset($_GET['function'])) {

                echo "<h1>Fonction</h1><br>";
                echo "===> J'utilise ma fonction readTable()<br><br>";
                //Appel de la fonction readTable avec affichage.
                readTable($table);
            } else {
                //Sinon affichage du bouton d'ajout des données.
                echo "
                <a href='index.php?add' class='btn btn-primary px-2'>Ajouter des données</a>
                ";
            }
            /**
             * @param $tableau
             */
            function readTable($tableau)
            {
                //Compteur
                $i = 0;
                //Pour chaque éléments du tableau
                foreach ($tableau as $item => $value) {
                    //affichage de la ligne du tableau
                    echo '<div>à la ligne n°'.$i.' correspond à la clé "'.$item.'" et contient "'.$value.'"</div>';
                    $i++;//incrémentation
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