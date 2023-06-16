<?php
session_start();
if (!isset($_SESSION['connected_id'])) {
    header("Location: login.php"); 
    exit();
}

?>

<?php include("header.php"); ?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>MySafePLace - Actualités</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css" />
    <div id="wrapper">
        <?php include("BDconnection.php");?>
        <aside>
        <?php
            $userId = intval($_SESSION['connected_id']);
            $laQuestionEnSql = "SELECT * FROM `users` WHERE id= '$userId' ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            $user = $lesInformations->fetch_assoc();

?>
            <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
            <section>
                <h3>⚡️ My safe news ⚡️</h3>
                <p>C'est ici que tu retrouveras les safes news.</p>
                <p>Tu y trouveras les messages de tout.e.s les utilisateurs.rices de notre réseau social. </p>
                <p>Bienveillance et respect sont nos maîtres-mots ! 🌈 </p>
                <p>Inspire-toi, réagis et partage tes idées à la commu !</p>
            </section>
        </aside>
        <main class="debord_gauche">
            <?php
            if ($mysqli->connect_errno) {
                echo "<article>";
                echo ("Échec de la connexion : " . $mysqli->connect_error);
                echo ("<p>Indice: Vérifiez les parametres de <code>new mysqli(...</code></p>");
                echo "</article>";
                exit();
            }

            $laQuestionEnSql = "
    SELECT posts.id, posts.content,
    users.id as author_id,
    posts.created,
    users.alias as author_name,  
    count(likes.id) as like_number,  
    GROUP_CONCAT(DISTINCT tags.label) AS taglist, GROUP_CONCAT(DISTINCT tags.id) AS tagId
    FROM posts
    JOIN users ON  users.id=posts.user_id
    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
    LEFT JOIN likes      ON likes.post_id  = posts.id 
    GROUP BY posts.id
    ORDER BY posts.created DESC  
    LIMIT 10
";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            if (!$lesInformations) {
                echo "<article>";
                echo ("Échec de la requete : " . $mysqli->error);
                echo ("<p>Indice: Vérifiez la requete  SQL suivante dans phpmyadmin<code>$laQuestionEnSql</code></p>");
                exit();
            }

            while ($post = $lesInformations->fetch_assoc()) {
                include "articles.php";
            }
            ?>

        </main>
    </div>
    </body>

</html>