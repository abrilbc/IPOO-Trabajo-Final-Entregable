<?php
include_once('BaseDatos.php');
include_once('Persona.php');
include_once('empresa.php');
include_once('pasajero.php');
include_once('responsableV.php');
include_once('viaje.php');



function menuPrincipal() {
    
    echo "\n--------MENU PRINCIPAL--------\n";
    echo "1. Gestionar EMPRESA.\n";
    echo "2. Gestionar VIAJE.\n";
    echo "3. Salir \n";
    echo "ELECCIÓN: ";
    $opcion=trim(fgets(STDIN));

    switch($opcion){
    
    case '1': gestionEmpresa();

    case '2': gestionViaje();

    }
}

function gestionEmpresa(){
echo "\nElija una de las siguientes opciones (1-5): \n";
echo "1. Agregar Empresa \n";
echo "2. Modificar Empresa \n";
echo "3. Eliminar Empresa \n";
echo "4. Listar Empresas existentes\n";
echo "5. Salir\n";
echo "ELECCION: ";
$opcion=trim(fgets(STDIN));
switch($opcion){

    case 1:  
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
    case 2:
        $obj_Empresa = new Empresa;
        $visualizar = $obj_Empresa->mostrarEmpresas();
        echo $visualizar;
        echo "\nIngrese el ID de la empresa a modificar: ";
        $idEmpresa=trim(fgets(STDIN));
        echo "\n¿Qué desea modificar? \n 1.NOMBRE \n 2.DIRECCION";
        echo "\nELECCION: ";
        $opcion=trim(fgets(STDIN));

        $operacion = null;
        if($opcion==1){
            echo "NUEVO NOMBRE: ";
            $nombreNuevo=trim(fgets(STDIN));
            $obj_Empresa=new Empresa();
            $obj_Empresa->Buscar($idEmpresa);
            $obj_Empresa->setEnombre($nombreNuevo);
            $operacion = $obj_Empresa->modificar();
        } elseif($opcion==2) {
            echo "NUEVA DIRECCION: ";
            $direccionNueva=trim(fgets(STDIN));
            $obj_Empresa=new Empresa();
            $obj_Empresa->Buscar($idEmpresa);
            $obj_Empresa->setEdireccion($direccionNueva);
            $operacion = $obj_Empresa->modificar();
        }
        else{
            echo "CLAVE INCORRECTA. \n";
        }
        if ($operacion && $operacion != null) {
            echo "Datos cambiados existosamente.";
            echo $obj_Empresa->__toString();
        }
        break;
         
    case 3: 
        $obj_Empresa = new Empresa();
        $visualizar = $obj_Empresa->mostrarEmpresas();
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
    case 4:
        $obj_Empresa = new Empresa();
        $visualizar = $obj_Empresa->mostrarEmpresas();
        echo $visualizar;
        break;
    case 5: 
        echo "------> ¡Hasta luego!";
        break;
    }
}

