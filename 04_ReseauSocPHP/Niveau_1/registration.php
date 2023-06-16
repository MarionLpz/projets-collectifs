<?php include("headerFull.php"); ?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>MySafePLace - Inscription</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css" />
</head>

<body>


    <div id="wrapper">

        <aside>
            <h2>Hello ! 👋 </h2>
            <p>Bienvenue sur My Safe Place, ton réseau social bienveillant et inclusif.</p>
            <p>Tu as déjà un compte ? <a href="login.php">Se connecter</a></p>
        </aside>
        <main class="debord_gauche">
            <article>
                <h2>Inscription</h2>
                <?php
                $enCoursDeTraitement = isset($_POST['email']);
                if ($enCoursDeTraitement) {
                    $new_email = $_POST['email'];
                    $new_alias = $_POST['pseudo'];
                    $new_passwd = $_POST['motpasse'];


                    include("BDconnection.php");
                    $new_email = $mysqli->real_escape_string($new_email);
                    $new_alias = $mysqli->real_escape_string($new_alias);
                    $new_passwd = $mysqli->real_escape_string($new_passwd);
                    // on crypte le mot de passe pour éviter d'exposer notre utilisatrice en cas d'intrusion dans nos systèmes
                    $new_passwd = md5($new_passwd);
                    // NB: md5 est pédagogique mais n'est pas recommandée pour une vraies sécurité
                    //Construction de la requete
                    $lInstructionSql = "INSERT INTO users (id, email, password, alias) "
                        . "VALUES (NULL, "
                        . "'" . $new_email . "', "
                        . "'" . $new_passwd . "', "
                        . "'" . $new_alias . "'"
                        . ");";
                    // Exécution de la requete
                    $ok = $mysqli->query($lInstructionSql);
                    if (!$ok) {
                        echo "L'inscription a échouée : " . $mysqli->error;
                    } else {
                        echo "Votre inscription est un succès. Bienvenue " . $new_alias . " !";
                        echo " <a href='login.php'>Connectez-vous.</a>";
                    }
                }
                ?>
                <form action="registration.php" method="post">
                    <input type='hidden' name='id' value=''>
                    <dl>
                        <dt><label for='pseudo'>Pseudo</label></dt>
                        <dd><input type='text' name='pseudo' class="button_log"></dd>
                        <dt><label for='email'>E-Mail</label></dt>
                        <dd><input type='email' name='email' class="button_log" ></dd>
                        <dt><label for='motpasse'>Mot de passe</label></dt>
                        <dd><input type='password' name='motpasse' class="button_log" ></dd>
                    </dl>
                    <input type='submit' value="Envoyer" class="button_settings"/>
                </form>
            </article>
        </main>
    </div>
</body>

</html>