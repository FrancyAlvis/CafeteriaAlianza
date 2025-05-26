<?php 

$controller = $_GET['controller'] ?? 'user';
$action = $_GET['action'] ?? 'index';

$controllerClass = ucfirst($controller) . "Controller";
$controllerfile = __DIR__ . "/../controllers/{$controllerClass}.php";

if (!file_exists($controllerfile)) {
    die("Error: El Controlador '$controllerClass' no existe.");
}

require_once $controllerfile;

if(!class_exists($controllerClass)) {
    die("Error: La Clase '$controllerClass'no esta definida.");
}

$controllerInstance = new $controllerClass();

if ($_SERVER['REQUEST_METHOD'] ==='POST') {
    if (isset($_GET['id'])) {
        $controllerInstance->$action($_GET['id'],  ...array_values($_POST));
   } else { 
    $controllerInstance->$action( ...array_values($_POST));
    }   
} else { 
   
if (isset($_GET['id'])) {
    $controllerInstance->$action($_GET['id']);
} else { 
    $controllerInstance->$action();

}
}
