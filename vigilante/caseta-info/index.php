<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/service/VigilantesService.php"; 

    //GET_CONTROLLER
    if(isset($_GET)) {
        $query = $_GET["activation_code"];
        if(isset($query)){
            $service = new VigilanteService();
            $res = $service->getInfoCaseta($query);
            if($res == null) {
                echo json_encode(array("status" => "400", "message" => "No se encontraron resultados"));
                return;
            }
            $resArr = array();
            while($row = $res->fetch_array()) {
                array_push($resArr, array("residenceMobile" => $row["numero_celular"], 
                "residencePhone" => $row["numero_telefono"], 
                "residenceExt" => $row["extension_telefono"], 
                "residenceName" => $row["nombre"], 
                "logoUrl" => $row["logo"], 
                "residenceAddress" => $row["direccion"]));
            }
            header("HTTP/1.1 200 OK");
            echo json_encode($resArr);
        }
    } else if(isset($_POST)) {
        // Do something
    } else {
        echo json_encode(array("status" => "400", "message" => "Method not allowed"));
    }

?>