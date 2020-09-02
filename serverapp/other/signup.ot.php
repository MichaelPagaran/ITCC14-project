<?php
if (isset($_POST['signupSubmit'])) { #check if user really clicked on submit button
    require 'dbh.ot.php';
    $username = $_POST['usernameInput'];
    $email = $_POST['emailInput'];
    $password = $_POST['passwordInput'];
    $passwordRepeat = $_POST['passwordInputRepeat'];
    $weight = $_POST['weightInput'];
    $height = $_POST['heightInput'];
    $age = $_POST['ageInput'];
    $sex = $_POST['sexDropdown'];

    #input error handling
    if (empty($username)||empty($email)||empty($password)||empty($passwordRepeat)) {
        header("Location: ../signup.php?error=emptyfields&usernameInput=".$username."&emailInput=".$email);
        exit();
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)&&!preg_match("/^[a-zA-Z-0-9]*$/", $username)) { #check if both wrong
        header("Location: ../signup.php?error=invalidmailusernameInput");
        exit();
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) { #check email if real
        header("Location: ../signup.php?error=invalidmail&usernameInput=".$username);
        exit();
    }
    elseif (!preg_match("/^[a-zA-Z-0-9]*$/", $username)) { #validate proper username
        header("Location: ../signup.php?error=invalidusername&emailInput=".$email);
        exit();
    }
    elseif ($password !== $passwordRepeat) { #check if password match with confirm password
        header("Location: ../signup.php?error=passwordcheck&emailInput=".$email."&usernameInput=".$username);
        exit();
    }
    elseif (preg_match("/^[a-zA-Z]*$/", $weight)) { #check if weight contains letters
        header("Location: ../signup.php?error=weighterror&emailInput=".$email."&usernameInput=".$username);
        exit();
    }
    elseif (preg_match("/^[a-zA-Z]*$/", $height)) { #check if height contains letters
        header("Location: ../signup.php?error=heighterror&emailInput=".$email."&usernameInput=".$username);
        exit();
    }
    else { #checking if username already exist in database
        $sql="SELECT username FROM users WHERE username=?"; #use placeholder '?' for safety
        $stmt=mysqli_stmt_init($conn); #initialize prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../signup.php?error=sqlerror");
            exit();
        }else {
            mysqli_stmt_bind_param($stmt, "s", $username); #bind statement with user input
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt); #store result back to $stmt
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
                header("Location: ../signup.php?error=usertaken&emailInput=".$email);
                exit();
            }else {
                $sql="INSERT INTO users (username, userEmail, userPwd, userWeight, userHeight, userAge, userSex) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt=mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../signup.php?error=sqlerror");
                    exit();
                }else {
                    //$hashedPwd = password_hash($password, PASSWORD_DEFAULT); I commented this because this app uses prepared statements while the API uses PDO. I don't know how to 'dehash' the password in PDO
                    mysqli_stmt_bind_param($stmt, "sssssss", $username, $email, $password, $weight, $height, $age, $sex); 
                    mysqli_stmt_execute($stmt);
                    header("Location: ../signup.php?signup=success");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}else{
    header("Location: ../signup.php");
    exit();
}