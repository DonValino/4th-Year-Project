<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RequestTypeTest
 *
 * @author Jake Valino
 */
require ("Controller/RequestTypeController.php");
class RequestTypeTest extends \PHPUnit_Framework_TestCase
{
    // Test Insert a new request type
    public function testInsertARequestType()
    {
        $requestTypeController = new RequestTypeController();
       
        $beforeInsertingANewRequestType = $requestTypeController->GetRequestTypes();
        
        $requestTypeController->InsertARequestType("Test New Type");
        
        $afterInsertingANewRequestType = $requestTypeController->GetRequestTypes();
        
        $this->assertEquals(count($beforeInsertingANewRequestType)+1,count($afterInsertingANewRequestType));
    }
    
    // Test Get Request Type.
    public function testGetRequestTypes()
    {
        $requestTypeController = new RequestTypeController();
        
        $requestypes = $requestTypeController->GetRequestTypes();
        
        $this->assertNotEquals(0, count($requestypes));
    }
    
    // Test Get Request Type.
    public function testGetARequestTypeById()
    {
        $requestTypeController = new RequestTypeController();
        
        $requestype = $requestTypeController->GetARequestTypeById(1);
        
        $this->assertEquals("Permission: View Your CV and Cover Letter", $requestype->name);
        
    }
}
