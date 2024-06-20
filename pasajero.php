<?php
include_once('BaseDatos.php');
class Pasajero extends Persona{
    private $objViaje;
    public function __construct(){
        parent::__construct();
        $this->objViaje = "";
    }

    public function cargar($NroD, $Nom, $Ape, $telefono){
        parent::cargar($NroD, $Nom, $Ape, $telefono);
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

    /**
	 * Recupera los datos de una persona por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($pidpersona){
		$base = new BaseDatos();
		$consultaPasajero = "Select * from pasajero where pidpersona=" . $pidpersona;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPasajero)){
				if($row2 = $base->Registro()){
					parent::Buscar($pidpersona);
					$this->setObjViaje($row2['idviaje']);
					$resp = true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}	

	public function pasajerosEnViaje($idViaje) {
		$base = new BaseDatos();
		$consultaPasajero = "Select * from pasajero where idviaje=" . $idViaje;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPasajero)){
				$arregloPasajero = array();
				while($row2 = $base->Registro()){
					$objViaje = new Viaje();
					$objViaje->Buscar($idViaje);
					$id=$row2['pidpersona'];
					//Crea el objeto y le settea los valores
					$pasajeroViaje = new Pasajero();
					$pasajeroViaje->Buscar($id);
					
					array_push($arregloPasajero, $pasajeroViaje);
					$this->setObjViaje($objViaje->getIdviaje());
					$resp = true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $arregloPasajero;
	}
    
	function mostrarPasajero($tipo) {
		$obj_pasajero = new Pasajero();
		$coleccionPasajero = $obj_pasajero->listar("");
		$cadena = "";
		if (!empty($coleccionPasajero)) {
			switch ($tipo) {
				case 'mostrar':
					$cadena .= "Actualmente existen " . count($coleccionPasajero) . " pasajero(s) para modificar: ";
					foreach ($coleccionPasajero as $pasajero) {
					$cadena .= $pasajero->stringSimplificado();
					}
					break;
				case 'visualizar';
					$cadena .= "Actualmente existen " . count($coleccionPasajero) . " pasajero(s): ";
					foreach ($coleccionPasajero as $pasajero) {
					$cadena .= $pasajero;
					}
					break;
			}
			
		} else {
			$cadena .= "No hay pasajeros existentes";
		}
		return $cadena;
	}

	public function listar($condicion){
	    $arregloPasajero = null;
		$base=new BaseDatos();
		$consultaPasajeros = "Select * from pasajero ";
		if ($condicion != ""){
		    $consultaPasajeros = $consultaPasajeros . ' where ' . $condicion;
		}
		$consultaPasajeros .= " order by pidpersona ";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPasajeros)){				
				$arregloPasajero = array();
				while($row2 = $base->Registro()){
				    $id=$row2['pidpersona'];
					$pasaj = new Pasajero();
					$pasaj->Buscar($id);
					$idViaje = $pasaj->getObjViaje();
					//Crea un obj viaje para que lo almacene y lo muestre
					$objViaje = new Viaje();
					$objViaje->Buscar($idViaje);
					$pasaj->setObjViaje($objViaje);

					array_push($arregloPasajero, $pasaj);
				}
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 }	
		 return $arregloPasajero;
	}	


	
	public function insertar(){
		$base = new BaseDatos();
		$resp = false;
		if(parent::insertar()){
			$consultaInsertar = "INSERT INTO pasajero(pidpersona,idviaje) 
				VALUES (". parent::getIdPersona() . "," . $this->getObjViaje()->getIdviaje() . ")";
		if($base->Iniciar()){
			if($id = $base->devuelveIDInsercion($consultaInsertar)){
			    $resp = true;
			} else {
					$this->setmensajeoperacion($base->getError());
			}
		} else {
				$this->setmensajeoperacion($base->getError());
			}
		}
		return $resp;
	}
	
	
	
	public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		if(parent::modificar()){
			$consultaModifica="UPDATE pasajero SET idviaje=".$this->getObjViaje()." WHERE pidpersona=".parent::getIdPersona();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
				
			}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		}
		
		return $resp;
	}
	
	public function eliminar(){
		$base = new BaseDatos();
		$resp = false;
		
		if($base->Iniciar()){
				$consultaBorra = "DELETE FROM pasajero WHERE pidpersona=" . parent::getIdPersona();
				if($base->Ejecutar($consultaBorra)){
					if(parent::eliminar()){
						 $resp = true;
					}
				} else {
						$this->setmensajeoperacion($base->getError());
				}
		} else {
				$this->setmensajeoperacion($base->getError());
		}
		return $resp; 
	}

    public function stringSimplificado() {
		return parent::__toString();
	}
    public function __toString() {
        $cadena = parent::__toString();
        $cadena .= "\nSU VIAJE: " . $this->getObjViaje();
		$cadena .= $this->getmensajeoperacion();
        return $cadena;
    }

}