<?php
    $conn = new mysqli("localhost", "root", "");
    if ($conn->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        return;
    }

    if(!$auth){
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
        <div class="contentBody">
            <header class="contentHeader">
                <h1> Add comment to <?php echo $attraction_name;?> </h1>
                <svg id="grey-triangle1" width="190px" height="50px">
                    <polygon points="0,50 190,0 190,50" style="fill:#A8A5A4;">
                </svg>
                <svg id="grey-triangle2" width="220px" height="65px">
                    <polygon points="0,65 19,0 220,65" style="fill:#7C7972;">
                </svg>
            </header>
            <main class="mainContent">
                <form method="POST" action=<?php "?page=addcomment?a=".$_GET["a"]?>>
                    <input name="title" type="text" placeholder="title">
                    <input name="comment" type="text" placeholder="comment">
                    <input type="submit" value="Add comment">
                </form>
            </main>
        </div>
        <?php
    }
    $conn->close();
?>
