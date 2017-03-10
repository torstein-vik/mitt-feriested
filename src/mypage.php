<?php
    if(!$auth){
        header("Location: ?page=login&redir=mypage");
        return;
    }
    $name = $_SESSION["user"];
    $userid = $_SESSION["userid"];
    $admin = $_SESSION["admin"];
?>

<p>My comments:</p>
