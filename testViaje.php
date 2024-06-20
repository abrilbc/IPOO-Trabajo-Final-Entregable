<?php
include_once('BaseDatos.php');
include_once('Persona.php');
include_once('empresa.php');
include_once('pasajero.php');
include_once('responsableV.php');
include_once('viaje.php');



function menuPrincipal() {
    do {
    echo "\n\n--------MENU PRINCIPAL--------\n";
    echo "1. Gestionar EMPRESA.\n";
    echo "2. Gestionar VIAJE.\n";
    echo "3. Salir \n";
    echo "ELECCIÓN: ";
    $opcion=trim(fgets(STDIN));
        switch($opcion){
        
        case '1': 
            gestionEmpresa();
            break;

        case '2': 
            gestionViaje();
            break;
        case 3:
            break;
        default:
            echo "-----> Opción Incorrecta\n";
        }
    } while ($opcion != 3);
}

function gestionEmpresa(){
echo "\nElija una de las siguientes opciones (1-5): \n";
echo "1. Agregar Empresa \n";
echo "2. Modificar Empresa \n";
echo "3. Eliminar Empresa \n";
echo "4. Listar Empresas existentes\n";
echo "5. Volver al Menú Principal\n";
echo "ELECCION: ";
$opcion=trim(fgets(STDIN));
switch($opcion){

    case 1: // Ingresa una nueva empresa
        echo "\nIngrese NOMBRE de la nueva empresa: ";
        $nombre= trim(fgets(STDIN));
        echo "Ingrese DIRECCION de la nueva empresa: ";
        $direccion= trim(fgets(STDIN));
        $obj_Empresa= new Empresa();
        $obj_Empresa->cargar($nombre,$direccion);
        $operacion = $obj_Empresa->insertar();
        if ($operacion) {
            echo "Empresa agregada exitosamente.";
            echo $obj_Empresa->__toString();
        } else {
            echo $obj_Empresa->getmensajeoperacion();
        }
        break;
    case 2: // Modifica una empresa
        $obj_Empresa = new Empresa;
        $visualizar = $obj_Empresa->mostrarEmpresas('visualizar');
        echo $visualizar;
        echo "\nIngrese el ID de la empresa a modificar: ";
        $idEmpresa=trim(fgets(STDIN));
        echo "\n¿Qué desea modificar? \n 1.NOMBRE \n 2.DIRECCION";
        echo "\nELECCION: ";
        $opcion=trim(fgets(STDIN));

        $operacion = null;
        switch ($opcion) {
            case 1:
                echo "NUEVO NOMBRE: ";
                $nombreNuevo=trim(fgets(STDIN));
                $obj_Empresa=new Empresa();
                $obj_Empresa->Buscar($idEmpresa);
                $obj_Empresa->setEnombre($nombreNuevo);
                break;
            case 2: 
                echo "NUEVA DIRECCION: ";
                $direccionNueva=trim(fgets(STDIN));
                $obj_Empresa=new Empresa();
                $obj_Empresa->Buscar($idEmpresa);
                $obj_Empresa->setEdireccion($direccionNueva);
                break;
            default:
                echo "-----> Opción Incorrecta\n";
        }
        // Modifica la empresa
        $operacion = $obj_Empresa->modificar();
        if ($operacion) {
            echo "Datos cambiados existosamente:";
            echo $obj_Empresa;
        }
        break;
    case 3: // Elimina una empresa
        $obj_Empresa = new Empresa();
        $visualizar = $obj_Empresa->mostrarEmpresas('visualizar');
        echo $visualizar;
        echo "\nIngrese el ID de la empresa que desea ELIMINAR: ";
        $idEliminar= trim(fgets(STDIN));
        $obj_Empresa->Buscar($idEliminar);
        echo "----> ¿Está segurx de querer eliminar la empresa " . $obj_Empresa->getEnombre() . "? (SI/NO)\n";
        echo "DECISION: ";
        $decision=trim(fgets(STDIN));

        if($decision == "si" || $decision == "SI" || $decision == "s" || $decision == "S"){
            $operacion = $obj_Empresa->eliminar();
            if ($operacion) {
                echo "Empresa eliminada exitosamente.";
            }
        } elseif ($decision == "no" || $decision == "NO" || $decision == "n" || $decision == "N") {
            echo "La empresa " . $obj_Empresa->getEnombre() . " NO se ha eliminado";
        }
        break;
    case 4: // Muestra las empresas almacenadas
        $obj_Empresa = new Empresa();
        $visualizar = $obj_Empresa->mostrarEmpresas('mostrar');
        echo $visualizar;
        break;
    case 5:
        break;
    default:
        echo "-----> Opción Incorrecta\n";
    }
}

