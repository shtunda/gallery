<?php
function classAutoLoader($class){
    $class = strtolower($class);
    $path = "includes/{$class}.php";
    file_exists($path) ? require_once($path) : die("{$class}.php was not found");
}
spl_autoload_register('classAutoLoader');
function redirect($location){
header("Location: {$location}");
}