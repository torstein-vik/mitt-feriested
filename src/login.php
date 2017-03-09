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
                    <br>
                    <a href="?page=register"> Click here to register </a>
                </main>
            </div>
            <?php
        }

    }
?>
