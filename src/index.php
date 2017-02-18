<?php
    $pages = [
        "home" => [
            "page" => "home.php"

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

            </header>
            <main>
                <?php
                    if(array_key_exists($page, $pages) ){
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
