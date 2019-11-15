<?php

include_once(realpath(dirname(__FILE__) . '/../config/config.php'));

class Conection{
   
    private $servidor;
    private $puerto;
    private $baseDatos;
    private $usuario;
    private $clave;
    private $conexion;
    
    function __construct() {
        $this->servidor = DB_SERVER;
        $this->puerto= DB_PORT;
        $this->baseDatos = DB_NAME;
        $this->usuario = DB_USER;
        $this->clave = DB_PASSW;
    }
    
    public function getConexion(){
        return $this->conexion=new PDO("pgsql:host=$this->servidor;dbname=$this->baseDatos", $this->usuario, $this->clave);
    }
    
}
?>