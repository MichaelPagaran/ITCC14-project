console.log(document);
let theData;
let pointer = 0;
$(document).ready(function(){
    $('.errorUsername').hide();
    $('.errorPassword').hide();
    $('.signupError').hide();
    $('.signupSuccess').hide();
    $('.controlButtons').hide();
});

$('.btnLogin').click(function (){   //index.html
    $('.errorUsername').hide();
    $('.errorPassword').hide();
    let usernameInput = $('#username').val();
    let passwordInput = $('#password').val();
    if (!$('#username').val()||!$('#password').val()) {
        $('.errorUsername').text("Username empty");
        $('.errorPassword').text("Password empty");
        $('.errorUsername').show();
        $('.errorPassword').show();
    }else{
        $.getJSON("http://serverapp/api/userbyusername/"+usernameInput, function(data){
        if(data.length == 1){
            $.getJSON("http://serverapp/api/userbypassword/"+passwordInput, function(data){
                if(data.length == 1){
                    sessionStorage.setItem('username', usernameInput);
                    sessionStorage.setItem('password', passwordInput);
                    window.location.href = "home.html";
                }else{
                    $('.errorPassword').show();
                }
            });
        }else{
            $('.errorUsername').show();
        }
    console.log(data.length);
    console.log(data); 
    });
    }
});

function setupHomePage() {//prevent user from going directly to home without index
    if(sessionStorage.getItem('username') == null){
        window.location.href = "index.html";
    }else{
        console.log(sessionStorage.getItem('username'));
        console.log(sessionStorage.getItem('password'));
        $.getJSON("http://serverapp/api/user/"+sessionStorage.getItem('username')+"/"+sessionStorage.getItem('password'), function(data){
            console.log(data);
            getRandomRecipe();
            $('.userHeader').text("Welcome, "+data[0].username+"!");
            suggestDiet(data);
        });
    }
}

function suggestDiet(data){ //updates the p tag depending on BMI result
    let bmi = getBMI(data[0].userWeight, data[0].userHeight);
    sessionStorage.setItem("userBMI", bmi);
    if (bmi > 25) {
        if(bmi > 30){
            $('.mainDescription').text("We have diagnosed you as an obese person. We have already made some adjustments to your suggested calorie intake if you choose normal diet type. Choosing otherwise is not recommended by Wedieco. Instead, seek proper help from a nutritionist.");
        }else{
            $('.mainDescription').text("We have diagnosed you as an overweight person but don't worry, we'll help you lose some weight. First, we already made changes to your suggested calorie intake when choosing the normal diet type. If you would like to try another diet type instead of normal, we recommend you to choose Ketogenic.");
        }
    }else if (bmi < 18.5){
        $('.mainDescription').text("We have diagnosed you as an underweight person. We have increased the recommended calorie intake if you choose normal diet type.");
    }else{
        $('.mainDescription').text("We congratulate you for maintaining a healthing body mass index. Wanna try different diet type other than normal?");
    }
}

$('.signup').click(function (){ //signup anchor at index.html
    console.log("asdasdasd");
    sessionStorage.setItem('status', 'signup'); //only this verifies if the user really clicked the signup anchor
    window.location.href = "signup.html";
});
function setupSignupPage(){//prevent user from going directly to signup without index
    if(sessionStorage.getItem('status') == null){
        window.location.href = "index.html"; //if empty, return to login page
    }else{
    }
}

