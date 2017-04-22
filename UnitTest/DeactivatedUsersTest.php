<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeactivatedUsersTest
 *
 * @author Jake Valino
 */
require ("Controller/DeactivatedUsersController.php");
class DeactivatedUsersTest extends \PHPUnit_Framework_TestCase
{
    // Test Insert A New Deactivated Jobs
    public function testInsertANewDeactivatedUser()
    {
        $deactivatedUsersController = new DeactivatedUsersController();
        
        $numberOfDeactivatedUsersBeforeInsertion = $deactivatedUsersController->GetAllDeactivatedUsers();
        
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
        $deactivatedUsersController->InsertANewDeactivatedUser(36, "This Person is inappropriate", $dateTime);
        
        $numberOfDeactivatedUsersAfterInsertion = $deactivatedUsersController->GetAllDeactivatedUsers();
        
        $this->assertEquals(count($numberOfDeactivatedUsersBeforeInsertion)+1,count($numberOfDeactivatedUsersAfterInsertion));
    }
}
