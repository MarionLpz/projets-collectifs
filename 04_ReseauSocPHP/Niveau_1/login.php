<?php
session_start();
?>
<?php include("headerFull.php"); ?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>MySafePLace - Connexion</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <div id="wrapper">
        <aside>
            <h2>Hello ! 👋 </h2>
            <p>Bienvenue sur My Safe Place, ton réseau social bienveillant et inclusif.</p>
        </aside>
        <main class="debord_gauche">
            <article>
                <h2>Connexion</h2>
                <?php
                /**
                 * TRAITEMENT DU FORMULAIRE
                 */
                // Vérifier si on est en train d'afficher ou de traiter le formulaire
                $enCoursDeTraitement = isset($_POST['email']);
                if ($enCoursDeTraitement) {
                    // Récupérer ce qu'il y a dans le formulaire 
                    $emailAVerifier = $_POST['email'];
                    $passwdAVerifier = $_POST['motpasse'];


                    //Ouvrir une connexion avec la base de donnée.
                    include("BDconnection.php");
                    $emailAVerifier = $mysqli->real_escape_string($emailAVerifier);
                    $passwdAVerifier = $mysqli->real_escape_string($passwdAVerifier);
                    // on crypte le mot de passe (attention faible sécurité ici) pour éviter d'exposer notre utilisatrice en cas d'intrusion dans nos systèmes
                    $passwdAVerifier = md5($passwdAVerifier);
                    //Construction de la requete
                    $lInstructionSql = "SELECT * "
                        . "FROM users "
                        . "WHERE "
                        . "email LIKE '" . $emailAVerifier . "'";
                    // Vérification de l'utilisateur
                    $res = $mysqli->query($lInstructionSql);
                    $user = $res->fetch_assoc();
                    if (!$user or $user["password"] != $passwdAVerifier) {
                        echo "La connexion a échouée. ";
                    } else {
                        echo "Votre connexion est un succès : " . $user['alias'] . ".";
                        // Se souvenir que l'utilisateur s'est connecté pour la suite
                        $_SESSION['connected_id'] = $user['id'];
                        // Redirection vers news page
                        header("Location: news.php");
                        exit;

                    }
                }

                ?>
                <form action="login.php" method="post">
                    <dl>
                        <dt><label for='email'>E-Mail</label></dt>
                        <dd><input type='email' name='email' class="button_log"></dd>
                        <dt><label for='motpasse'>Mot de passe</label></dt>
                        <dd><input type='password' name='motpasse' class="button_log"></dd>
                    </dl>
                    <input type='submit' value="Envoyer" class="button_settings" />
                </form>
                <p>
                    Pas de compte?
                    <a href='registration.php'>Inscrivez-vous.</a>
                </p>

            </article>
        </main>
    </div>
</body>

</html>