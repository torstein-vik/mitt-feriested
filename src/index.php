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
            "css" => "home.css",
            "external" => "slideshow.php",
            "title" => "The Faroe Islands!",
            "headerid" => "homeHeader",
            "headerSvg1width" => 220,
            "headerSvg1height" => 55,
            "headerSvg2width" => 200,
            "headerSvg2height" => 125,
            "polygon1spec" => 'points="0,55 60,0 220,55" style="fill:#3f5e10;"',
            "polygon2spec" => 'points="0,125 200,0 200,125" style="fill:#7C7972;"',
            "navid" => 0
        ],
        "login" => [
            "page" => "login.php",
            "script" => "login.js",
            "scriptinit" => "init",
            "css" => "errormessage.css",
            "title" => "Login",
            "headerid" => "loginHeader",
            "headerSvg1width" => 190,
            "headerSvg1height" => 50,
            "headerSvg2width" => 220,
            "headerSvg2height" => 65,
            "polygon1spec" => 'points="0,50 190,0 190,50" style="fill:#A8A5A4;"',
            "polygon2spec" => 'points="0,65 19,0 220,65" style="fill:#7C7972;"',
            "navid" => 6
        ],
        "logout" => [
            "external" => "logout.php",
            "navid" => 4
        ],
        "register" => [
            "page" => "register.php",
            "script" => "register.js",
            "scriptinit" => "init",
            "css" => "errormessage.css",
            "title" => "Register",
            "headerid" => "registerHeader",
            "headerSvg1width" => 250,
            "headerSvg1height" => 65,
            "headerSvg2width" => 220,
            "headerSvg2height" => 75,
            "polygon1spec" => 'points="0,65 115,0 250,65" style="fill:#7C7972;"',
            "polygon2spec" => 'points="0,75 220,0 220,75" style="fill:#3f5e10;"',
            "navid" => 5
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
            "navid" => 1
        ],
        "contact" => [
            "page" => "contact.php",
            "title" => "Contact",
            "headerid" => "homeHeader",
            "headerSvg1width" => 220,
            "headerSvg1height" => 55,
            "headerSvg2width" => 200,
            "headerSvg2height" => 125,
            "polygon1spec" => 'points="0,55 60,0 220,55" style="fill:#3f5e10;"',
            "polygon2spec" => 'points="0,125 200,0 200,125" style="fill:#7C7972;"',
            "navid" => 2
        ],
        "mypage" => [
            "page" => "mypage.php",
            "title" => "Welcome, ".(isset($_SESSION["user"]) ? $_SESSION["user"] : "Anonymous")."!",
            "script" => "mypage.js",
            "scriptinit" => "init",
            "css" => "mypage.css",
            "headerid" => "loginHeader",
            "headerSvg1width" => 190,
            "headerSvg1height" => 50,
            "headerSvg2width" => 220,
            "headerSvg2height" => 65,
            "polygon1spec" => 'points="0,50 190,0 190,50" style="fill:#A8A5A4;"',
            "polygon2spec" => 'points="0,65 19,0 220,65" style="fill:#7C7972;"',
            "navid" => 3
        ],
        "404" => [
            "page" => "notfound.php",
            "title" => "Not found!",
            "headerid" => "loginHeader",
            "headerSvg1width" => 190,
            "headerSvg1height" => 50,
            "headerSvg2width" => 220,
            "headerSvg2height" => 65,
            "polygon1spec" => 'points="0,50 190,0 190,50" style="fill:#A8A5A4;"',
            "polygon2spec" => 'points="0,65 19,0 220,65" style="fill:#7C7972;"',
            "navid" => -1
        ]
    ];

    if (array_key_exists("page", $_GET)){
        $page = $_GET["page"];
    } else {
        $page = "home";
    }

    if (isset($pages[$page])){
        $pageo = $pages[$page];
    } else {
        $pageo = $pages[404];
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
            if(isset($pageo["script"])){
                echo "<script src='".$pageo["script"]."'></script>";
            }

            if(isset($pageo["scriptinit"])){
                ?>
                <script>
                    $(<?php echo $pageo["scriptinit"];?>);
                </script>
                <?php
            }

            if(isset($pageo) and isset($pageo["css"])){
                echo "<link rel='stylesheet' href='".$pageo["css"]."'/>";
            }
        ?>
    </head>
    <body>
        <div id="content">
            <header>
                <div id="logo">
                    <a href='?page=home'><img src="res/logo_transparent_text.png" alt="Faroe Adventures"></a>
                </div>
                <nav id="mainNav">
                    <ul>
                        <li navid=0><a href="?page=home"> Home </a></li>
                        <li navid=1><a href="?page=attractions"> Attractions &amp; Travel </a></li>
                        <li navid=2><a href="?page=contact"> Contact </a></li>
                    </ul>
                </nav>
                <nav id="userNav">
                    <ul>
                        <?php
                        if($auth) {
                            ?>
                            <li navid=3><a style="padding-left: 60px;" href='?page=mypage'> My page </a></li>
                            <li navid=4><a href='?page=logout'> Log out </a></li>
                            <?php
                        } else {
                            ?>
                            <li navid=5><a style="padding-left: 60px;" href='?page=register'> Register </a></li>
                            <li navid=6><a href='?page=login'> Log in </a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </nav>

                <script>
                    var navid = <?php echo $pageo["navid"];?>;

                    $("ul > li[navid='" + navid + "'] > a").addClass('active');
                </script>
            </header>
            <main>
                <?php
                if(isset($pageo["external"]) ){
                    include $pageo["external"];
                }

                if(isset($pageo["page"])){
                ?>
                    <div class="contentBody">
                        <header id="<?php echo $pageo["headerid"];?>" class="contentHeader">
                            <h1><?php echo $pageo["title"];?> </h1>
                            <svg id="<?php echo $pageo["headerid"];?>Svg1" width="<?php echo $pageo["headerSvg1width"];?>px" height="<?php echo $pageo["headerSvg1height"];?>px">
                                <polygon <?php echo $pageo["polygon1spec"];?>>
                            </svg>
                            <svg id="<?php echo $pageo["headerid"];?>Svg2" width="<?php echo $pageo["headerSvg2width"];?>px" height="<?php echo $pageo["headerSvg2height"];?>px">
                                <polygon <?php echo $pageo["polygon2spec"];?>>
                            </svg>
                        </header>
                        <main class="mainContent">
                            <?php
                             include $pageo["page"];
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
