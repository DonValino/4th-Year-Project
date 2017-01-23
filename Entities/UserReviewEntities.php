<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserReviewEntities
 *
 * @author Jake Valino
 */
class UserReviewEntities {
  public $id;
  public $reviewer;
  public $userid;
  public $description;
  public $rating;
  public $date;
  
  //Constructor
  function __construct($id, $reviewer, $userid, $description, $rating, $date) {
      $this->id = $id;
      $this->reviewer = $reviewer;
      $this->userid = $userid;
      $this->description = $description;
      $this->rating = $rating;
      $this->date = $date;
  }

  
  // Getters
  function getId() {
      return $this->id;
  }

  function getUserid() {
      return $this->userid;
  }

  function getDescription() {
      return $this->description;
  }

  function getRating() {
      return $this->rating;
  }

  function getDate() {
      return $this->date;
  }
  
  function getReviewer() {
      return $this->reviewer;
  }

  

  // Setters
  function setId($id) {
      $this->id = $id;
  }

  function setUserid($userid) {
      $this->userid = $userid;
  }

  function setDescription($description) {
      $this->description = $description;
  }

  function setRating($rating) {
      $this->rating = $rating;
  }

  function setDate($date) {
      $this->date = $date;
  }

  function setReviewer($reviewer) {
      $this->reviewer = $reviewer;
  }



  
}
