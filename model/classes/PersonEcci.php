<?php

include_once(realpath(dirname(__FILE__) . '/../Conection.php'));

class PersonEcci {
    private $conectDb;
    
    public function getPersonEcci($codigo){
        $this->conectDb=new Conection(); 
        $sql = "SELECT * FROM person_ecci WHERE code_ecci='".$codigo."';";

        $query = $this->conectDb->getConexion()->prepare($sql);
        $query ->execute();
        return $query ->fetch(PDO::FETCH_ASSOC);
    }
}
