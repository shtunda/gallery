<?php
require_once('new_config.php');
class Database {
public $connection;
public $host = DB_HOST;
public $user = DB_USER;
public $pass = DB_PASS;
public $name = DB_NAME;

public function __construct()
{
    $this->openDbConnection();
}
public function openDbConnection(){
    $this->connection = new mysqli($this->host, $this->user, $this->pass, $this->name);
    if($this->connection->connect_errno){
        die('Connection problem' . $this->connection->connect_error);
    }
}
public function query($sql){
    $query = $this->connection->query($sql);
    $this->confirm($query);
    return $query;
    
}
private function confirm($result){
    if(!$result){
        die('Query Failed' . $this->connection->error);
        return $result;
    }
}
public function escapeString($string){
    return $this->connection->real_escape_string($string);
}
public function insertId(){
    return $this->connection->insert_id;
}
}
$database = new Database();