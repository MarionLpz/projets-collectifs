<?php
session_start();
?>

<?php include("header.php"); ?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>MySafePlace - Les messages par mot-clé</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css"/>
</head>

<div id="wrapper">
    <?php
    if (isset($_GET['id'])) {
        $tagId = intval($_GET['id']);
    }

    include("BDconnection.php");
    ?>

    <aside>

    <?php
    $laQuestionEnSql = "SELECT * FROM tags";
    $lesInformations = $mysqli->query($laQuestionEnSql);
    if (!$lesInformations) {
        echo("Échec de la requête : " . $mysqli->error);
    }
    ?>
    <img src="user.jpg" alt="Portrait de l'utilisatrice"/>

    <section>
        <h3>Mots-clés</h3>
        <?php
        $tagList = "";
        while ($tag = $lesInformations->fetch_assoc()) {
            $tagList .= '<a href="tags.php?id=' . $tag["id"] . '">'.'#'. $tag["label"] . '</a> ';
        }
        echo $tagList;
        ?>
    </section>


    
        <?php if (isset($tagId)):
            $laQuestionEnSql = "SELECT * FROM tags WHERE id = '$tagId'";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            $tag = $lesInformations->fetch_assoc();
            ?>
            <div class="initial-avatar">...</div>

            <section>
    <h3>Mes Safes Keys #</h3>
    <p>Sur cette page, vous trouverez les derniers messages comportant le mot-clé <strong><?php echo $tag["label"] ?></strong></p>
</section>

        <?php endif; ?>

    </aside>
    <main class="debord_gauche">
        <?php
        if (isset($tagId)) {
            $laQuestionEnSql = "
                    SELECT posts.content,
                    users.id as author_id,
                    posts.created,
                    users.alias as author_name,
                    count(likes.id) as like_number,
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist, GROUP_CONCAT(DISTINCT tags.id) AS tagId
                    FROM posts_tags as filter 
                    JOIN posts ON posts.id=filter.post_id
                    JOIN users ON users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id
                    LEFT JOIN likes      ON likes.post_id  = posts.id
                    WHERE filter.tag_id = '$tagId'
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            if (!$lesInformations) {
                echo ("Échec de la requête : " . $mysqli->error);
            }

            /**
             * Parcourir les messages et remplir correctement le HTML avec les bonnes valeurs php
             */
            while ($post = $lesInformations->fetch_assoc()) {
                include "articles.php";
            }
        }
        ?>

    </main>
</div>
</body>
</html>
