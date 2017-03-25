<?php
    if(!$auth){
        header("Location: ?page=login&redir=mypage");
        return;
    }
    $name = $_SESSION["user"];
    $userid = $_SESSION["userid"];
    $admin = $_SESSION["admin"];

    if($admin){
    ?>
        <h1> Congrats </h1>
    <?php
    } else {
        commentField($conn, $userid, "Your comments:", '<p style="padding:20px;font-size:20px;">You may now leave comments on <a href="?page=attractions">attractions</a>!</p>');
    }
?>

<?php

function commentField($conn, $userid, $header, $emptymsg){
    $comment_query = $conn->query("SELECT tips.tipid, attractions.name, UNIX_TIMESTAMP(tips.timestamp), tips.content, tips.title FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tips` WHERE attractions.attractionid=tips.attractionid AND tips.userid=".$userid." ORDER BY tips.timestamp DESC;");

    if(!$comment_query){
        echo $conn->error;
        return;
    }

    $comments = [];
    while($row = $comment_query->fetch_assoc()){
        $comments[] = $row;
    }

    echo '<div id="comments">';
        if($comment_query->num_rows == 0){
            echo $emptymsg;
        } else {
            echo "<h1>$header</h1>";
        }

        foreach($comments as $comment){
            ?>
                <div class="comment">
                    <h3> <?php echo($comment['title']) ?></h3>
                    <h4><?php echo $comment["name"].' - '.date('d/m/Y', $comment["UNIX_TIMESTAMP(tips.timestamp)"]); ?></h4>
                    <p>
                        <?php echo($comment["content"]);?>
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
