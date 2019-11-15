<?php
echo "Entro controller:".realpath(dirname(__FILE__) ;
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
date_default_timezone_set('America/Bogota');

require_once(realpath(dirname(__FILE__) . '/../model/classes/PersonEcci.php'));
require_once(realpath(dirname(__FILE__) . '/../config/config.php'));

$action=isset($_REQUEST['action'])?$_REQUEST['action']:0;
$response;

try {
    switch ($action) {
        case 1:
            $request_body = file_get_contents('php://input',1);
            $dataRequest=isset($request_body)? json_decode($request_body):null;
            $response= processLogin($dataRequest);
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

function processLogin($request){
    try {
        $response=[];
        $response['SERVER']=$_SERVER['SERVER_NAME'];
        $response['dbserver']=DB_SERVER;
        if(!isset($request->codePerson)){
            $response['status']=400;
            $response['message']="Datos no obtenidos.";
        }else{
            $person=new PersonEcci();
            $data=$person->getPersonEcci($request->codePerson);
            if(empty($data)){
                $response['status']=400;
                $response['message']="El estudiante o profesor no está registrado en la institución.";
            }else{
                if(!$data['is_active']){
                    $response['status']=400;
                    $response['message']="El estudiante o profesor está inactivo en la institución.";
                }else{
                    $response['status']=200;
                    $response['data']=$data;
                }
            }
        }
    } catch (Exception $exc) {
        $response['status']=400;
        $response['message']='Error inesperado al  momento validar el usuario.';
    } finally {
        return $response;
    }
}