$('.btnSignup').click(function(){
    $('.signupError').hide();
    let usernameInput = $('#usernameInput').val();
    let passwordInput = $('#passwordInput').val();
    let passwordRepeat = $('#passwordInputRepeat').val();
    let emailInput = $('#emailInput').val();
    let weightInput = $('#weightInput').val();
    let heightInput = $('#heightInput').val();
    let ageInput = $('#ageInput').val();
    let sexInput = $('#sexDropdown').val();
    console.log("button clicked");
    //error handling
    if (!$('#usernameInput').val()||!$('#passwordInput').val()||!$('#emailInput').val()||!$('#weightInput').val()||!$('#heightInput').val()||!$('#ageInput').val()||!$('#sexDropdown').val()) {
        $('.signupError').text("Empty field error!");
        $('.signupError').show();
    }else if (!validateEmail(emailInput)) { //check if valid email
        $('.signupError').text("Email invalid!");
        $('.signupError').show();
    }else if (passwordInput !== passwordRepeat) {
        $('.signupError').text("Password confirmation didn't match!");
        $('.signupError').show();
    }else if (!/^[0-9.]+$/.test(weightInput)) {
        $('.signupError').text("Weight input error");
        $('.signupError').show();
    }else if (!/^[0-9.]+$/.test(heightInput)) {
        $('.signupError').text("Height input error");
        $('.signupError').show();
    }else if (!/^[0-9]+$/.test(ageInput)) {
        $('.signupError').text("Age input error");
        $('.signupError').show();
    }else{
        try {
            const user = {
                username: usernameInput,
                password: passwordInput,
                email: emailInput,
                weight: weightInput,
                height: heightInput,
                age: ageInput,
                sex: sexInput
            };
            fetch('http://serverapp/api/user/add', {
                method: "post",
                body: JSON.stringify(user),
                headers:{
                    'Content-Type': 'application/json'
                }
            }).then(function(response){
                return response.text();
            }).then(function(text){
                console.log(text);
            }).catch(function(error){
                console.error(error);
                sessionStorage.setItem('signupStatus', 'fail')
            })
            sessionStorage.setItem('signupStatus', 'success');
        } catch (error) {
            $('.signupError').text("Unspecified error! Refer to web console.");
            $('.signupError').show();
        }
        if(sessionStorage.getItem('signupStatus')=='success'){
            $('.signupSuccess').show();
            sessionStorage.removeItem('signupStatus');
        }
    }
});

function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

$('.logout').click(function(){
    console.log("logout clicked");
});

function toMeter(feet){ //convert feet to meter
    const meterPerFoot = 0.3048;
    const result = feet * meterPerFoot;
    return result;
}

function getBMI(weight, height){
    const meterHeight = toMeter(height); //default unit of height is foot. only a dumbass preferes not to use metric.  jk
    const bmi =  weight/Math.pow(meterHeight, 2); //weight in kilograms divided by height in meters squared.
    return bmi
}
$('.getRecipeBtn').click(function(){
    pointer = 0;
    $('.recipeHeader').text("Search result:");
    let bmi = sessionStorage.getItem("userBMI");
    let minCalories;
    let maxCalories;
    let dietType = $('.dietDropdown').val();
    let selectedCheckbox = $('input[type="checkbox"]:checked'); //get all the checked checkbox
    let intoleranceSelected; //will store the value of the selected checkbox
    selectedCheckbox.each(function(){ //loop through the array
        if (intoleranceSelected == null) { //to avoid listing the 'undefined' value at array[0]
            intoleranceSelected = $(this).val(); //doesn't include the ","
        }else{
            intoleranceSelected = intoleranceSelected + "," + $(this).val();
        }
    });
    let url = "https://api.spoonacular.com/recipes/complexSearch?apiKey=8dfad9073494467faf6009b0ca45cdb9"
    if(intoleranceSelected != null){
        url = url + "&intolerances=" + intoleranceSelected;
    }
    if(dietType != "Normal"){
        url = url + "&diet=" + dietType;
    }else{
        if (bmi > 25) { //adjust the min calories depending on the body mass index
            if(bmi > 30){
                minCalories = 200;
                maxCalories = 400;
                url = url + "&minCalories=" + minCalories + "&maxCalories=" + maxCalories;
            }else{
                minCalories = 200;
                maxCalories = 400;
                url = url + "&minCalories=" + minCalories + "&maxCalories=" + maxCalories;
            }
        }else if (bmi < 18.5){
            minCalories = 500;
            maxCalories = 700;
            url = url + "&minCalories=" + minCalories + "&maxCalories=" + maxCalories;
        }else{
            minCalories = 400;
            maxCalories = 700;
            url = url + "&minCalories=" + minCalories + "&maxCalories=" + maxCalories;
        }
    }
    $.getJSON(url, function(data){
        theData = data.results;

        $('.foodPic').attr("src", data.results[0].image);
        $('.titleDescription').text(data.results[0].title);
        $('.minutesDescription').text(data.results[0].readyInMinutes);
        $('.servingsDescription').text(data.results[0].servings);
        $('.healthScoreDescription').text(data.results[0].healthScore);
        $('.sourceDescription').text(data.results[0].sourceUrl);
        $('.sourceDescription').attr("href", data.results[0].sourceUrl);
        $('#next').show();
    });
});

