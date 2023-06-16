<br>
<hr>
<br>

<form action="wall.php?user_id=<?php echo $userId; ?>" method="post">
<input type="submit" name = "unsubscribe" value="Se désabonner" class="button_settings">
</form>

<?php

// Etape 1 : Vérifier si l'utilisateur a cliqué sur le bouton de désabonnement
if (isset($_POST['unsubscribe'])) {
    

    // Etape 2 : Récupérer l'ID de l'utilisateur à désabonner
    $userIdToUnfollow = $_POST['user_id'];

    // Etape 3 : Effectuer la requête pour supprimer l'abonnement
    $sqlUnfollow = "DELETE FROM followers 
    WHERE followed_user_id = " 
    . $userId
    . " AND following_user_id = " 
    . $_SESSION['connected_id'] . ";";
    
    $unfollowResult = $mysqli->query($sqlUnfollow);

    if (!$unfollowResult) {
        echo "Oups, impossible de se désabonner.";
    } else {
        header("Refresh:0");
    }
}
?>
