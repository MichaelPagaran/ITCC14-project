<?php
if (isset($_POST['loginSubmit'])) {
    require 'dbh.ot.php';
    $emailUsername = $_POST['emailUsernameInput'];
    $password = $_POST['passwordInput'];

    if (empty($emailUsername)||empty($password)) {
        header("Location: ../index.php?error=emptyfields");
        exit();
    }else {
        $sql = "SELECT * FROM users WHERE username=? OR userEmail=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=sqlerror");
            exit();
        }else {
            mysqli_stmt_bind_param($stmt, "ss", $emailUsername, $emailUsername);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) { //result from row. 
                //$pwdCheck = password_verify($password, $row['userPwd']); I commented this because this app uses prepared statements while the API uses PDO. I don't know how to 'dehash' the password in PDO
                if ($password != $row['userPwd']) {
                    header("Location: ../index.php?error=wrongpwd");
                    exit();
                }elseif ($password == $row['userPwd']) {
                    session_start();
                    #session variables
                    $_SESSION['userID'] = $row['userId'];
                    $_SESSION['userName'] = $row['username'];

                    header("Location: ../index.php?login=success");
                    exit();
                }else {
                    header("Location: ../index.php?error=wrongpwd");
                    exit();
                }
            }else {
                header("Location: ../index.php?error=nouser");
                exit();
            }
        }
    }
}else {
    header("Location: ../index.php");
    exit();
}