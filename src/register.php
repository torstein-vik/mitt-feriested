<?php
    if ($auth){
        header("Location: ?page=logout&redir=register");
    } else {

        if (isset($_GET['redir'])){
            $redir = $_GET['redir'];
        } else {
            $redir = 'mypage';
        }

        ?>
        <form id="registerform" redir="<?php echo $redir;?>">
            <input class="grey" style="border-radius: 5px 5px 0 0" name="username" type="text" placeholder="username">
            <input  name="password" type="password" placeholder="password">
            <input class="grey" name="conf_password" type="password" placeholder="confirm password">
            <input type="submit" value="Register">

            <p>Already have a user? <a href="?page=login">Login here.</a></p>
            <div id="errmsg"> </div>
        </form>

        <?php
    }
?>