function gestionViaje() {

    echo "\nElija una de las siguientes opciones (1-5): \n";
    echo "1. AGREGAR Viaje \n";
    echo "2. MODIFICAR Viaje \n";
    echo "3. ELIMINAR Viaje \n";
    echo "4. LISTAR Viajes Existentes\n";
    echo "5. GESTIONAR Persona\n";
    echo "6. Volver al Menú Principal\n";
    echo "ELECCION: ";
    $opcion=trim(fgets(STDIN));
    switch ($opcion) {
        case 1: // Agrega un viaje
            echo "\nIngrese el destino de su viaje: ";
            $destino = trim(fgets(STDIN));
            echo "\nIngrese la cantidad máxima de pasajeros: ";
            $cantMax = trim(fgets(STDIN));
            echo "\nIngrese el ID de la empresa encargada del viaje: \n";

            /** Muestra las empresas existentes */
            $emp = new Empresa();
            echo $emp->mostrarEmpresas('mostrar');
            echo "EMPRESA ELEGIDA: ";
            $empresa = trim(fgets(STDIN));
            if ($emp->Buscar($empresa)) {
                /** Muestra los responsables existentes */
                $obj_responsable = new ResponsableV();
                echo $obj_responsable->mostrarResponsable();
                echo "\nIngrese el número de empleado responsable: \n";
                echo "RESPONSABLE ELEGIDO: ";
                $responsable = trim(fgets(STDIN));
                if ($obj_responsable->Buscar($responsable)) {
                    echo "Ingrese el Importe: ";
                    $imp = trim(fgets(STDIN));
                    $viaje = new Viaje();
                    $viaje->cargar($destino, $cantMax, $emp , $obj_responsable, $imp);
                    if ($viaje->insertar()){
                        echo "-----> Viaje creado correctamente.\n";
                    };
                } else {
                    echo "\n----> ERROR: Responsable no encontrado.";
                }
            } else {
                echo "\n----> ERROR: Empresa no encontrada.";
            }
            
            
            break;
        case 2: // Modifica los viajes almacenados
            $viaje = new Viaje();
            $visualizar = $viaje->mostrarViajes('mostrar');
            echo $visualizar;
            echo "\nIngrese el ID del viaje que quiere modificar: ";
            $idviaje = trim(fgets(STDIN));
            $operacion = $viaje->Buscar($idviaje);
            if ($operacion) {
                modificarViaje($viaje);
            } else {
                echo "\nViaje NO encontrado.";
            }
            break;
        case 3: // Elimina los viajes almacenados
            $viaje = new Viaje();
            $visualizar = $viaje->mostrarViajes('mostrar');
            echo $visualizar;
            echo "\nIngrese el ID del viaje que desea ELIMINAR: ";
            $idEliminar= trim(fgets(STDIN));
            $buscar = $viaje->Buscar($idEliminar);
            if ($buscar) {
                echo "----> ¿Está segurx de querer eliminar el viaje de ID " . $viaje->getIdviaje() . "? (SI/NO)\n";
                echo "DECISION: ";
                $decision=trim(fgets(STDIN));

                if($decision == "si" || $decision == "SI" || $decision == "s" || $decision == "S"){
                    $operacion = $viaje->eliminar();
                    if ($operacion) {
                        echo "Viaje eliminado exitosamente.";
                    } else {
                        echo "Hubo un problema con la eliminación.";
                    }
                } elseif ($decision == "no" || $decision == "NO" || $decision == "n" || $decision == "N") {
                    echo "El viaje " . $viaje->getIdviaje() . " NO se ha eliminado";
                }
            } else {
                echo "-----> No existe un viaje con ese ID.";
            }
            break;
        case 4: //Muestra los viajes almacenados
            $viaje = new Viaje();
            $visualizar = $viaje->mostrarViajes('visualizar');
            echo $visualizar;
            break;
        case 5: 
            gestionarPersona();
            break;
        case 6:
            break;
        default:
            echo "Opción Incorrecta.";
        }
    }

    function modificarViaje($viaje) {
        echo "\nViaje encontrado.\n";
                    echo "¿Qué desea modificar?\n";
                    echo "1. Destino\n";
                    echo "2. Cantidad Máxima de Pasajeros\n";
                    echo "3. Empresa\n";
                    echo "4. Responsable\n";
                    echo "5. Importe de Viaje\n";
                    echo "6. Salir\n";
                    echo "ELECCION: ";
                    $selec = trim(fgets(STDIN));
                    switch($selec) {
                        case 1: // Modifica el destino del viaje
                            echo "\nIngrese el nuevo destino: ";
                            $nuevoDestino = trim(fgets(STDIN));
                            $viaje->setVdestino($nuevoDestino);
                            break;
                        case 2:
                            echo "\nIngrese la nueva cantidad máxima: ";
                            $nuevaCant = trim(fgets(STDIN));
                            $viaje->setVcantmaxpasajeros($nuevaCant);
                            break;
                        case 3:
                            echo "\nIngrese el ID de la nueva empresa: ";
                            $nuevaEmpresa = trim(fgets(STDIN));
                            $viaje->setIdempresa($nuevaEmpresa);
                            break;
                        case 4:
                            echo "\nIngrese el Número de Empleado del nuevo responsable: ";
                            $nuevoResponsable = trim(fgets(STDIN));
                            $viaje->setRnumeroempleado($nuevoResponsable);
                            break;
                        case 5:
                            echo "\nIngrese el nuevo Importe: ";
                            $importeNuevo = trim(fgets(STDIN));
                            $viaje->setVimporte($importeNuevo);
                            break;
                        case 6:
                            break;
                        default: 
                            echo "Opción Incorrecta.";
                    }
                    $operacion = $viaje->modificar();
                    if ($operacion) {
                        echo "Viaje modificado exitosamente.\n";
                    }
    }

