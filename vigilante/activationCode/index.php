<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/model/VigilantesModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/constants/constants.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php"; 
    $payload = $_POST;
    if(isset($payload["code"])) {
        session_start();
        $session = new SessionManager();
        $connValues = $session->getSession("userConn");
        $model = new Vigilante($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
        $res = $model->getActivationCode($payload["code"]);
        if($res) {
            $row = $res->fetch_assoc();
            if($row["estatus_uso"] == 0 || $row["estatus_uso"] == "0") {
                $operation = $model->updateActivationCode($payload["code"]);
                if(!$operation) {
                    header("HTTP/1.1 500 ERROR");
                    $msg = array("code" => "500", "message" => "Error al actualizar el codigo");
                    echo json_encode($msg);
                    return;
                }
                header("HTTP/1.1 200 OK");
                $resArr = array("code" => "200", "message" => "Codigo Actualizado", "token_instalacion" => uniqid('', true));            
                echo json_encode($resArr);
            } else {
                header("HTTP/1.1 400 ERROR");
                $msg = array("code" => "400", "message" => "Codigo en uso");
                echo json_encode($msg);
                return;
            }
        } else {
            header("HTTP/1.1 400 ERROR");
            $msg = array("code" => "400", "message" => "Problema al obtener el codigo de activación");
            echo json_encode($msg);
        }
    }
?>