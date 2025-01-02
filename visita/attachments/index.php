<?php
    /**
     * Filename: visita_uniqueId + id_vehiculo + (attachment_img_uri) + file_extension
     *  */ 
    require_once $_SERVER['DOCUMENT_ROOT']."/service/VisitaService.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/model/ImageUrlModel.php";
    session_start();
    if(isset($_POST["id"])) {        
        $id = $_POST['id'];
        if( !isset($id) ){
            header("HTTP/1.1 400 ERROR");
            echo json_encode(array("error" => "Por favor, agregue los parametros necesarios"));
            return;
        }
        $service = new VisitaService();
        $generalPath = $_SERVER['DOCUMENT_ROOT']. "/uploads/";
        $fileArraySize = sizeof($_FILES);
        $successCounter = 0;
        $imageUrlArray = array();  
              
        foreach($_FILES as $file){
            $index = strchr($file['name'], ".");
            $extension = substr($index, 1);
            $fileName = "tmp_".$id."_".$successCounter.".".$extension;
            $path = $generalPath . $fileName;
            
            $created = move_uploaded_file($file['tmp_name'], $path);
            if($created){
                $successCounter++;                
            }
        }        
        
        if($successCounter != $fileArraySize){
            header("HTTP/1.1 400 ERROR");
            echo json_encode(array("error" => "Error al subir el archivo"));
        } else {            
            $res = array("message" => "Archivos guardados correctamente", "path" => "uploads/", "code" => 200);
            echo json_encode($res);
        }
    } else if(isset($_GET["uri"])) {
        $service = new VisitaService();
        $uri = $_GET['uri'];        
        $images = $service->removeAttachedImage($uri);
        if($images){
            unlink($_SERVER['DOCUMENT_ROOT']."/".$uri);
            header("HTTP/1.1 200 OK");
            $msg = array("message" => "Imagen eliminada correctamente", "code" => 200);
            echo json_encode($msg);
        } else {
            header("HTTP/1.1 400 ERROR");
            echo json_encode(array("error" => "Error al eliminar las imagenes"));
        }
    }

?>