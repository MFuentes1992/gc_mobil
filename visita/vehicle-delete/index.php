<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/service/VisitaService.php";
    session_start();
    $payload = $_POST;
    $service = new VisitaService();    
    $res = $service->deleteVehicle(intval($payload["id"]));
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