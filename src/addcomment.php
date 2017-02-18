<?php
    $conn = new mysqli("localhost", "root", "");
    if ($conn->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        return;
    }

    if(!isset($_SESSION["userid"])){
        header("Location: ?page=login&redir=addcomment");
        return;
    }

    if(!isset($_GET["a"])){
        header("Location: ?page=attractions&redir=addcomment");
        return;
    }



    $a = $conn->real_escape_string($_GET["a"]);
    $attraction_name = $conn->query("SELECT name FROM `mitt-feriested`.`attractions` WHERE attractionid=".$a.";")->fetch_assoc()["name"];

    if(isset($_POST["title"]) and isset($_POST["comment"])){

        $title = $conn->real_escape_string($_POST["title"]);
        $comment = $conn->real_escape_string($_POST["comment"]);
        $userid = $_SESSION["userid"];

        $query = $conn->query("INSERT INTO `mitt-feriested`.`tips` (userid, attractionid, title, content) VALUES ('".$userid."',".$a.",'".$title."','".$comment."');");

        if($query){
            echo "success! ";
            $conn->close();
            header("Location: ?page=attractions&a=".$_GET["a"]);

        } else {
            echo "failure!";
            print $conn->error;
        }


    } else {
        ?>

        <h1> Add comment to <?php echo $attraction_name;?> </h1>

        <form method="POST" action=<?php "?page=addcomment?a=".$_GET["a"]?>>
            <input name="title" type="text" placeholder="title">
            <input name="comment" type="text" placeholder="comment">
            <input type="submit" value="Add comment">
        </form>

        <?php
    }
    $conn->close();
?>
