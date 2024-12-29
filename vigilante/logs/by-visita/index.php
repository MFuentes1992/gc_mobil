<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/service/VigilantesService.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/service/VisitaService.php";

    session_start();
    if(isset($_GET)) {
        $uniqueId = $_GET["uniqueId"];

        if($uniqueId == "" || $uniqueId == null) {
            header("HTTP/1.1 400 ERROR");
            $msg = array("estatus"=> "400", "message"=>"Unique ID is required");
            echo json_encode($msg);    
            return;
        }

        $serviceVisita = new VisitaService();
        $serviceVigilante = new VigilanteService();
        $resVisita = $serviceVisita->getVisitByQR($uniqueId);
        $resLogs = $serviceVigilante->getLogsByVisitaId($resVisita["visitaId"]);
        header("HTTP/1.1 200 OK");
        echo json_encode($resLogs);
    }
?>