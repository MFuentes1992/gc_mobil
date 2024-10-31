<?php 
    /**
    * Autor: Marco Fuentes.
    * Obtiene la visita por medio del QR, este endpoint es utilizado por el usuario residente, no genera logs en bitacora.
    * Method: GET
    * Respuesta en formato JSON
    */
    
    require_once $_SERVER['DOCUMENT_ROOT']."/service/VisitaService.php";
    session_start();
    if(isset($_GET)) {
        $uniqueId = $_GET["uniqueId"];
        $service = new VisitaService();
        $visitaResponse = $service->getVisitByQR($uniqueId);
        if($visitaResponse) {
            header("HTTP/1.1 200 OK");
            echo json_encode($visitaResponse); 
        } else {
            header("HTTP/1.1 500 ERROR");
            $msg = array("estatus"=> "500", "message"=>"No se pudo obtener la visita.");
            echo json_encode($msg);    
        }
    } else {
        header("HTTP/1.1 400 ERROR");
        $msg = array("estatus"=> "400", "message"=>"No se proporcionaron los datos necesarios.");
        echo json_encode($msg);    
    }
?>