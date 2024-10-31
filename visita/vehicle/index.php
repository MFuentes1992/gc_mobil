<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/service/VisitaService.php";
    session_start();
    if(isset($_POST)) {
        $visitaService = new VisitaService();
        $idVisita = $_POST["idVisita"];
        $vehicles = $_POST["vehicles"];
        $res = $visitaService->saveVehicle(intval($idVisita), $vehicles);
        if($res) {
            header("HTTP/1.1 200 OK");
            $msg = array("estatus"=> "200", "message"=>"Vehicles created successfully");
            echo json_encode($msg); 
        } else {
            header("HTTP/1.1 400 ERROR");
            $msg = array("estatus"=> "400", "message"=>"Something went wrong");
            echo json_encode($msg);    
        }
    } else {
        header("HTTP/1.1 400 ERROR");
        $msg = array("estatus"=> "400", "message"=>"Bad Request");
        echo json_encode($msg);
    }
?>