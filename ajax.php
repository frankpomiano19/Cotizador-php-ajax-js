<?php
require_once 'app/config.php';

//Parámetro action enviado desde nuestro frontend (javascript)
//Deve ser recibido en ajax.php
//Calidaremos que el valor de action, concuerde con el nombre de una función
//Si existe la función, se ejecuta dicha funcion y listo

//en caso de no existir la función o no recibir el parámetro
//por defecto mandaremos un error 403 de acceso no autorizado

try{
    if(!isset($_POST['action']) && !isset($_GET['action'])){
        throw new Exception("El acceso no está autorizado");
    }

    //Guardar el valor de action
    $action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];
    $action = str_replace('-','_',$action);
    $function = sprintf('hook_%s',$action);

    //Validar la existencia de la función
    if(!function_exists($function)){
        throw new Exception("El acceso no está autorizado");
    }

    //Se ejecuta la funcion
    $function();
}catch(Exception $e){
    json_output(json_build(403,null,$e->getMessage()));
}