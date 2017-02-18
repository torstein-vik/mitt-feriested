<?php
    if(!$auth){
        header("Location: ?page=login&redir=mypage");
        return;
    }
    $name = $_SESSION["user"];
    $userid = $_SESSION["userid"];
    $admin = $_SESSION["admin"];
?>


<h1> Welcome, <?php echo $name;?>!</h1> <br>

<?php
    if($admin){
        echo "congrats on being admin.<br>";
    }
?>

Don't know what this will let you do though
