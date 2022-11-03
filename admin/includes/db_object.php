<?php

class DbObject {
    
    public static function findAll(){
        return static::findByQuery("SELECT * FROM " . static::$db_table);
  }
  public static function findById($id){
     $result = static::findByQuery("SELECT * FROM " . static::$db_table . " WHERE id = $id LIMIT 1");
     return !empty($result) ? array_shift($result) : false;
  }

  

  public static function findByQuery($sql){
      global $database;
      $result = $database->query($sql);
      $object = [];
      while($row = mysqli_fetch_assoc($result)){
          $object[] = static::instantiation($row);
      }
      return $object;

  }

  private static function instantiation($arr){
    $class = get_called_class();
      $inst = new $class;
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
    foreach(static::$db_table_fields as $db_field){
     if(property_exists($this, $db_field)){
         $properties[$db_field] = $this->$db_field;
     }
    }
    return $properties;
 }

 protected function cleanProperties(){
     global $database;
     $arr = [];
     foreach($this->properties() as $key => $value){
         $arr[$key] = $database->escapeString($value);
     }
     return $arr;
 }

  public function save()
    {
       return isset($this->id) ? $this->update() : $this->create();
    }

    public function create(){
        global $database;
        $properties = $this->cleanProperties();
        $sql = "INSERT INTO " . static::$db_table . " (" . implode(',', array_keys($properties)) . ") VALUES (";
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
        $properties = $this->cleanProperties();
        $propertiesPairs = [];
        foreach($properties as $key => $value){
            $propertiesPairs[] = "$key = '$value'";
        }
        $sql = "UPDATE " . static::$db_table . " SET ";
        $sql .= implode(", ", $propertiesPairs);
        $sql .= " WHERE id = " . $this->id;
        $database->query($sql);
        return $database->connection->affected_rows === 1 ? true : false;
    }
    
    public function destroy()
    {   
        global $database;
        $sql = "DELETE FROM " . static::$db_table . " WHERE id = " . $this->id;
        $database->query($sql);
        return $database->connection->affected_rows === 1 ? true : false;
    }

}