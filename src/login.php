<?php
    if ($auth){
        echo 'You\'re logged in!';
    } else {
        $_SESSION["user"] = "someone";
        header("Refresh:0");
    }
?>
