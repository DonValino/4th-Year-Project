<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegisterTest
 *
 * @author Jake Valino
 */
require ("Controller/RegisterController.php");
class RegisterTest extends \PHPUnit_Framework_TestCase
{
    // Test Check if a user exist using the model and return the object
    public function testCheckUser()
    {
        $registerController = new RegisterController();
       
        $isUserExist = $registerController->CheckUser("donvalino");
        
        $this->assertEquals("donvalino",$isUserExist->username);
    }
    
    // Test Check if an email already exist in the database
    public function testCheckEmail()
    {
        $registerController = new RegisterController();
       
        $isEmailExist = $registerController->CheckEmail("jk_valino@yahoo.com");
        
        $this->assertEquals("jk_valino@yahoo.com",$isEmailExist->email);
    }
}