function gestionViaje() {

    echo "\nElija una de las siguientes opciones (1-5): \n";
    echo "1. Agregar Viaje \n";
    echo "2. Modificar Viaje \n";
    echo "3. Eliminar Viaje \n";
    echo "4. Listar Viajes Existentes\n";
    echo "5. Gestionar responsable\n";
    echo "6. Gestionar pasajero\n";
    echo "7. Salir\n";
    echo "ELECCION: ";
    $opcion=trim(fgets(STDIN));
    switch ($opcion) {
        case 1: 
            echo "\nIngrese el destino de su viaje: ";
            $destino = trim(fgets(STDIN));
            echo "\nIngrese la cantidad máxima de pasajeros: ";
            $cantMax = trim(fgets(STDIN));
            echo "\nIngrese el ID de la empresa encargada del viaje: ";
            $emp = new Empresa();
            $emp->mostrarEmpresas();
            echo "EMPRESA ELEGIDA: ";
            $empresa = trim(fgets(STDIN));
            echo "\nIngrese el número de empleado responsable: ";
            echo "RESPONSABLE ELEGIDO: ";
            $responsable = trim(fgets(STDIN));
            echo "Ingrese el Importe: ";
            $imp = trim(fgets(STDIN));
            $viaje = new Viaje();
            $viaje->cargar($destino, $cantMax, $empresa, $responsable, $imp);
            $viaje->insertar();
            break;
        case 2:
            $viaje = new Viaje();
            $visualizar = $viaje->mostrarViajes();
            echo $visualizar;
            echo "\nIngrese el ID del viaje que quiere modificar: ";
            $idviaje = trim(fgets(STDIN));
            $operacion = $viaje->Buscar($idviaje);
            if ($operacion) {
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
                    case 1:
                        echo "\nIngrese el nuevo destino: ";
                        $nuevoDestino = trim(fgets(STDIN));
                        $viaje->setVdestino($nuevoDestino);
                        $viaje->modificar();
                        break;
                    case 2:
                        echo "\nIngrese la nueva cantidad máxima: ";
                        $nuevaCant = trim(fgets(STDIN));
                        $viaje->setVcantmaxpasajeros($nuevaCant);
                        $viaje->modificar();
                        break;
                    case 3:
                        echo "\nIngrese el ID de la nueva empresa: ";
                        $nuevaEmpresa = trim(fgets(STDIN));
                        $viaje->setIdempresa($nuevaEmpresa);
                        $viaje->modificar();
                        break;
                    case 4:
                        echo "\nIngrese el Número de Empleado del nuevo responsable: ";
                        $nuevoResponsable = trim(fgets(STDIN));
                        $viaje->setRnumeroempleado($nuevoResponsable);
                        $viaje->modificar();
                        break;
                    case 5:
                        echo "\nIngrese el nuevo Importe: ";
                        $importeNuevo = trim(fgets(STDIN));
                        $viaje->setVimporte($importeNuevo);
                        $viaje->modificar();
                    case 6:
                        break;
                }
                
            } else {
                echo "\nViaje NO encontrado.";
            }
            break;
        case 3:
            $viaje = new Viaje();
            $visualizar = $viaje->mostrarViajes();
            echo $visualizar;
            echo "\nIngrese el ID del viaje que desea ELIMINAR: ";
            $idEliminar= trim(fgets(STDIN));
            $viaje->Buscar($idEliminar);
            echo "----> ¿Está segurx de querer eliminar el viaje " . $viaje->getIdviaje() . "? (SI/NO)\n";
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
            break;
        case 4: 
            $viaje = new Viaje();
            $visualizar = $viaje->mostrarViajes();
            echo $visualizar;
            break;
        case 5: gestionarResponsable();
            break;
        case 6: gestionarPasajero();
            break;
        }
}

