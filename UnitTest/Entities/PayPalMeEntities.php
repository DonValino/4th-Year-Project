<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PayPalMeEntities
 *
 * @author Jake Valino
 */
class PayPalMeEntities {
    public $id;
    public $userId;
    public $payPalMeUrl;
    
    // Constructor
    function __construct($id, $userId, $payPalMeUrl) {
        $this->id = $id;
        $this->userId = $userId;
        $this->payPalMeUrl = $payPalMeUrl;
    }
    
    // Getters
    function getId() {
        return $this->id;
    }

    function getUserId() {
        return $this->userId;
    }

    function getPayPalMeUrl() {
        return $this->payPalMeUrl;
    }
    
    // Setters
    function setId($id) {
        $this->id = $id;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setPayPalMeUrl($payPalMeUrl) {
        $this->payPalMeUrl = $payPalMeUrl;
    }

}
