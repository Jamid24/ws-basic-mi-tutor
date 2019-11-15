<?php
include_once(realpath(dirname(__FILE__) . '/../Conection.php'));

class User {
    private $conectDb;
    
    public $idUser;
    public $idProfile;
    public $names;
    public $surnames;
    public $idTypeIdentification;
    public $codeTypeIdentification;
    public $numberIdentification;
    public $codeTypePerson;
    public $idInstitution;
    public $codeUserInstitution;
    public $emailInstitucional;
    public $emailPersonal;
    public $password;
    public $isActive;

     public function getUserByCode($code){
        $this->conectDb=new Conection(); 
        $sql = "SELECT * FROM public.user_app WHERE code_user_institution='".$code."';";
        $query = $this->conectDb->getConexion()->prepare($sql);
        $query ->execute();
        return $query ->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getUserByCodePassw($code, $pass){
        $this->conectDb=new Conection(); 
        $sql = "SELECT * FROM public.user_app WHERE code_user_institution='".$code."' and password='".  md5($pass)."';";
        $query = $this->conectDb->getConexion()->prepare($sql);
        $query ->execute();
        return $query ->fetch(PDO::FETCH_ASSOC);
    }
    
    public function addUser(){
        $this->conectDb=new Conection(); 
        $sql = "INSERT INTO public.user_app
            (id_profile, names, surnames, id_type_identification, code_type_identification, number_identification
                ,code_type_person, id_institution, code_user_institution, email_institucional, password)
            VALUES(".$this->idProfile.", '".$this->names."', '".$this->surnames."', ".$this->idTypeIdentification.""
            . ", '".$this->codeTypeIdentification."', '".$this->numberIdentification."', '".$this->codeTypePerson."'"
            . ", ".$this->idInstitution.", '".$this->codeUserInstitution."', '".$this->emailInstitucional."'"
            . ", '".$this->password."') returning id_user;";
        $query = $this->conectDb->getConexion()->prepare($sql);
        $query ->execute();
        return $query ->fetch(PDO::FETCH_ASSOC);
    }
}
