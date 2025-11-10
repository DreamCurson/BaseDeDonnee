<?php
namespace App\Providers;

class Validator {
    private $errors = array();
    private $key;
    private $value;
    private $name;

    public function field($key, $value, $name = null){
        $this->key = $key;
        $this->value = $value;
        if($name == null){
            $this->name = ucfirst($key);
        }else{
            $this->name = ucfirst($name);
        }
        return $this;
    }

    //regles
    public function required(){
        if(empty($this->value)){
            $this->errors[$this->key]="Est requis.";
        }
        return $this;
    }

    public function max($length){
        if(strlen($this->value) > $length){
            $this->errors[$this->key]="Doit contenir moins que $length caractères.";
        }
        return $this;
    }

    public function min($length){
        if(strlen($this->value) < $length){
            $this->errors[$this->key]="Doit contenir plus que $length caractères.";
        }
        return $this;
    }

    public function int(){
        if(!filter_var($this->value, FILTER_VALIDATE_INT)){
            $this->errors[$this->key]="Doit être un nombre";
        }
        return $this;
    }

    public function email() {
        if (!empty($this->value) && !filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$this->key]="Format invalide.";
        }
        return $this;
    }

    public function unique(callable $callback) {
        if (call_user_func($callback, $this->value)) {
            $this->errors[$this->key] = "Ce {$this->name} existe déjà.";
        }
        return $this;
    }

    //regles fin

    public function isSuccess(){
        if(empty($this->errors)) return true;
    }

    public function getErrors(){
        if(!$this->isSuccess()) return $this->errors;
    }
}

?>

