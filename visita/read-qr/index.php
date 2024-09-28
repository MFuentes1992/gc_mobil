<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/service/VisitaService.php";    
    // -- Controller
    session_start();
    if(isset($_GET["qr"])) {
        $qr = $_GET["qr"];
        if($qr == "" || $qr == null) {
            header("HTTP/1.1 400 ERROR");
            $msg = array("estatus"=> "400", "message"=>"QR is required");
            echo json_encode($msg);    
            return;
        }
        $service = new VisitaService();
        $res = $service->getVisitByQR($qr); 
        header("HTTP/1.1 200 OK");
        echo json_encode($res); 

    } else if(isset($_POST["qr"])) {
        $qr = $_POST["qr"];
        $casetaId = $_POST["casetaId"];
        $visitaId = $_POST["visitaId"];
        $type = $_POST["type"];
        if($qr == "" || $qr == null) {
            header("HTTP/1.1 400 ERROR");
            $msg = array("estatus"=> "400", "message"=>"QR is required");
            echo json_encode($msg);    
            return;
        }
        if($casetaId == "" || $casetaId == null) {
            header("HTTP/1.1 400 ERROR");
            $msg = array("estatus"=> "400", "message"=>"Caseta ID is required");
            echo json_encode($msg);    
            return;
        }
        if($visitaId == "" || $visitaId == null) {
            header("HTTP/1.1 400 ERROR");
            $msg = array("estatus"=> "400", "message"=>"Visita ID is required");
            echo json_encode($msg);    
            return;
        }
        if($type == "" || $type == null) {
            header("HTTP/1.1 400 ERROR");
            $msg = array("estatus"=> "400", "message"=>"Type is required");
            echo json_encode($msg);    
            return;
        }
        $service = new VisitaService();
        if($type == "entry") {
            $res = $service->registerQREntry($visitaId, $casetaId);
            if($res) {
                header("HTTP/1.1 200 OK");
                echo json_encode(array("estatus"=> "200", "message"=>"Entrada registrada."));
            } else {
                header("HTTP/1.1 400 ERROR");
                echo json_encode(array("estatus"=> "400", "message"=>"El usuario ya ha registrado su entrada, por favor registre su salida."));
            }
        } else {
            $res = $service->registerQRExit($visitaId, $casetaId);
            if($res) {
                header("HTTP/1.1 200 OK");
                echo json_encode(array("estatus"=> "200", "message"=>"Salida registrada."));
            } else {
                header("HTTP/1.1 400 ERROR");
                echo json_encode(array("estatus"=> "400", "message"=>"El usuario no ha registrado su entrada, por favor registre su entrada."));
            }
        }

    }
?>