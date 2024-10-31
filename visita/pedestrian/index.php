<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/service/VisitaService.php"; 
    session_start();
    if(isset($_POST)) {
        $idVisita = $_POST['idVisita'];
        $pedestrians = $_POST['pedestrians'];
        $visitaService = new VisitaService();
        $res = $visitaService->savePedestrian($idVisita, $pedestrians);
        if($res) {
            header("HTTP/1.1 200 OK");
            $msg = array("estatus"=> "200", "message"=>"Peatones creados correctamente");
            echo json_encode($msg); 
        } else {
            header("HTTP/1.1 400 ERROR");
            $msg = array("estatus"=> "400", "message"=>"Algo salió mal");
            echo json_encode($msg);    
        }
    } else {
        header("HTTP/1.1 400 Bad Request");
        $msg = array("error" => "No se recibieron datos");
        echo json_encode($msg);
    }
?>