<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FollowingEntities
 *
 * @author Jake Valino
 */
class FollowingEntities {
  public $id;
  public $userId;
  public $followinguserId;
  public $dateoffollowed;
  
  // Constructor
  function __construct($id, $userId, $followinguserId, $dateoffollowed) {
      $this->id = $id;
      $this->userId = $userId;
      $this->followinguserId = $followinguserId;
      $this->dateoffollowed = $dateoffollowed;
  }
  
  // Getters
  function getId() {
      return $this->id;
  }

  function getUserId() {
      return $this->userId;
  }

  function getFollowinguserId() {
      return $this->followinguserId;
  }

  function getDateoffollowed() {
      return $this->dateoffollowed;
  }


  // Setters
  function setId($id) {
      $this->id = $id;
  }

  function setUserId($userId) {
      $this->userId = $userId;
  }

  function setFollowinguserId($followinguserId) {
      $this->followinguserId = $followinguserId;
  }

  function setDateoffollowed($dateoffollowed) {
      $this->dateoffollowed = $dateoffollowed;
  }



  
}
