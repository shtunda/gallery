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

function storeUser(){
    if(isset($_POST['store_user'])){
        $user = new User();
    $user->username = $_POST['username'];
    $user->password = $_POST['password'];
    $user->first_name = $_POST['first_name'];
    $user->last_name = $_POST['last_name'];
    $user->create();
    redirect('users.php');
    }
}

function updateUser($id){
    if(isset($_POST['update_user'])){
    $user = new User();
    $user->id = $id;
    $user->username = $_POST['username'];
    $user->password = $_POST['password'];
    $user->first_name = $_POST['first_name'];
    $user->last_name = $_POST['last_name'];
    $user->update();
    redirect('users.php');
    }
}

function destroyUser()
{
    if(isset($_GET['destroy'])){
        $user = new User;
        $user->id = $_GET['destroy'];
        $user->destroy();
        redirect('users.php');
    }
}

function dd($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
    die;
}