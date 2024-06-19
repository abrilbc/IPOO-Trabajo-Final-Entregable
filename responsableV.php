<?php
include_once('BaseDatos.php');
class ResponsableV extends Persona{
    private $rnumeroempleado;
    private $rnumerolicencia;
    public function __construct() {
        parent::__construct();
        $this->rnumeroempleado = 0;
        $this->rnumerolicencia = "";
    }

    public function cargar($NroD, $Nom, $Ape, $telefono){
    parent::cargar($NroD, $Nom, $Ape, $telefono);
    }

    public function cargarEmpleado($rnumerolicencia) {
        // $this->setRnumeroempleado($rnumeroempleado);
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

	function mostrarResponsable() {
		$obj_responsable = new ResponsableV();
		$coleccionResponsable = $obj_responsable->listar();
		$cadena = "";
		if (!empty($coleccionResponsable)) {
			$cadena .= "Actualmente existen " . count($coleccionResponsable) . " responsable(s): ";
			foreach ($coleccionResponsable as $responsable) {
				$cadena .= $responsable->__toString();
			}
		} else {
			$cadena .= "No hay responsables existentes";
		}
		return $cadena;
	}
    /**
	 * Recupera los datos de una persona por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($nroEmpleado){
		$base=new BaseDatos();
		$consultaResponsable = "Select * from responsable where rnumeroempleado=".$nroEmpleado;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaResponsable)){
				if($row2=$base->Registro()){
					parent::Buscar($row2['ridpersona']);
                    $this->setRnumeroempleado($row2['rnumeroempleado']);
                    $this->setRnumerolicencia($row2['rnumerolicencia']);
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
	    $arregloResponsable = null;
		$base = new BaseDatos();
		$consultaResponsable="Select * from responsable ";
		if ($condicion!=""){
		    $consultaResponsable = $consultaResponsable .' where '.$condicion;
		}
		$consultaResponsable.=" order by rnumeroempleado ";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaResponsable)){				
				$arregloResponsable = array();
				while($row2 = $base->Registro()){
				    $nro_empleado = $row2['rnumeroempleado'];
					$respo = new ResponsableV();
					$respo->Buscar($nro_empleado);
					array_push($arregloResponsable, $respo);
				}
				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloResponsable;
	}	


	
	public function insertar(){
		$base = new BaseDatos();
		$resp = false;
		if(parent::insertar()){
				$consultaInsertar = "INSERT INTO responsable(ridpersona, rnumeroempleado, rnumerolicencia) 
					VALUES (".parent::getIdPersona().",".$this->getRnumeroempleado().",".$this->getRnumerolicencia().")";
			if($base->Iniciar()){
				if($id = $base->devuelveIDInsercion($consultaInsertar)){
					$this->setRnumeroempleado($id);
					$resp=  true;
				}	else {
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
	    $base = new BaseDatos();
		if(parent::modificar()){
			$consultaModifica = "UPDATE responsable SET rnumerolicencia =" . $this->getRnumerolicencia() ." WHERE rnumeroempleado=". $this->getRnumeroempleado();
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
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM responsable WHERE rnumeroempleado=".$this->getRnumeroempleado();
				if($base->Ejecutar($consultaBorra)){
					if(parent::eliminar()){
					 	$resp=  true;	
					}
				   
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}
    
    public function __toString() {
        $cadena = "\n--------RESPONSABLE--------\n";
        $cadena .= "\nNUMERO EMPLEADO: " . $this->getRnumeroempleado();
        $cadena .= "\nNUMERO DE LICENCIA: " . $this->getRnumeroLicencia();
		$cadena .= parent::__toString() . "\n";
        return $cadena;
    }
}