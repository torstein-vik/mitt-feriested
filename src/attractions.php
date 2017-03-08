<?php

    $query = $conn->query("SELECT * FROM `mitt-feriested`.`attractions`");

    if(!$query){
        echo $conn->error;
        return;
    }

    $attractions = [];
    while($row = $query->fetch_assoc()){
        $attractions[] = $row;
    }

    if(isset($_GET["a"]) and sizeof($attractions) > $_GET["a"] - 1){
        $attraction = $attractions[$_GET["a"] - 1];
        include($attraction["pagefile"]);

        echo "<h1> Comments about ".$attraction["name"].": </h1>";

        $comment_query = $conn->query("SELECT users.username, users.privilege, UNIX_TIMESTAMP(tips.timestamp), tips.content, tips.title FROM `mitt-feriested`.`users`, `mitt-feriested`.`tips` WHERE users.userid=tips.userid AND tips.attractionid=".$attraction["attractionid"]." ORDER BY tips.timestamp DESC;");

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
                <h3> <?php echo($comment['title']." - ".$comment["username"].($comment['privilege'] == 'admin' ? " [admin]" : "").' (posted '.date('d/m/Y', $comment["UNIX_TIMESTAMP(tips.timestamp)"]).")"); ?></h3>
                <p>
                    <?php echo($comment["content"]);?>
                </p>

            <?php
        }

        if($auth){
            echo "<a href='?page=addcomment&a=".$_GET["a"]."'> Click to add comment! </a>";
        } else {
            echo "<a href='?page=login'> Log in</a> or <a href='?page=register'> Register</a> to leave comments!";
        }

        echo '<script src="http://www.yr.no/sted/'.$attraction["weather"].'/ekstern_boks_tre_dager.js"></script>';
        echo '<noscript><a href="http://www.yr.no/sted/'.$attraction["weather"].'/">Klikk her for å se værvarsel.</a></noscript>';


    } else {
        if (isset($_GET["redir"])){
            $redir = $_GET["redir"];
        } else {
            $redir = "attractions";
        }

        echo "<h1> Pick an attraction! </h1>";

        foreach($attractions as $key => $attraction){
            echo "<a href='?page=".$redir."&a=".($key + 1)."'>".$attraction["name"]."</a>";
        }
    }
?>
