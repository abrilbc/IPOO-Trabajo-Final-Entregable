<?php
include_once('BaseDatos.php');
class Pasajero extends Persona{
    private $objViaje;
    public function __construct(){
        parent::__construct();
        $this->objViaje = "";
    }

    public function cargar($idpersona,$NroD,$Nom,$Ape,$telefono){
        parent::cargar($idpersona,$NroD,$Nom,$Ape,$telefono);
    }

    public function cargarViaje($objViaje) {
        $this->setObjViaje($objViaje);
    }

    public function getObjViaje()
    {
        return $this->objViaje;
    }
    
    public function setObjViaje($objViaje)
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