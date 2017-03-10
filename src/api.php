<?php
    session_start();

    $conn = new mysqli("localhost", "root", "");
    if ($conn->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        return;
    }

    $conn -> set_charset("utf8");





    if(isset($_GET["type"])){
        $type = $_GET["type"];
    } else {
        return;
    }

    if($type == "attractions"){

            $query = $conn->query("SELECT * FROM `mitt-feriested`.`tags`");

            $tags = [];
            while($row = $query->fetch_assoc()){
                $tags[] = $row;
            }



            $flags = $_GET["flags"];

            $ntags = [];

            foreach($tags as $tag){
                if($flags >> ($tag["tagid"] - 1) & 1 == 1){
                    $ntags[] = $tag;
                }
            }

            $query2string = "SELECT attractions.attractionid, attractions.previewimg, attractions.name FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tagselections` WHERE attractions.attractionid = tagselections.attractionid AND ( ";


            foreach($ntags as $tag){
                $query2string .= "tagselections.tagid=".$tag["tagid"]." OR ";
            }

            $query2string .= "1 = 0 ) GROUP BY attractions.attractionid";

            $query2 = $conn->query($query2string);

            if(!$query2){
                echo $conn->error;
            }

            $attractions = [];
            while($row = $query2->fetch_assoc()){
                $attractions[] = $row;
            }

            foreach($attractions as $attraction){
                echo "<a class='attraction' href='?page=".($_GET["redir"])."&a=".($attraction["attractionid"])."'>";
                echo "<img style='width:60; height:60;' class='attractionpreview' src='".$attraction["previewimg"]."'/>";
                echo $attraction["name"];
                echo "</a>";
            }



    } else if($type == "addcomment" and isset($_SESSION["userid"])){

        $a = $conn->real_escape_string($_GET["a"]);
        $attraction_name = $conn->query("SELECT name FROM `mitt-feriested`.`attractions` WHERE attractionid=".$a.";")->fetch_assoc()["name"];

        if(isset($_POST["title"]) and isset($_POST["comment"])){

            $title = $conn->real_escape_string($_POST["title"]);
            $comment = $conn->real_escape_string($_POST["comment"]);
            $userid = $_SESSION["userid"];

            $query = $conn->query("INSERT INTO `mitt-feriested`.`tips` (userid, attractionid, title, content) VALUES ('".$userid."',".$a.",'".$title."','".$comment."');");

            if($query){
                echo "success! ";
                header("Location: /?page=attractions&a=".$_GET["a"]);

            } else {
                echo "failure!";
                print $conn->error;
            }

        } else {
            echo "System error. Are you sure you entered a title and comment?";
        }

    } else {
        echo "what do you think you're doing?";
        return;
    }
?>
