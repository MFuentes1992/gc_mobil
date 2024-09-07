<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/model/VisitaModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php";
    session_start();
    $query = $_GET;
    if(isset($query["uniqueId"])) {
        $session = new SessionManager();
        $connValues = $session->getSession("userConn");
        $model = new Visit($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
        $res = $model->getVisitaById($query["uniqueId"]);
        if($res && $res->num_rows > 0) {
            $row = $res->fetch_array();
            header("HTTP/1.1 200 OK");
            echo json_encode($row); 
        } else {
            header("HTTP/1.1 500 ERROR");
            $msg = array("estatus"=> "400", "message"=>"No se pudo obtener la visita.");
            echo json_encode($msg);    
        }
    } else {
        header("HTTP/1.1 400 ERROR");
        $msg = array("estatus"=> "400", "message"=>"Algo salió mal.");
        echo json_encode($msg);    
    }

?>