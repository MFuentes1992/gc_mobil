<?php
    require_once "service/DBService.php";
    require_once "service/UserService.php";
    require_once "Auth/AuthLogin.php";
    require_once "constants/constants.php";
    require_once "sessionManager/SessionManager.php";

    // -- Default Admin credentials
    session_start();
    $session = new SessionManager();
    $urlPayload = $_POST;
    if(!$session->sessionExists($dbSession)) {
        // -- Cliend credentials
        if(isset($urlPayload['code'])){
            // -- Create connection to db Admins and retrieve the corresponding DB.
            $dbService = new DBService($dbUrl, $dbUser, $dbPass, $dbName, $urlPayload['code']); 
            $dbRes = $dbService->connectToAdmin();       
            $clientDB = $dbRes->fetch_array();
            $clientDBName = $urlPayload['prefix'].'_'.$clientDB['datos'];
            $clientDBUser = $urlPayload['prefix'].'_'.$clientDB['usuario'];
            $dbService->closeConnection();
            // -- Create a new connection for client db.
            $userConn = new UserService($dbUrl, $clientDBUser, $clientDB['acceso'], $clientDBName);            
            $session->initializeSession($dbSession, array("dbUrl" => $dbUrl, "user" => $clientDBUser, "password" => $clientDB['acceso'], "dbName" => $clientDBName));
            //$res = $userConn->getUserByEmail($urlPayload['email']);
            $res = array("message"=>"DB is selected for user: ".$clientDBName);
            header("HTTP/1.1 200 OK");
            echo json_encode($res);
            $userConn->closeConnection();
        } else {
            header("HTTP/1.1 500 ERROR");
            $msg = array("message"=>"Please provide the customer code you would like to autenticate.");
            echo json_encode($msg);
        }
    }  else {        
        $requestString = substr($requestUrl, strlen($baseUrl));        
        switch ($requestString) {
            case '/?login':                                
                if($urlPayload == null || !(array_key_exists('password', $urlPayload) || array_key_exists('email', $urlPayload))) {
                    header("HTTP/1.1 400 OK");
                    $msg = array("message"=>"Please provide user credentials");
                    echo json_encode($msg);
                    break;
                }
                $email = $urlPayload['email'];
                $pass = $urlPayload['password'];
                $auth = new AuthLogin();
                $user = $auth->login($email, $pass);
                $token = sprintf("%s-%s", $email, date("Y-m-d"));                
                if($user != null) {
                    header("HTTP/1.1 200 OK");
                    $msg = array("message"=>"success", "code"=>"200", "access_token"=> base64_encode($token), "name"=>$user["name"], "id"=>$user["id"], "instalaciones"=>$user["id_instalacion"]);
                    echo json_encode($msg);
                    break;
                } else {
                    header("HTTP/1.1 400 OK");
                    $msg = array("message"=>"Incorrect credentials. Please verify.", "code"=>"400");
                    echo json_encode($msg);
                    break;
                }
                break;
            case '/?logout': 
                session_unset();
                break;
            default:
                header("HTTP/1.1 200 OK");
                $msg = array("message"=>"Existing connection.");
                echo json_encode($msg);
                break;
        }
    }  
?>
