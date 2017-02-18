<?php
    if ($auth){
        unset($_SESSION["user"]);
        unset($_SESSION["userid"]);
        unset($_SESSION["admin"]);
        header("Refresh:0");
    } else {
        echo 'You\'re logged out!';
    }
?>
