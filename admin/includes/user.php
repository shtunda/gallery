<?php

class User {
    protected static $db_table = "users";
    protected static $db_table_fields = ['username', 'password', 'first_name', 'last_name'];
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

    protected function properties(){
       $properties = [];
       foreach(self::$db_table_fields as $db_field){
        if(property_exists($this, $db_field)){
            $properties[$db_field] = $this->$db_field;
        }
       }
       return $properties;
    }

    public function save()
    {
       return isset($this->id) ? $this->update() : $this->create();
    }

    public function create(){
        global $database;
        $properties = $this->properties();
        $sql = "INSERT INTO " . self::$db_table . " (" . implode(',', array_keys($properties)) . ") VALUES (";
        $sql .= "'" . implode("','", array_values($properties)) . "')";
        if($database->query($sql)){
            $this->id = $database->insertId();
            return true;
        }else{
            return false;
        }
    }

    public function update(){
        global $database;
        $properties = $this->properties();
        $propertiesPairs = [];
        foreach($properties as $key => $value){
            $propertiesPairs[] = "$key = '$value'";
        }
        $sql = "UPDATE " . self::$db_table . " SET ";
        $sql .= implode(", ", $propertiesPairs);
        $sql .= " WHERE id = " . $this->id;
        $database->query($sql);
        return $database->connection->affected_rows() === 1 ? true : false;
    }
    
    public function destroy()
    {   
        global $database;
        $sql = "DELETE FROM " . self::$db_table . " WHERE id = " . $this->id;
        $database->query($sql);
        return $database->connection->affected_rows() === 1 ? true : false;
    }
}