<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PaymentEntities
 *
 * @author Jake Valino
 */
class PaymentEntities {
    public $id;
    public $userId;
    public $targetUserId;
    public $jobId;
    public $amount;
    public $date;
    public $paymentType;
    public $status;
    public $seen;
    
    // Constructor
    function __construct($id, $userId, $targetUserId, $jobId, $amount, $date, $paymentType, $status, $seen) {
        $this->id = $id;
        $this->userId = $userId;
        $this->targetUserId = $targetUserId;
        $this->jobId = $jobId;
        $this->amount = $amount;
        $this->date = $date;
        $this->paymentType = $paymentType;
        $this->status = $status;
        $this->seen = $seen;
    }

        // Getters
    function getId() {
        return $this->id;
    }

    function getUserId() {
        return $this->userId;
    }

    function getTargetUserId() {
        return $this->targetUserId;
    }

    function getJobId() {
        return $this->jobId;
    }

    function getDate() {
        return $this->date;
    }

    function getPaymentType() {
        return $this->paymentType;
    }
    
    function getStatus() {
        return $this->status;
    }
    
    function getSeen() {
        return $this->seen;
    }
    
    function getAmount() {
        return $this->amount;
    }
    
    // Setters
    function setId($id) {
        $this->id = $id;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setTargetUserId($targetUserId) {
        $this->targetUserId = $targetUserId;
    }

    function setJobId($jobId) {
        $this->jobId = $jobId;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setPaymentType($paymentType) {
        $this->paymentType = $paymentType;
    }
    
    function setStatus($status) {
        $this->status = $status;
    }
    
    function setSeen($seen) {
        $this->seen = $seen;
    }
    
    function setAmount($amount) {
        $this->amount = $amount;
    }

}