$('#next').click(function(){
    pointer++;
    let id = theData[pointer].id;
    $.getJSON("https://api.spoonacular.com/recipes/"+id+"/information?apiKey=8dfad9073494467faf6009b0ca45cdb9", function(data){
        console.log(data);
        $('.foodPic').attr("src", data.image);
        $('.titleDescription').text(data.title);
        $('.minutesDescription').text(data.readyInMinutes);
        $('.servingsDescription').text(data.servings);
        $('.healthScoreDescription').text(data.healthScore);
        $('.sourceDescription').text(data.sourceUrl);
        $('.sourceDescription').attr("href", data.sourceUrl);
    });
    if(pointer >= 9){
        $('#next').hide();
    }
    if(pointer > 0){
        $('#previous').show();
    }
});
$('#previous').click(function(){
    pointer--;
    let id = theData[pointer].id;
    console.log(id);
    $.getJSON("https://api.spoonacular.com/recipes/"+id+"/information?apiKey=8dfad9073494467faf6009b0ca45cdb9", function(data){
        console.log(data);
        $('.foodPic').attr("src", data.image);
        $('.titleDescription').text(data.title);
        $('.minutesDescription').text(data.readyInMinutes);
        $('.servingsDescription').text(data.servings);
        $('.healthScoreDescription').text(data.healthScore);
        $('.sourceDescription').text(data.sourceUrl);
        $('.sourceDescription').attr("href", data.sourceUrl);
    });
    if(pointer <= 0){
        $('#previous').hide();
        
    }
    if(pointer < 9){
        $('#next').show();
    }
});

function getRandomRecipe(){
    $.getJSON("https://api.spoonacular.com/recipes/random?apiKey=8dfad9073494467faf6009b0ca45cdb9", function(data){
        console.log(data);
        $('.foodPic').attr("src", data.recipes[0].image);
        $('.titleDescription').text(data.recipes[0].title);
        $('.minutesDescription').text(data.recipes[0].readyInMinutes);
        $('.servingsDescription').text(data.recipes[0].servings);
        $('.healthScoreDescription').text(data.recipes[0].healthScore);
        $('.sourceDescription').text(data.recipes[0].sourceUrl);
        $('.sourceDescription').attr("href", data.recipes[0].sourceUrl);
        console.log('random recipe generated')
    });
}

