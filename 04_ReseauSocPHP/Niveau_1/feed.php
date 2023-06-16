<?php
session_start();
// Vérifie si l'utilisateur n'est pas connecté (par exemple, en vérifiant la présence d'une variable de session)
if (!isset($_SESSION['connected_id'])) {
    header("Location: login.php"); // Redirige vers la page de connexion
    exit(); // Arrête l'exécution du reste du code
}

?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>MySafePLace - Flux</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php include("header.php"); ?>

    <div id="wrapper">
        <?php
        $userId = intval($_GET['user_id']);
        ?>
        <?php
        /**
         * Se connecter à la base de donnée
         */
        include("BDconnection.php");
        ?>
        <aside>
            <?php
            /**
             * Récupérer le nom de l'utilisateur
             */
            $laQuestionEnSql = "SELECT * FROM `users` WHERE id= '$userId' ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            $user = $lesInformations->fetch_assoc();
            //echo "<pre>" . print_r($user, 1) . "</pre>";
            ?>
            <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
            <section>
                <h3>🌸 Ta safe commu 🌸</h3>
                <p><?php echo $user['alias'] ?>, ici tu n'es qu'entre ami.e.s !</p>
                <p>C'est sur cette page que tu retrouves les posts des personnes que tu suis.</p>
            </section>
        </aside>
        <main class="debord_gauche">
            <?php
            include("mainSQLrequest.php");
            ?>
            <?php
            while ($post = $lesInformations->fetch_assoc()) {
                include "articles.php";
            }
            ?>
        </main>
    </div>
</body>

</html>