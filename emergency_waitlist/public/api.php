<?php

require_once('_config.php');

use DBmanager\DBmanager;

$dbmanager = new DBmanager();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullPath = $_GET["path"];
    $path = explode("/", $fullPath);
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);
    $reply;
    switch($fullPath){
        case "/validate/admin":
            $reply = $dbmanager->validateAdmin($data);
            if($reply != false){
                http_response_code(200);
                echo("/admin.php"); //redirect to page
            }
            break;
        case "/validate/patient":
            $reply = $dbmanager->validatePatient($data);
            if($reply != false){
                $reply += ["page" => "patient.php"];
                $json = json_encode($reply);
                http_response_code(200);
                echo($json); //redirect to page
            }
            break;
        case "/insert/patient":
            $reply = $dbmanager->insertPatient($data);
            if($reply != false){
                http_response_code(200);
                echo("/patient.php"); //redirect to page
            }
            break;
        case "/fetch/waitlist/ordered/time":
            $reply = $dbmanager->getOrderedWaitlistByTime();
            if($reply != NULL){
                $json = json_encode($reply);
                header("Content-Type: application/json");
                echo ($json);
            }
            break;
        case "/fetch/all/patients":
            $reply = $dbmanager->getAllPatients();
            if($reply != NULL){
                $json = json_encode($reply);
                header("Content-Type: application/json");
                echo ($json);
            }
            break;
        case "/fetch/waitlist/ordered/severity":
            $reply = $dbmanager->getOrderedWaitlistBySeverity();
            if($reply != NULL){
                $json = json_encode($reply);
                header("Content-Type: application/json");
                echo ($json);
            }
            break;
        case "/fetch/wait/time":
            $reply = $dbmanager->getApproximateWaitTime();
            if($reply != NULL){
                $json = json_encode($reply);
                header("Content-Type: application/json");
                echo ($json);
            }
            break;
    }
    
    if($reply == false){
        http_response_code(404);
        echo("/index.php"); //redirect to page
    }
}


