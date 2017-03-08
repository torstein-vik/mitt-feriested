<?php
    if(isset($_POST["username"]) and isset($_POST["password"]) and isset($_POST["conf_password"])){
        $username = $conn->real_escape_string($_POST["username"]);
        $password = $conn->real_escape_string($_POST["password"]);
        $password_conf = $conn->real_escape_string($_POST["conf_password"]);

        if($password != $password_conf){
            echo 'password mismatch!';
            return;
        }

        $username_conflict = $conn->query("SELECT * FROM `mitt-feriested`.`users` WHERE username = '".$username."'");

        if($username_conflict->num_rows > 0){
            echo 'Username already in use!';
            return;
        }

        print $conn->error;

        $salt = bin2hex(random_bytes(32));

        $hash = hash('sha256', $password.$salt);

        $privilege = "'user'";

        $query = $conn->query("INSERT INTO `mitt-feriested`.`users`  (username, passhash, passsalt, privilege) VALUES ('".$username."',0x".$hash.",0x".$salt.",".$privilege.");");

        if($query){
            echo "success! ";
            include("login.php");

        } else {
            echo "failure!";
            print $conn->error;
        }

    } else {
        ?>

        <div class="contentBody">
            <header class="contentHeader">
                <h1>Register for free today!</h1>
                <svg id="grey-triangle1" width="190px" height="50px">
                    <polygon points="0,50 190,0 190,50" style="fill:#A8A5A4;">
                </svg>
                <svg id="grey-triangle2" width="220px" height="65px">
                    <polygon points="0,65 19,0 220,65" style="fill:#7C7972;">
                </svg>
            </header>
            <main class="mainContent">
                <form method="POST" action="?page=register">
                    <input name="username" type="text" placeholder="username">
                    <input name="password" type="password" placeholder="password">
                    <input name="conf_password" type="password" placeholder="confirm password">
                    <input type="submit" value="Register">
                </form>
            </main>
        </div>

        <?php
    }
?>
