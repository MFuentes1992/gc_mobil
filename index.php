<?php
    require_once "service/DBService.php";
    require_once "service/UserService.php";
    require_once "Auth/AuthLogin.php";
    require_once "constants/constants.php";
    require_once "sessionManager/SessionManager.php";

    // -- Default Admin credentials
    session_start();
    $session = new SessionManager();
    $jsonPayload = file_get_contents('php://input');
    if(!$session->sessionExists($dbSession)) {
        // -- Cliend credentials
        
        $clientData  = json_decode($jsonPayload, true);
        if(array_key_exists('code', $clientData)){
            // -- Create connection to db Admins and retrieve the corresponding DB.
            $dbService = new DBService($dbUrl, $dbUser, $dbPass, $dbName, $clientData['code']); 
            $dbRes = $dbService->connectToAdmin();       
            $clientDB = $dbRes->fetch_array();
            $clientDBName = $clientData['prefix'].'_'.$clientDB['datos'];
            $dbService->closeConnection();
            // -- Create a new connection for client db.
            $userConn = new UserService($dbUrl, $clientData['user'], $clientData['password'], $clientDBName);            
            $session->initializeSession($dbSession, array("dbUrl" => $dbUrl, "user" => $clientData['user'], "password" => $clientData['password'], "dbName" => $clientDBName));
            $res = $userConn->getUserByEmail($clientData['email']);
            header("HTTP/1.1 200 OK");
            echo json_encode($res->fetch_array());
            $userConn->closeConnection();
        } else {
            $msg = array("message"=>"Please provide the customer code you would like to autenticate.");
            echo json_encode($msg);
        }
    }  else {
        $requestUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $requestString = substr($requestUrl, strlen($baseUrl));        
        switch ($requestString) {
            case '/?login':                
                $payload  = json_decode($jsonPayload, true);
                if($payload == null || !(array_key_exists('password', $payload) || array_key_exists('email', $payload))) {
                    $msg = array("message"=>"Please provide user credentials");
                    echo json_encode($msg);
                    break;
                }
                $email = $payload['email'];
                $pass = $payload['password'];
                $auth = new AuthLogin();
                $aut = $auth->login($email, $pass);
                $token = sprintf("%s-%s", $email, date("Y-m-d"));                
                if($aut) {
                    $msg = array("message"=>"success", "code"=>"200", "access_token"=> base64_encode($token));
                    echo json_encode($msg);
                    break;
                } else {
                    $msg = array("message"=>"Incorrect credentials. Please verify.", "code"=>"400");
                    echo json_encode($msg);
                    break;
                }
                break;
            case '/?logout': 
                session_unset();
                break;
            default:
                # code...
                break;
        }
    }  
?>
