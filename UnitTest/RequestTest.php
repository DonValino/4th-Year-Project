<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RequestTest
 *
 * @author Jake Valino
 */
require ("Controller/RequestController.php");
class RequestTest extends \PHPUnit_Framework_TestCase
{
    // Test Insert a new request 
    public function testInsertANewReportType()
    {
        $requestController = new RequestController();
       
        $beforeInsertingANewRequest = $requestController->GetRequests();
        
        $requestController->InsertANewRequest(38, 36, 1, "Test Date", 1);
        
        $afterInsertingANewRequest = $requestController->GetRequests();
        
        $this->assertEquals(count($beforeInsertingANewRequest)+1,count($afterInsertingANewRequest));
    }
    
    // Test Get Requests.
    public function testGetRequests()
    {
        $requestController = new RequestController();
        
        $requests = $requestController->GetRequests();
        
        $this->assertNotEquals(0,count($requests));
    }
    
    // Test Update seen request
    public function testUpdateRequestSeen()
    {
        $requestController = new RequestController();
        
        $requestController->updateRequestSeen(36);
        
        $request = $requestController->GetRequestsByUserIdAndTargetUserIdTest(38, 36);
        
        $this->assertEquals(1,$request->seen);
    }
    
    // Test Update request status
    public function testUpdateRequestStatus()
    {
        $requestController = new RequestController();
        
        $requestController->updateRequestStatus(2, 38, 36);
        
        $request = $requestController->GetRequestsByUserIdAndTargetUserIdTest(38, 36);
        
        $this->assertEquals(2,$request->status);
    }
    
    // Test Cancel Request
    public function testcancelRequest()
    {
       $requestController = new RequestController();
       
       $beforeCancelling = $requestController->GetRequests();
       
       $requestController->cancelRequest(38, 36);
       
       $afterCancelling = $requestController->GetRequests();
       
       $this->assertEquals(count($beforeCancelling)-1, count($afterCancelling));
       
    }
    
    
}
