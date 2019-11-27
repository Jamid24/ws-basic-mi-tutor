<?php

include_once(realpath(dirname(__FILE__) . '/../Conection.php'));

class Headquarter {
    private $conectDb;
      
    public function getHeadquartersXCity($idCity){
        $this->conectDb=new Conection(); 
        $sql = "select h.id_headquarter value_name, h.name_headquarter text_name
        from headquarter h 
        join city c on h.id_city=c.id_city and c.id_city=".$idCity.";";

        $query = $this->conectDb->getConexion()->prepare($sql);
        $query ->execute();
        return $query ->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
