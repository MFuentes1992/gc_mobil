<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . "/model/NotificacionesModel.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/constants/constants.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php"; 
    session_start();
    $recintoId = $_GET["recintoId"];
    if (isset($recintoId)) {
        $session = new SessionManager();
        $connValues = $session->getSession("userConn");
        $notifModel = new Notificaciones($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
        $res = $notifModel->getAvisosByRecinto($recintoId);
        $avisosArr = array();
        while ($row = $res->fetch_array()) {
            array_push($avisosArr, array(
                "id" => $row["id"],
                "titulo" => $row["titulo"],
                "descripcion" => $row["contenido"],
                "fecha" => $row["fecha_envio"]
            ));
        }
        $response = array(
            "status" => "OK",
            "avisos" => $avisosArr
        );
        echo json_encode($response);
    } else {
        header("HTTP/1.1 400 ERROR");
        $response = array(
            "status" => "ERROR",
            "message" => "Missing recintoId"
        );
        echo json_encode($response);
    }

?>