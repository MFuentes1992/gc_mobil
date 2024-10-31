<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/service/VisitaService.php"; 
    session_start();
    if(isset($_POST)) {
        $idVisita = $_POST['idVisita'];
        $idTipoIngreso = $_POST['idTipoIngreso'];
        $idTipoVisita = $_POST['idTipoVisita'];
        $fechaIngreso = $_POST['fechaIngreso'];
        $fechaSalida = $_POST['fechaSalida'];
        $multiple = $_POST['multiple'];
        $notificaciones = $_POST['notificaciones'];
        $nombreVisita = $_POST['nombreVisita'];
        $vehicles = $_POST['vehiculos']; 
        $pedestrians = $_POST['peatones'];
        $estatusRegistro = $_POST['estatusRegistro'];
        $visitaService = new VisitaService();
        $visita = $visitaService->updateVisita($idVisita, $idTipoVisita, $idTipoIngreso, $fechaIngreso, $fechaSalida, $multiple, $notificaciones, $nombreVisita, $estatusRegistro, $vehicles, $pedestrians);
        if($visita) {
            header("HTTP/1.1 200 OK");
            $msg = array("estatus"=> "200", "message"=>"La visita se actualizo correctamente");
            echo json_encode($msg);
        } else {
            header("HTTP/1.1 500 Internal Server Error");
            $msg = array("error" => "No se pudo actualizar la visita");
            echo json_encode($msg);
        }
    } else {
        header("HTTP/1.1 400 Bad Request");
        $msg = array("error" => "No se recibieron datos");
        echo json_encode($msg);
    }
    
?>