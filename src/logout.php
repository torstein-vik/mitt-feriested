<?php
    if ($auth){
        unset($_SESSION["user"]);
        unset($_SESSION["userid"]);
        unset($_SESSION["admin"]);
        header("Refresh:0");
    } else {
        if(isset($_GET["redir"])){
            header("Location: ?page=".$_GET["redir"]);
        } else {
            header("Location: ?page=home");
        }
    }
?>
