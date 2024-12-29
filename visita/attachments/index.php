<?php
    /**
     * Filename: visita_uniqueId + id_vehiculo + (attachment_img_uri) + file_extension
     *  */ 
    require_once $_SERVER['DOCUMENT_ROOT']."/service/VisitaService.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/model/ImageUrlModel.php";
    session_start();
    if(isset($_POST["uniqueId"])){        
        $uniqueId = $_POST['uniqueId'];
        $idVehiculo = $_POST['idVehiculo'];
        $idPedestrian = $_POST['idPeaton'];
        $tipoEvidencia = $_POST['tipoEvidencia'];

        if(!isset($uniqueId) || !isset($tipoEvidencia) || (!isset($idVehiculo) && !isset($idPedestrian))){
            header("HTTP/1.1 400 ERROR");
            echo json_encode(array("error" => "Por favor, agregue los parametros necesarios"));
            return;
        }

        $service = new VisitaService();
        $generalPath = $_SERVER['DOCUMENT_ROOT']. "/uploads/";
        $fileArraySize = sizeof($_FILES);
        $successCounter = 0;
        $imageUrlArray = array();
        var_dump($_FILES);
        foreach($_FILES as $file){
            $fileName = $uniqueId."_". $idVehiculo."_" ."attachment_". $file['name'];
            $path = $generalPath . $fileName;
            $created = move_uploaded_file($file['tmp_name'], $path);
            if($created){
                $successCounter++;
                array_push($imageUrlArray, new ImageUrlModel($tipoEvidencia, isset($idVehiculo) ? $idVehiculo : $idPedestrian, "uploads/".$fileName));
            }
        }        
        
        if($successCounter != $fileArraySize){
            header("HTTP/1.1 400 ERROR");
            echo json_encode(array("error" => "Error al subir el archivo"));
        } else {            
            $dbSaved = $service->saveImageAttached($imageUrlArray);
            if($dbSaved){
                header("HTTP/1.1 200 ERROR");
                $res = array("message" => "Archivos guardados correctamente", "path" => "uploads/", "code" => 200);
                echo json_encode($res);
            } else {
                header("HTTP/1.1 400 ERROR");
                $res = array("message" => "Error al guardar en la base de datos", "code" => 400);
                echo json_encode($res);
            }
        }
    } else if(isset($_GET["id"])) {
        $service = new VisitaService();
        $id = $_GET['id'];        
        $images = $service->removeAttachedImage($id);
        if($images){
            header("HTTP/1.1 200 OK");
            $msg = array("message" => "Imagen eliminada correctamente", "code" => 200);
            echo json_encode($msg);
        } else {
            header("HTTP/1.1 400 ERROR");
            echo json_encode(array("error" => "Error al eliminar las imagenes"));
        }
    }

?>