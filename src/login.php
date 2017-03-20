<?php
    if ($auth){
        header("Location: ?page=mypage");
    } else {

            if (isset($_GET['redir'])){
                $redir = $_GET['redir'];
            } else {
                $redir = 'mypage';
            }

            ?>
            <form id="loginform" redir="<?php echo $redir;?>">
                <input class="grey" style="border-radius: 5px 5px 0 0" name="username" type="text" placeholder="username">
                <input name="password" type="password" placeholder="password">
                <input class="grey" type="submit" value="Log in">
                <p>Don't have a user? <a href="?page=register">Register here.</a></p>
                <div id="errmsg"> </div>
            </form>


            <?php


    }
?>
