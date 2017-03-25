<center>
    <?php
        if(apache_getenv("REDIRECT_URL")){
            echo 'Couldn\'t find page "'.apache_getenv("REDIRECT_URL").'"';
        } else if (isset($_GET["page"])){
            echo 'Couldn\'t find page "'.$_GET["page"].'"';
        } else {
            echo 'Couldn\'t find page';
        }
    ?>
</center>
