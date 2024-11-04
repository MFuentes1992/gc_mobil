<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/service/VisitaService.php";

    session_start();
    if(isset($_POST["id"])) {
        $service = new VisitaService();
        $res = $service->deletePedestrian(intval($_POST["id"]));
        if($res) {
            header("HTTP/1.1 200 OK");
            $msg = array("estatus"=> "200", "message"=>"Pedestrian removed successfully");
            echo json_encode($msg); 
        } else {
            header("HTTP/1.1 400 ERROR");
            $msg = array("estatus"=> "400", "message"=>"Something went wrong");
            echo json_encode($msg);    
        }
    } else {
        header("HTTP/1.1 400 ERROR");
        $msg = array("estatus"=> "400", "message"=>"Missing parameters");
        echo json_encode($msg);    
    }

?>