<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReportTypeEntities
 *
 * @author Jake Valino
 */
class ReportTypeEntities {
    public $id;
    public $name;
    
    // Constructor
    function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }
    
    // Getters
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }
    
    // Setters
    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

}
