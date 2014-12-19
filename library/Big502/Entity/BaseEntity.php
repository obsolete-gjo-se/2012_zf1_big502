<?php
namespace Big502\Entity;

class BaseEntity {

    public function __get($property){
        return $this->$property;
    }

    public function __set($property, $value){
        $this->$property = $value;
    }
    

    // TODO - werden die gebraucht?
     public function fromArray(array $values){
         foreach ($values as $property => $value) {
            
             $this->__set($property, $value);
         }
    
     }
   
     public function toArray(){
         return $properties = get_object_vars($this);
     }
}