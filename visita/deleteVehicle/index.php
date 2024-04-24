<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/model/VisitaModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/constants/constants.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php"; 
    session_start();
    $payload = $_POST;
    $session = new SessionManager();
    $connValues = $session->getSession("userConn");
    $model = new Visit($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]); 
    
    $res = $model->deleteVehicle(intval($payload["idVehicle"]));
    if($res) {
        header("HTTP/1.1 200 OK");
        $msg = array("estatus"=> "200", "message"=>"Vehicle removed successfully");
        echo json_encode($msg); 
    } else {
        header("HTTP/1.1 400 ERROR");
        $msg = array("estatus"=> "400", "message"=>"Something went wrong");
        echo json_encode($msg);    
    }
?>