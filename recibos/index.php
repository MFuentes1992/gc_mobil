<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . "/model/RecibosModel.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/constants/constants.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php"; 
    session_start();
    $residenteId = $_GET["residenteId"];
    $instalacionId = $_GET["instalacionId"];
    $recintoId = $_GET["recintoId"];
    if (isset($residenteId) && isset($instalacionId) && isset($recintoId)) {
        $session = new SessionManager();
        $connValues = $session->getSession("userConn");
        $recibosModel = new Recibos($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
        $res = $recibosModel->getRecibosByInstalacionResidente($residenteId, $instalacionId, $recintoId);
        $attachmentsArr = array();
        while ($row = $res->fetch_array()) {
            array_push($attachmentsArr, array(
                "id" => $row["id"],
                "nombre" => $row["archivo"],
                "fecha" => $row["fecha_elaboracion"],
                "folio" => $row["folio"],              
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
            "message" => "Parámetros incorrectos"
        );
        echo json_encode($response);
    }

?>