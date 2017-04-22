<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserTest
 *
 * @author Jake Valino
 */
require ("Controller/UserController.php");
class UserTest extends \PHPUnit_Framework_TestCase  
{
    // Test Get Users
    public function testGetUsers()
    {
        $userController = new UserController();
        
        $users = $userController->GetUsers();
        
        $this->assertNotEquals(0, count($users));
    }
    
    // Test Get Active Users
    public function testGetActiveUsers()
    {
        $userController = new UserController();
        
        $users = $userController->GetActiveUsers();
        
        $this->assertNotEquals(0, count($users));
    }
    
    // Test Get Active Users
    public function testGetUserById()
    {
        $userController = new UserController();
        
        $user = $userController->GetUserById(36);
        
        $this->assertEquals(36, $user->id);
    }
    
    // Test Check if a user exist using the model and return the object
    public function testCheckUser()
    {
        $userController = new UserController();
        
        $user = $userController->CheckUser("donvalino");
        
        $this->assertEquals("donvalino", $user->username);
    }
    
    // Test Check if an email already exist in the database
    public function testCheckEmail()
    {
        $userController = new UserController();
        
        $user = $userController->CheckEmail("jk_valino@yahoo.com");
        
        $this->assertEquals("jk_valino@yahoo.com", $user->email);
    }
    
    // Test Update Account's Active State
    public function testUpdateAccountStateActive()
    {
        $userController = new UserController();
        
        $activeUsersBefore = $userController->GetActiveUsers();
        
        $userController->updateAccountStateActive(0, 36);
        
        $activeUsersAfter = $userController->GetActiveUsers();
        
        $userController->updateAccountStateActive(1, 36);
        
        $this->assertEquals(count($activeUsersBefore)-1, count($activeUsersAfter));
    }
    
    // Test Update account type
    public function testUpdateAccountType()
    {
        $userController = new UserController();
        
        $userController->updateAccountType(1, 36);
        
        $user = $userController->GetUserById(36);
        
        $userController->updateAccountType(0, 36);
        
        $this->assertEquals(1,$user->admin);
    }
}
