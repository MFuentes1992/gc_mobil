<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/service/InstalacionesService.php";
    session_start();
    if(isset($_GET)) {
        if(isset($_GET["recintoId"]) && intval($_GET["recintoId"]) > 0) {
            $instalacionesService = new InstalacionesService();
            $instalaciones = $instalacionesService->getInstalacionesByRecinto($_GET["recintoId"]);
            if($instalaciones) {
                header("HTTP/1.1 200 OK");
                echo json_encode($instalaciones);
            } else {
                header("HTTP/1.1 400 Bad Request");
                echo json_encode(array("error" => "No se encontraron instalaciones"));
            }
            
        } else {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("error" => "No se ha enviado el id del recinto"));
        }

    }
?>