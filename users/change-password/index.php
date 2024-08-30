<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . "/service/UserService.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/constants/constants.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/sessionManager/SessionManager.php"; 
    session_start();
    $previousPassword = $_POST["previousPassword"];
    $userEmail = $_POST["email"];
    $newPassword = $_POST["newPassword"];
    if (isset($userEmail) && isset($newPassword) && isset($previousPassword)) {
        $session = new SessionManager();
        $connValues = $session->getSession("userConn");
        $userService = new UserService($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
        $raw = $userService->getUserByEmail($userEmail);
        $currUser = $raw->fetch_array();
        if($currUser && password_verify($previousPassword, $currUser['password'])) {
            $res = $userService->changePassword($userEmail, $newPassword);
            if ($res) {
                $response = array(
                    "status" => "OK",
                    "message" => "La contraseña fue cambiada con éxito."
                );
                echo json_encode($response);
            } else {
                header("HTTP/1.1 400 ERROR");
                $response = array(
                    "status" => "ERROR",
                    "message" => "No se cambió la contraseña, es necesario contactar al administrador."
                );
                echo json_encode($response);
            }
        } else {
            header("HTTP/1.1 400 ERROR");
            $response = array(
                "status" => "ERROR",
                "message" => "No se cambió la contraseña debido a que la contraseña actual no fue ingresada correctamente."
            );
            echo json_encode($response);
            exit();
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