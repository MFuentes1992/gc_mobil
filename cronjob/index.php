<?php 
  require_once $_SERVER['DOCUMENT_ROOT']."/service/DBService.php";
  require_once $_SERVER['DOCUMENT_ROOT']."/constants/constants.php";
  
  $dbService = new DBService($dbUrl, $dbUser, $dbPass, $dbName); 
  $dbRes = $dbService->getAllAdminRecords();
  $resArr = array();
  while($row = $dbRes->fetch_array()){
    $dbUserName = $dbPrefix."_".$row["datos"];
    $dbAcceso = $row["acceso"];
    $dbTempService = new DBService($dbUrl, $dbUserName, $dbAcceso, $dbUserName);
    $executor = $dbTempService->getDBObject();
    $query = sprintf("CALL expire_visita()");
    $res = $executor->execQuery($query);
    if(!$res) {
      header("HTTP/1.1 500 ERROR");
      echo json_encode(array("mensaje" => "La llamada al SP fallo para".$row["datos"], "codigo"=>"400"));
    } 
    array_push($resArr, array(
      "datos" => $row["datos"],
      "acceso" => $row["acceso"],
      "codigo" => $row["codigo"],
      "SP_executed" => $res,
    ));
  }
  header("HTTP/1.1 200 OK");
  echo json_encode($resArr);
?>
