<?php
include_once('BaseDatos.php');
include_once('Persona.php');
include_once('empresa.php');
include_once('pasajero.php');
include_once('responsableV.php');
include_once('viaje.php');

function menuPrincipal() {
    echo "\n--------MENU PRINCIPAL--------\n";
    echo "1. Gestionar persona.\n";
    echo "2. Gestionar empresa.\n";
    echo "3. Gestionar viaje.\n";
    echo "4. Salir \n";
    echo "ELECCIÓN: ";
    $opcion=trim(fgets(STDIN));

    switch($opcion){
    
    case '1': menuPersona();

    case '2': 

    case '3': 
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
        case 1:

    }
}