<?php
    if(isset($_POST["username"]) and isset($_POST["password"]) and isset($_POST["conf_password"])){
        $conn = new mysqli("localhost", "root", "");

        if ($conn->connect_errno) {
            printf("Connect failed: %s\n", $mysqli->connect_error);
            return;
        }

        $username = $conn->real_escape_string($_POST["username"]);
        $password = $conn->real_escape_string($_POST["password"]);
        $password_conf = $conn->real_escape_string($_POST["conf_password"]);

        if($password != $password_conf){
            echo 'password mismatch!';
            return;
        }

        $username_conflict = $conn->query("SELECT * FROM `mitt-feriested`.`users` WHERE username = '".$username."'");

        if(mysqli_num_rows($username_conflict) > 0){
            echo 'Username already in use!';
            return;
        }

        print $conn->error;

        $salt = random_bytes(8);

        $hash = hash('sha256', $password.bin2hex($salt));

        $privilege = "'user'";

        $query = $conn->query("INSERT INTO `mitt-feriested`.`users`  (username, passhash, passsalt, privilege) VALUES ('".$username."',0x".$hash.",0x".bin2hex($salt).",".$privilege.");");

        if($query){
            echo "success! ";
            include("login.php");

        } else {
            echo "failure!";
            print $conn->error;
        }

        $conn->close();

    } else {
        ?>

        <form method="POST" action="?page=register">
            <input name="username" type="text" placeholder="username">
            <input name="password" type="password" placeholder="password">
            <input name="conf_password" type="password" placeholder="confirm password">
            <input type="submit" value="Register">
        </form>

        <?php
    }
?>
