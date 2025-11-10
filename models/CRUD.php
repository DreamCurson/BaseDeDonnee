<?php
namespace App\Models;

abstract class CRUD extends \PDO {

    final public function __construct(){
        parent::__construct('mysql:host=localhost; dbname=planteweb; port=3306; charset=utf8', 'root', '');
    }

    final public function select( $field = null, $order = 'ASC'){
        if($field == null){
            $field = $this->primaryKey;
        }
        $sql = "SELECT * FROM $this->table ORDER BY $field $order";
        // return  $sql;
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }

    final public function selectId($value){
        $sql = "SELECT * FROM $this->table WHERE $this->primaryKey = :$this->primaryKey";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$this->primaryKey", $value);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count == 1){
            return $stmt->fetch();
        }else{
            return false;
        }    
    }

    final public function selectBy($column, $value) {
        $sql = "SELECT * FROM $this->table WHERE $column = :value";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":value", $value);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    final public function insert($data){

        $data_keys = array_fill_keys($this->fillable, '');
        $data = array_intersect_key($data, $data_keys);

        $fieldName = implode(', ', array_keys($data));
        $fieldValue = ":".implode(', :', array_keys($data));
        $sql = "INSERT INTO $this->table ($fieldName) VALUES ($fieldValue)";

        $stmt = $this->prepare($sql);
        foreach($data as $key=>$value){
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();

        return $this->lastInsertId();
    }
    
    public function update($data, $id){

        $data_keys = array_fill_keys($this->fillable, '');
        $data = array_intersect_key($data, $data_keys);

        $fieldName = null;
        foreach($data as $key=>$value){
            $fieldName .= "$key = :$key, ";
        } 
        
        $fieldName = rtrim($fieldName, ', ');

        $sql = "UPDATE $this->table SET $fieldName WHERE $this->primaryKey = :$this->primaryKey";

        $data[$this->primaryKey]=$id;

        $stmt = $this->prepare($sql);
        foreach($data as $key=>$value){
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        if($stmt){
            return true;
        }else{
            return false;
        }
    }
    public function delete($value){

        $sql = "DELETE FROM $this->table WHERE $this->primaryKey = :$this->primaryKey";
        $stmt = $this->prepare($sql);
        $stmt->bindValue("$this->primaryKey", $value);
        $stmt->execute();
        if($stmt){
            return true;
        }else{
            return false;
        }

    }

    public function valueExists($column, $value){
        $sql = "SELECT COUNT(*) FROM $this->table WHERE $column = :value";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':value', $value);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

}