<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . "/model/UserModel.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/constants/constants.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/sessionManager/SessionManager.php"; 
    session_start();
    $userEmail = $_POST["email"];
    $newPassword = $_POST["newPassword"];
    if (isset($userEmail) && isset($newPassword)) {
        $session = new SessionManager();
        $connValues = $session->getSession("userConn");
        $usersModel = new UserModel($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $res = $usersModel->changePassword($userEmail, $hashedPassword);
        if ($res) {
            $response = array(
                "status" => "OK",
                "message" => "Contraseña cambiada correctamente"
            );
            echo json_encode($response);
        } else {
            header("HTTP/1.1 400 ERROR");
            $response = array(
                "status" => "ERROR",
                "message" => "Error al cambiar la contraseña"
            );
            echo json_encode($response);
        }
    } else {
        header("HTTP/1.1 400 ERROR");
        $response = array(
            "status" => "ERROR",
            "message" => "Parámetros incorrectos"
        );
        echo json_encode($response);
    }
?>