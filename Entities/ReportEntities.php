<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReportEntities
 *
 * @author Jake Valino
 */
class ReportEntities {
    public $id;
    public $userId;
    public $description;
    public $type;
    public $date;
    public $seen;
    public $status;
    
    // Constructor
    function __construct($id, $userId, $description, $type, $date, $seen, $status) {
        $this->id = $id;
        $this->userId = $userId;
        $this->description = $description;
        $this->type = $type;
        $this->date = $date;
        $this->seen = $seen;
        $this->status = $status;
    }

    
    // Getters
    function getId() {
        return $this->id;
    }

    function getUserId() {
        return $this->userId;
    }

    function getDescription() {
        return $this->description;
    }

    function getDate() {
        return $this->date;
    }

    function getSeen() {
        return $this->seen;
    }

    function getStatus() {
        return $this->status;
    }
    
    function getType() {
        return $this->type;
    }

        
    // Setters
    function setId($id) {
        $this->id = $id;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setSeen($seen) {
        $this->seen = $seen;
    }

    function setStatus($status) {
        $this->status = $status;
    }
    
    function setType($type) {
        $this->type = $type;
    }

}
