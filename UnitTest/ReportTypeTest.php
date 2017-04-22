<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReportTypeTest
 *
 * @author Jake Valino
 */
require ("Controller/ReportTypeController.php");

class ReportTypeTest extends \PHPUnit_Framework_TestCase
{
    // Test Insert a new report type 
    public function testInsertANewReportType()
    {
        $reportTypeController = new ReportTypeController();
       
        $beforeInsertingANewReportType = $reportTypeController->GetAllReportTypes();
        
        $reportTypeController->InsertANewReportType("Test Report Type");
        
        $afterInsertingANewReportType = $reportTypeController->GetAllReportTypes();
        
        $this->assertEquals(count($beforeInsertingANewReportType)+1,count($afterInsertingANewReportType));
    }
    
    //Get Report Type By Id.
    public function testGetReportTypeById()
    {
        $reportTypeController = new ReportTypeController();
        
        $report = $reportTypeController->GetReportTypeById(7);
        
        $this->assertEquals("Other",$report->name);
    }
    
    //Get All Report Types.
    public function testGetAllReportTypes()
    {
        $reportTypeController = new ReportTypeController();
        
        $reports = $reportTypeController->GetAllReportTypes();
        
        $this->assertNotEquals(0,  count($reports));
    }
    
    
}
