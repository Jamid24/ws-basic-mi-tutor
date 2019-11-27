<?php

include_once(realpath(dirname(__FILE__) . '/../Conection.php'));

class Ubication {
    private $conectDb;
      
    public function getUbicationsXHeadquarter($idHeadquarter){
        $this->conectDb=new Conection(); 
        $sql = "select u.id_ubication value_name, u.name_ubication text_name
            from ubication u 
            join headquarter h on u.id_headquarter=h.id_headquarter and u.id_headquarter=".$idHeadquarter.";";

        $query = $this->conectDb->getConexion()->prepare($sql);
        $query ->execute();
        return $query ->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
