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
    <title>MySafePLace - Paramètres</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <div id="wrapper" class='profile'>


        <aside>
            <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
            <section>
                <h3>🛠️ Tes paramètres 🛠️</h3>
                <p>Sur cette page tu trouveras toutes tes informations personnelles - que nous ne vendons pas au plus offrant comme Facebook 😇.</p>
                <br>
                <form action="settings.php?user_id=<?php echo $_SESSION['connected_id']; ?>" method="post">
                <input class="button_settings" type="submit" name = 'followers' value="Mes followers">
                </form>
                <form action="settings.php?user_id=<?php echo $_SESSION['connected_id']; ?>" method="post">
                <input class="button_settings" type="submit" name = 'subscribe' value="Mes abonnements">
                </form>
                <form action="login.php?user_id=<?php echo $_SESSION['connected_id']; ?>" method="post">
                <input class="button_settings" type="submit" name = 'disconnect' value="Me déconnecter">
                </form>
            </section>
        </aside>
        <main class="debord_gauche">
            <?php
            $userId = intval($_SESSION['connected_id']);

            include("BDconnection.php");

            $laQuestionEnSql = "
                    SELECT users.*, 
                    count(DISTINCT posts.id) as totalpost, 
                    count(DISTINCT given.post_id) as totalgiven, 
                    count(DISTINCT recieved.user_id) as totalrecieved 
                    FROM users 
                    LEFT JOIN posts ON posts.user_id=users.id 
                    LEFT JOIN likes as given ON given.user_id=users.id 
                    LEFT JOIN likes as recieved ON recieved.post_id=posts.id 
                    WHERE users.id = '$userId' 
                    GROUP BY users.id
                    ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            if (!$lesInformations) {
                echo ("Échec de la requete : " . $mysqli->error);
            }
            $user = $lesInformations->fetch_assoc();

            ?>
            <article class='parameters'>
                <h3>Mes paramètres</h3>
                <dl>
                    <dt>Pseudo</dt>
                    <dd><?php echo $user['alias'] ?></dd>
                    <dt>Email</dt>
                    <dd><?php echo $user['email'] ?></dd>
                    <dt>Nombre de message</dt>
                    <dd><?php echo $user['totalpost'] ?></dd>
                    <dt>Nombre de "J'aime" donnés </dt>
                    <dd><?php echo $user['totalgiven'] ?></dd>
                    <dt>Nombre de "J'aime" reçus</dt>
                    <dd><?php echo $user['totalrecieved'] ?></dd>
                </dl>
            </article>

            <main class='contacts'>

            <?php if(isset($_POST['followers'])){
 
            // Récupérer l'id de l'utilisateur
            $userId = intval($_SESSION['connected_id']);
            // Se connecter à la base de donnée
            include("BDconnection.php");
            // Récupérer le nom de l'utilisateur
            $laQuestionEnSql = "
                    SELECT users.*
                    FROM followers
                    LEFT JOIN users ON users.id=followers.following_user_id
                    WHERE followers.followed_user_id='$userId'
                    GROUP BY users.id
                    ";
            $lesInformations = $mysqli->query($laQuestionEnSql);

            while ($userId = $lesInformations->fetch_assoc()) { ?>
                <article class='contacts'>
                    <img src="user.jpg" alt="blason" />
                    <h3><?php echo $userId["alias"] ?></h3>
                    <!-- <p><?php echo $userId["id"] ?></p> -->
                </article>
            <?php
            } ?>
            <?php
            }
            ?>

            <!-- Si on clique sur le boutton mes abonnements -->
            <?php if(isset($_POST['subscribe'])){
                // Etape 1: récupérer l'id de l'utilisateur
                $userId = intval($_SESSION['connected_id']);
                // Etape 2: se connecter à la base de donnée
                include("BDconnection.php");
                // Etape 3: récupérer le nom de l'utilisateur
                $laQuestionEnSql = "
                    SELECT users.* 
                    FROM followers 
                    LEFT JOIN users ON users.id=followers.followed_user_id 
                    WHERE followers.following_user_id='$userId'
                    GROUP BY users.id
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                
                while ($user = $lesInformations->fetch_assoc())
                {?>
                    <article class='contacts'>
                    <img src="user.jpg" alt="blason"/>
                    <h3><?php echo $user["alias"]?></h3>
                    <!-- <p><?php echo $user["id"]?></p>  -->                   
                </article>
                <?php
                } 
            }?>
        </main>
        </main>
    </div>
</body>

</html>