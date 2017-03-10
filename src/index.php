<?php
    session_start();

    $conn = new mysqli("localhost", "root", "");
    if ($conn->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        return;
    }

    $conn -> set_charset("utf8");

    $pages = [
        "home" => [
            "page" => "home.php",
            "script" => "home.js",
            "scriptinit" => "init",
            "external" => "slideshow.php",
            "title" => "The Faroe Islands!"
        ],
        "login" => [
            "page" => "login.php",
            "title" => "Login"
        ],
        "logout" => [
            "page" => "logout.php",
            "title" => "Log out"
        ],
        "register" => [
            "page" => "register.php",
            "title" => "Register"
        ],
        "attractions" => [
            "page" => "attractions.php",
            "script" => "attractions.js",
            "scriptinit" => "init",
            "css" => "attractions.css",
            "title" => "Attractions & Travel"
        ],
        "mypage" => [
            "page" => "mypage.php",
            "title" => "My page"
        ],
        "404" => [
            "page" => "notfound.php",
            "title" => "Not found!"
        ]
    ];

    if (array_key_exists("page", $_GET)){
        $page = $_GET["page"];
    } else {
        $page = "home";
    }

    $auth = isset($_SESSION["user"])
?>
<html>
    <head>
        <title>Faroe Adventures</title>
        <meta charset="utf-8" />
        <link rel="icon" href="res/favicon.png">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans" />
        <link href="https://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet">

        <link rel="stylesheet" href="index.css"/>


        <?php
            if(isset($pages[$page]) and isset($pages[$page]["script"])){
                echo "<script src='".$pages[$page]["script"]."'></script>";
            }

            if(isset($pages[$page]) and isset($pages[$page]["scriptinit"])){
                ?>
                <script>
                    $(<?php echo $pages[$page]["scriptinit"];?>);
                </script>
                <?php
            }

            if(isset($pages[$page]) and isset($pages[$page]["css"])){
                echo "<link rel='stylesheet' href='".$pages[$page]["css"]."'/>";
            }
        ?>

    </head>
    <body>
        <div id="content">
            <header>
                <div id="logo">
                    <a href='?page=home'><img src="res/logo_transparent_text.png" alt="Faroe Adventures"></a>
                </div>
                <nav>
                    <ul>
                        <li><a href="?page=home"> Home </a></li>
                        <li><a href="?page=attractions"> Attractions & Travel </a></li>
                        <?php
                        if($auth) {
                            ?>
                            <li><a href='?page=mypage'> My page </a></li>
                            <li><a href='?page=logout'> Log out </a></li>
                            <?php
                        } else {
                            ?>
                            <li><a href='?page=register'> Register </a></li>
                            <li><a href='?page=login'> Log in </a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </nav>
            </header>
            <main>
                <?php
                    if(isset($pages[$page]) and isset($pages[$page]["external"]) ){
                        include $pages[$page]["external"];
                    }
                ?>

                <div class="contentBody">
                    <header id="homeHeader" class="contentHeader">
                        <h1><?php echo $pages[$page]["title"];?> </h1>
                        <svg id="homeHeaderSvg1" width="220px" height="55px">
                            <polygon points="0,55 60,0 220,55" style="fill:#3f5e10;" />
                        </svg>
                        <svg id="homeHeaderSvg2" width="200px" height="125px">
                            <polygon points="0,125 200,0 200,125" style="fill:#7C7972;" />
                        </svg>
                    </header>
                    <main class="mainContent">
                        <?php
                            if(isset($pages[$page]) ){
                                include $pages[$page]["page"];
                            } else {
                                include $pages["404"]["page"];
                            }
                        ?>
                    </main>
                </div>
            </main>
            <footer>
                <div>&copy;Johannes Hansen Aas, Torstein Vik 2017</div>
            </footer>
            <div id="bottomCorner_logo">
                <img src="res/black_logo.png">
            </div>
        </div>
    </body>
</html>
<?php
    $conn->close();
?>
