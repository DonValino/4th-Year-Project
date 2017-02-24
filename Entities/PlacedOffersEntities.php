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
  public $bidType;
  public $numberOfDays;
  public $prefferedCommenceDate;
  public $seen;
  
  // Contructor
  function __construct($jobid, $userID, $comment, $placementDate, $offerPrice, $bidType, $numberOfDays, $prefferedCommenceDate, $seen) {
      $this->jobid = $jobid;
      $this->userID = $userID;
      $this->comment = $comment;
      $this->placementDate = $placementDate;
      $this->offerPrice = $offerPrice;
      $this->bidType = $bidType;
      $this->numberOfDays = $numberOfDays;
      $this->prefferedCommenceDate = $prefferedCommenceDate;
      $this->seen = $seen;
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
  
  function getBidType() {
      return $this->bidType;
  }

  function getNumberOfDays() {
      return $this->numberOfDays;
  }

  function getPrefferedCommenceDate() {
      return $this->prefferedCommenceDate;
  }
  
  function getSeen() {
      return $this->seen;
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
  
  function setBidType($bidType) {
      $this->bidType = $bidType;
  }

  function setNumberOfDays($numberOfDays) {
      $this->numberOfDays = $numberOfDays;
  }
  
  function setPrefferedCommenceDate($prefferedCommenceDate) {
      $this->prefferedCommenceDate = $prefferedCommenceDate;
  }
  
  function setSeen($seen) {
      $this->seen = $seen;
  }

}