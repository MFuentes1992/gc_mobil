<?php 
  require_once $_SERVER['DOCUMENT_ROOT']."/service/DBService.php";
  require_once $_SERVER['DOCUMENT_ROOT']."/constants/constants.php";
  
  $dbService = new DBService($dbUrl, $dbUser, $dbPass, $dbName); 
  $dbRes = $dbService->getAllAdminRecords();
  $resArr = array();
  while($row = $dbRes->fetch_array()){
    $dbUserName = $dbPrefix."_".$row["usuario"];
    $dbAcceso = $row["acceso"];
    $dbTempName = $dbPrefix."_".$row["datos"];
    $dbTempService = new DBService($dbUrl, $dbUserName, $dbAcceso, $dbTempName);
    $executor = $dbTempService->getDBObject();
    $query = sprintf("CALL expire_visita()");
    $res = $executor->execQuery($query);
    array_push($resArr, array(
      "datos" => $row["datos"],
      "usuario" => $row["usuario"],
      "acceso" => $row["acceso"],
      "codigo" => $row["codigo"],
      "SP_executed" => $res,
    ));
  }
  header("HTTP/1.1 200 OK");
  echo json_encode($resArr);
?>
