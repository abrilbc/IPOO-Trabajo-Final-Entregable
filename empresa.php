<?php
include_once('BaseDatos.php');
class Empresa{
    private $idempresa;
    private $enombre;
    private $edireccion;
	private $coleccionObjViaje;
    private $mensajeoperacion;

    public function __construct(){
        $this->idempresa=0;
        $this->enombre="";
        $this->edireccion="";
		$this->coleccionObjViaje=[];
    }

    public function cargar($enombre,$edireccion){	
	    // $this->setIdempresa($idempresa);
        $this->setEnombre($enombre);
        $this->setEdireccion($edireccion);
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

    public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}

    public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}

	public function getColeccionObjViaje() {
		return $this->coleccionObjViaje;
	}

	public function setColeccionObjViaje($coleccionObjViaje) {
		$this->coleccionObjViaje = $coleccionObjViaje;
	}

	function mostrarEmpresas() {
		$obj_empresa = new Empresa();
		$coleccionEmpresas = $obj_empresa->listar("");
		$cadena = "";
		if (!empty($coleccionEmpresas)) {
			$cadena .= "Actualmente existen " . count($coleccionEmpresas) . " empresa(s): ";
			foreach ($coleccionEmpresas as $empresa) {  
				$cadena .= $empresa->__toString();
			}
		} else {
			$cadena .= "No hay empresas existentes";
		}
		return $cadena;
	}

    public function Buscar($idempresa){
		$base=new BaseDatos();
		$consultaEmpresa="Select * from empresa where idempresa=".$idempresa;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaEmpresa)){
				if($row2=$base->Registro()){
					//Creamos un objeto Viaje para la delegación
					$coleccionViaje = $this->getColeccionObjViaje();
					$objViaje = new Viaje();
					$viajeEncontrado = $objViaje->Buscar($idempresa);

				    $this->setIdempresa($idempresa);
				    $this->setEnombre($row2['enombre']);
					$this->setEdireccion($row2['edireccion']);
					array_push($coleccionViaje, $viajeEncontrado);
					$this->setColeccionObjViaje($coleccionViaje);
					$resp= true;
				}
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}	

    public function listar($condicion){
	    $arregloEmpresa = null;
		$base=new BaseDatos();
		$consultaEmpresa="Select * from empresa ";
		if ($condicion!=""){
		    $consultaEmpresa=$consultaEmpresa.' where '.$condicion;
		}
		$consultaEmpresa.=" order by idempresa ";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaEmpresa)){				
				$arregloEmpresa= array();
				while($row2=$base->Registro()){
				    $idempresa=$row2['idempresa'];
					$enombre=$row2['enombre'];
					$edireccion=$row2['edireccion'];
				
					$empre=new Empresa();
					$empre->setIdempresa($idempresa);
					$empre->cargar($enombre, $edireccion);
					array_push($arregloEmpresa, $empre);
	
				}
				
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloEmpresa;
	}

    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO empresa( enombre, edireccion) 
				VALUES (".$this->getEnombre()."','".$this->getEdireccion()."')";
		if($base->Iniciar()){

			if($idempresa = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setIdempresa($idempresa);
			    $resp=  true;

			}	else {
					$this->setmensajeoperacion($base->getError());
					
			}

		} else {
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}

    public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModifica="UPDATE empresa SET enombre='".$this->getEnombre()."',edireccion='".$this->getEdireccion()."' WHERE idempresa= ".$this->getIdempresa();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
				
			}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}
	
	public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM empresa WHERE idempresa=".$this->getIdempresa();
				if($base->Ejecutar($consultaBorra)){
				    $resp=  true;
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}

	public function mostrarColeccionEmpresa() {
		$mostrar = "";
		$coleccionObjViaje = $this->getColeccionObjViaje();
		foreach ($coleccionObjViaje as $viaje) {
			$mostrar.= $viaje->__toString() . "\n";
		}
		return $mostrar;
	}

   public function __toString(){
        $cadena="\n--------EMPRESA--------\n" ;
        $cadena.= "NUMERO ID: ".$this->getIdempresa()."\n";
        $cadena.= "NOMBRE: ".$this->getEnombre()."\n";
        $cadena.= "DIRECCION: ".$this->getEdireccion()."\n";
		$cadena.= "VIAJES DE ESA EMPRESA: \n" . $this->mostrarColeccionEmpresa();

        return $cadena;
    }
}
