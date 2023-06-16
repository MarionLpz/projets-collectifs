<?php
session_start();
?>
<?php include("header.php"); ?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>MySafePLace - Mur</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>

    
    
        <div id="wrapper">
            <?php
            $userId =intval($_GET['user_id']);
            ?>
            <?php
            include("BDconnection.php");
            ?>

            <aside>
                <?php
                $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $user = $lesInformations->fetch_assoc();
                ?>
                <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>✨ Ta safe place ✨</h3>
                    <p>Ici, c'est chez toi <?php echo $user['alias'] ?> !</p>
                    <p>Sur cette page, tu peux poster ton mood et tes envies, dans la bienveillance et le partager à ta communauté !</p>
                
                <?php if ($userId == $_SESSION['connected_id']) {
                include("WriteAPost.php"); 
                }else{

                    $IsSubscribedQuery = "SELECT * FROM followers WHERE followed_user_id = " 
                    . $userId
                    . " AND following_user_id = " 
                    . $_SESSION['connected_id'] . ";";

                    $isSubscribedResult = $mysqli -> query($IsSubscribedQuery);

                    if ($isSubscribedResult->num_rows > 0){

                        // Afficher le formulaire de désabonnement
                        include("formDesabonnement.php");
                    } else {
                    // Afficher le formulaire d'abonnement
                        include("formAbonnement.php");
                    }
                }
                ?>

                </section>
            </aside>
            <main class="debord_gauche">
                <?php
                $laQuestionEnSql = "
                    SELECT posts.id, posts.content, posts.created, users.alias as author_name, 
                    users.id as author_id,
                    COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist, GROUP_CONCAT(DISTINCT tags.id) AS tagId
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE posts.user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                } 

                while ($post = $lesInformations->fetch_assoc())
                {

                    include "articles.php";

} ?>


            </main>
        </div>
    </body>
</html>
