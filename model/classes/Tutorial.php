<?php

include_once(realpath(dirname(__FILE__) . '/../Conection.php'));

class Tutorial {
    private $conectDb;
      
    public function createTutorial($tutor, $matter, $ubication, $date, $hour, $quota){
        $this->conectDb=new Conection(); 
        $sql = "INSERT INTO tutorial(id_tutor,id_matter, id_ubication,date_tutorial,hour_tutorial,quota) ";
        $sql .= "VALUES(".$tutor.",".$matter.",".$ubication.",'".$date."','".$hour."',".$quota.") RETURNING id_tutorial;";

        $query = $this->conectDb->getConexion()->prepare($sql);
        $query ->execute();
        return $query ->fetch(PDO::FETCH_ASSOC);
    }
    
}