$('.dietDropdown').change(function(){
    const selected = $('.dietDropdown').val();
    switch (selected) {
        case "Normal":
            $('.dietDescription').text("You will get a recipe based on a normal diet with exceptions for selected tolerances.");
        break;
        case "Gluten Free":
            $('.dietDescription').text("Eliminating gluten means avoiding wheat, barley, rye, and other gluten-containing grains and foods made from them (or that may have been cross contaminated).");
        break;

        case "Ketogenic":
            $('.dietDescription').text("The keto diet is based more on the ratio of fat, protein, and carbs in the diet rather than specific ingredients. Generally speaking, high fat, protein-rich foods are acceptable and high carbohydrate foods are not.");
        break;

        case "Vegetarian":
            $('.dietDescription').text("No ingredients may contain meat or meat by-products, such as bones or gelatin.");
        break;

        case "Lacto-Vegetarian":
            $('.dietDescription').text("All ingredients must be vegetarian and none of the ingredients can be or contain egg.");
        break;

        case "Ovo-Vegetarian":
            $('.dietDescription').text("All ingredients must be vegetarian and none of the ingredients can be or contain dairy.");
        break;

        case "Vegan":
            $('.dietDescription').text("No ingredients may contain meat or meat by-products, such as bones or gelatin, nor may they contain eggs, dairy, or honey.");
        break;

        case "Pescetarian":
            $('.dietDescription').text("Everything is allowed except meat and meat by-products - some pescetarians eat eggs and dairy, some do not.");
        break;

        case "Paleo":
            $('.dietDescription').text("Allowed ingredients include meat (especially grass fed), fish, eggs, vegetables, some oils (e.g. coconut and olive oil), and in smaller quantities, fruit, nuts, and sweet potatoes. We also allow honey and maple syrup (popular in Paleo desserts, but strict Paleo followers may disagree). Ingredients not allowed include legumes (e.g. beans and lentils), grains, dairy, refined sugar, and processed foods.");
        break;

        case "Primal":
            $('.dietDescription').text("Very similar to Paleo, except dairy is allowed - think raw and full fat milk, butter, ghee, etc.");
        break;

        case "Whole30":
            $('.dietDescription').text("Allowed ingredients include meat, fish/seafood, eggs, vegetables, fresh fruit, coconut oil, olive oil, small amounts of dried fruit and nuts/seeds. Ingredients not allowed include added sweeteners (natural and artificial, except small amounts of fruit juice), dairy (except clarified butter or ghee), alcohol, grains, legumes (except green beans, sugar snap peas, and snow peas), and food additives, such as carrageenan, MSG, and sulfites.");
        break;

        default:
        break;
    }
});

//Get recipe by ID: https://api.spoonacular.com/recipes/{id}/information?apiKey=8dfad9073494467faf6009b0ca45cdb9
//Random recipe: https://api.spoonacular.com/recipes/random?apiKey=8dfad9073494467faf6009b0ca45cdb9
//With intolerance: https://api.spoonacular.com/recipes/complexSearch?apiKey=8dfad9073494467faf6009b0ca45cdb9&intolerance=Gluten,
//Custom search: https://api.spoonacular.com/recipes/complexSearch?apiKey=8dfad9073494467faf6009b0ca45cdb9&diet=Pescetarian&minCalories=200&maxCalories=400


/** custom stuff
 * $.getJSON("https://api.spoonacular.com/recipes/complexSearch?apiKey=8dfad9073494467faf6009b0ca45cdb9&Diet=Primal&intolerance=Gluten,Egg,Soy", function(data){
        console.log(data);
        $('.foodPic').attr("src", data.recipes[0].image);
        $('.titleDescription').text(data.recipes[0].title);
        $('.minutesDescription').text(data.recipes[0].readyInMinutes);
        $('.servingsDescription').text(data.recipes[0].servings);
        $('.healthScoreDescription').text(data.recipes[0].healthScore);
        $('.sourceDescription').text(data.recipes[0].sourceUrl);
        $('.sourceDescription').attr("href", data.recipes[0].sourceUrl);
    });
 */



/**NEED TO GET THIS DONE TOMORROW
 * To do:
 * 
 * I need to get all the data from the diet dropdown and intolerance. concatenate them. might do a nested if? (I hope not, depends on the remaining time)
 * Custom search is done tho.
 * 
 * The custom search returns 10 objects with less details. I need to select from the 10 and get the recipe based on the id
 * Get recipe by ID is done tho.
 * 
 * Learn to browse through the array of json objects.
 * 
 * Might add random food joke or random food trivia just to compensate for lacking areas
 */