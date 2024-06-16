<?php
include_once('BaseDatos.php');
class Pasajero extends Persona{
    private $objViaje;
    public function __construct(){
        parent::__construct();
        $this->objViaje = "";
    }

    public function cargar($idpersona,$NroD,$Nom,$Ape,$telefono,$objViaje){
        parent::cargar($idpersona,$NroD,$Nom,$Ape,$telefono);
        $this->setIdViaje($objViaje);
    }

    public function getObjViaje()
    {
        return $this->objViaje;
    }
    
    public function setIdViaje($objViaje)
    {
        $this->objViaje = $objViaje;
    }

    
    public function __toString() {
        $cadena = "\n--------PASAJERO--------\n";
        $cadena .= parent::__toString();
        $cadena .= "\nNUMERO DE VIAJE: " . $this->getObjViaje();
        return $cadena;
    }

}