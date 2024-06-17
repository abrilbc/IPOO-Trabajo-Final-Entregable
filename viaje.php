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
    private $mensajeoperacion;

    public function __construct(){
        $this->idviaje = 1;
        $this->vdestino ="vdestino";
        $this->vcantmaxpasajeros="";
        $this->idempresa ="";
        $this->rnumeroempleado ="";
        $this->vimporte ="";
        $this->coleccionObjPasajeros=[];
    }

    public function cargar($idviaje,$vdestino,$vcantmaxpasajeros,$idempresa,$rnumeroempleado,$vimporte){
        $this->setIdviaje($idviaje);
        $this->setVdestino($vdestino);
        $this->setVcantmaxpasajeros($vcantmaxpasajeros);
        $this->setIdempresa($idempresa);
        $this->setRnumeroempleado($rnumeroempleado);
        $this->setVimporte($vimporte);
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

    public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}

    public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
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

    public function hayPasajesDisponible(){
        $valor = false;
        if (count($this->getColeccionObjPasajeros()) < $this->getVcantmaxpasajeros()){
            $valor = true;
        }
        return $valor;
    }

    // public function modificarPasajero($documento, $modificarNombre, $modificarApellido, $modificarTelefono) {
    //     $coleccionObjPasajeros = $this->getColeccionObjPasajeros();
    //     $encontrado = false; 
    //     foreach ($coleccionObjPasajeros as $pasajero) {
    //         if ($pasajero->getNrodoc() == $documento) {
    //             $pasajero->setNombre($modificarNombre);
    //             $pasajero->setApellido($modificarApellido);
    //             $pasajero->setTelefono($modificarTelefono);
    //             $encontrado = true;
    //         }
    //     }
    //     return $encontrado;
    // } 

    public function agregarPasajero($nuevoPasajero) {
        $coleccionObjPasajeros = $this->getColeccionObjPasajeros();
        $valor = true;
        
        foreach ($coleccionObjPasajeros as $pasajero) {
            if ($pasajero->getNrodoc() == $nuevoPasajero->getNrodoc()) {
                $valor = false;  
            }
        }
        if (count($coleccionObjPasajeros) >= $this->getVcantmaxpasajeros()) {
            $valor = false;
        }
        if ($valor==true) {
            $coleccionObjPasajeros[] = $nuevoPasajero;
            $this->setColeccionObjPasajeros($coleccionObjPasajeros);
        }
        return $valor; 
    }

    public function Buscar($idviaje){
		$base=new BaseDatos();
		$consultaViaje="Select * from viaje where idviaje=".$idviaje;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaViaje)){
				if($row2=$base->Registro()){
				    $this->setIdviaje($idviaje);
				    $this->setVdestino($row2['vdestino']);
					$this->setVcantmaxpasajeros($row2['vcantmaxpasajeros']);
					$this->setIdempresa($row2['idempresa']);
					$this->setRnumeroempleado($row2['rnumeroempleado']);
                    $this->setVimporte($row2['vimporte']);
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

    public function listar($condicion=""){
	    $arregloPasajero = null;
		$base=new BaseDatos();
		$consultaViaje="Select * from viaje ";
		if ($condicion!=""){
		    $consultaViaje=$consultaViaje.' where '.$condicion;
		}
		$consultaViaje.=" order by idviaje ";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaViaje)){				
				$arregloPasajero= array();
				while($row2=$base->Registro()){
				    $idviaje=$row2['idviaje'];
					$vdestino=$row2['vdestino'];
					$vcantmaxpasajeros=$row2['vcantmaxpasajeros'];
					$idempresa=$row2['idempresa'];
					$rnumeroempleado=$row2['rnumeroempleado'];
                    $vimporte=$row2['vimporte'];
				
					$viaje=new Viaje();
					$viaje->cargar($idviaje,$vdestino,$vcantmaxpasajeros,$idempresa,$rnumeroempleado,$vimporte);
					array_push($arregloViaje,$viaje);
	
				}
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloViaje;
	}

    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO viaje(idviaje, vdestino, vcantmaxpasajeros,  idempresa, rnumeroempleado, vimporte) 
				VALUES (".$this->getIdviaje().",'".$this->getVdestino()."','".$this->getVcantmaxpasajeros()."','".$this->getIdempresa()."','".$this->getRnumeroempleado()."','".$this->getVimporte()."')";
		if($base->Iniciar()){

			if($idviaje = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setIdviaje($idviaje);
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
		$consultaModifica="UPDATE viaje SET idviaje='".$this->getIdviaje()."',vdestino='".$this->getVdestino()."',vcantmaxpasajeros='".$this->getVcantmaxpasajeros()."',idempresa=". $this->getIdempresa()."',rnumerompleado=".$this->getRnumeroempleado()."',vimporte=".$this->getVimporte()." WHERE idviaje=".$this->getIdviaje();
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
				$consultaBorra="DELETE FROM viaje WHERE idviaje=".$this->getIdviaje();
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
