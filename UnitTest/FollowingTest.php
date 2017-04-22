<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FollowingTest
 *
 * @author Jake Valino
 */
require ("Controller/FollowingController.php");
class FollowingTest extends \PHPUnit_Framework_TestCase
{
    // Test Follow Another User
     public function testFollowAUser()
     {
        $followingController = new FollowingController();

        $followersBeforeInsertion = $followingController->GetFollowersByFollowingUserId(42);

        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');

        $followingController->FollowAUser(38, 42, $dateTime);
        
        $followersAfterInsertion = $followingController->GetFollowersByFollowingUserId(42);
         
        $this->assertEquals(count($followersBeforeInsertion)+1,count($followersAfterInsertion));
     }
     
    // Test UnFollow Another User
     public function testCheckIfUserAlreadyFollowedAnotherUser()
     {
        $followingController = new FollowingController();
        
        $following = $followingController->CheckIfUserAlreadyFollowedAnotherUser(38, 42);
        
        $this->assertEquals(38,$following->userId);
        
     }
     
    // Test UnFollow Another User
     public function testUnfollowAUser()
     {
         $followingController = new FollowingController();
         
         $followersBeforeInsertion = $followingController->GetFollowersByFollowingUserId(42);
         
         $followingController->unfollowAUser(38, 42);
         
         $followersAfterInsertion = $followingController->GetFollowersByFollowingUserId(42);
         
         $this->assertEquals(count($followersBeforeInsertion)-1,count($followersAfterInsertion));
     }
     
}
