<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/model/VisitaModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/constants/constants.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php"; 
    session_start();
    $payload = $_POST;
    $session = new SessionManager();
    $connValues = $session->getSession("userConn");
    $model = new Visit($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]); 
    
    $res = $model->createMultipleVehicles(intval($payload["idVisita"]), isset($payload["vehicles"]) ? $payload["vehicles"] : "");
    if($res) {
        header("HTTP/1.1 200 OK");
        $msg = array("estatus"=> "200", "message"=>"Vehicles created successfully");
        echo json_encode($msg); 
    } else {
        header("HTTP/1.1 400 ERROR");
        $msg = array("estatus"=> "400", "message"=>"Something went wrong");
        echo json_encode($msg);    
    }
?>