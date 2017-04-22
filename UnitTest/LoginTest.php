<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginTest
 *
 * @author Jake Valino
 */
require ("Controller/LoginController.php");
class LoginTest extends \PHPUnit_Framework_TestCase
{
    // Test Check If A User Exist
    public function testCheckUser()
    {
        $loginController = new LoginController();
        
        $job = $loginController->CheckUser("donvalino");
        
        $this->assertEquals("donvalino",$job->username);
    }
    
    // Test Check If A User Is Active
    public function testCheckIfUserIsActive()
    {
        $loginController = new LoginController();
        
        $this->assertEquals(1,$loginController->CheckIfUserIsActive("donvalino"));
    }
}
