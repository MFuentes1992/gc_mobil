<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/model/VisitaModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php";
    session_start();
    $query = $_GET;
    if(isset($query["qr"])) {
        $session = new SessionManager();
        $connValues = $session->getSession("userConn");
        $model = new Visit($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
        $res = $model->getVehiclesByVisit($query["qr"]);
        if($res) {
            $resArr = array();
            while($row = $res->fetch_array()) {
                array_push($resArr, array(
                    "vehicle_id"=> $row["vehicle_id"],
                    "conductor" => $row["conductor"],
                    "marca" => $row["marca"],
                    "modelo" => $row["modelo"],
                    "anio" => $row["anio"],
                    "placas" => $row["placas"],
                    "color" => $row["color"],
                ));
            }
            header("HTTP/1.1 200 OK");
            echo json_encode($resArr);
        } else {
            header("HTTP/1.1 400 ERROR");
            $msg = array("estatus"=> "400", "message"=>"Something went wrong");
            echo json_encode($msg);    
        }
    } else {
        header("HTTP/1.1 400 ERROR");
        $msg = array("estatus"=> "400", "message"=>"Something went wrong");
        echo json_encode($msg);    
    }
?>