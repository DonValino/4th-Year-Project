<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MessagesEntities
 *
 * @author Jake Valino
 */
class MessagesEntities {
    
    // Variables
    public $id;
    public $fromusername;
    public $tousername;
    public $message;
    public $dateofmessage;
    
    // Constructor
    function __construct($id, $fromusername, $tousername, $message, $dateofmessage) {
        $this->id = $id;
        $this->fromusername = $fromusername;
        $this->tousername = $tousername;
        $this->message = $message;
        $this->dateofmessage = $dateofmessage;
    }

            // Getters
        function getId() {
            return $this->id;
        }

        function getFromusername() {
            return $this->fromusername;
        }

        function getTousername() {
            return $this->tousername;
        }

        function getMessage() {
            return $this->message;
        }
        
        function getDateofmessage() {
            return $this->dateofmessage;
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

    function setMessage($message) {
        $this->message = $message;
    }
    
    function setDateofmessage($dateofmessage) {
        $this->dateofmessage = $dateofmessage;
    }
    
}
