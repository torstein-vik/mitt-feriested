<?php
    if ($auth){
        unset($_SESSION["user"]);
        unset($_SESSION["userid"]);
        unset($_SESSION["admin"]);
        redir();
    } else {
        redir();
    }

    function redir(){
        if(isset($_GET["redir"])){
            header("Location: ?page=".$_GET["redir"]);
        } else {
            header("Location: ?page=home");
        }
    }
?>
