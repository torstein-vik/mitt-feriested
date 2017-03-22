<?php
    if ($auth){
        header("Location: ?page=logout&redir=login");
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

            <div id="errmsg">
                <p></p>
            </div>

            <p>Don't have a user? <a href="?page=register">Register here.</a></p>
        </form>

        <?php
    }
?>
