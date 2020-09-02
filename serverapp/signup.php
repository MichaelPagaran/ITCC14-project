<?php
    require "header.php";
?>
<main>
    <div class="wrapper">
        <h1>Signup</h1>
        <?php
            if (isset($_GET['error'])) {
                switch ($_GET['error']) {
                    case "emptyfields":
                        echo '<p class="signupErrorLabel">Fill in all fields</p>';
                        break;
                    case "invalidmailusernameInput";
                        echo '<p class="signupErrorLabel">Invalid email and username input</p>';
                        break;
                    case "invalidmail":
                        echo '<p class="signupErrorLabel">Invalid email</p>';
                        break;
                    case "invalidusername";
                        echo '<p class="signupErrorLabel">Invalid username</p>';
                        break;
                    case "passwordcheck";
                        echo '<p class="signupErrorLabel">Password did not match</p>';
                        break;
                    case "weighterror";
                        echo '<p class="signupErrorLabel">Invalid weight</p>';
                        break;
                    case "heighterror";
                        echo '<p class="signupErrorLabel">Invalid height</p>';
                        break;
                    case "sqlerror";
                        echo '<p class="signupErrorLabel">SQL error</p>';
                        break;
                    case "usertaken";
                        echo '<p class="signupErrorLabel">User already exist</p>';
                        break;
                    default:
                        break;
                }                   
            }elseif (isset($_GET['signup'])) {
                if ($_GET['signup'] == "success") {
                    echo '<p class="signupSuccessLabel">Signup successful</p>';
                }               
            }
        ?>
        <form action="other/signup.ot.php" method="POST">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <label for="usernameInput">Username</label>
                        <input type="text" name="usernameInput" placeholder="bigPP420" class="form-control longInput">
                        <label for="emailInput">Email</label>
                        <input type="text" name="emailInput" placeholder="example@gmail.com" class="form-control longInput">
                    </div>
                    <div class="row">
                        <label for="passwordInput">Password</label>
                        <input type="password" name="passwordInput" placeholder="new password" class="form-control longInput">
                        <label for="passwordInputRepeat">Confirm password</label>
                        <input type="password" name="passwordInputRepeat" placeholder="repeat password" class="form-control longInput">    
                    </div>   
                </div>
                <div class="col">
                    <div class="row">
                        <label for="weightInput">Weight</label>
                        <input type="text" name="weightInput" placeholder="unit: kg" class="form-control shortInput">
                        <label for="heightInput">Height</label>
                        <input type="text" name="heightInput" placeholder="unit: ft" class="form-control shortInput">
                    </div>
                    <div class="row">
                        <label for="ageInput">Age</label>
                        <input type="text" name="ageInput" placeholder="64" class="form-control shortInput">

                        <label for="sel1">Sexual orientation</label>
                        <select class="form-control sexInput" name="sexDropdown">
                            <option>Male</option>
                            <option>Famale</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row row2">
                <div class="col">
                    <!--
                    <label for="form-check" class="intoleranceLabel">Intolerances</label>  
                    <div class="form-check checkboxForm">
                        <div class="row">
                            <div class="col">                            
                                <input type="checkbox" name="" id="diary" class="form-check-input">
                                <label for="dairy" class="form-check-label checkbox-inline">Dairy</label>
                            </div>
                            <div class="col">                             
                                <input type="checkbox" name="" id="egg" class="form-check-input checkbox-inline">
                                <label for="egg" class="form-check-label">Egg</label>
                            </div>
                            <div class="col">
                                <input type="checkbox" name="" id="gluten" class="form-check-input checkbox-inline">
                                <label for="gluten" class="form-check-label">Gluten</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="checkbox" name="" id="grain" class="form-check-input checkbox-inline">
                                <label for="grain" class="form-check-label">Grain</label>
                            </div>
                            <div class="col">                               
                                <input type="checkbox" name="" id="peanut" class="form-check-input checkbox-inline">
                                <label for="peanut" class="form-check-label">Peanut</label>
                            </div>
                            <div class="col">                              
                                <input type="checkbox" name="" id="seafood" class="form-check-input">
                                <label for="seafood" class="form-check-label">Seafood</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">                           
                                <input type="checkbox" name="" id="seasame" class="form-check-input checkbox-inline">
                                <label for="seasame" class="form-check-label">Seasame</label>
                            </div>
                            <div class="col">                           
                                <input type="checkbox" name="" id="shellfish" class="form-check-input checkbox-inline">
                                <label for="shellfish" class="form-check-label">Shellfish</label>
                            </div>
                            <div class="col">                               
                                <input type="checkbox" name="" id="soy" class="form-check-input">
                                <label for="soy" class="form-check-label">Soy</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">             
                                <input type="checkbox" name="" id="sulfite" class="form-check-input checkbox-inline">
                                <label for="sulfite" class="form-check-label">Sulfite</label>
                            </div>
                            <div class="col">             
                                <input type="checkbox" name="" id="treeNut" class="form-check-input checkbox-inline">
                                <label for="treeNut" class="form-check-label">Tree Nut</label>
                            </div>
                            <div class="col"> 
                                <input type="checkbox" name="" id="wheat" class="form-check-input checkbox-inline">
                                <label for="wheat" class="form-check-label">Wheat</label>
                            </div>
                        </div>      
                    </div>
                    -->   
                </div>
                <div class="col">
                    <button type="submit" name="signupSubmit" class="btn btn-info pull-right">Signup</button>
                </div>
            </div>
        </form>
    </div>
</main>

<?php
    require "footer.php";
?>