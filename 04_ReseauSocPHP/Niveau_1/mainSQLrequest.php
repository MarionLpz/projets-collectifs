<?php
$laQuestionEnSql = "
                    SELECT posts.content,
                    posts.id,
                    posts.created,
                    users.alias as author_name, 
                    users.id as author_id,
                    count(likes.id) as like_number,  
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist, GROUP_CONCAT(DISTINCT tags.id) AS tagId
                    FROM followers 
                    JOIN users ON users.id=followers.followed_user_id
                    JOIN posts ON posts.user_id=users.id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE followers.following_user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                }
                ?>     