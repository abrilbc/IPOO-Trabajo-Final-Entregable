<?php
include_once('BaseDatos.php');
class ResponsableV extends Persona{
    private $rnumeroempleado;
    private $rnumerolicencia;
    public function __construct($nombre, $apellido, $numDocumento, $telefono, $rnumeroempleado, $rnumerolicencia) {
        parent::__construct($nombre, $apellido, $numDocumento, $telefono);
        $this->rnumeroempleado = $rnumeroempleado;
        $this->rnumerolicencia = $rnumerolicencia;
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