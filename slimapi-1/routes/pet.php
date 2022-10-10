<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

// Get All Post Function
$app->get('/api/all', function (Request $request, Response $response){
    $sql = "SELECT * FROM dragonpay";

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
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Headers', 'GET')
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        //throw $th;
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Headers', 'GET')
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});

// Get Specific ID 
$app->get('/api/{id}', function (Request $request, Response $response, array $args): Response {
    
    $id = $args['id'];

    $response->getBody()->write(sprintf('Get user: %s', $id));

    $sql = "SELECT * FROM dragonpay WHERE id = $id"; 

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
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Headers', 'GET')
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        //throw $th;
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Headers', 'GET')
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }

    return $response;
});

// Add Data
$app->post('/api/add', function (Request $request, Response $response){
    
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $project_name = $request->getParam('project_name');
    $payment_type = $request->getParam('payment_type');
    $reference_num = $request->getParam('reference_num');
    $block_num = $request->getParam('block_num');
    $email_address = $request->getParam('email_address');
    $contact_num = $request->getParam('contact_num');
    $amount = $request->getParam('amount');
    $remarks = $request->getParam('remarks');
        
    $sql = "INSERT INTO dragonpay (first_name, last_name, project_name, payment_type, reference_num, block_num, email_address, contact_num, amount, remarks) VALUE (:first_name, :last_name, :project_name, :payment_type, :reference_num, :block_num, :email_address, :contact_num, :amount, :remarks)"; 

    try {
        //code...
        $db = new DB();
        $conn = $db->connect();
        // Statement
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':project_name', $project_name);
        $stmt->bindParam(':payment_type', $payment_type);
        $stmt->bindParam(':reference_num', $reference_num);
        $stmt->bindParam(':block_num', $block_num);
        $stmt->bindParam(':email_address', $email_address);
        $stmt->bindParam(':contact_num', $contact_num);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':remarks', $remarks);

        $result = $stmt->execute();

        // set to null for error free
        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Headers', 'POST')
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        //throw $th;
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Headers', 'POST')
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});

// Add Data
$app->delete('/api/{id}', function (Request $request, Response $response, array $args){
    
    $id = $args['id'];

    $sql = "DELETE FROM dragonpay WHERE id = $id"; 

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
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Headers', 'DELETE')
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        //throw $th;
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Headers', 'DELETE')
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});

?>