<?php

class Conection{
   
    private $servidor;
    private $puerto;
    private $baseDatos;
    private $usuario;
    private $clave;
    private $conexion;
    
    function __construct() {
        $this->servidor = '127.0.0.1';
        $this->puerto='5432';
        $this->baseDatos = 'mi_tutor';
        $this->usuario = 'postgres';
        $this->clave = '123456';
    }
    
    public function getConexion(){
        return $this->conexion=new PDO("pgsql:host=$this->servidor;dbname=$this->baseDatos", $this->usuario, $this->clave);
    }
    
}
?>