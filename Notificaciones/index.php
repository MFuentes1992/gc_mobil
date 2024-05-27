<?php 
  require_once $_SERVER['DOCUMENT_ROOT']."/service/DBService.php";
  require_once $_SERVER['DOCUMENT_ROOT']."/model/NotificacionesModel.php";
  require_once $_SERVER['DOCUMENT_ROOT']."/constants/constants.php";
  require_once $_SERVER['DOCUMENT_ROOT']."/util/index.php";

  $urlPayload = $_POST;

  if(isset($urlPayload["code"]) && isset($urlPayload["idRecinto"]) && isset($urlPayload["titulo"]) && isset($urlPayload["descripcion"])) {
    $dbService = new DBService($dbUrl, $dbUser, $dbPass, $dbName, $urlPayload["code"]); 
    $dbRes = $dbService->connectToAdmin();       
    $clientDB = $dbRes->fetch_array();
    $clientDBName = $dbPrefix.'_'.$clientDB['datos'];
    $clientDBUser = $dbPrefix.'_'.$clientDB['usuario'];
    $cliendDBAccesso = $clientDB['acceso'];
    $dbService->closeConnection();
    // -- Connect to selected DB
    $notifModel = new Notificaciones($dbUrl, $clientDBUser, $cliendDBAccesso, $clientDBName);
    // -- Get devices by recinto
    $res = $notifModel->getDevicesByRecinto($urlPayload["idRecinto"]);
    $devicesArr = array();
    while($row = $res->fetch_array()) {
        array_push($devicesArr, array(
            $row["deviceId"]
        ));
    }
    if(count($devicesArr) == 0) {
      header("HTTP/1.1 400 ERROR");
      $response = array(
        "status"=>"ERROR",
        "message"=>"No registered devices found"
      );
      echo json_encode($response);
    }
    // -- Send notificaciones to all devices by recinto
    $url = "https://fcm.googleapis.com/v1/projects/".$fcmProjectId."/messages:send";
    $accessToken = getGoogleAuthToken('../credenciales/gc_fcm_credentials.json')->access_token;
    $headers = array( "Authorization: Bearer ".$accessToken.""
    ,"content-type: application/json;UTF-8");

    $notification = array(
      "title" => $urlPayload["titulo"],
      "body" => $urlPayload["descripcion"]
    );

    $ch = curl_init();
    $logArr = array();
    foreach($devicesArr as $device){
      $fields = array(
        "message"=>array(
        "token" => $device[0],
        "notification" => $notification
        )
      );
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
      $curl_res = curl_exec($ch);
      if($curl_res) {
        array_push($logArr, array(
          "device"=>$device,
          "status"=>"Ok",
          "notification"=>"sent",
        ));
      } else {
        array_push($logArr, array(
          "device"=>$device,
          "status"=>"Failed",
          "notification"=>"No"
        ));
      }
    }
    curl_close($ch);
    header("HTTP/1.1 200 OK");
    $response = array(
      "status"=>"Ok",
      "message"=>"API attempt to sent a notification to the following devices",
      "logs"=>$logArr
    );
    echo json_encode($response);
    

  } else {
    header("HTTP/1.1 400 ERROR");
    $response = array(
      "status"=>"ERROR",
      "message"=>"Please provide all required fields"
    );
    echo json_encode($response);
  }
  

?>
