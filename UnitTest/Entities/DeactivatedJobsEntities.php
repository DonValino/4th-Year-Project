<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeactivatedJobsEntities
 *
 * @author Jake Valino
 */
class DeactivatedJobsEntities {
  public $id;
  public $jobId;
  public $userId;
  public $reason;
  public $date;
  
  // Constructor
  function __construct($id, $jobId, $userId, $reason, $date) {
      $this->id = $id;
      $this->jobId = $jobId;
      $this->userId = $userId;
      $this->reason = $reason;
      $this->date = $date;
  }
  
  // Getters
  function getId() {
      return $this->id;
  }

  function getJobId() {
      return $this->jobId;
  }

  function getUserId() {
      return $this->userId;
  }

  function getReason() {
      return $this->reason;
  }

  function getDate() {
      return $this->date;
  }
  
  // Setters
  
  function setId($id) {
      $this->id = $id;
  }

  function setJobId($jobId) {
      $this->jobId = $jobId;
  }

  function setUserId($userId) {
      $this->userId = $userId;
  }

  function setReason($reason) {
      $this->reason = $reason;
  }

  function setDate($date) {
      $this->date = $date;
  }

}
