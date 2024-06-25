<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . "/model/NotificacionesModel.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/constants/constants.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php"; 
    session_start();
    $avisoId = $_GET["avisoId"];
    if (isset($avisoId)) {
        $session = new SessionManager();
        $connValues = $session->getSession("userConn");
        $notifModel = new Notificaciones($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
        $res = $notifModel->getAvisosAttachments($avisoId);
        $attachmentsArr = array();
        while ($row = $res->fetch_array()) {
            array_push($attachmentsArr, array(
                "id" => $row["id"],
                "nombre" => $row["archivo"],                
            ));
        }
        $response = array(
            "status" => "OK",
            "attachments" => $attachmentsArr
        );
        echo json_encode($response);
    } else {
        header("HTTP/1.1 400 ERROR");
        $response = array(
            "status" => "ERROR",
            "message" => "Missing avisoId"
        );
        echo json_encode($response);
    }

?>