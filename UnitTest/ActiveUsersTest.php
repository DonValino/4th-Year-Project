<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ActiveUsersTest
 *
 * @author Jake Valino
 */
require ("Controller/ActiveUsersController.php");
class ActiveUsersTest extends \PHPUnit_Framework_TestCase
{
    // Return A User By user Id
    public function testInsertANewActiveUser()
    {
	$activeUsersController = new ActiveUsersController();
        
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
        $countBeforeInsertion = $activeUsersController->GetAllActiveUsers();
        $activeUsersController->InsertANewActiveUser(38, $dateTime, 1);
        
        $countAfterInsertion = $activeUsersController->GetAllActiveUsers();
        
        $this->assertEquals(count($countBeforeInsertion)+1,count($countAfterInsertion));
    }
    
    // Return A User By user Id
    public function testGetActiveUsersByUserId()
    {
	$activeUsersController = new ActiveUsersController();
        $activeJobs = $activeUsersController->GetActiveUserByUserId(38);
        
        require_once 'Model/UserModel.php';
        $userModel = new UserModel();
        $user = $userModel->GetUserById($activeJobs->userId);
        
        $this->assertEquals("a",$user->username);
    }
    
    // Return A User By user Id
    public function testDeleteAnActiveUser()
    {
	$activeUsersController = new ActiveUsersController();
        
        $countBeforeDeletion = $activeUsersController->GetAllActiveUsers();
        $activeUsersController->deleteActiveUserByID(38);
        
        $countAfterDeletion = $activeUsersController->GetAllActiveUsers();
        echo "before: ".count($countBeforeDeletion)." \after: ".count($countAfterDeletion);
        $this->assertEquals(count($countBeforeDeletion)-1,count($countAfterDeletion));
        
    }   
}
