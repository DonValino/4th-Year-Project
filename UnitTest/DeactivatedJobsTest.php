<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeactivatedJobsTest
 *
 * @author Jake Valino
 */
require ("Controller/DeactivatedJobsController.php");
class DeactivatedJobsTest extends \PHPUnit_Framework_TestCase
{
    // Test Insert A New Deactivated Jobs
    public function testInsertANewDeactivatedJob()
    {
        $deactivatedJobsController = new DeactivatedJobsController();
        $numberOfDeactivatedJobsBeforeInsertion = $deactivatedJobsController->GetAllDeactivatedJobs();
        
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
        $deactivatedJobsController->InsertANewDeactivatedJob(138, 36, "Inappropriate", $dateTime);
        
        $numberOfDeactivatedJobsAfterInsertion = $deactivatedJobsController->GetAllDeactivatedJobs();
        
        $this->assertEquals(count($numberOfDeactivatedJobsBeforeInsertion)+1,count($numberOfDeactivatedJobsAfterInsertion));
    }
    
}
