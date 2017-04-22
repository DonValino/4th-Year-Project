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
  public $punctionality;
  public $workSatisfaction;
  public $skills;
  public $date;
  
  //Constructor
  function __construct($id, $reviewer, $userid, $description, $punctionality, $workSatisfaction, $skills, $date) {
      $this->id = $id;
      $this->reviewer = $reviewer;
      $this->userid = $userid;
      $this->description = $description;
      $this->punctionality = $punctionality;
      $this->workSatisfaction = $workSatisfaction;
      $this->skills = $skills;
      $this->date = $date;
  }

    
  // Getters
  function getId() {
      return $this->id;
  }

  function getReviewer() {
      return $this->reviewer;
  }

  function getUserid() {
      return $this->userid;
  }

  function getDescription() {
      return $this->description;
  }

  function getPunctionality() {
      return $this->punctionality;
  }

  function getWorkSatisfaction() {
      return $this->workSatisfaction;
  }

  function getSkills() {
      return $this->skills;
  }

  function getDate() {
      return $this->date;
  }

  
  

  // Setters
  function setId($id) {
      $this->id = $id;
  }

  function setReviewer($reviewer) {
      $this->reviewer = $reviewer;
  }

  function setUserid($userid) {
      $this->userid = $userid;
  }

  function setDescription($description) {
      $this->description = $description;
  }

  function setPunctionality($punctionality) {
      $this->punctionality = $punctionality;
  }

  function setWorkSatisfaction($workSatisfaction) {
      $this->workSatisfaction = $workSatisfaction;
  }

  function setSkills($skills) {
      $this->skills = $skills;
  }

  function setDate($date) {
      $this->date = $date;
  }





  
}
