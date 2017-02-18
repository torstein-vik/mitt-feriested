<?php
    if ($auth){
        echo 'You\'re logged in!';
    } else {

        if(isset($_POST["username"]) and isset($_POST["password"])){
            $conn = new mysqli("localhost", "root", "");

            if ($conn->connect_errno) {
                printf("Connect failed: %s\n", $mysqli->connect_error);
                return;
            }

            $username = $conn->real_escape_string($_POST["username"]);
            $password = $conn->real_escape_string($_POST["password"]);

            $username_find = $conn->query("SELECT * FROM `mitt-feriested`.`users` WHERE username = '".$username."'");

            if($username_find->num_rows == 0){
                echo 'No such username!';
                return;
            }

            $user = $username_find->fetch_assoc();

            $conn->close();

            $salt = bin2hex($user['passsalt']);

            $hash = hash('sha256', $password.$salt);

            if($hash == bin2hex($user["passhash"])){
                $_SESSION['user'] = $username;
                $_SESSION['admin'] = ($user['privilege'] == 'admin');

                header('Location: ?page=login');
            } else {
                echo "Wrong password!";
                return;
            }

        } else {
            ?>

            <form method="POST" action="?page=login">
                <input name="username" type="text" placeholder="username">
                <input name="password" type="password" placeholder="password">
                <input type="submit" value="Log in">
            </form>

            <?php
        }

    }
?>
