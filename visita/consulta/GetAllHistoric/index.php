<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/model/VisitaModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/constants/constants.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php"; 
    session_start();
    $query = $_GET;
    if(!isset($query['idInstalacion']) || !isset($query['email'])) {
      header("HTTP/1.1 400 ERROR");
      $msg = array("estatus"=> "400", "message"=>"Ingresa la instalacion o el email");
      echo json_encode($msg);    
      return;
    }

    $session = new SessionManager();
    $connValues = $session->getSession("userConn");
    $model = new Visit($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
    $res = $model->getAllHistoric(intval($query['idInstalacion']), $query["email"]);

    if($res) {
        $responseArr = array();
        
      while($row = $res->fetch_array()) {
          $resVehicles = $model->getVehiclesByVisit($row['uniqueID']);
    
            $vehicles = array();
            if($res && $res->num_rows > 0) {
            while($rowV = $resVehicles->fetch_array()) {
                array_push($vehicles, array(
                    "placas" => $rowV["placas"],
                ));
            }
          }
          array_push($responseArr, array(
          "idvisita" => $row['uniqueID'],
          "fechaVisita" => $row['hasta'],
          "horaVisita" => explode ("T", $row['hasta'])[1],
          "tipoVisita" => $row['tipo_visita'],
          "tipoIngreso" => $row['tipo'],
          "emailAutor" => $row['emailAutor'],
          "casa" => $row['seccion'] . "" . $row['num_int'],
          "status" => $row['status'],
          "vehiculos" => $vehicles,
          ));
        }
        header("HTTP/1.1 200 OK");
        echo json_encode($responseArr);
    } else {
      header("HTTP/1.1 400 ERROR");
      $msg = array("estatus"=> "400", "message"=>"Something went wrong");
      echo json_encode($msg);    
    }
?>
