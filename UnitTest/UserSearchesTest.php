<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserSearchesTest
 *
 * @author Jake Valino
 */
require ("Controller/UserSearchesController.php");
class UserSearchesTest extends \PHPUnit_Framework_TestCase
{
    // Test Insert user searches in database
    public function testInsertAUserSearches()
    {
        $userSearchesController = new UserSearchesController();
       
        $userSearchesController->InsertANewReview(36, "Test Keyword", "2017-04-15", 2);
        
        $beforeInsertingANewUserSearches = $userSearchesController->GetUserSearhesById(36);
        
        $userSearchesController->InsertANewReview(36, "Test Keyword", "2017-04-15", 2);
        
        $afterInsertingANewUserSearches = $userSearchesController->GetUserSearhesById(36);
        
        $this->assertEquals(count($beforeInsertingANewUserSearches)+1,  count($afterInsertingANewUserSearches));
    }
    
    // Test Number of keyword search per user
    public function testCountNumberOfUserSearhesById()
    {
        $userSearchesController = new UserSearchesController();
        
        $count = $userSearchesController->CountNumberOfUserSearhesById(36);
        
        $this->assertNotEquals(0,$count);
    }
    
    // Test Get All keyword search From A Specific User
    public function testGetUserSearhesById()
    {
        $userSearchesController = new UserSearchesController();
        
        $userSearches = $userSearchesController->GetUserSearhesById(36);
        
        $this->assertNotEquals(0,  count($userSearches));
    }
    
    // Test Delete all user keyword searches
    public function testDeleteKeywordSearches()
    {
        $userSearchesController = new UserSearchesController();
        
        $userSearches = $userSearchesController->deleteKeywordSearches(36);
        
        $this->assertEquals(0,count($userSearches));
    }
}
