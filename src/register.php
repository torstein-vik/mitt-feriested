<?php
    if(isset($_POST["username"]) and isset($_POST["password"]) and isset($_POST["conf_password"])){

    } else {
        ?>

        <form method="POST" action="?page=register">
            <input type="text" placeholder="username">
            <input type="password" placeholder="password">
            <input type="password" placeholder="confirm password">
            <input type="submit" value="Register">
        </form>

        <?php
    }
?>
