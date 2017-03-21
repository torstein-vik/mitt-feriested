<?php
    if ($auth){
        header("Location: ?page=logout&redir=register");
    } else {

        if (isset($_GET['redir'])){
            $redir = $_GET['redir'];
        } else {
            $redir = 'home';
        }

        ?>
        <form id="registerform" redir="<?php echo $redir;?>">
            <input class="grey" style="border-radius: 5px 5px 0 0" name="username" type="text" placeholder="username">
            <input  name="password" type="password" placeholder="password">
            <input class="grey" name="conf_password" type="password" placeholder="confirm password">
            <input type="submit" value="Register">
            <div id="errmsg"> <p></p></div>

            <p>Already have a user? <a href="?page=login">Login here.</a></p>
        </form>

        <?php
    }
?>
