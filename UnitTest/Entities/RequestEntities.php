<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RequestEntities
 *
 * @author Jake Valino
 */
class RequestEntities {
  public $id;
  public $userId;
  public $targetUserId;
  public $typeId;
  public $date;
  public $status;
  public $seen;
  
  // Constructor
  function __construct($id, $userId, $targetUserId, $typeId, $date, $status, $seen) {
      $this->id = $id;
      $this->userId = $userId;
      $this->targetUserId = $targetUserId;
      $this->typeId = $typeId;
      $this->date = $date;
      $this->status = $status;
      $this->seen = $seen;
  }

    
  // Getters
  function getId() {
      return $this->id;
  }

  function getUserId() {
      return $this->userId;
  }

  function getTargetUserId() {
      return $this->targetUserId;
  }

  function getTypeId() {
      return $this->typeId;
  }
  
  function getDate() {
      return $this->date;
  }

  function getStatus() {
      return $this->status;
  }
  
  function getSeen() {
      return $this->seen;
  }

  
  // Setters
  function setId($id) {
      $this->id = $id;
  }

  function setUserId($userId) {
      $this->userId = $userId;
  }

  function setTargetUserId($targetUserId) {
      $this->targetUserId = $targetUserId;
  }

  function setTypeId($typeId) {
      $this->typeId = $typeId;
  }
  
  function setDate($date) {
      $this->date = $date;
  }

  function setStatus($status) {
      $this->status = $status;
  }
  
  function setSeen($seen) {
      $this->seen = $seen;
  }

}
