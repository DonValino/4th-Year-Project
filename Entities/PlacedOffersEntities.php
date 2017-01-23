<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PlacedOffers
 *
 * @author Jake Valino
 */
class PlacedOffersEntities
{ 
 // Variables
  public $jobid;
  public $userID;
  public $comment;
  public $placementDate;
  public $offerPrice;
  
  // Contructor
  function __construct($jobid, $userID, $comment, $placementDate, $offerPrice) {
      $this->jobid = $jobid;
      $this->userID = $userID;
      $this->comment = $comment;
      $this->placementDate = $placementDate;
      $this->offerPrice = $offerPrice;
  }
  
  // Getters
  function getJobid() {
      return $this->jobid;
  }

  function getUserID() {
      return $this->userID;
  }

  function getComment() {
      return $this->comment;
  }

  function getPlacementDate() {
      return $this->placementDate;
  }

  function getOfferPrice() {
      return $this->offerPrice;
  }


  // Setters
  function setJobid($jobid) {
      $this->jobid = $jobid;
  }

  function setUserID($userID) {
      $this->userID = $userID;
  }

  function setComment($comment) {
      $this->comment = $comment;
  }

  function setPlacementDate($placementDate) {
      $this->placementDate = $placementDate;
  }

  function setOfferPrice($offerPrice) {
      $this->offerPrice = $offerPrice;
  }




}