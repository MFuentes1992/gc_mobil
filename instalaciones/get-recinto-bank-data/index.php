<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/model/RecintosModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/constants/constants.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php";
    session_start();
    $query = $_GET;
    $session = new SessionManager();
    $connValues = $session->getSession("userConn");
    $model = new Recintos($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
    if(isset($query["recintoId"])) {
        $idRecinto = $query["recintoId"];
        $res = $model->getRecintoBankData($idRecinto);
        if($res) {
            $arr = array();
            while($row = $res->fetch_array()) {                
                array_push($arr, array("numero_cuenta" => $row["numero_cuenta"], "banco" => $row["banco"], "clabe" => $row["clabe"]));        
            }
            $response = array(
                "status" => "OK",
                "result" => $arr
            );
            header("HTTP/1.1 200 OK");
            echo json_encode($response);
        } else {
            header("HTTP/1.1 500 ERROR");
            $msg = array("message"=>"No se encontraron recintos para la instalación.");
            echo json_encode($msg);
        }
    }
?>