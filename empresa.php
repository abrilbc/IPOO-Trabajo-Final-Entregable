<?php
include_once('BaseDatos.php');
class Empresa{
    private $idempresa;
    private $enombre;
    private $edireccion;
    public function __construct($idempresa,$enombre,$edireccion){
        $this->idempresa=$idempresa;
        $this->enombre=$enombre;
        $this->edireccion=$edireccion;
    }


    public function getIdempresa(){
        return $this->idempresa;
    }

    public function setIdempresa($idempresa) {
        $this->idempresa = $idempresa;

    }

    public function getEnombre(){
        return $this->enombre;
    }


    public function setEnombre($enombre){
        $this->enombre = $enombre;

    }

    public function getEdireccion(){
        return $this->edireccion;
    }

    public function setEdireccion($edireccion){
        $this->edireccion = $edireccion;
    }

   public function __toString(){
        $cadena="\n--------EMPRESA--------\n" ;
        $cadena.= "NUMERO: ".$this->getIdempresa()."\n";
        $cadena.= "NOMBRE: ".$this->getEnombre()."\n";
        $cadena.= "DIRECCION: ".$this->getEdireccion()."\n";

        return $cadena;
    }
}
