<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReportTest
 *
 * @author Jake Valino
 */
require ("Controller/ReportController.php");

class ReportTest extends \PHPUnit_Framework_TestCase
{
    // Test Insert a new report 
    public function testInsertANewReport()
    {
        $reportController = new ReportController();
       
        $beforeInsertingANewReport = $reportController->GetReportsTest(2017);
        
        $reportController->InsertANewReport(36, "Test Description", 2, "2017-04-12", 0, 1);
        
        $afterInsertingANewReport = $reportController->GetReportsTest(2017);
        
        $this->assertEquals(count($beforeInsertingANewReport)+1,count($afterInsertingANewReport));
    }
    
    // Test Update report status
    public function testUpdateReportStatus()
    {
        $reportController = new ReportController();
        
        $reportController->updateReportStatus(2, 23);
        
        $report = $reportController->GetReportById(23);
        
        $this->assertEquals(2,$report->status);
    }
    
    //Test Get Reports
    public function testGetReports()
    {
        $reportController = new ReportController();
        
        $reports = $reportController->GetReportsTest(2017);
        
        $this->assertNotEquals(0,count($reports));
    }
    
    // Test Get My Reports
    public function testGetMyReports()
    {
        $reportController = new ReportController();
        
        $reports = $reportController->GetMyReports(36);
        
        $this->assertNotEquals(0,count($reports));
    }
    
    
}
