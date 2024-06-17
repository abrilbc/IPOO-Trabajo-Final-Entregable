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
    

	public function listar($condicion=""){
	    $arregloPersona = null;
		$base=new BaseDatos();
		$consultaPasajeros = "Select * from pasajero ";
		if ($condicion != ""){
		    $consultaPasajeros = $consultaPasajeros . ' where ' . $condicion;
		}
		$consultaPasajeros .= " order by papellido ";
		//echo $consultaPasajeros;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPasajeros)){				
				$arregloPasajero = array();
				while($row2=$base->Registro()){
				    $id=$row2['pidpersona'];
					// $NroDoc=$row2['pdocumento'];
					// $Nombre=$row2['pnombre'];
					// $Apellido=$row2['papellido'];
					// $telefono=$row2['ptelefono'];
                    // $viaje = $row2['idviaje'];
					$pasaj = new Pasajero();
					$pasaj->Buscar($id);
					// $pasaj->cargar($id);
                    // $pasaj->cargarViaje($viaje);
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
				VALUES (".parent::getIdPersona(). "," . $this->getObjViaje() . "')";
		if($base->Iniciar()){
			if($id = $base->devuelveIDInsercion($consultaInsertar)){

                // $this->setIdPersona($id);
			    $resp=  true;
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
			$consultaModifica="UPDATE pasajero SET pidviaje=".$this->getObjViaje()." WHERE pidpersona=".parent::getIdPersona();
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

    
    public function __toString() {
        $cadena = "\n--------PASAJERO--------\n";
        $cadena .= parent::__toString();
        $cadena .= "\nSU VIAJE: " . $this->getObjViaje();
        return $cadena;
    }

}