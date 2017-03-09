<?php
    if(!$auth){
        header("Location: ?page=login&redir=mypage");
        return;
    }
    $name = $_SESSION["user"];
    $userid = $_SESSION["userid"];
    $admin = $_SESSION["admin"];
?>

<div class="contentBody">
    <header id="loginHeader" class="contentHeader">
        <h1> Welcome, <?php echo $name;?>!</h1>
        <svg id="loginHeaderSvg1" width="190px" height="50px">
            <polygon points="0,50 190,0 190,50" style="fill:#A8A5A4;">
        </svg>
        <svg id="loginHeaderSvg2" width="220px" height="65px">
            <polygon points="0,65 19,0 220,65" style="fill:#7C7972;">
        </svg>
    </header>
    <main class="mainContent">
        <p>My coments:</p>

    </main>
</div>
