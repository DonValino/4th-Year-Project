<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeactivatedUsersEntities
 *
 * @author Jake Valino
 */
class DeactivatedUsersEntities {
    
    public $id;
    public $userId;
    public $reason;
    public $date;
    
    // Constructor
    function __construct($id, $userId, $reason, $date) {
        $this->id = $id;
        $this->userId = $userId;
        $this->reason = $reason;
        $this->date = $date;
    }
    
    // Getters
    function getId() {
        return $this->id;
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
