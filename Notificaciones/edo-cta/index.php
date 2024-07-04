<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/NotificacionesModel.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/constants/constants.php";
require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php"; 
session_start();
$instalacionId = $_GET["instalacion"];
$residenteId = $_GET["residente"];
if (isset($instalacionId) && isset($residenteId)) {
    $session = new SessionManager();
    $connValues = $session->getSession("userConn");
    $notifModel = new Notificaciones($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
    $res = $notifModel->getEstadosCuenta($residenteId, $instalacionId);
    $avisosArr = array();
    while ($row = $res->fetch_array()) {
        array_push($avisosArr, array(
            "id" => $row["id"],
            "titulo" => "Estado de cuenta - ".$row["mes_envio"],
            "path" => $row["archivo"],
            "fecha" => $row["fecha_procesado"]
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
        "message" => "Missing params"
    );
    echo json_encode($response);
}
?>