<?php
session_start();
// Vérifie si l'utilisateur n'est pas connecté (par exemple, en vérifiant la présence d'une variable de session)
if (!isset($_SESSION['connected_id'])) {
    header("Location: login.php"); // Redirige vers la page de connexion
    exit(); // Arrête l'exécution du reste du code
}

?>

<?php include("header.php"); ?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>MySafePLace - Mes abonnés </title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div id="wrapper">
        <aside>
            <!-- <div class="initial-avatar">AVAT</div> -->
            <img src = "user.jpg" alt = "Portrait de l'utilisatrice"/>
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez la liste des personnes qui
                    suivent les messages de l'utilisatrice
                    n° <?php echo intval($_SESSION['connected_id']) ?></p>

            </section>
        </aside>
        <main class='contacts'>
            <?php
            // Etape 1: récupérer l'id de l'utilisateur
            $userId = intval($_SESSION['connected_id']);
            // Etape 2: se connecter à la base de donnée
            include("BDconnection.php");
            // Etape 3: récupérer le nom de l'utilisateur
            $laQuestionEnSql = "
                    SELECT users.*
                    FROM followers
                    LEFT JOIN users ON users.id=followers.following_user_id
                    WHERE followers.followed_user_id='$userId'
                    GROUP BY users.id
                    ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            // Etape 4: à vous de jouer
            //@todo: faire la boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous 

            while ($userId = $lesInformations->fetch_assoc()) { ?>
                <article>
                    <img src="user.jpg" alt="blason" />
                    <h3><?php echo $userId["alias"] ?></h3>
                    <p><?php echo $userId["id"] ?></p>
                </article>
            <?php
            } ?>
        </main>
    </div>
</body>

</html>