<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/model/VisitaModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/constants/constants.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php"; 
    session_start();
    $payload = $_POST;
    $session = new SessionManager();
    $connValues = $session->getSession("userConn");
    $model = new Visit($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]); 
    $rawBitacora = $model->getBitacoraId(intval($payload["idVisita"]));
    $bitacora = $rawBitacora->fetch_array();
    if(isset($bitacora["fecha_lectura"])) {
        header("HTTP/1.1 400 ERROR");
        $msg = array("estatus"=> "400", "message"=>"El QR que intentas actualizar ya ha sido usado.");
        echo json_encode($msg); 
        return;
    }

    $res = $model->updateVisita(intval($payload["idVisita"]), intval($payload["tipoVisita"]), intval($payload["tipoIngreso"]),
    $payload["fechaIngreso"], $payload["fechaSalida"],
    intval($payload["multiEntrada"]), intval($payload["notificaciones"]), $payload["nombreVisita"],
    1,
    isset($payload["vehicles"]) ? $payload["vehicles"] : "");
    if($res) {
        header("HTTP/1.1 200 OK");
        $msg = array("estatus"=> "200", "message"=>"La visita se actualizo correctamente");
        echo json_encode($msg); 
    } else {
        header("HTTP/1.1 400 ERROR");
        $msg = array("estatus"=> "400", "message"=>"Algo salio mal, intente de nuevo.", );
        echo json_encode($msg);    
    }
?>