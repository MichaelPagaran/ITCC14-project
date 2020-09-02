<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Lora'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"> 
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <header>
    <nav class="navbar navbar-expand-sm navbar-dark">
        <a href="#" class="navbar-brand brandName" >Wedieco&trade;</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item ml-4">
                    <a href="index.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item ml-4">
                    <a href="#" class="nav-link">Portfolio</a>
                </li>
                <li class="nav-item ml-4">
                    <a href="#" class="nav-link">About me</a>
                </li>
                <li class="nav-item ml-4">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>
        </div>
        <?php
            if (isset($_SESSION['userID'])) {
                echo '<form action="other/logout.ot.php" method="post" class="navbarForms">
                    <button type="submit" name="logoutSubmit">Logout</button>
                    </form>';
            }else {
                echo '<form action="other/login.ot.php" method="POST" class="navbarForms">
                <input type="text" name="emailUsernameInput" placeholder="Username/E-mail">
                <input type="password" name="passwordInput" placeholder="Password">
                <button type="submit" name="loginSubmit">Login</button>
                </form>
                <a href="signup.php" class="signupAnchor">Signup</a>';
            }
        ?>       
    </nav>
    </header>