<?php

header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
date_default_timezone_set('America/Bogota');

include_once(realpath(dirname(__FILE__) . '/../model/classes/Matter.php'));
include_once(realpath(dirname(__FILE__) . '/../model/classes/Headquarter.php'));
include_once(realpath(dirname(__FILE__) . '/../model/classes/Ubication.php'));
include_once(realpath(dirname(__FILE__) . '/../model/classes/Tutorial.php'));

$action=isset($_REQUEST['action'])?$_REQUEST['action']:0;
$response;

try {
    switch ($action) {
        case 1:
            $request_body = file_get_contents('php://input',1);
            $dataRequest=isset($request_body)? json_decode($request_body):null;
            $response= getMattersXUser($dataRequest);
            break;
        
        case 2:
            $request_body = file_get_contents('php://input',1);
            $dataRequest=isset($request_body)? json_decode($request_body):null;
            $response= getHeadquarters($dataRequest);
            break;
          
        case 3:
            $request_body = file_get_contents('php://input',1);
            $dataRequest=isset($request_body)? json_decode($request_body):null;
            $response= getUbications($dataRequest);
            break;
        
        case 4:
            $request_body = file_get_contents('php://input',1);
            $dataRequest=isset($request_body)? json_decode($request_body):null;
            $response= createTutorial($dataRequest);
            break;

        default:
            $response['status']=401;
            $response['message']='Acción no autorizada.';
            break;
    }
} catch (Exception $exc) {
    $response['status']=400;
    $response['message']='Error inesperado en el controlador';
} finally {
    echo json_encode($response);
}

function getMattersXUser($request){
    try {
        $response['status']=400;
        if(!isset($request->idUser) ){
            $response['message']="Datos no obtenidos.";
        }else{
            $objMatter=new Matter();
            $data=$objMatter->getMatterXUser($request->idUser);
            if(empty($data)){
                $response['message']="El estudiante o profesor no tiene asociadas materias a su carrera.";
            }else{
                $response['status']=200;
                $response['data']=$data;
            }
        }
        return $response;
    } catch (Exception $exc) {
        $response['status']=400;
        $response['message']='Error inesperado al  momento validar el usuario.';
        return $response;
    } 
}

function getHeadquarters($request){
    try {
        $response['status']=400;
        if(!isset($request->datum) ){
            $response['message']="Datos no obtenidos.";
        }else{
            $obj=new Headquarter();
            $data=$obj->getHeadquartersXCity($request->datum);
            if(empty($data)){
                $response['message']="Sedes no encontradas.";
            }else{
                $response['status']=200;
                $response['data']=$data;
            }
        }
        return $response;
    } catch (Exception $exc) {
        $response['status']=400;
        $response['message']='Error inesperado al  momento validar el usuario.';
        return $response;
    } 
}

function getUbications($request){
    try {
        $response['status']=400;
        if(!isset($request->datum) ){
            $response['message']="Datos no obtenidos.";
        }else{
            $obj=new Ubication();
            $data=$obj->getUbicationsXHeadquarter($request->datum);
            if(empty($data)){
                $response['message']="Sedes no encontradas.";
            }else{
                $response['status']=200;
                $response['data']=$data;
            }
        }
        return $response;
    } catch (Exception $exc) {
        $response['status']=400;
        $response['message']='Error inesperado al  momento validar el usuario.';
        return $response;
    } 
}

function createTutorial($request){
    try {
        $response['status']=400;
        if(!isset($request->idUser) ){
            $response['message']="Datos no obtenidos.";
        }else{
            $obj=new Tutorial();
            $data=$obj->createTutorial($request->idUser,$request->idMatter, $request->idUbication, $request->dateTutorial, $request->hourTutorial, $request->quota );
            if(empty($data)){
                $response['message']="No se pudo registrar la tutoria.";
            }else{
                $response['status']=200;
                $response['message']="Tutoria creada.";
                $response['data']=$data;
            }
        }
        return $response;
    } catch (Exception $exc) {
        $response['status']=400;
        $response['message']='Error inesperado al  momento crear la tutoria.';
        return $response;
    } 
}

