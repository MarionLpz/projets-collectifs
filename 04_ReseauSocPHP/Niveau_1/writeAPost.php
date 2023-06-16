<article>
    <br>
    <hr size="2px" color="#fe66c3">
    <h3>💭 Poster un message 💭</h3>
    <?php
    include("BDconnection.php");
    /**
     * Récupération de la liste des tags
     */
    $listTags = [];
    $laQuestionEnSql = "SELECT * FROM tags";
    $lesInformations = $mysqli->query($laQuestionEnSql);
    while ($tags = $lesInformations->fetch_assoc())
    {
        $listTags[$tags['id']] = $tags['label'];
    }


    /**
     * TRAITEMENT DU FORMULAIRE
     */
    // Vérifier si on est en train d'afficher ou de traiter le formulaire
    $enCoursDeTraitement = isset($_POST['auteur']);
    if ($enCoursDeTraitement)
    {
        // Récupérer ce qu'il y a dans le formulaire 
        $authorId = $_POST['auteur'];
        $postContent = $_POST['message'];
        $tagId = $_POST['tags'];

        $authorId = intval($mysqli->real_escape_string($authorId));
        $postContent = $mysqli->real_escape_string($postContent);

        // Construction de la requête pour insérer le nouveau post
        $insertPostQuery = "INSERT INTO posts (user_id, content, created) VALUES ('$authorId', '$postContent', NOW())";
        $mysqli->query($insertPostQuery);

        // Récupérer l'id du nouveau post
        $postId = $mysqli->insert_id;

        //Insérer l'association entre le post et le tag dans la table posts_tags
        $insertPostTagQuery = "INSERT INTO posts_tags (post_id, tag_id) VALUES ('$postId', '$tagId')";
        $mysqli->query($insertPostTagQuery);

        echo "Message posté";
    }
    ?>
    <form action="wall.php?user_id=<?php echo $_GET['user_id']; ?>" method="post">
        <input type='hidden' name='auteur' value='<?php echo $_SESSION["connected_id"]; ?>'>

        <dl>
            <dd><textarea name='message' minlength="1"></textarea></dd>
            <br>
            <dd>
                <select name="tags">
                    <?php
                    foreach ($listTags as $id => $label) {
                        echo "<option value='$id'>$label</option>";
                    }
                    ?>
                </select>
            </dd>

        </dl>
        <input type='submit' value="Je partage !" class="button_settings">
    </form>
</article>
