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



    } else {
        return;
    }
?>
