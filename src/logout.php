<?php
    if ($auth){
        unset($_SESSION["user"]);
        header("Refresh:0");
    } else {
        echo 'You\'re logged out!';
    }
?>
