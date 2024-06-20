<?php
include_once('BaseDatos.php');
class Viaje {
    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $obj_empresa; // Hacer delegación
    private $obj_responsable; // Hacer delegación
    private $vimporte;
    private $coleccionObjPasajeros;
    private $mensajeoperacion;

    public function __construct(){
        $this->idviaje = 1;
        $this->vdestino ="vdestino";
        $this->vcantmaxpasajeros="";
        $this->obj_empresa = "";
        $this->obj_responsable = "";
        $this->vimporte ="";
        $this->coleccionObjPasajeros=[];
    }

    public function cargar($vdestino,$vcantmaxpasajeros,$obj_empresa,$obj_responsable,$vimporte){
        $this->setVdestino($vdestino);
        $this->setVcantmaxpasajeros($vcantmaxpasajeros);
        $this->setObj_empresa($obj_empresa);
        $this->setObj_responsable($obj_responsable);
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
    public function getObj_empresa()
    {
        return $this->obj_empresa;
    }


    public function setObj_empresa($obj_empresa)
    {
        $this->obj_empresa = $obj_empresa;

    }


    public function getObj_responsable()
    {
        return $this->obj_responsable;
    }


    public function setObj_responsable($obj_responsable)
    {
        $this->obj_responsable = $obj_responsable;

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

    public function mostrarColeccion($idviaje){
        $pasajero = new Pasajero();
        $coleccionPasajeros = $pasajero->pasajerosEnViaje($idviaje);
        $cadena = "";
        if (!empty($coleccionPasajeros)) {
            $cadena .= "|---> Este viaje tiene " . count($coleccionPasajeros) . " pasajeros registrados:\n";
            foreach ($coleccionPasajeros as $i => $pasajero){
                $cadena .= "\n---------PASAJERO N°" . $i+1 . "---------";
                $cadena .= $pasajero;
            }
        } else {
            $cadena .= "|---> Este viaje no tiene pasajeros registrados \n";
        }
        return $cadena;
    }

    // public function agregarPasajero($nuevoPasajero) {
    //     $coleccionObjPasajeros = $this->getColeccionObjPasajeros();
    //     $valor = true;
        
    //     foreach ($coleccionObjPasajeros as $pasajero) {
    //         if ($pasajero->getNrodoc() == $nuevoPasajero->getNrodoc()) {
    //             $valor = false;  
    //         }
    //     }
    //     if (count($coleccionObjPasajeros) >= $this->getVcantmaxpasajeros()) {
    //         $valor = false;
    //     }
    //     if ($valor==true) {
    //         $coleccionObjPasajeros[] = $nuevoPasajero;
    //         $this->setColeccionObjPasajeros($coleccionObjPasajeros);
    //     }
    //     return $valor; 
    // }

    public function Buscar($idviaje){
		$base=new BaseDatos();
		$consultaViaje="Select * from viaje where idviaje=" . $idviaje;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaViaje)){
				if($row2=$base->Registro()){
				    $this->setIdviaje($idviaje);
				    $this->setVdestino($row2['vdestino']);
					$this->setVcantmaxpasajeros($row2['vcantmaxpasajeros']);
                    // CORRECCION: 
                    $empresa= new Empresa();
                    $empresa ->Buscar($row2['idempresa']);
					$this->setObj_empresa($empresa);

                    $empleado= new ResponsableV();
                    $empleado ->Buscar($row2['rnumeroempleado']);
					$this->setObj_responsable($empleado); 

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


    public function cantidadMaxima($idViaje){
        $bandera=false;
        $obj_viaje= new Viaje();
        $obj_viaje -> Buscar($idViaje);
        $pasajero = new Pasajero();
        $cantidadPasajeros= count($pasajero -> pasajerosEnViaje($idViaje));
        $cantidadMaxima=$obj_viaje->getVcantmaxpasajeros();
            if ($cantidadPasajeros < $cantidadMaxima ) {
                $bandera=true;
            }

        return $bandera;
    }

    public function viajesEnEmpresas($idEmpresa) {
		$base = new BaseDatos();
		$consultaPasajero = "Select * from viaje where idempresa=" . $idEmpresa;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPasajero)){
				$arregloViajes = array();
				while($row2 = $base->Registro()){
					$objEmpresa = new Empresa();
					$objEmpresa->Buscar($idEmpresa);
					$idViaje = $row2['idviaje'];
					//Crea el objeto y le settea los valores
					$viaje = new Viaje();
					$viaje->Buscar($idViaje);

					array_push($arregloViajes, $viaje);
					$this->setObj_empresa($objEmpresa->getIdempresa());
					$resp = true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $arregloViajes;
	}

    function mostrarViajes($opcion) {
		$obj_viaje = new Viaje();
		$coleccionViajes = $obj_viaje->listar("");
		$cadena = "";
		if (!empty($coleccionViajes)) {
            switch ($opcion) {
                case 'mostrar': 
                    $cadena .= "\n---> Actualmente existen " . count($coleccionViajes) . " viaje(s) para modificar:";
			        foreach ($coleccionViajes as $viaje) {
				        $cadena .= $viaje->mostrarString();
			        }
                    break;
                case 'visualizar':
                    $cadena .= "\n---> Actualmente existen " . count($coleccionViajes) . " viaje(s)";
			        foreach ($coleccionViajes as $viaje) {
				        $cadena .= $viaje;
			        }
            }
			
		} else {
			$cadena .= "No hay viajes existentes";
		}
		return $cadena;
	}

    public function listar($condicion){
	    $arregloViaje = null;
		$base=new BaseDatos();
		$consultaViaje="Select * from viaje ";
		if ($condicion!=""){
		    $consultaViaje=$consultaViaje.' where '.$condicion;
		}
		$consultaViaje.=" order by idviaje ";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaViaje)){				
				$arregloViaje = array();
				while($row2=$base->Registro()){
				    $idviaje=$row2['idviaje'];
					$vdestino=$row2['vdestino'];
					$vcantmaxpasajeros=$row2['vcantmaxpasajeros'];
					$idempresa=$row2['idempresa']; //hacer delegación
					$rnumeroempleado=$row2['rnumeroempleado']; //hacer delegación
                    $vimporte=$row2['vimporte'];
				
					$viaje=new Viaje();
					$viaje->cargar($vdestino,$vcantmaxpasajeros,$idempresa,$rnumeroempleado,$vimporte);
                    $viaje->setIdviaje($idviaje);
					array_push($arregloViaje, $viaje);
	
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
        $objEmp= $this->getObj_empresa();
		$consultaInsertar="INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte) 
				VALUES ('".$this->getVdestino()."',".$this->getVcantmaxpasajeros().",".$objEmp->getIdempresa().",".$this->getObj_responsable()->getRnumeroempleado().",".$this->getVimporte().")";
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
		$consultaModifica="UPDATE viaje SET idviaje=".$this->getIdviaje().", vdestino='".$this->getVdestino()."', vcantmaxpasajeros=".$this->getVcantmaxpasajeros().", idempresa=". $this->getObj_empresa()->getIdempresa().", rnumeroempleado=".$this->getObj_responsable()->getRnumeroempleado().", vimporte=".$this->getVimporte()." WHERE idviaje=".$this->getIdviaje();
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
    /** Función que muestra el Viaje tradicional (si usaba el __toString se traba el visual, demasiada información)
     * 
     */
    public function mostrarString() {
        $cadena="\n--------VIAJE--------\n";
        $cadena.= "NUMERO: ".$this->getIdviaje()."\n";
        $cadena.= "DESTINO: ".$this->getVdestino()."\n";
        $cadena.= "CANTIDAD MAXIMA DE PASAJEROS: ".$this->getVcantmaxpasajeros()."\n";
        $cadena.= "EMPRESA: ".$this->getObj_empresa()."\n";
        return $cadena;
    }
    public function __toString(){
        $cadena="\n--------VIAJE--------\n";
        $cadena.= "NUMERO: ".$this->getIdviaje()."\n";
        $cadena.= "DESTINO: ".$this->getVdestino()."\n";
        $cadena.= "CANTIDAD MAXIMA DE PASAJEROS: ".$this->getVcantmaxpasajeros()."\n";
        $cadena.= "EMPRESA: ".$this->getObj_empresa()."\n";
        $cadena.= "EMPLEADO RESPONSABLE: ".$this->getObj_responsable()."\n";
        $cadena.= "IMPORTE: ".$this->getVimporte()."\n";
        $cadena.= $this->mostrarColeccion($this->getIdviaje())."\n";
        
        return $cadena;
    }
}
