<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CancelRequestEntities
 *
 * @author Jake Valino
 */
class CancelRequestEntities {
  public $id;
  public $userId;
  public $tagerUserId;
  public $jobId;
  public $reason;
  public $status;
  public $date;
  public $seen;
  
  // Constructor
  function __construct($id, $userId, $tagerUserId, $jobId, $reason, $status, $date, $seen) {
      $this->id = $id;
      $this->userId = $userId;
      $this->tagerUserId = $tagerUserId;
      $this->jobId = $jobId;
      $this->reason = $reason;
      $this->status = $status;
      $this->date = $date;
      $this->seen = $seen;
  }

      
  // Getters
  function getId() {
      return $this->id;
  }

  function getUserId() {
      return $this->userId;
  }

  function getTagerUserId() {
      return $this->tagerUserId;
  }

  function getJobId() {
      return $this->jobId;
  }

  function getStatus() {
      return $this->status;
  }
  
  function getReason() {
      return $this->reason;
  }
  
  function getDate() {
      return $this->date;
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

  function setTagerUserId($tagerUserId) {
      $this->tagerUserId = $tagerUserId;
  }

  function setJobId($jobId) {
      $this->jobId = $jobId;
  }

  function setStatus($status) {
      $this->status = $status;
  }
  
  function setReason($reason) {
      $this->reason = $reason;
  }
  
  function setDate($date) {
      $this->date = $date;
  }
  
  function setSeen($seen) {
      $this->seen = $seen;
  }

}
