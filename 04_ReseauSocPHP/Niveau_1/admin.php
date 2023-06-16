<?php
session_start();
?>

<?php include("header.php");
        /**
         * Ouvrir une connexion avec la base de donnée.
         */
        include("BDconnection.php");
        //verification
        if ($mysqli->connect_errno)
        {
            echo("Échec de la connexion : " . $mysqli->connect_error);
            exit();
        }
        ?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>MySafePlace - Administration</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
          
        <div id="wrapper" class='admin'>
            <aside>
                <h2>Mots-clés</h2>
                <?php
                /*
                 * Trouver tous les mots clés
                 */
                $laQuestionEnSql = "SELECT * FROM `tags` LIMIT 50";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                // Vérification
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                    exit();
                }

                /*
                 * Afficher les mots clés
                 */
                while ($tag = $lesInformations->fetch_assoc())
                {
                    // echo "<pre>" . print_r($tag, 1) . "</pre>";
                    // ?>
                    <article>
                        <p><b><?php echo "Tag : " .$tag['label'] ?></b></p>
                        <br>
                        <p><?php echo "#" .$tag['id'] ?></p>
                        <nav><br>
                        <a href="tags.php?id=<?php echo $tag['id']; ?>">Voir les posts associés</a>
                        </nav>
                    </article>
                <?php } ?>
            </aside>
            <main class="debord_gauche">
                <h2>Nos safe members</h2>
                <?php
                /*
                 * Trouver tous les mots clés
                 */
                $laQuestionEnSql = "SELECT * FROM `users` LIMIT 50";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                // Vérification
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                    exit();
                }

                /*
                 * Afficher les utilisateurs-rices en s'inspirant de ce qui a été fait dans news.php
                 */
                while ($tag = $lesInformations->fetch_assoc())
                {
                    // echo "<pre>" . print_r($tag, 1) . "</pre>";
                    ?>
                    <article>
                        <h3><b>Pseudo : <?php echo $tag['alias'] ?></b></h3>
                        <p><?php echo "Identifiant : " .$tag['id'] ?></p>
                        <nav>
                            <br></br>
                            <a href="wall.php?user_id=<?php echo $tag['id']; ?>">Mur</a>
                            | <a href="feed.php?user_id=<?php echo $tag['id']; ?>">Flux</a>
                            | <a href="settings.php?user_id=<?php echo $tag['id']; ?>">Paramètres</a>
                            | <a href="followers.php?user_id=<?php echo $tag['id']; ?>">Mes followers</a>
                            | <a href="subscriptions.php?user_id=<?php echo $tag['id']; ?>">Mes abonnements</a>
                        </nav>
                    </article>
                <?php } ?>
            </main>
        </div>
    </body>
</html>