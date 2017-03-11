<?php
    if ($auth){
        header("Location: ?page=mypage");
    } else {

        if(isset($_POST["username"]) and isset($_POST["password"])){
            $username = $conn->real_escape_string($_POST["username"]);
            $password = $conn->real_escape_string($_POST["password"]);

            $username_find = $conn->query("SELECT * FROM `mitt-feriested`.`users` WHERE username = '".$username."'");

            if($username_find->num_rows == 0){
                ?>Wrong username<?php
                return;
            }

            $user = $username_find->fetch_assoc();

            $salt = bin2hex($user['passsalt']);

            $hash = hash('sha256', $password.$salt);

            if($hash == bin2hex($user["passhash"])){
                $_SESSION['userid'] = $user["userid"];
                $_SESSION['user'] = $username;
                $_SESSION['admin'] = ($user['privilege'] == 'admin');


                if (isset($_GET['redir'])){
                    $redir = $_GET['redir'];
                } else {
                    $redir = 'login';
                }

                header('Location: ?page='.$redir);
            } else {
                echo "Wrong password!";
                return;
            }

        } else {
            if (isset($_GET['redir'])){
                $redir = $_GET['redir'];
            } else {
                $redir = 'login';
            }

            ?>
            <form method="POST" action=<?php echo "?page=login&redir=".$redir;?>>
                <input class="grey" style="border-radius: 5px 5px 0 0" name="username" type="text" placeholder="username">
                <input name="password" type="password" placeholder="password">
                <input class="grey" type="submit" value="Log in">
                <p>Don't have a user? <a href="?page=register">Register here.</a></p>
            </form>

            <?php
        }

    }
?>
