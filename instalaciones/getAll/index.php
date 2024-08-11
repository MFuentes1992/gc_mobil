<?php
require_once $_SERVER['DOCUMENT_ROOT']."/model/InstalacionesModel.php";
require_once $_SERVER['DOCUMENT_ROOT']."/constants/constants.php";
require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php"; 
session_start();
$query = $_GET;
$session = new SessionManager();
$connValues = $session->getSession("userConn");
$model = new InstalacionesModel($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
$res = $model->getAllInstalaciones($query["ids"]);
if($res) {    
    $arr = array();
    while($row = $res->fetch_array()) {
        array_push($arr, $row);        
    }
    header("HTTP/1.1 200 OK");
    echo json_encode($arr);
} else {
    header("HTTP/1.1 500 ERROR");
    $msg = array("message"=>"No se encontraron instalaciones para el usuario.");
    echo json_encode($msg);
}
?>