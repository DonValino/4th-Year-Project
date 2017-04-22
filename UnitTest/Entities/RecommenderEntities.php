<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecommenderEntities
 *
 * @author Jake Valino
 */
class RecommenderEntities {
  public $id;
  public $catId;
  public $userId;
  public $qty;
  public $date;
  
  // Constructor
  function __construct($id, $catId, $userId, $qty, $date) {
      $this->id = $id;
      $this->catId = $catId;
      $this->userId = $userId;
      $this->qty = $qty;
      $this->date = $date;
  }

  
  // Getters
  function getId() {
      return $this->id;
  }

  function getCatId() {
      return $this->catId;
  }

  function getUserId() {
      return $this->userId;
  }

  function getQty() {
      return $this->qty;
  }

  function getDate() {
      return $this->date;
  }

  
  // Setters
  function setId($id) {
      $this->id = $id;
  }

  function setCatId($catId) {
      $this->catId = $catId;
  }

  function setUserId($userId) {
      $this->userId = $userId;
  }

  function setQty($qty) {
      $this->qty = $qty;
  }

  function setDate($date) {
      $this->date = $date;
  }

}
