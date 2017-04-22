<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SignInTest
 *
 * @author Jake Valino
 */
require ("Controller/SignInController.php");
class SignInTest extends \PHPUnit_Framework_TestCase
{
    //Insert a user sign in
    public function testInsertAUserSignIn()
    {
        $signInController = new SignInController();
       
        $beforeInsertingANewSignIn = $signInController->GetAllSignIn();
        
        $signInController->InsertAUserSignIn(36, 138, "Test Date", 0);
        
        $afterInsertingANewSignIn = $signInController->GetAllSignIn();
        
        $this->assertEquals(count($beforeInsertingANewSignIn)+1,count($afterInsertingANewSignIn));
    }
    
    // Test Update latest status
    public function testUpdateLatestStatus()
    {
        $signInController = new SignInController();
        
        $signInController->updateLatestStatus(1, 36, 138);
        
        $signIn = $signInController->GetSignInRecordsByUserIdAndJobId(36, 138);
        
        $this->assertEquals(1,$signIn->latest);
    }
    
    // Test Get All Sign In.
    public function testGetAllSignIn()
    {
        $signInController = new SignInController();
        
        $signIns = $signInController->GetAllSignIn();
        
        $this->assertNotEquals(0,  count($signIns));
    }
    
}
