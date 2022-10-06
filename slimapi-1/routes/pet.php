<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();


// Get All Post Function
$app->get('/pet/all', function (Request $request, Response $response){
    $sql = "SELECT * FROM pet";

    try {
        //code...
        $db = new DB();
        $conn = $db->connect();
        // Statement
        $stmt = $conn->query($sql);
        $pet = $stmt->fetchAll(PDO::FETCH_OBJ);

        // set to null for error free
        $db = null;
        $response->getBody()->write(json_encode($pet));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        //throw $th;
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});

// Get Specific ID 
$app->get('/pet/{id}', function (Request $request, Response $response, array $args){
    
    $id = $args['id'];
    $sql = "SELECT * FROM pet WHERE id = $id"; 

    try {
        //code...
        $db = new DB();
        $conn = $db->connect();
        // Statement
        $stmt = $conn->query($sql);
        $petsp = $stmt->fetch(PDO::FETCH_OBJ);

        // set to null for error free
        $db = null;
        $response->getBody()->write(json_encode($petsp));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        //throw $th;
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});

// Add Data
$app->post('/pet/add', function (Request $request, Response $response){
    
    $email = $request->getParam('email');
    $name = $request->getParam('name');
    $age = $request->getParam('age');

    $sql = "INSERT INTO pet (email, name, age) VALUE (:email, :name, :age)"; 

    try {
        //code...
        $db = new DB();
        $conn = $db->connect();
        // Statement
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':age', $age);

        $result = $stmt->execute();

        // set to null for error free
        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        //throw $th;
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});

// Add Data
$app->delete('/pet/{id}', function (Request $request, Response $response, array $args){
    
    $id = $args['id'];

    $sql = "DELETE FROM pet WHERE id = $id"; 

    try {
        //code...
        $db = new DB();
        $conn = $db->connect();
        // Statement
        $stmt = $conn->prepare($sql);

        $result = $stmt->execute();

        // set to null for error free
        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        //throw $th;
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});


?>