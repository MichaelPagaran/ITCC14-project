<?php
require "header.php";
?>
<main>
    <div class="wrapper">
        <?php
            if (isset($_SESSION['userID'])) {
                echo '
                <h1 class="brandName">Wedieco&trade;</h1>
                <p class="text-center ptext">Status: User is logged in</p>
                ';
            }else {
                echo '
                <h1 class="brandName">Securinator&trade;</h1>
                <hr class="titleHr">
                <p>
                    Securinator is a trusted software made by students who wish to apply their
                    knowledge in web development and information security that they learned from 
                    their 2nd year as Information Technology students. This application was only 
                    designed to keep the users information inside the database. This application 
                    was also used in other web application such as Wedieco&trade;. 
                </p>
                <p class="text-center ptext">Status: User is logged out</p>
                ';
            }
        ?>
    </div>
</main>
<?php
    require "footer.php";
?>