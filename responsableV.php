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

    public function cargar($idpersona, $NroD, $Nom, $Ape, $telefono){
    parent::cargar($idpersona, $NroD, $Nom, $Ape, $telefono);
    }

    public function cargarEmpleado($rnumeroempleado,$rnumerolicencia) {
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

    /**
	 * Recupera los datos de una persona por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($dni){
		$base=new BaseDatos();
		$consultaResponsable = "Select * from responsable where rnumDocumento=".$dni;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaResponsable)){
				if($row2=$base->Registro()){
				    $this->setIdPersona($row2['idpersona']);
				    $this->setNrodoc($dni);
					$this->setNombre($row2['nombre']);
					$this->setApellido($row2['apellido']);
					$this->setTelefono($row2['telefono']);
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
				    $id=$row2['idpersona'];
					$NroDoc=$row2['nrodoc'];
					$Nombre=$row2['nombre'];
					$Apellido=$row2['apellido'];
					$telefono=$row2['telefono'];
                    $nroEmpleado = $row2['rnumeroempleado'];
                    $nroLicencia = $row2['rnumerolicencia'];
					$respo = new ResponsableV();
					$respo->cargar($id,$NroDoc,$Nombre,$Apellido,$telefono);
                    $respo->cargarEmpleado($nroEmpleado, $nroLicencia);
					array_push($arregloResponsable,$respo);
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
		$consultaInsertar = "INSERT INTO responsable(rnumDocumento, rnumeroempleado, rnumerolicencia) 
				VALUES (".$this->getNrodoc().",'".$this->getRnumeroempleado()."','".$this->getRnumerolicencia()."')";
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
		return $resp;
	}
	
	
	
	public function modificar(){
	    $resp =false; 
	    $base = new BaseDatos();
		$consultaModifica = "UPDATE responsable SET rnumerolicencia =" . $this->getRnumerolicencia() ." WHERE rnumDocumento =" . $this->getNrodoc();
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
				$consultaBorra="DELETE FROM responsable WHERE rnumDocumento=".$this->getNrodoc();
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
    
    public function __toString() {
        $cadena = "\n--------RESPONSABLE--------\n";
        $cadena .= parent::__toString();
        $cadena .= "\nNUMERO EMPLEADO: " . $this->getRnumeroempleado();
        $cadena .= "\nNUMERO DE LICENCIA: " . $this->getRnumeroLicencia();

        return $cadena;
    }
}