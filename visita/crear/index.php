<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/service/VisitaService.php";
    session_start();
    if(isset($_POST)) {
        $payload = $_POST;
    
        $visitaService = new VisitaService();
        $idUsuario = intval($payload["idUsuario"]);
        $idTipoVisita = intval($payload["idTipoVisita"]);
        $idTipoIngreso = intval($payload["idTipoIngreso"]);
        $idInstalacion = $payload["idInstalacion"];

        $fechaIngreso = $payload["fechaIngreso"];
        $fechaSalida = $payload["fechaSalida"];
        $multiple = intval($payload["multiple"]);
        $notificaciones = intval($payload["notificaciones"]);
        $nombreVisita = $payload["nombreVisita"];
        $estatusRegistro = 1;
        $vehiculos = isset($payload["vehiculos"]) ? $payload["vehiculos"] : "";
        $peatones = isset($payload["peatones"]) ? $payload["peatones"] : "";
        $res = $visitaService->createVisita($idUsuario, $idTipoVisita, $idTipoIngreso, $idInstalacion, $fechaIngreso, $fechaSalida, $multiple, $notificaciones, $nombreVisita, $estatusRegistro, $vehiculos, $peatones);   
        if($res) {
            header("HTTP/1.1 200 OK");
            $msg = array("estatus"=> "200", "message"=>"Record created successfully", "uniqueID"=>$res);
            echo json_encode($msg); 
        } else {
            header("HTTP/1.1 400 ERROR");
            $msg = array("estatus"=> "400", "message"=>"Something went wrong");
            echo json_encode($msg);    
        }
    } else {
        header("HTTP/1.1 400 ERROR");
        $msg = array("estatus"=> "400", "message"=>"No se recibieron datos.");
        echo json_encode($msg);
    }


?>