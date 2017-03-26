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

        global $weather_added;
        $weather_added = false;

        ob_start();
        ob_implicit_flush(false);
        echo "<div id='weather'>";
        echo "<h2> Weather near ".$attraction["name"].": </h2>";

        echo '<script src="http://www.yr.no/place/'.$attraction["weather"].'/external_box_three_days.js"></script>';
        echo "</div>";
        $weather = ob_get_clean();

        $replaceWeatherCallback = function($res) use ($weather){
            global $weather_added;
            $weather_added = !(strpos($res, "###WEATHER###") == false);
            return str_replace("###WEATHER###", $weather, $res);
        };

        echo "<div class='pagecontent'>";
        ob_start($replaceWeatherCallback);
        include($attraction["pagefile"]);
        ob_end_flush();
        echo "</div>";

        if($attraction["weather"] != "NONE" and !$weather_added){
            echo $weather;
        }

        $comment_query = $conn->query("SELECT users.userid, users.username, users.privilege, UNIX_TIMESTAMP(tips.timestamp), tips.content, tips.title, tips.tipid FROM `mitt-feriested`.`users`, `mitt-feriested`.`tips` WHERE users.userid=tips.userid AND tips.attractionid=".$attraction["attractionid"]." ORDER BY tips.timestamp DESC;");

        if(!$comment_query){
            echo $conn->error;
            return;
        }

        $comments = [];
        while($row = $comment_query->fetch_assoc()){
            $comments[] = $row;
        }

        echo '<div class="comments">';
            if($comment_query->num_rows > 0){
                echo "<h2> Comments about ".$attraction["name"].": </h2>";
            }

            foreach($comments as $comment){
                $userlink = "<a href='?page=mypage&userid=".$comment["userid"]."'> ".$comment["username"].($comment['privilege'] == 'admin' ? " [admin]" : "")."</a>";
                ?>
                    <div class="comment" id="comment<?php echo $comment['tipid']?>">
                        <h3> <?php echo($comment['title']); ?></h3>
                        <h4><?php echo $userlink." - ".date('d/m/Y', $comment["UNIX_TIMESTAMP(tips.timestamp)"]); ?></h4>
                        <p><?php echo(nl2br($comment["content"]));?></p>
                    </div>
                <?php
            }

        if($auth){
            ?>
                <form method="POST" action="api?type=addcomment&a=<?php echo $_GET["a"]; ?>">
                    <h2>Leave a comment!</h2><br>
                    <input class="grey" style="border-radius: 5px 5px 0 0" name="title" type="text" placeholder="title">
                    <textarea name="comment" placeholder="comment" rows=5></textarea>
                    <input type="submit" value="Add comment">
                </form>
            <?php
        } else {
            echo "<p style='padding:20px;font-size:20px;'><a href='?page=login'>Log in</a> or <a href='?page=register'>Register</a> to leave comments!</p>";
        }
        echo '</div>';

    } else {
        if (isset($_GET["redir"])){
            $redir = $_GET["redir"];
        } else {
            $redir = "attractions";
        }

        $query2 = $conn->query("SELECT * FROM `mitt-feriested`.`tags`");

        if(!$query2){
            $conn->error;
            return;
        }

        $tags = [];
        while($row = $query2->fetch_assoc()){
            $tags[] = $row;
        }

        ?>

        <div id="redir" hidden><?php echo $redir; ?></div>

        <div id="tags">
            <?php
            foreach($tags as $key => $tag){
                echo "<div class='tagselector' tagid='".$tag["tagid"]."'>";
                echo "<h3>".$tag["name"]."</h3>";
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
