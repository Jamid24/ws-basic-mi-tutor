<?php

header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
date_default_timezone_set('America/Bogota');

include_once(realpath(dirname(__FILE__) . '/../model/classes/PersonEcci.php'));
include_once(realpath(dirname(__FILE__) . '/../model/classes/User.php'));
include_once(realpath(dirname(__FILE__) . '/../model/classes/Career.php'));

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
        if(!isset($request->codePerson) || !isset($request->passw) || !isset($request->idInstitution)){
            $response['status']=400;
            $response['message']="Datos no obtenidos.";
            return $response;
        }else{
            $person=new PersonEcci();
            $data=$person->getPersonEcci($request->codePerson);
            if(empty($data)){
                $response['status']=400;
                $response['message']="El estudiante o profesor no está registrado en la institución.";
                return $response;
            }else{
                if(!$data['is_active']){
                    $response['status']=400;
                    $response['message']="El estudiante o profesor está inactivo en la institución.";
                    return $response;
                }else{
                    return getUserMiTutor($data, $request->passw, $request->idInstitution);
                }
            }
        }
    } catch (Exception $exc) {
        $response['status']=400;
        $response['message']='Error inesperado al  momento validar el usuario.';
        return $response;
    } 
}


function getUserMiTutor($dataPerson, $passw, $idInstitution){
    $response=[];
    $response['status']=200;
    
    $userApp=new User();
    $objUser=$userApp->getUserByCodePassw($dataPerson['code_ecci'], $passw);
    if(!empty($objUser)){
        if(!$objUser['is_active']){
            $response['status']=400;
            $response['message']='Usuario inactivo en la plataforma Mi Tutor.';
        } else {
            $response['data']=$objUser;   
        }
    }else{
        if($userApp->getUserByCode($dataPerson['code_ecci'])){
            $response['status']=400;
            $response['message']='Password incorrecto.';
        }else{
            $userApp->idProfile=($dataPerson['code_type_person']=="STUD")?1:2;  
            $userApp->names=$dataPerson['names'];  
            $userApp->surnames=$dataPerson['surnames'];  
            $userApp->idTypeIdentification=$dataPerson['id_type_identification'];  
            $userApp->codeTypeIdentification =$dataPerson['code_type_identification'];  
            $userApp->numberIdentification =$dataPerson['number_identification'];  
            $userApp->codeTypePerson=$dataPerson['code_type_person'];  
            $userApp->idInstitution=$idInstitution;  
            $userApp->codeUserInstitution=$dataPerson['code_ecci'];  
            $userApp->emailInstitucional=$dataPerson['email_institucional'];  
            $userApp->password= md5($dataPerson['number_identification']);  

            $result=$userApp->addUser();
            $objCareer=new Career();
            $career=$objCareer->getCareer($dataPerson['code_career']);
            $objCareer->addCareerUser($result['id_user'], $career['id_career']);
            
            $response['data']=$userApp->getUserByCodePassw($userApp->codeUserInstitution, $userApp->numberIdentification);
        }
    }
    return $response;
    
}