function gestionarResponsable(){
    echo "1. Agregar responsable\n";
    echo "2. Modificar responsable\n";
    echo "3. Eliminar responsable\n";
    echo "4. Salir\n";
    echo "ELECCION: ";
    $opcion = trim(fgets(STDIN));
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

        // $persona = new Persona();
        // $persona->cargar($dni, $nombre, $apellido,$telefono);
        // $persona->insertar();
        $responsable=new ResponsableV();
        $responsable->cargar($dni, $nombre, $apellido, $telefono);
        $responsable->cargarEmpleado($numLicencia);
        $responsable->insertar();
    break;
    
    case 2:
        echo "\nIngrese el numero de empleado del responsable a modificar: ";
        $nroEmpleado=trim(fgets(STDIN));
        echo "\n¿Qué desea modificar? \n 1.NOMBRE \n 2.APELLIDO \n 3.DNI \n 4.TELEFONO \n 5.NUMERO DE LICENCIA";
        echo "\nELECCION: ";
        $opcion=trim(fgets(STDIN));
        $operacion = null;
        switch($opcion){
        case 1:
            echo "NUEVO NOMBRE: ";
            $nombreNuevo=trim(fgets(STDIN));
            $obj_responsable=new ResponsableV();
            $obj_responsable->Buscar($nroEmpleado);
            $idresponsable = $obj_responsable->getIdPersona();
            $obj_persona = new Persona();
            $obj_persona->Buscar($idresponsable);
            $obj_persona->setnombre($nombreNuevo);
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
            $obj_persona->setapellido($apellidoNuevo);
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
        }
        if ($operacion && $operacion != null) {
            echo "Datos cambiados existosamente.";
            // echo $obj_persona->__toString();
        }
        break;
    case 3:
            // $responsable = new ResponsableV();
            // $visualizar = $responsable->mostrarResponsable();
            // echo $visualizar;
            echo "\nIngrese el numero de empleado que desea ELIMINAR: ";
            $nroEliminar= trim(fgets(STDIN));
            // $obj_persona= new Persona();
            $obj_responsable = new ResponsableV();
            $obj_responsable->Buscar($nroEliminar);
            
            echo "----> ¿Está segurx de querer eliminar al responsable " . $obj_responsable->getRnumeroempleado() . "? (SI/NO)\n";
            echo "DECISION: ";
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
            break;
    }
}

function gestionarPasajero(){
    echo "1. Agregar pasajero\n";
    echo "2. Modificar pasajero\n";
    echo "3. Eliminar pasajero\n";
    echo "4. Salir\n";
    echo "ELECCION: ";
    $opcion = trim(fgets(STDIN));
    switch($opcion){
        case 1: 
        $obj_viaje = new Viaje();
        echo "\nIngrese el nombre del pasajero: ";
        $nombre = trim(fgets(STDIN));
        echo "\nIngrese el apellido del pasajero: ";
        $apellido = trim(fgets(STDIN));
        echo "\nIngrese el DNI del pasajero: ";
        $dni = trim(fgets(STDIN));
        echo "\nIngrese el telefono del pasajero: ";
        $telefono = trim(fgets(STDIN));
        echo "\nDestinos: \n";
        $verViajes = $obj_viaje->mostrarViajes();
        echo $verViajes;
        echo "\nIngrese el ID del destino: ";
        $idViaje = trim(fgets(STDIN));
        $obj_viaje->Buscar($idViaje);

        // $persona = new Persona();
        // $persona->cargar($dni, $nombre, $apellido,$telefono);
        // $persona->insertar();
        $pasajero = new Pasajero();
        $pasajero->cargar($dni, $nombre, $apellido, $telefono);
        $pasajero->cargarViaje($idViaje);
        $operacion = $pasajero->insertar();
        if ($operacion) {
            echo "\n\nOperacion realizada exitosamente.";
        } else {
            echo "\n\nNO";
        }
    break;
    case 2:
        echo "\nIngrese el numero de empleado del responsable a modificar: ";
        $nroEmpleado=trim(fgets(STDIN));
        echo "\n¿Qué desea modificar? \n 1.NOMBRE \n 2.APELLIDO \n 3.DNI \n 4.TELEFONO \n 5.NUMERO DE LICENCIA";
        echo "\nELECCION: ";
        $opcion=trim(fgets(STDIN));
        $operacion = null;
        switch($opcion){
        case 1:
            echo "NUEVO NOMBRE: ";
            $nombreNuevo=trim(fgets(STDIN));
            $obj_responsable=new ResponsableV();
            $obj_responsable->Buscar($nroEmpleado);
            $idresponsable = $obj_responsable->getIdPersona();
            $obj_persona = new Persona();
            $obj_persona->Buscar($idresponsable);
            $obj_persona->setnombre($nombreNuevo);
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
            $obj_persona->setapellido($apellidoNuevo);
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
        }
        if ($operacion && $operacion != null) {
            echo "Datos cambiados existosamente.";
            // echo $obj_persona->__toString();
        }
        break;
    case 3:
            // $responsable = new ResponsableV();
            // $visualizar = $responsable->mostrarResponsable();
            // echo $visualizar;
            echo "\nIngrese el numero de empleado que desea ELIMINAR: ";
            $nroEliminar= trim(fgets(STDIN));
            // $obj_persona= new Persona();
            $obj_responsable = new ResponsableV();
            $obj_responsable->Buscar($nroEliminar);
            
            echo "----> ¿Está segurx de querer eliminar al responsable " . $obj_responsable->getRnumeroempleado() . "? (SI/NO)\n";
            echo "DECISION: ";
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
            break;
    }
}
// function gestionPersona(){
//     echo "1. Agregar responsable\n";
//     echo "2. Gestionar pasajero\n";
//     echo "3. Salir \n";
//     echo "ELECCIÓN: ";
//     $opcion = trim(fgets(STDIN));
//     switch($opcion) {
//         case 1: gestionResponsable();
//             echo "\nIngrese el nombre del responsable: ";
//             $nombre = trim(fgets(STDIN));
//             echo "\nIngrese el apellido del responsable: ";
//             $apellido = trim(fgets(STDIN));
//             echo "\nIngrese el DNI del responsable: ";
//             $dni = trim(fgets(STDIN));
//             echo "\nIngrese el telefono del responsable: ";
//             $telefono = trim(fgets(STDIN));
//             echo "\nIngrese el numero de licencia: ";
//             $numLicencia = trim(fgets(STDIN));
//             $persona = new Persona();
//             $persona->cargar($dni, $nombre, $apellido,$telefono);
//             $persona->insertar();
//             $idpersona = $persona->getIdPersona();
//             $responsable=new ResponsableV();
//             $responsable->cargar($dni, $nombre, $apellido, $telefono);
//             $responsable->cargarEmpleado($idpersona, $numLicencia);
//             $responsable->insertar();
//         break;
        
