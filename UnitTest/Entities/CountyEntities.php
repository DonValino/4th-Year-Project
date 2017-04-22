<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CountyEntities
 *
 * @author Jake Valino
 */
class CountyEntities {
  public $id;
  public $county;

  // Constructor
  function __construct($id, $county) {
      $this->id = $id;
      $this->county = $county;
  }
  
  // Getters
  function getId() {
      return $this->id;
  }

  function getCounty() {
      return $this->county;
  }

  // Setters
  function setId($id) {
      $this->id = $id;
  }

  function setCounty($county) {
      $this->county = $county;
  }


  

  
  
}
