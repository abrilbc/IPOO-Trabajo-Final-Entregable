<?php
include_once('BaseDatos.php');
include_once('Persona.php');
include_once('empresa.php');
include_once('pasajero.php');
include_once('responsableV.php');
include_once('viaje.php');



function menuPrincipal() {
    
    echo "\n--------MENU PRINCIPAL--------\n";
    echo "1. GESTIONAR EMPRESA.\n";
    echo "2. GESTIONAR VIAJE.\n";
    echo "3. Salir \n";
    echo "ELECCIÓN: ";
    $opcion=trim(fgets(STDIN));

    switch($opcion){
    
    case '1': gestion();

    case '2': gestion();

    }
}


function gestion(){
echo "1. AGREGAR: \n";
echo "2. MODIFICAR: \n";
echo "3. ELIMINAR: \n";
echo "4. SALIR\n";
$opcion=trim(fgets(STDIN));
switch($opcion){

    case 1:  
        echo "INGRESE NOMBRE: \n";
        $nombre= trim(fgets(STDIN));
        echo "INGRESE DIRECCION: \n";
        $direccion= trim(fgets(STDIN));
        $obj_Empresa= new Empresa;
        $obj_Empresa->cargar($nombre,$direccion);
        $obj_Empresa->insertar();
        break;

    case 2:
        echo "INGRESE EL ID DE LA EMPRESA A MODIFICAR: \n";
        $idEmpresa=trim(fgets(STDIN));
        echo "QUE DESEA MODIFICAR?\n 1.NOMBRE\n 2.DIRECCION \n";
        $opcion=trim(fgets(STDIN));
        if($opcion==1){
            echo "NUEVO NOMBRE: \n";
            $nombreNuevo=trim(fgets(STDIN));
            $obj_Empresa=new Empresa;
            $obj_Empresa->Buscar($idEmpresa);
            $obj_Empresa->setEnombre($nombreNuevo);
            $obj_Empresa->modificar();
        }
        elseif($opcion==2){
            echo "NUEVA DIRECCION: \n";
            $direccionNueva=trim(fgets(STDIN));
            $obj_Empresa=new Empresa;
            $obj_Empresa->Buscar($idEmpresa);
            $obj_Empresa->setEdireccion($direccionNueva);
            $obj_Empresa->modificar();
        }
        else{
            echo "CLAVE INCORRECTA. \n";
        }
        break;
         
    case 3: 
        
        echo "INGRESE EL ID DE LA EMPRESA QUE DESEA ELIMINAR: \n";
        $idEliminar= trim(fgets(STDIN));
        echo "¿ESTA SEGURO DE SU OPERACION? \n 1.SI | 2.NO \n";
        $decision=trim(fgets(STDIN));

        if($decision==1){
            $obj_Empresa= new Empresa;
            $obj_Empresa->Buscar($idEliminar);
            $obj_Empresa->eliminar();
        }
    case 4: ;
}
}

function menuPersona(){
    echo "1. Gestionar responsable";
    echo "2. Gestionar pasajero";
    echo "3. Salir ";
    echo "ELECCIÓN: ";
    $opcion = trim(fgets(STDIN));
    switch($opcion) {
        case 1: gestion();
        case 2: gestion();
        
    }
}

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