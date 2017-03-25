<?php
    if(!$auth){
        header("Location: ?page=login&redir=mypage");
        return;
    }
    $name = $_SESSION["user"];
    $userid = $_SESSION["userid"];
    $admin = $_SESSION["admin"];

    if(isset($_GET["userid"])){
        if($admin){
            userpage($conn, $_GET["userid"]);
        } else {
            header("Location: /?page=mypage");
        }
    } else {
        if($admin){
            ?>
            <div id="users">
                <h1> These are all the users: </h1>
                <?php
                $user_query = $conn->query("SELECT users.userid, users.username, users.privilege FROM `mitt-feriested`.`users`");

                $users = [];
                while($row = $user_query->fetch_assoc()){
                    $users[] = $row;
                }

                foreach($users as $user){
                    echo "<a href='?page=mypage&userid=".$user["userid"]."'> ".$user["username"].($user['privilege'] == 'admin' ? " [admin]" : "")."</a><br>";
                }

                ?>
            </div>
            <?php
        }

        commentField($conn, $userid, "Your comments:", '<p style="padding:20px;font-size:20px;">You may leave comments on <a href="?page=attractions">attractions</a>!</p>', false);

        if($admin){
            commentField($conn, 0, "<div style='margin-top:40px'></div>All comments:", '<p style="padding:20px;font-size:20px;">There aren\'t any comments yet!</p>', true);
        }
    }
?>

<?php

function commentField($conn, $userid, $header, $emptymsg, $allcomments){
    if($allcomments){
        $comment_sql = "SELECT tips.tipid, attractions.attractionid, attractions.name, UNIX_TIMESTAMP(tips.timestamp), tips.content, tips.title, users.username, users.privilege, users.userid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tips`, `mitt-feriested`.`users` WHERE attractions.attractionid=tips.attractionid AND users.userid=tips.userid ORDER BY tips.timestamp DESC;";
    } else {
        $comment_sql = "SELECT tips.tipid, attractions.attractionid, attractions.name, UNIX_TIMESTAMP(tips.timestamp), tips.content, tips.title FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tips` WHERE attractions.attractionid=tips.attractionid AND tips.userid=".$userid." ORDER BY tips.timestamp DESC;";
    }

    $comment_query = $conn->query($comment_sql);

    if(!$comment_query){
        echo $conn->error;
        return;
    }

    $comments = [];
    while($row = $comment_query->fetch_assoc()){
        $comments[] = $row;
    }

    echo '<div class="comments">';
        if($comment_query->num_rows == 0){
            echo $emptymsg;
        } else {
            echo "<h1>$header</h1>";
        }

        foreach($comments as $comment){
            ?>
                <div class="comment">
                    <h3> <a href='/?page=attractions&a=<?php echo $comment["attractionid"];?>#comment<?php echo $comment["tipid"];?>'><?php echo($comment['title']) ?></a></h3>
                    <?php
                    if($allcomments){
                        $userlink = "<a href='?page=mypage&userid=".$comment["userid"]."'> ".$comment["username"].($comment['privilege'] == 'admin' ? " [admin]" : "")."</a>";
                        echo "<h4>".$comment["name"].' - '.$userlink.' - '.date('d/m/Y', $comment["UNIX_TIMESTAMP(tips.timestamp)"])."</h4>";
                    } else {
                        echo "<h4>".$comment["name"].' - '.date('d/m/Y', $comment["UNIX_TIMESTAMP(tips.timestamp)"])."</h4>";
                    }
                    ?>
                    <p>
                        <?php echo(nl2br($comment["content"]));?>
                    </p>
                </div>

                <a  class="deletecomment" tipid="<?php echo $comment["tipid"];?>">
                    <div>
                        Click here to delete this comment
                    </div>
                </a>
            <?php
        }
    echo '</div>';
}
?>

<?php

function userpage($conn, $userid){
    $userq = $conn->query("SELECT users.privilege, users.username FROM `mitt-feriested`.`users` WHERE userid=$userid")->fetch_assoc();
    $isadmin = $userq["privilege"] == "admin";

    ?>
        <script>
            $(".contentBody header h1").html("<?php echo $userq["username"];?>");
        </script>
    <?php

    echo "<div id='users'>";
        echo "<a href='#' id='ban' userid='$userid'>Ban this user</a><br>";
        if($isadmin){
            echo "<a href='#' id='regrade' userid='$userid' npriv='user'>Demote this admin to only a user</a>";
        } else {
            echo "<a href='#' id='regrade' userid='$userid' npriv='admin'>Promote this user to admin</a>";
        }
    echo "</div>";
    commentField($conn, $userid, "User comments:", '<p style="padding:20px;font-size:20px;">This user has no comments</a>', false);
}

?>
