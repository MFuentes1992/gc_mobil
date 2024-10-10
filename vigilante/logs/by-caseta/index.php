<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/service/VigilantesService.php";
    session_start();
    if(isset($_GET)) {
        $casetaId = $_GET["casetaId"];
        if($casetaId == "" || $casetaId == null) {
            header("HTTP/1.1 400 ERROR");
            $msg = array("estatus"=> "400", "message"=>"Caseta ID is required");
            echo json_encode($msg);    
            return;
        }
        $service = new VigilanteService();
        $res = $service->getLogsByCasetaId($casetaId); 
        header("HTTP/1.1 200 OK");
        echo json_encode($res);
    } else if (isset($_POST)) {

    }
?>