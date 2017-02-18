<?php
class QualificationEntities 
{ 
  public $qualificationId;
  public $qualificationName;
  public $description;
  
  //Constructor
  function __construct($qualificationId, $qualificationName, $description) {
      $this->qualificationId = $qualificationId;
      $this->qualificationName = $qualificationName;
      $this->description = $description;
  }
  
  function getQualificationId() {
      return $this->qualificationId;
  }

  function getQualificationName() {
      return $this->qualificationName;
  }

  function getDescription() {
      return $this->description;
  }

  function setQualificationId($qualificationId) {
      $this->qualificationId = $qualificationId;
  }

  function setQualificationName($qualificationName) {
      $this->qualificationName = $qualificationName;
  }

  function setDescription($description) {
      $this->description = $description;
  }


}

?>
