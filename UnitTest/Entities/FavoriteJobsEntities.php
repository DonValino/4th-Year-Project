<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FavoriteJobsEntities
 *
 * @author Jake Valino
 */
class FavoriteJobsEntities {
  public $id;
  public $jobId;
  public $userId;
  public $dateAdded;
  
  // Constructor
  function __construct($id, $jobId, $userId, $dateAdded) {
      $this->id = $id;
      $this->jobId = $jobId;
      $this->userId = $userId;
      $this->dateAdded = $dateAdded;
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

  function getDateAdded() {
      return $this->dateAdded;
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

  function setDateAdded($dateAdded) {
      $this->dateAdded = $dateAdded;
  }

}
