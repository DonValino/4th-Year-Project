<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SignInEntities
 *
 * @author Jake Valino
 */
class SignInEntities {
    public $id;
    public $userId;
    public $jobId;
    public $date;
    public $latest;
    
    // Constructor
    function __construct($id, $userId, $jobId, $date, $latest) {
        $this->id = $id;
        $this->userId = $userId;
        $this->jobId = $jobId;
        $this->date = $date;
        $this->latest = $latest;
    }

        // Getters
    function getId() {
        return $this->id;
    }

    function getUserId() {
        return $this->userId;
    }

    function getJobId() {
        return $this->jobId;
    }

    function getDate() {
        return $this->date;
    }
    
    function getLatest() {
        return $this->latest;
    }
    
    // Setters
    function setId($id) {
        $this->id = $id;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setJobId($jobId) {
        $this->jobId = $jobId;
    }

    function setDate($date) {
        $this->date = $date;
    }
    
    function setLatest($latest) {
        $this->latest = $latest;
    }

}
