<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/model/VisitaModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/constants/constants.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php"; 
    session_start();
    $query = $_GET;
    $session = new SessionManager();
    $connValues = $session->getSession("userConn");
    $model = new Visit($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
    $res = $model->getAllvisitByOwner($query["email"]);
    if($res) {
        header("HTTP/1.1 200 OK");
        while($row = $res->fetch_array()) {
            echo json_encode($row);
        }
    }
?>