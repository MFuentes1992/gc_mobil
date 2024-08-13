<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/model/InstalacionesModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/constants/constants.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php"; 
    session_start();
    $query = $_GET;
    $session = new SessionManager();
    $connValues = $session->getSession("userConn");
    $model = new InstalacionesModel($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
    $res = $model->getInstalacionesReferenciaPago($query["instalacionId"]);
    if($res) {    
        $arr = array();
        while($row = $res->fetch_array()) {
            array_push($arr, array(
                "referencia_concepto"=>$row["referencia_concepto"],
                "referencia_centavos"=>$row["referencia_centavos"],
                "referencia_bancaria"=>$row["referencia_bancaria"]
            ));        
        }
        $response = array(                
        "status" => "OK",
        "result" => $arr);
        header("HTTP/1.1 200 OK");
        echo json_encode($response);
    } else {
        header("HTTP/1.1 500 ERROR");
        $msg = array("message"=>"No se encontraron instalaciones para el usuario.");
        echo json_encode($msg);
    }
?>