<?php
include_once('BaseDatos.php');
class ResponsableV extends Persona{
    private $rnumeroempleado;
    private $rnumerolicencia;
    public function __construct() {
        parent::__construct();
        $this->rnumeroempleado = "";
        $this->rnumerolicencia = "";
    }

    public function cargar($idpersona,$NroD,$Nom,$Ape,$telefono,$rnumeroempleado,$rnumerolicencia){
    parent::cargar($idpersona,$NroD,$Nom,$Ape,$telefono);
    $this->setRnumeroempleado($rnumeroempleado);
    $this->setRnumerolicencia($rnumerolicencia);
    }

    public function getRnumeroempleado()
    {
        return $this->rnumeroempleado;
    }
    public function setRnumeroempleado($rnumeroempleado)
    {
        $this->rnumeroempleado = $rnumeroempleado;
    }
    public function getRnumerolicencia()
    {
        return $this->rnumerolicencia;
    }
    public function setRnumerolicencia($rnumerolicencia)
    {
        $this->rnumerolicencia = $rnumerolicencia;
    }
    
    public function __toString() {
        $cadena = "\n--------RESPONSABLE--------\n";
        $cadena .= parent::__toString();
        $cadena .= "\nNUMERO EMPLEADO: " . $this->getRnumeroempleado();
        $cadena .= "\nNUMERO DE LICENCIA: " . $this->getRnumeroLicencia();

        return $cadena;
    }
}