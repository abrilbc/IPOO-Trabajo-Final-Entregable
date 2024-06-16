<?php
include_once('BaseDatos.php');
class Pasajero extends Persona{
    private $objViaje;
    public function __construct(){
        parent::__construct();
        $this->objViaje = "";
    }

    public function cargar($idpersona, $NroD, $Nom, $Ape, $telefono){
        parent::cargar($idpersona, $NroD, $Nom, $Ape, $telefono);
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
    public function Buscar($dni){
		$base = new BaseDatos();
		$consultaPasajero = "Select * from pasajero where pdocumento=" . $dni;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPasajero)){
				if($row2 = $base->Registro()){
				    // $this->setIdPersona($row2['idpersona']);
				    $this->setNrodoc($dni);
					$this->setNombre($row2['pnombre']);
					$this->setApellido($row2['papellido']);
					$this->setTelefono($row2['ptelefono']);
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
				    $id=$row2['idpersona'];
					$NroDoc=$row2['pdocumento'];
					$Nombre=$row2['pnombre'];
					$Apellido=$row2['papellido'];
					$telefono=$row2['ptelefono'];
                    $viaje = $row2['idviaje'];
					$pasaj = new Pasajero();
					$pasaj->cargar($id,$NroDoc,$Nombre,$Apellido,$telefono);
                    $pasaj->cargarViaje($viaje);
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
		$consultaInsertar = "INSERT INTO pasajero(pdocumento, papellido, pnombre, ptelefono, idviaje) 
				VALUES (" . $this->getNrodoc().",'" . $this->getApellido() . "','" . $this->getNombre() . "','".$this->getTelefono()."','" . $this->getObjViaje() . "')";
		if($base->Iniciar()){
			if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setIdPersona($id);
			    $resp=  true;
			} else {
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
		$consultaModifica="UPDATE persona SET apellido='".$this->getApellido()."',nombre='".$this->getNombre()."'
                           ,ptelefono='".$this->getTelefono()."',nrodoc=". $this->getNrodoc()." WHERE id".$this->getIdPersona();
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
		$base = new BaseDatos();
		$resp = false;
		if($base->Iniciar()){
				$consultaBorra = "DELETE FROM pasajero WHERE pdocumento=" . $this->getNrodoc();
				if($base->Ejecutar($consultaBorra)){
				    $resp = true;
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