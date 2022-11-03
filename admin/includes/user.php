<?php

class User extends DbObject {
    
    protected static $db_table = "users";
    protected static $db_table_fields = ['username', 'password', 'first_name', 'last_name'];
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;

    public static function verifyUser($username, $password){
        global $database;
        $username = $database->escapeString($username);
        $password = $database->escapeString($password);
        $result = self::findByQuery("SELECT * FROM " . self::$db_table . " WHERE username = '$username' AND password = '$password' LIMIT 1");
        return !empty($result) ? array_shift($result) : false;
    }
    

    
}