//         case 2: gestionPasajero();
//             $viaje = new Viaje();
//             $visualizar = $viaje->mostrarViajes();
//             echo "\nIngrese el nombre del pasajero: ";
//             $nombre = trim(fgets(STDIN));
//             echo "\nIngrese el apellido del pasajero: ";
//             $apellido = trim(fgets(STDIN));
//             echo "\nIngrese el DNI del pasajero: ";
//             $dni = trim(fgets(STDIN));
//             echo "\nIngrese el telefono del pasajero: ";
//             $telefono = trim(fgets(STDIN));
//             echo "\nIngrese el ID del viaje que desea realizar: ";
//             echo $visualizar;
//             echo "ELECCION: ";
//             $idviaje = trim(fgets(STDIN));
//             $viajeElegido = $viaje->Buscar($idviaje);
//             $persona = new Persona();
//             $persona->cargar($nombre, $apellido, $dni, $telefono);
//             $persona->insertar();
//             $pasajero = new Pasajero();
//             $pasajero->cargar($nombre, $apellido, $dni, $telefono);
//             $pasajero->cargarViaje($viajeElegido);
//             $pasajero->insertar();
//         break;
//     }
// }

function agregar($objeto){
    $respuesta = $objeto->insertar();
    
}

$obj_Persona= new Persona;
// $obj_Persona->cargar(42806093,"Rodrigo","Velo",2944537213);
//     $respuesta=$obj_Persona->insertar();
//     // Inserto el OBj Persona en la base de datos
//     if ($respuesta==true) {
//             echo "\nOP INSERCION;  La persona fue ingresada en la BD";
//             $colPersonas =$obj_Persona->listar("");
//             foreach ($colPersonas as $unaPersona){

//                 echo $unaPersona;
//                 echo "-------------------------------------------------------";
//             }
//     }else 
//         echo $obj_Persona->getmensajeoperacion();

    // $obj_Persona->cargar(12345,"Martin","Traga Leche",4213452);
    

menuPrincipal();