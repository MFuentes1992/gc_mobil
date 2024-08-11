<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . "/model/UserModel.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/constants/constants.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php"; 
    session_start();
    $userEmail = $_GET["email"];
    if (isset($userEmail)) {
        $session = new SessionManager();
        $connValues = $session->getSession("userConn");
        $usersModel = new UserModel($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
        $res = $usersModel->getProfiles($userEmail);
        $profilesArr = array();
        while ($row = $res->fetch_array()) {
            array_push($profilesArr, array(
                "id_profile" => $row["id_profile"],  
                "foto" => $row["foto"]           
            ));
        }
        $response = array(
            "status" => "OK",
            "result" => $profilesArr
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