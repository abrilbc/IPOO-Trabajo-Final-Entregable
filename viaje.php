<?php
include_once('BaseDatos.php');
class Viaje {
    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $idempresa;
    private $rnumeroempleado;
    private $vimporte;
    private $coleccionObjPasajeros;

    public function __construct($idviaje,$vdestino,$vcantmaxpasajeros,$idempresa,$rnumeroempleado,$vimporte,$coleccionObjPasajeros){
        $this->idviaje=$idviaje;
        $this->vdestino=$vdestino;
        $this->vcantmaxpasajeros=$vcantmaxpasajeros;
        $this->idempresa=$idempresa;
        $this->rnumeroempleado=$rnumeroempleado;
        $this->vimporte=$vimporte;
        $this->coleccionObjPasajeros = $coleccionObjPasajeros;
    }
    
    public function getIdviaje(){
        return $this->idviaje;
    }

    public function setIdviaje($idviaje){
        $this->idviaje = $idviaje;
    }

    public function getVdestino()
    {
        return $this->vdestino;
    }

    public function setVdestino($vdestino)
    {
        $this->vdestino = $vdestino;

    }

    public function getVcantmaxpasajeros()
    {
        return $this->vcantmaxpasajeros;
    }

    public function setVcantmaxpasajeros($vcantmaxpasajeros)
    {
        $this->vcantmaxpasajeros = $vcantmaxpasajeros;

    }
    public function getIdempresa()
    {
        return $this->idempresa;
    }


    public function setIdempresa($idempresa)
    {
        $this->idempresa = $idempresa;

    }


    public function getRnumeroempleado()
    {
        return $this->rnumeroempleado;
    }


    public function setRnumeroempleado($rnumeroempleado)
    {
        $this->rnumeroempleado = $rnumeroempleado;

    }


    public function getVimporte()
    {
        return $this->vimporte;
    }


    public function setVimporte($vimporte)
    {
        $this->vimporte = $vimporte;

    }

    public function getColeccionObjPasajeros(){
        return $this->coleccionObjPasajeros;
    }

    public function setColeccionObjPasajeros($coleccionObjPasajeros){
        $this->coleccionObjPasajeros = $coleccionObjPasajeros;
    }

    public function mostrarColeccion($coleccion){
        $cadena = "";
        foreach ($coleccion as $i => $objeto){
            $cadena .= "\n-------> PASAJERO " . $i . ": ";
            $cadena .= "\n".$objeto;
        }
        return $cadena;
    }

    public function __toString(){
        $cadena="\n--------VIAJE--------\n";
        $cadena.= "NUMERO: ".$this->getIdviaje()."\n";
        $cadena.= "DESTINO: ".$this->getVdestino()."\n";
        $cadena.= "CANTIDAD MAXIMA DE PASAJEROS: ".$this->getVcantmaxpasajeros()."\n";
        $cadena.= "NUMERO EMPRESA: ".$this->getIdempresa()."\n";
        $cadena.= "NUMERO EMPLEADO RESPONSABLE: ".$this->getRnumeroempleado()."\n";
        $cadena.= "IMPORTE: ".$this->getVimporte()."\n";
        $cadena.= $this->mostrarColeccion($this->getColeccionObjPasajeros())."\n";
        
        return $cadena;
    }
}