function gestionarResponsable(){
    echo "\n--------OPCIONES--------\n";
    echo "1. Agregar responsable\n";
    echo "2. Modificar responsable\n";
    echo "3. Eliminar responsable\n";
    echo "4. Salir\n";
    echo "ELECCION: ";
    $opcion = trim(fgets(STDIN));
    $responsable = new ResponsableV();
    switch($opcion){
        case 1: 
        echo "\nIngrese el nombre del responsable: ";
        $nombre = trim(fgets(STDIN));
        echo "\nIngrese el apellido del responsable: ";
        $apellido = trim(fgets(STDIN));
        echo "\nIngrese el DNI del responsable: ";
        $dni = trim(fgets(STDIN));
        echo "\nIngrese el telefono del responsable: ";
        $telefono = trim(fgets(STDIN));
        echo "\nIngrese el numero de licencia: ";
        $numLicencia = trim(fgets(STDIN));
        $responsable->cargar($dni, $nombre, $apellido, $telefono);
        $responsable->cargarEmpleado($numLicencia);
        $operacion = $responsable->insertar();
        if ($operacion) {
            echo "\nResponsable agregado correctamente.\n";
        } else {
            echo "\nHubo un problema con la operación.\n";
        }
    break;
    
    case 2:
        /* Muestra los responsables existentes */
        $responsable = new ResponsableV();
        $visualizar = $responsable->mostrarResponsable();
        echo $visualizar;

        echo "\n\nIngrese el numero de empleado del responsable a modificar: ";
        $nroEmpleado=trim(fgets(STDIN));

        if ($responsable->Buscar($nroEmpleado)) {
            echo "\n¿Qué desea modificar? \n 1.NOMBRE \n 2.APELLIDO \n 3.DNI \n 4.TELEFONO \n 5.NUMERO DE LICENCIA";
            echo "\nELECCION: ";
            $opcion=trim(fgets(STDIN));
            $operacion = null;
            switch($opcion){
            case 1:
                echo "NUEVO NOMBRE: ";
                $nombreNuevo = trim(fgets(STDIN));
                $obj_responsable = new ResponsableV();
                $obj_responsable->Buscar($nroEmpleado);
                $idresponsable = $obj_responsable->getIdPersona();
                $obj_persona = new Persona();
                $obj_persona->Buscar($idresponsable);
                $obj_persona->setNombre($nombreNuevo);
                $operacion = $obj_persona->modificar();
                break;
            case 2:
                echo "NUEVO APELLIDO: ";
                $apellidoNuevo=trim(fgets(STDIN));
                $obj_responsable=new ResponsableV();
                $obj_responsable->Buscar($nroEmpleado);
                $idresponsable = $obj_responsable->getIdPersona();
                $obj_persona = new Persona();
                $obj_persona->Buscar($idresponsable);
                $obj_persona->setApellido($apellidoNuevo);
                $operacion = $obj_persona->modificar();
                break;
            case 3:
                echo "NUEVO DNI: ";
                $dniNuevo=trim(fgets(STDIN));
                $obj_responsable=new ResponsableV();
                $obj_responsable->Buscar($nroEmpleado);
                $idresponsable = $obj_responsable->getIdPersona();
                $obj_persona = new Persona();
                $obj_persona->Buscar($idresponsable);
                $obj_persona->setNrodoc($dniNuevo);
                $operacion = $obj_persona->modificar();
                break;
            case 4:
                echo "NUEVO TELEFONO: ";
                $telefonoNuevo=trim(fgets(STDIN));
                $obj_responsable=new ResponsableV();
                $obj_responsable->Buscar($nroEmpleado);
                $idresponsable = $obj_responsable->getIdPersona();
                $obj_persona = new Persona();
                $obj_persona->Buscar($idresponsable);
                $obj_persona->setTelefono($telefonoNuevo);
                $operacion = $obj_persona->modificar();
                break;
            case 5:
                echo "NUEVO NUMERO DE LICENCIA: ";
                $nroLicenciaNuevo=trim(fgets(STDIN));
                $obj_responsable=new ResponsableV();
                $obj_responsable->Buscar($nroEmpleado);
                $idresponsable = $obj_responsable->getIdPersona();
                $obj_responsable->setRnumerolicencia($nroLicenciaNuevo);
                $operacion = $obj_responsable->modificar();
                break;
            default:
                echo "-----> Opción incorrecta\n";
            }
            if ($operacion && $operacion != null) {
                echo "Datos cambiados existosamente.";
                // echo $obj_persona->__toString();
            }
            break;
        } else {
            echo "-----> Responsable no encontrado.\n";
        }
    case 3:
            /* Mostrar responsables existentes */
            $responsable = new ResponsableV();
            $visualizar = $responsable->mostrarResponsable();
            echo $visualizar;

            echo "\nIngrese el numero de empleado que desea ELIMINAR: ";
            $nroEliminar= trim(fgets(STDIN));
            $obj_responsable = new ResponsableV();
            $buscar = $obj_responsable->Buscar($nroEliminar);
            if ($buscar) {
                echo "----> ¿Está segurx de querer eliminar al responsable " . $obj_responsable->getRnumeroempleado() . "? (SI/NO)\n";
                echo "\nDECISION: ";
                $decision=trim(fgets(STDIN));

                if($decision == "si" || $decision == "SI" || $decision == "s" || $decision == "S"){
                    $operacion = $obj_responsable->eliminar();
                    if ($operacion) {
                        echo "Responsable eliminado exitosamente.";
                    } else {
                        echo "Hubo un problema con la eliminación.";
                    }
                } elseif ($decision == "no" || $decision == "NO" || $decision == "n" || $decision == "N") {
                    echo "El responsable " . $obj_responsable->getRnumeroempleado() . " NO se ha eliminado";
                }
            } else {
                echo "---> No existe un responsable con ese numero de empleado.";
            }
            break;
            default:
             echo "-----> Opcion incorrecta\n";
    }
}

