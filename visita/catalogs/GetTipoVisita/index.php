<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/model/VisitaCatalogsModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/constants/constants.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php"; 
    session_start();
    $session = new SessionManager();
    $connValues = $session->getSession("userConn");
    $model = new VisitaCatalogs($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
    $res = $model->getAllTipoVisita();
    if($res) {
        $resArr = array();
        while($row = $res->fetch_array()) {
            array_push($resArr, array(
                "id" => $row["id"],
                "tipo_visita" => $row["tipo_visita"],
                "descripcion" => $row["descripcion"],
            ));
        }
        header("HTTP/1.1 200 OK");
        echo json_encode($resArr);
    }
?>