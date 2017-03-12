<?php

    $query = $conn->query("SELECT * FROM `mitt-feriested`.`attractions`");

    if(!$query){
        echo $conn->error;
        return;
    }

    $attractions = [];
    while($row = $query->fetch_assoc()){
        $attractions[$row["attractionid"]] = $row;
    }

    if(isset($_GET["a"]) and $_GET["a"] > 0 and sizeof($attractions) > $_GET["a"] - 1){
        $attraction = $attractions[$_GET["a"]];
        include($attraction["pagefile"]);


        echo "<h1> Weather near ".$attraction["name"].": </h1>";

        echo '<script src="http://www.yr.no/sted/'.$attraction["weather"].'/ekstern_boks_tre_dager.js"></script>';
        echo '<noscript><a href="http://www.yr.no/sted/'.$attraction["weather"].'/">Klikk her for å se værvarsel.</a></noscript>';


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
                <div class="comment">
                    <h3> <?php echo($comment['title']); ?></h3>
                    <h4><?php echo($comment["username"].($comment['privilege'] == 'admin' ? " [admin]" : "")." - ".date('d/m/Y', $comment["UNIX_TIMESTAMP(tips.timestamp)"])); ?></h4>
                    <p>
                        <?php echo($comment["content"]);?>
                    </p>
                </div>
            <?php
        }

        if($auth){
            ?>

                <form method="POST" action="api?type=addcomment&a=<?php echo $_GET["a"]; ?>">
                    <h2>Leave a comment!</h2>
                    <input class="grey" name="title" type="text" placeholder="title">
                    <input name="comment" type="text" placeholder="comment">
                    <input type="submit" value="Add comment">
                </form>

            <?php
        } else {
            echo "<a href='?page=login'> Log in</a> or <a href='?page=register'> Register</a> to leave comments!";
        }

    } else {
        if (isset($_GET["redir"])){
            $redir = $_GET["redir"];
        } else {
            $redir = "attractions";
        }

        $query2 = $conn->query("SELECT * FROM `mitt-feriested`.`tags`");

        $tags = [];
        while($row = $query2->fetch_assoc()){
            $tags[] = $row;
        }

        echo "<h1> Pick an attraction or travel option! </h1>";

        ?>

        <div id="redir" hidden><?php echo $redir; ?></div>

        <div id="#tags">
            <?php
            foreach($tags as $key => $tag){
                echo "<div class='tagselector' tagid='".$tag["tagid"]."'>";
                echo "<span>".$tag["name"]."</span>";
                echo "</div>";
            }
            ?>
        </div>
        <?php

        ?>
        <div id="attractions">

        </div>
        <?php
    }
?>

<div id="per">
    <div class="hei">
        <span>hei</span>
    </div>
    <div class="hei">
        <span>hei</span>
    </div>
    <div class="hei">
        <span>hei</span>
    </div>
    <div class="hei">
        <span>hei</span>
    </div>
</div>
