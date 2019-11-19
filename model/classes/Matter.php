<?php

include_once(realpath(dirname(__FILE__) . '/../Conection.php'));

class Matter {
    private $conectDb;
      
    public function getMatterXUser($idUser){
        $this->conectDb=new Conection(); 
        $sql = "select m.id_matter, m.name_matter
            from career c 
            join matter_x_career mc on c.id_career=mc.id_career 
            join matter m on mc.id_matter=m.id_matter
            join career_x_user cu on cu.id_career=c.id_career
            join user_app u on cu.id_user=u.id_user
            where u.id_user=".$idUser." and u.is_active=1 and mc.is_active=1 and cu.is_active=1
            order by m.name_matter;";

        $query = $this->conectDb->getConexion()->prepare($sql);
        $query ->execute();
        return $query ->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
