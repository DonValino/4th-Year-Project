<?php
class TypeEntities 
{ 
  public $typeId;
  public $name;
  
  //Constructor
  function __construct($typeId, $name) {
      $this->typeId = $typeId;
      $this->name = $name;
  }
  
  function getTypeId() {
      return $this->typeId;
  }

  function getName() {
      return $this->name;
  }

  function setTypeId($typeId) {
      $this->typeId = $typeId;
  }

  function setName($name) {
      $this->name = $name;
  }


}

?>
