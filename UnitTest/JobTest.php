<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JobTest
 *
 * @author Jake Valino
 */

require ("Controller/JobController.php");
class JobTest extends \PHPUnit_Framework_TestCase {
    
    // Test Insert A New Job
    public function testInsertANewJobPaymentCompleted()
    {
        $jobController = new JobController();
        
        $numJobsBeforeInsertion = $jobController->GetAllJobs();
        
        $jobController->InsertANewJobPaymentCompleted("TestJob", "TestJob", 1, 1, "TestJob", 2, 1, 1, 100, 1, 36, "TestJob", "TestJob", 1);
        
        $numJobsAfterInsertion = $jobController->GetAllJobs();
        
        $this->assertEquals(count($numJobsBeforeInsertion)+1,count($numJobsAfterInsertion));
    }
    
    // Test Update A Job Start Date
    public function testUpdateJobStartDate()
    {
        $jobController = new JobController();
        
        $job = $jobController->GetLastpostedJobs();
        
        $jobController->updateJobStartDate($job->jobid, "Updated Date");
        
        $job = $jobController->GetLastpostedJobs();
        
        $this->assertEquals("Updated Date",$job->startDate);
    }
    
    // Test Update A Job Posted Date
    public function testUpdateJobDate()
    {
        $jobController = new JobController();
        
        $job = $jobController->GetLastpostedJobs();
        
        $jobController->updateJobDate($job->jobid, "Updated Date");
        
        $job = $jobController->GetLastpostedJobs();
        
        $this->assertEquals("Updated Date",$job->date);
    }
    
    // Test Update A Job Ad Type
    public function testUpdateJobAdType()
    {
        $jobController = new JobController();
        
        $job = $jobController->GetLastpostedJobs();
        
        $jobController->updateJobAdType($job->jobid, 1);
        
        $job = $jobController->GetLastpostedJobs();
        
        $this->assertEquals(1,$job->adtype);
    }
    
    // Test Update A Job Active Status
    public function testUpdateJobActiveStatus()
    {
        $jobController = new JobController();
        
        $job = $jobController->GetLastpostedJobs();
        
        $jobController->updateJobActiveStatus($job->jobid, 1);
        
        $job = $jobController->GetLastpostedJobs();
        
        $this->assertEquals(1,$job->isActive);
    }
    
    // Test Update A Job Subcription Type
    public function testUpdateStandardJobToFeaturedJob()
    {
        $jobController = new JobController();
        
        $job = $jobController->GetLastpostedJobs();
        
        $jobController->updateStandardJobToFeaturedJob($job->jobid, 1);
        
        $job = $jobController->GetLastpostedJobs();
        
        $this->assertEquals(1,$job->adtype);
    }
    
    // Test Delete A Job
    public function testGetAndDeleteJob()
    {
        $jobController = new JobController();
        $job = $jobController->GetLastpostedJobs();
        
        $numJobsBeforeInsertion = $jobController->GetAllJobs();
        
        $jobController->deleteJob($job->jobid);
        
        $numJobsAfterInsertion = $jobController->GetAllJobs();
        
        $this->assertEquals(count($numJobsBeforeInsertion)-1,count($numJobsAfterInsertion));
    }
}
