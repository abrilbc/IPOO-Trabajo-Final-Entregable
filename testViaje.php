<?php
include_once('BaseDatos.php');
include_once('Persona.php');
include_once('empresa.php');
include_once('pasajero.php');
include_once('responsableV.php');
include_once('viaje.php');



function menuPrincipal() {
    echo "\n--------MENU PRINCIPAL--------\n";
    echo "1. Gestionar empresa.\n";
    echo "2. Gestionar viaje.\n";
    echo "3. Salir \n";
    echo "ELECCIÓN: ";
    $opcion=trim(fgets(STDIN));

    switch($opcion){
    
    case '1': menuPersona();

    case '2': gestion();

    case '3': gestion();
    }
}

function gestion(){
echo "1. AGREGAR: ";
echo "2. MODIFICAR: ";
echo "3. ELIMINAR: ";
echo "4. SALIR";
$opcion=trim(fgets(STDIN));
switch($opcion){
    case 1: ; 
    case 2: ;
    case 3: ;
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
    $obj_Persona->setIdPersona(2);
    // $obj_Persona->modificar();

    $obj_Persona->eliminar();