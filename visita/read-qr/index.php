<?php     
    require_once $_SERVER['DOCUMENT_ROOT']."/model/VisitaModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php";
    session_start();
    $query = $_GET;
    if(isset($query["qr"])) {
        $session = new SessionManager();
        $connValues = $session->getSession("userConn");
        $model = new Visit($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
        $res = $model->readQR($query["qr"]);
        if($res) {
            header("HTTP/1.1 200 OK");
            echo json_encode($res->fetch_array()); 
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