<?php
header("Access-Control-Allow-Origin: *"); //CORS error fix
header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = new \Slim\App;

//Get test
$app->get('/api/test', function(Request $request, Response $response){
    echo 'Hello world, cuzzz';
});

//Get All users
$app->get('/api/allusers', function(Request $request, Response $response){
    $sql = "SELECT * FROM users";
    try{
        //get db object
        $db = new db();
        //connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $users = $stmt->fetchAll(PDO::FETCH_OBJ); //get result from object
        $db = null;

        echo json_encode($users);
        

    }catch(PDOException $e){
        echo '{"error": {"text":'.$e->getMessage().'}}';
    }
});

$app->get('/api/userbyid/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "SELECT * FROM users WHERE userId = $id";
    try{
        //get db object
        $db = new db();
        //connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ); //get result from object
        $db = null;

        echo json_encode($user);
        

    }catch(PDOException $e){
        echo '{"error": {"text":'.$e->getMessage().'}}';
    }
});

$app->get('/api/userbyemail/{email}', function(Request $request, Response $response){
    $email = $request->getAttribute('email');
    $sql = "SELECT * FROM users WHERE userEmail = '$email'";
    try{
        //get db object
        $db = new db();
        //connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ); //get result from object
        $db = null;

        echo json_encode($user);
        

    }catch(PDOException $e){
        echo '{"error": {"text":'.$e->getMessage().'}}';
    }
});

$app->get('/api/userbyusername/{username}', function(Request $request, Response $response){
    $username = $request->getAttribute('username');
    $sql = "SELECT * FROM users WHERE username = '$username'";
    try{
        //get db object
        $db = new db();
        //connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ); //get result from object
        $db = null;

        echo json_encode($user);
        

    }catch(PDOException $e){
        echo '{"error": {"text":'.$e->getMessage().'}}';
    }
});

$app->get('/api/userbypassword/{password}', function(Request $request, Response $response){
    $password = $request->getAttribute('password');
    $sql = "SELECT * FROM users WHERE userPwd = '$password'";
    try{
        //get db object
        $db = new db();
        //connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ); //get result from object
        $db = null;

        echo json_encode($user);
        

    }catch(PDOException $e){
        echo '{"error": {"text":'.$e->getMessage().'}}';
    }
});

$app->post('/api/user/add', function(Request $request, Response $response){
    $username = $request->getParam('username');
    $password = $request->getParam('password');
    $email = $request->getParam('email');
    $weight = $request->getParam('weight');
    $height = $request->getParam('height');
    $age = $request->getParam('age');
    $sex = $request->getParam('sex');
    $sql = "INSERT INTO users (username, userEmail, userPwd, userWeight, userHeight, userAge, userSex) VALUES (:username, :userEmail, :userPwd, :userWeight, :userHeight, :userAge, :userSex)";
    try{
        //get db object
        $db = new db();
        //connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':userEmail', $email);
        $stmt->bindParam(':userPwd', $password);
        $stmt->bindParam(':userWeight', $weight);
        $stmt->bindParam(':userHeight', $height);
        $stmt->bindParam(':userAge', $age);
        $stmt->bindParam(':userSex', $sex);

        $stmt->execute();

        echo '{"notice:": {"text": "User Added"}';
        

    }catch(PDOException $e){
        echo '{"error": {"text":'.$e->getMessage().'}}';
    }
});

$app->get('/api/user/{username}/{password}', function(Request $request, Response $response){
    $username = $request->getAttribute('username');
    $password = $request->getAttribute('password');
    $sql = "SELECT * FROM users WHERE username = '$username' AND userPwd = '$password'";
    try{
        //get db object
        $db = new db();
        //connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ); //get result from object
        $db = null;

        echo json_encode($user);
        

    }catch(PDOException $e){
        echo '{"error": {"text":'.$e->getMessage().'}}';
    }
});