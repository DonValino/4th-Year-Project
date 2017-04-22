<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserReviewTest
 *
 * @author Jake Valino
 */
require ("Controller/UserReviewController.php");
class UserReviewTest extends \PHPUnit_Framework_TestCase
{
    // Test Insert a new review into the database
    public function testInsertANewReview()
    {
        $userReviewController = new UserReviewController();
       
        $beforeInsertingANewUserReview = $userReviewController->GetNumberOfUserReviewById(36);
        
        $userReviewController->InsertANewReview("donvalino", 36, "Test Review", 5, 5, 5, "2017-02-26");
        
        $afterInsertingANewUserReview = $userReviewController->GetNumberOfUserReviewById(36);
        
        $this->assertEquals($beforeInsertingANewUserReview+1,$afterInsertingANewUserReview);
    }
    
    // Test Number of reviews per user
    public function testGetNumberOfUserReviewById()
    {
        $userReviewController = new UserReviewController();
        
        $userReviews = $userReviewController->GetNumberOfUserReviewById(36);
        
        $this->assertNotEquals(0,$userReviews);
    }
    
    // Test Get All Reviews From A Specific User
    public function testGetUserReviewById()
    {
       $userReviewController = new UserReviewController();
       
       $userReview= $userReviewController->GetUserReviewById(36);
        
       $this->assertNotEquals(0,count($userReview));
    }
}
