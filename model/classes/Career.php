<?php

include_once(realpath(dirname(__FILE__) . '/../Conection.php'));

class Career {
    private $conectDb;
    
    public $idUser;
    public $idProfile;
    public $names;
    
    public function getCareer($code){
        $this->conectDb=new Conection(); 
        $sql = "SELECT * FROM public.career WHERE code_career='".$code."';";

        $query = $this->conectDb->getConexion()->prepare($sql);
        $query ->execute();
        return $query ->fetch(PDO::FETCH_ASSOC);
    }
    
    public function addCareerUser($idUSer, $idCareer){
        $this->conectDb=new Conection(); 
        $sql = "INSERT INTO public.career_x_user(id_user, id_career)
            VALUES(".$idUSer.", ".$idCareer.") returning is_active;";
        $query = $this->conectDb->getConexion()->prepare($sql);
        $query ->execute();
        return $query ->fetch(PDO::FETCH_ASSOC);
    }
}
