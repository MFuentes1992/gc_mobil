<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . "/model/UserModel.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/constants/constants.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/sessionManager/SessionManager.php"; 
    session_start();
    $instalacion = $_GET["instalacion"];
    if(isset($instalacion)) {
        $session = new SessionManager();
        $connValues = $session->getSession("userConn");
        $usersModel = new UserModel($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
        $res = $usersModel->getInstalacionEquity($instalacion);
        $saldo_total = 0;
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $saldo_total = $row["monto_disponible"];
            }        
            $response = array(
                "status" => "OK",
                "message" => "Deuda obtenida correctamente",
                "equity" => $saldo_total
            );
            echo json_encode($response);
        } else {
            header("HTTP/1.1 400 ERROR");
            $response = array(
                "status" => "ERROR",
                "message" => "Error al obtener la deuda"
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