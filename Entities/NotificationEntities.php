<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotificationEntities
 *
 * @author Jake Valino
 */
class NotificationEntities {

    // Variables
    public $id;
    public $fromusername;
    public $tousername;
    public $typeId;
    public $seen;
    
    // Constructor
    function __construct($id, $fromusername, $tousername, $typeId, $seen) {
        $this->id = $id;
        $this->fromusername = $fromusername;
        $this->tousername = $tousername;
        $this->typeId = $typeId;
        $this->seen = $seen;
    }
    
    // Gtters
    function getId() {
        return $this->id;
    }

    function getFromusername() {
        return $this->fromusername;
    }

    function getTousername() {
        return $this->tousername;
    }

    function getTypeId() {
        return $this->typeId;
    }

    function getSeen() {
        return $this->seen;
    }

    // Setters
    function setId($id) {
        $this->id = $id;
    }

    function setFromusername($fromusername) {
        $this->fromusername = $fromusername;
    }

    function setTousername($tousername) {
        $this->tousername = $tousername;
    }

    function setTypeId($typeId) {
        $this->typeId = $typeId;
    }

    function setSeen($seen) {
        $this->seen = $seen;
    }



}
