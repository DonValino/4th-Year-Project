<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RevenueEntities
 *
 * @author Jake Valino
 */
class RevenueEntities {
   public $id;
   public $amount;
   public $date;
   public $userId;
   public $adType;
   
   // Constructor
   function __construct($id, $amount, $date, $userId, $adType) {
       $this->id = $id;
       $this->amount = $amount;
       $this->date = $date;
       $this->userId = $userId;
       $this->adType = $adType;
   }
   
   // Getters
   function getId() {
       return $this->id;
   }

   function getAmount() {
       return $this->amount;
   }

   function getDate() {
       return $this->date;
   }

   function getUserId() {
       return $this->userId;
   }

   function getAdType() {
       return $this->adType;
   }
   
   // Setters
   function setId($id) {
       $this->id = $id;
   }

   function setAmount($amount) {
       $this->amount = $amount;
   }

   function setDate($date) {
       $this->date = $date;
   }

   function setUserId($userId) {
       $this->userId = $userId;
   }

   function setAdType($adType) {
       $this->adType = $adType;
   }

}
