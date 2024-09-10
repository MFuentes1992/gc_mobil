<?php 
        require_once $_SERVER['DOCUMENT_ROOT']."/model/VisitaModel.php";
        require_once $_SERVER['DOCUMENT_ROOT']."/constants/constants.php";
        require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php"; 
        session_start();
        $payload = $_GET;
        if(isset($payload["uniqueId"])) {
            $session = new SessionManager();
            $connValues = $session->getSession("userConn");
            $model = new Visit($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]); 
            $rawBitacora = $model->getBitacoraUniqueId($payload["uniqueId"]);
            $bitacora = $rawBitacora->fetch_array();
            if(isset($bitacora["fecha_lectura"])) {
                header("HTTP/1.1 400 ERROR");
                $msg = array("estatus"=> "400", "message"=>"El QR que intentas eliminar ya ha sido usado.");
                echo json_encode($msg); 
                return;
            }
            
            $res = $model->deleteVisita($payload["uniqueId"]);
            if($res) {
                header("HTTP/1.1 200 OK");
                $msg = array("estatus"=> "200", "message"=>"La visita se eliminó correctamente.");
                echo json_encode($msg); 
            } else {
                header("HTTP/1.1 400 ERROR");
                $msg = array("estatus"=> "400", "message"=>"Algo salió mal, intente de nuevo.", );
                echo json_encode($msg);    
            }
        } else {
            header("HTTP/1.1 400 ERROR");
            $msg = array("estatus"=> "400", "message"=>"Algo salió mal, intente de nuevo.", );
            echo json_encode($msg);    
        }
?>