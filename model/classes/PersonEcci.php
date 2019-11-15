<?php

include_once(realpath(dirname(__FILE__) . '/../Conection.php'));

class PersonEcci {
    private $conectDb;
    
    public function getPersonEcci($codePerson){
        $this->conectDb=new Conection(); 
        $sql = "SELECT * FROM public.person_ecci WHERE code_ecci='".$codePerson."';";

        $query = $this->conectDb->getConexion()->prepare($sql);
        $query ->execute();
        return $query ->fetch(PDO::FETCH_ASSOC);
    }
    
}
