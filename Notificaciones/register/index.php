<?php   
    require_once $_SERVER['DOCUMENT_ROOT'] . "/model/NotificacionesModel.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/sessionManager/SessionManager.php";
    session_start();
    $payload = $_POST;
    if(isset($payload['idRecinto']) && isset($payload['deviceId'])) {
        $session = new SessionManager();
        $connValues = $session->getSession("userConn");
        $model = new Notificaciones($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
        $deviceExists = $model->getDeviceByDeviceId($payload['deviceId']);        
        if($deviceExists->num_rows > 0) {
            header("HTTP/1.1 400 ERROR");
            $msg = array("estatus"=> "400", "message"=>"El dispositivo ya esta registrado", "device"=>$payload['deviceId']);
            echo json_encode($msg);    
            return;
        } else {
            $res = $model->registerDevice(intval($payload['idRecinto']), $payload['deviceId']);
            if($res) {
                header("HTTP/1.1 200 OK");
                $msg = array("estatus"=> "200", "message"=>"Dispositivo registrado");
                echo json_encode($msg);
            } else {
                header("HTTP/1.1 400 ERROR");
                $msg = array("estatus"=> "400", "message"=>"Something went wrong");
                echo json_encode($msg);    
            }
        }
    } else {
        header("HTTP/1.1 400 ERROR");
        $msg = array("estatus"=> "400", "message"=>"Ingresa el recinto o el dispositivo");
        echo json_encode($msg);
    }
?>