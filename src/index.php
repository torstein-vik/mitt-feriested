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
            "title" => "The Faroe Islands!",
            "headerid" => "homeHeader",
            "headerSvg1width" => 220,
            "headerSvg1height" => 55,
            "headerSvg2width" => 200,
            "headerSvg2height" => 125,
            "polygon1spec" => 'points="0,55 60,0 220,55" style="fill:#3f5e10;"',
            "polygon2spec" => 'points="0,125 200,0 200,125" style="fill:#7C7972;"',
        ],
        "login" => [
            "page" => "login.php",
            "title" => "Login",
            "headerid" => "loginHeader",
            "headerSvg1width" => 190,
            "headerSvg1height" => 50,
            "headerSvg2width" => 220,
            "headerSvg2height" => 65,
            "polygon1spec" => 'points="0,50 190,0 190,50" style="fill:#A8A5A4;"',
            "polygon2spec" => 'points="0,65 19,0 220,65" style="fill:#7C7972;"',
        ],
        "logout" => [
            "external" => "logout.php"
        ],
        "register" => [
            "page" => "register.php",
            "title" => "Register",
            "headerid" => "registerHeader",
            "headerSvg1width" => 250,
            "headerSvg1height" => 65,
            "headerSvg2width" => 220,
            "headerSvg2height" => 75,
            "polygon1spec" => 'points="0,65 115,0 250,65" style="fill:#7C7972;"',
            "polygon2spec" => 'points="0,75 220,0 220,75" style="fill:#3f5e10;"',
        ],
        "attractions" => [
            "page" => "attractions.php",
            "script" => "attractions.js",
            "scriptinit" => "init",
            "css" => "attractions.css",
            "title" => "Attractions & Travel",
            "headerid" => "attractionsHeader",
            "headerSvg1width" => 250,
            "headerSvg1height" => 110,
            "headerSvg2width" => 230,
            "headerSvg2height" => 110,
            "polygon1spec" => 'points="70,0 250,110 0,110" style="fill:#7C7972;"',
            "polygon2spec" => 'points="0,110 230,0 230,110" style="fill:#3f5e10;"',
        ],
        "mypage" => [
            "page" => "mypage.php",
            "title" => "Welcome, ".(isset($_SESSION["user"]) ? $_SESSION["user"] : "Anonymous")."!",
            "headerid" => "loginHeader",
            "headerSvg1width" => 190,
            "headerSvg1height" => 50,
            "headerSvg2width" => 220,
            "headerSvg2height" => 65,
            "polygon1spec" => 'points="0,50 190,0 190,50" style="fill:#A8A5A4;"',
            "polygon2spec" => 'points="0,65 19,0 220,65" style="fill:#7C7972;"',
        ],
        "404" => [
            "page" => "notfound.php",
            "title" => "Not found!",
            "headerid" => "mypageHeader",
            "headerSvg1width" => 190,
            "headerSvg1height" => 50,
            "headerSvg2width" => 220,
            "headerSvg2height" => 65,
            "polygon1spec" => 'points="0,50 190,0 190,50" style="fill:#A8A5A4;"',
            "polygon2spec" => 'points="0,65 19,0 220,65" style="fill:#7C7972;"',
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

                if(isset($pages[$page]) and isset($pages[$page]["page"])){
                ?>
                    <div class="contentBody">
                        <header id="<?php echo $pages[$page]["headerid"];?>" class="contentHeader">
                            <h1><?php echo $pages[$page]["title"];?> </h1>
                            <svg id="<?php echo $pages[$page]["headerid"];?>Svg1" width="<?php echo $pages[$page]["headerSvg1width"];?>px" height="<?php echo $pages[$page]["headerSvg1height"];?>px">
                                <polygon <?php echo $pages[$page]["polygon1spec"];?>>
                            </svg>
                            <svg id="<?php echo $pages[$page]["headerid"];?>Svg2" width="<?php echo $pages[$page]["headerSvg2width"];?>px" height="<?php echo $pages[$page]["headerSvg2height"];?>px">
                                <polygon <?php echo $pages[$page]["polygon2spec"];?>>
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
                <?php
                }
                ?>
            </main>
            <footer>
                <div>&copy; Johannes Hansen Aas, Torstein Vik 2017</div>
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
