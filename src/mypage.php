<?php
    if(!$auth){
        header("Location: ?page=login&redir=mypage");
        return;
    }
    $name = $_SESSION["user"];
    $userid = $_SESSION["userid"];
    $admin = $_SESSION["admin"];
?>
<br>
<h1>Your comments:</h1>
<br>
<?php
$comment_query = $conn->query("SELECT tips.tipid, attractions.name, UNIX_TIMESTAMP(tips.timestamp), tips.content, tips.title FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tips` WHERE attractions.attractionid=tips.attractionid AND tips.userid=".$userid." ORDER BY tips.timestamp DESC;");

        if(!$comment_query){
            echo $conn->error;
            return;
        }

        $comments = [];
        while($row = $comment_query->fetch_assoc()){
            $comments[] = $row;
        }

        foreach($comments as $comment){
            ?>
                <br><h3> <?php echo($comment['title']." - ".$comment["name"].' (posted '.date('d/m/Y', $comment["UNIX_TIMESTAMP(tips.timestamp)"]).")"); ?></h3>
                <p>
                    <?php echo($comment["content"]);?>
                </p>
                <p><a class="deletecomment" href="/api?type=deletecomment&tipid=<?php echo $comment["tipid"];?>">Click here to delete this comment</a></p>

            <?php
        }
?>
