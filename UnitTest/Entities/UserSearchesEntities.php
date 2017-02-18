<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserSearchesEntities
 *
 * @author Jake Valino
 */
class UserSearchesEntities {
  public $id;
  public $userId;
  public $keyword;
  public $dateOfSearch;
  public $numResult;
  
  // Constructor
  function __construct($id, $userId, $keyword, $dateOfSearch, $numResult) {
      $this->id = $id;
      $this->userId = $userId;
      $this->keyword = $keyword;
      $this->dateOfSearch = $dateOfSearch;
      $this->numResult = $numResult;
  }
  
  // Getters
  function getId() {
      return $this->id;
  }

  function getUserId() {
      return $this->userId;
  }

  function getKeyword() {
      return $this->keyword;
  }

  function getDateOfSearch() {
      return $this->dateOfSearch;
  }

  function getNumResult() {
      return $this->numResult;
  }
  
  // Setters
  function setId($id) {
      $this->id = $id;
  }

  function setUserId($userId) {
      $this->userId = $userId;
  }

  function setKeyword($keyword) {
      $this->keyword = $keyword;
  }

  function setDateOfSearch($dateOfSearch) {
      $this->dateOfSearch = $dateOfSearch;
  }

  function setNumResult($numResult) {
      $this->numResult = $numResult;
  }  
}