function gestionarPasajero(){
    echo "\n--------OPCIONES--------\n";
    echo "1. AGREGAR pasajero\n";
    echo "2. MODIFICAR pasajero\n";
    echo "3. ELIMINAR pasajero\n";
    echo "4. Salir\n";
    echo "ELECCION: ";
    $opcion = trim(fgets(STDIN));
    switch($opcion){
        case 1: 
        
        $obj_viaje = new Viaje();
        echo "\nDestinos: \n";
        $verViajes = $obj_viaje->mostrarViajes('visualizar');
        echo $verViajes;
        echo "\nIngrese el ID del destino: ";
        $idViaje = trim(fgets(STDIN));
        $obj_viaje->Buscar($idViaje);

            if($obj_viaje->cantidadMaxima(($idViaje))){
                if ($obj_viaje->Buscar($idViaje)){
                    echo "\nIngrese el nombre del pasajero: ";
                    $nombre = trim(fgets(STDIN));
                    echo "\nIngrese el apellido del pasajero: ";
                    $apellido = trim(fgets(STDIN));
                    echo "\nIngrese el DNI del pasajero: ";
                    $dni = trim(fgets(STDIN));
                    echo "\nIngrese el telefono del pasajero: ";
                    $telefono = trim(fgets(STDIN));
                    $pasajero = new Pasajero();
                    $pasajero->cargar($dni, $nombre, $apellido, $telefono);
                    $pasajero->cargarViaje($obj_viaje);
                    $operacion = $pasajero->insertar();
                    if ($operacion){
                        echo "Pasajero agregado correctamente.\n";
                    }else {
                        echo "Ocurrio un problema.\n";
                    }
                }

            }else {
                echo "-----> Este viaje ha alcanzado su capacidad maxima de pasajeros.";
            }

    break;
    case 2: // Modifica un pasajero
        $pasaj = new Pasajero();
        echo $pasaj->mostrarPasajero('mostrar');
        echo "\nIngrese el numero de pasajero a modificar: ";
        $nroPasajero=trim(fgets(STDIN));
        if ($pasaj->Buscar($nroPasajero)){
            echo "\n¿Qué desea modificar? \n 1.NOMBRE \n 2.APELLIDO \n 3.DNI \n 4.TELEFONO \n 5.VIAJE";
            echo "\nELECCION: ";
            $opcion=trim(fgets(STDIN));
            $operacion = null;
            switch($opcion){
            case 1:
                echo "NUEVO NOMBRE: ";
                $nombreNuevo = trim(fgets(STDIN));
                $obj_pasajero = new Pasajero();
                $obj_pasajero->Buscar($nroPasajero);
                $idpasajero = $obj_pasajero->getIdPersona();
                $obj_persona = new Persona();
                $obj_persona->Buscar($idpasajero);
                $obj_persona->setnombre($nombreNuevo);
                $operacion = $obj_persona->modificar();
                break;
            case 2:
                echo "NUEVO APELLIDO: ";
                $apellidoNuevo=trim(fgets(STDIN));
                $obj_pasajero=new Pasajero();
                $obj_pasajero->Buscar($nroPasajero);
                $idpasajero = $obj_pasajero->getIdPersona();
                $obj_persona = new Persona();
                $obj_persona->Buscar($idpasajero);
                $obj_persona->setapellido($apellidoNuevo);
                $operacion = $obj_persona->modificar();
                break;
            case 3:
                echo "NUEVO DNI: ";
                $dniNuevo=trim(fgets(STDIN));
                $obj_pasajero=new Pasajero();
                $obj_pasajero->Buscar($nroPasajero);
                $idpasajero = $obj_pasajero->getIdPersona();
                $obj_persona = new Persona();
                $obj_persona->Buscar($idpasajero);
                $obj_persona->setNrodoc($dniNuevo);
                $operacion = $obj_persona->modificar();
                break;
            case 4:
                echo "NUEVO TELEFONO: ";
                $telefonoNuevo=trim(fgets(STDIN));
                $obj_pasajero=new Pasajero();
                $obj_pasajero->Buscar($nroPasajero);
                $idpasajero = $obj_pasajero->getIdPersona();
                $obj_persona = new Persona();
                $obj_persona->Buscar($idpasajero);
                $obj_persona->setTelefono($telefonoNuevo);
                $operacion = $obj_persona->modificar();
                break;
            case 5:
                echo "\nViajes Disponibles: \n";
                $viaje = new Viaje();
                echo $viaje->mostrarViajes('mostrar');
                echo "NUEVO VIAJE: ";
                $idViajeNuevo = trim(fgets(STDIN));
                $obj_pasajero = new Pasajero();
                $obj_pasajero->Buscar($nroPasajero);
                $obj_pasajero->setObjViaje($idViajeNuevo);
                $operacion = $obj_pasajero->modificar();
                break;
                default:
                echo "Opción Incorrecta.";
            }
            if ($operacion && $operacion != null) {
                echo "Datos cambiados ex<istosamente.";
                echo $obj_pasajero;
            }
        }else {
            echo "----> Pasajero NO encontrado.\n";
        }
        break;
        
    case 3: //
            $obj_pasajero = new Pasajero();
            $visualizar = $obj_pasajero->mostrarPasajero('mostrar');
            echo $visualizar;
            echo "\nIngrese el numero de pasajero que desea ELIMINAR: ";
            $nroEliminar= trim(fgets(STDIN));
            $buscar = $obj_pasajero->Buscar($nroEliminar);
            if ($buscar){
                echo "----> ¿Está segurx de querer eliminar al pasajero " . $obj_pasajero->getIdPersona() . "? (SI/NO)\n";
                echo "DECISION: ";
                $decision=trim(fgets(STDIN));
                if($decision == "si" || $decision == "SI" || $decision == "s" || $decision == "S"){
                    $operacion = $obj_pasajero->eliminar();
                    if ($operacion) {
                        echo "Pasajero eliminado exitosamente.";
                    } else {
                        echo "Hubo un problema con la eliminación.";
                    }
                } elseif ($decision == "no" || $decision == "NO" || $decision == "n" || $decision == "N") {
                    echo "El pasajero " . $obj_pasajero->getIdPersona() . " NO se ha eliminado";
                }
            }else{
            echo "------> No existe un pasajero con ese ID";
            }
            break;
        case 4:
            echo "\n¡Nos vamos luego!";
            break;
        default:
            echo "\nOpción incorrecta.";
    }
}

function gestionarPersona() {
    echo "\nSeleccione lo que desea gestionar: \n";
    echo "1. Responsable del viaje \n";
    echo "2. Pasajero del viaje \n";
    echo "Selección: ";
    $seleccion = trim(fgets(STDIN));
    switch ($seleccion) {
        case 1: 
            gestionarResponsable();
            break;
        case 2:
            gestionarPasajero();
            break;
        default:
        echo "Opción incorrecta.";
    }
}

function visualizarEmpresas() {
    $obj_Empresa = new Empresa();
    $visualizar = $obj_Empresa->mostrarEmpresas();
    echo $visualizar;
}

menuPrincipal();
?>