<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PaymentTest
 *
 * @author Jake Valino
 */
require ("Controller/PaymentController.php");
class PaymentTest extends \PHPUnit_Framework_TestCase
{
    // Test Insert A New Payment
    public function testInsertANewPayment()
    {
        $paymentController = new PaymentController();
        
        $paymentsBeforeInsertion = $paymentController->GetAllPayments();
        
        $paymentController->InsertANewPayment(38, 36, 138, 100, "Test Date", 0, 1, 0);
        
        $paymentsAfterInsertion = $paymentController->GetAllPayments();
        
        $this->assertEquals(count($paymentsBeforeInsertion)+1,count($paymentsAfterInsertion));
    }
    
    // Test Update Payment Status
    public function testUpdatePaymentConfirmation()
    {
        $paymentController = new PaymentController();
        
        $paymentController->updatePaymentConfirmation(2, 36, 38, 138);
        
        $payment = $paymentController->GetPayPalMeAccountByUserIdAndJobId(36, 138);
        
        $this->assertEquals(2,$payment->status);
    }
    
    // Test Get Payments By UserId, TargetUserId And JobId
    public function testGetPaymentsByUserIdTargetUserIdAndJobId()
    {
        $paymentController = new PaymentController();
        
        $payments = $paymentController->GetPaymentMeAccountByUserIdTargetUserIdAndJobId(38, 36, 138);
        
        $this->assertNotEquals(0,  count($payments));
    }
    
    // Test Count Payments By UserId And JobId
    public function testGetAllPayments()
    {
        $paymentController = new PaymentController();
        
        $payments = $paymentController->GetAllPayments();
        
        $this->assertNotEquals(0,  count($payments));
    }
}
