<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PayPalMeTest
 *
 * @author Jake Valino
 */
require ("Controller/PayPalMeController.php");
class PayPalMeTest extends \PHPUnit_Framework_TestCase
{
    // Test Insert A New PayPalMe Account
    public function testInsertANewPayPalMeAccount()
    {
        $payPalMeController = new PayPalMeController();
        
        $paypalAccountsBeforeInsertion = $payPalMeController->GetPayPalMeAccounts();
        
        $payPalMeController->InsertANewPayPalMeAccount(36, "paypal.org");
        
        $paypalAccountsAfterInsertion = $payPalMeController->GetPayPalMeAccounts();
        
        $this->assertEquals(count($paypalAccountsBeforeInsertion)+1,count($paypalAccountsAfterInsertion));
    }
    
    // Test Update A PayPalMe Account
    public function testUpdateUserPayPalMeAccount()
    {
        $payPalMeController = new PayPalMeController();
        
        $beforeUpdate = $payPalMeController->GetPayPalMeAccountByUserId(38);
        
        $payPalMeController->updateUserPayPalMeAccount("Updated", 38);
        
        $afterUpdate = $payPalMeController->GetPayPalMeAccountByUserId(38);
        
        $this->assertEquals("Updated",$afterUpdate->payPalMeUrl);
        
        $payPalMeController->updateUserPayPalMeAccount($beforeUpdate->payPalMeUrl, 38);
    }
    
    
}
