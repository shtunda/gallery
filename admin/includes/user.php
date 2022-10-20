<?php
class User {
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public static function findAllUsers(){
          return self::findThisQuery("SELECT * FROM users");
    }
    public static function findUserById($id){
       $result = self::findThisQuery("SELECT * FROM users where id = $id LIMIT 1");
       return !empty($result) ? array_shift($result) : false;
    }
    public static function verifyUser($username, $password){
        global $database;
        $username = $database->escapeString($username);
        $password = $database->escapeString($password);
        $result = self::findThisQuery("SELECT * FROM users WHERE username = '$username' AND password = '$password' LIMIT 1");
        return !empty($result) ? array_shift($result) : false;
    }
    public static function findThisQuery($sql){
        global $database;
        $result = $database->query($sql);
        $object = [];
        while($row = mysqli_fetch_assoc($result)){
            $object[] = self::instantiation($row);
        }
        return $object;

    }
    private static function instantiation($arr){
        $inst = new self;
        foreach($arr as $property => $value){
            if($inst->hasProperty($property)){
                $inst->$property = $value;
            }
        }
        return $inst;
    }
    private function hasProperty($property){
        $properties = get_object_vars($this);
        return array_key_exists($property, $properties);
    }
}