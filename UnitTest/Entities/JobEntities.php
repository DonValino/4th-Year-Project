<?php
class JobEntities 
{ 
  public $jobid;
  public $name;
  public $description;
  public $type;
  public $qualification;
  public $address;
  public $county;
  public $numberOfDays;
  public $numberOfPeopleRequired;
  public $price;
  public $isActive;
  public $id;
  public $date;
  public $startDate;
  
  //Constructor
  function __construct($jobid, $name, $description, $type, $qualification, $address, $county, $numberOfDays, $numberOfPeopleRequired, $price, $isActive, $id, $date, $startDate) {
      $this->jobid = $jobid;
      $this->name = $name;
      $this->description = $description;
      $this->type = $type;
      $this->qualification = $qualification;
      $this->address = $address;
      $this->county = $county;
      $this->numberOfDays = $numberOfDays;
      $this->numberOfPeopleRequired = $numberOfPeopleRequired;
      $this->price = $price;
      $this->isActive = $isActive;
      $this->id = $id;
      $this->date = $date;
      $this->startDate = $startDate;
  }

        // Getters
    function getJobid() {
        return $this->jobid;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getType() {
        return $this->type;
    }

    function getQualification() {
        return $this->qualification;
    }

    function getAddress() {
        return $this->address;
    }

    function getNumberOfDays() {
        return $this->numberOfDays;
    }

    function getNumberOfPeopleRequired() {
        return $this->numberOfPeopleRequired;
    }

    function getPrice() {
        return $this->price;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function getId() {
        return $this->id;
    }

    function getDate() {
        return $this->date;
    }
    
    function getCounty() {
        return $this->county;
    }
    
    function getStartDate() {
        return $this->startDate;
    }
    
    // Setters
    function setJobid($jobid) {
        $this->jobid = $jobid;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setQualification($qualification) {
        $this->qualification = $qualification;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setNumberOfDays($numberOfDays) {
        $this->numberOfDays = $numberOfDays;
    }

    function setNumberOfPeopleRequired($numberOfPeopleRequired) {
        $this->numberOfPeopleRequired = $numberOfPeopleRequired;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setCounty($county) {
        $this->county = $county;
    }
    
    function setStartDate($startDate) {
        $this->startDate = $startDate;
    }    
}

?>
