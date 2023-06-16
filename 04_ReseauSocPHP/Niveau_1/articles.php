<article>
    <h3>
        <time><?php echo $post['created'];?></time>
    </h3>
    <address><a href="wall.php?user_id=<?php echo $post["author_id"]; ?>"><?php echo $post["author_name"];?></a></address>            
    <div>

    <p><?php echo $post["content"];?></p>
    </div>                                            
    <footer>
    <small> ⭐️ <?php echo $post["like_number"]?> 
    <?php 
        $currentPost = $post["id"];
        if($_POST["post_id"] == $currentPost && isset($_POST['like'])) {
            $sqlQueryLikes = "INSERT INTO likes (user_id, post_id) VALUES ('$userId', '$currentPost');";
            $sqlLikesResult = $mysqli->query($sqlQueryLikes);

            if (! $sqlLikesResult){
                echo("Echec");
            }else{
                header("Refresh:0");
            }
        }

        if($_POST["post_id"] == $currentPost && isset($_POST['dislike'])) {
            $sqlQueryDislikes = "DELETE FROM likes WHERE user_id = '$userId' AND post_id = '$currentPost';";
            $sqlDislikesResult = $mysqli->query($sqlQueryDislikes);

            if (! $sqlDislikesResult){
                echo("Echec");
            }else{
                header("Refresh:0");
            }
        }
    ?>
    <form method="post" style="display: inline;">
        <input type="hidden" name="post_id" value="<?php echo $post["id"]; ?>"/>
        <?php
        $sqlQueryDidLike = "SELECT COUNT(*) FROM likes WHERE post_id = '$currentPost' AND user_id = '$userId';";
        $sqlQueryDidLikeResult = $mysqli->query($sqlQueryDidLike);
        $row = $sqlQueryDidLikeResult->fetch_row();
        $hasLikedPost = $row[0] >= 1;

        if ($hasLikedPost) {
            echo "<button type='submit' name='dislike' class='button_settings_like'>Not safe</button>";
        } else {
            echo "<button type='submit' name='like' class='button_settings_like'>Safe</button>";
        }
        ?>
    </form>
    </small>
    <a href="tags.php?id=<?php echo $post["tagId"]; ?>"><?php echo "#" .$post['taglist'];?></a>        
    </footer>
    </article>

    