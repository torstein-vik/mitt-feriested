<?php
    session_start();

    $pages = [
        "home" => [
            "page" => "home.php"
        ],
        "login" => [
            "page" => "login.php"
        ],
        "logout" => [
            "page" => "logout.php"
        ],
        "register" => [
            "page" => "register.php"
        ],
        "attractions" => [
            "page" => "attractions.php"
        ],
        "addcomment" => [
            "page" => "addcomment.php"
        ],
        "mypage" => [
            "page" => "mypage.php"
        ],
        "404" => [
            "page" => "notfound.php"
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
        <title>Faroe Adventure</title>
        <meta charset="utf-8" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans" />
        <link href="https://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet">

        <link rel="stylesheet" href="index.css"/>
        <script src="index.js"></script>

        <script>
            $(init);
        </script>
    </head>
    <body>
        <div id="content">
            <header>
                <nav>
                    <ul>
                        <li><a href="?page=home"> Home </a></li>
                        <li><a href="?page=attractions"> Attractions </a></li>
                        <?php
                        if($auth){
                            ?>
                            <li><a href='?page=mypage'> My page </a></li>
                            <li><a href='?page=addcomment'> Add comment </a></li>
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
                    if(isset($pages[$page]) ){
                        include $pages[$page]["page"];
                    } else {
                        include $pages["404"]["page"];
                    }
                ?>
            </main>
            <footer>
                <copyright>
                    Johannes Hansen Aas, Torstein Vik 2017
                </copyright>
            </footer>
        </div>
    </body>
</html>
