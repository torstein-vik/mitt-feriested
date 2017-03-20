<?php
    session_start();

    $conn = new mysqli("localhost", "root", "");
    if ($conn->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        return;
    }

    $conn -> set_charset("utf8");

    if(isset($_SESSION["user"])){
        $name = $_SESSION["user"];
        $userid = $_SESSION["userid"];
        $admin = $_SESSION["admin"];
    }


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
                echo "<div>";
                echo "<a class='attraction' href='?page=".($_GET["redir"])."&a=".($attraction["attractionid"])."'>";
                echo "<img class='attractionpreview' src='".$attraction["previewimg"]."'/>";
                echo $attraction["name"];
                echo "</a>";
                echo "</div>";
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

    } else if($type == "deletecomment" and isset($_SESSION["userid"])){

        $tipid = $conn->real_escape_string($_GET["tipid"]);

        if ($admin){
            $queryDelSQL = "DELETE FROM `mitt-feriested`.`tips` WHERE tips.tipid=".$tipid;
        } else {
            $queryDelSQL = "DELETE FROM `mitt-feriested`.`tips` WHERE tips.tipid=".$tipid." AND tips.userid=".$userid;
        }

        $queryDel = $conn->query($queryDelSQL);

        if(!$queryDel){
            echo $conn->error;
            return;
        } else {
            header("Location: /?page=mypage");
            return;
        }

    } else if($type == "login"){
        if(isset($_POST["username"]) and isset($_POST["password"])){
            $username = $conn->real_escape_string($_POST["username"]);
            $password = $conn->real_escape_string($_POST["password"]);

            $username_find = $conn->query("SELECT * FROM `mitt-feriested`.`users` WHERE username = '".$username."'");

            if($username_find->num_rows == 0){
                ?>USERNAME_ERR<?php
                return;
            }

            $user = $username_find->fetch_assoc();

            $salt = bin2hex($user['passsalt']);

            $hash = hash('sha256', $password.$salt);

            if($hash == bin2hex($user["passhash"])){
                $_SESSION['userid'] = $user["userid"];
                $_SESSION['user'] = $username;
                $_SESSION['admin'] = ($user['privilege'] == 'admin');

                ?>SUCCESS<?php
                return;

            } else {
                ?>PASSWORD_ERR<?php
                return;
            }
        }
    } else if($type == "register"){
        if(isset($_POST["username"]) and isset($_POST["password"]) and isset($_POST["conf_password"])){
            $username = $conn->real_escape_string($_POST["username"]);
            $password = $conn->real_escape_string($_POST["password"]);
            $password_conf = $conn->real_escape_string($_POST["conf_password"]);

            if($password != $password_conf){
                ?>PASSWD_MISMATCH_ERR<?php
                return;
            }

            $username_conflict = $conn->query("SELECT * FROM `mitt-feriested`.`users` WHERE username = '".$username."'");

            if($username_conflict->num_rows > 0){
                ?>USERNAME_USED_ERR<?php
                return;
            }

            print $conn->error;

            $salt = bin2hex(random_bytes(32));

            $hash = hash('sha256', $password.$salt);

            $privilege = "'user'";

            $query = $conn->query("INSERT INTO `mitt-feriested`.`users`  (username, passhash, passsalt, privilege) VALUES ('".$username."',0x".$hash.",0x".$salt.",".$privilege.");");

            if($query){
                ?>SUCCESS<?php
                return;
            } else {
                ?>UNKNOWN_ERR<?php
                return;
            }

        }
    } else {
        echo "what do you think you're doing?";
        return;
    }
?>
