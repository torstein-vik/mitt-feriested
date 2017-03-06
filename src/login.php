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

            <div class="contentBody">
                <header id="loginHeader" class="contentHeader">
                    <h1>Login</h1>
                    <svg id="loginHeaderSvg1" width="190px" height="50px">
                        <polygon points="0,50 190,0 190,50" style="fill:#A8A5A4;">
                    </svg>
                    <svg id="loginHeaderSvg2" width="220px" height="65px">
                        <polygon points="0,65 19,0 220,65" style="fill:#7C7972;">
                    </svg>
                </header>
                <main class="mainContent">
                    <form method="POST" action=<?php echo "?page=login&redir=".$redir;?>>
                        <input name="username" type="text" placeholder="username">
                        <input name="password" type="password" placeholder="password">
                        <input type="submit" value="Log in">
                    </form>
                </main>
            </div>
            <?php
        }

    }
?>
