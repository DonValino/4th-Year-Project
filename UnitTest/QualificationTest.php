<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QualificationTest
 *
 * @author Jake Valino
 */
require ("Controller/QualificationController.php");
class QualificationTest extends \PHPUnit_Framework_TestCase
{
    // Test Get All Placed Offers
    public function testGetAllQualifications()
    {
        $qualificationController = new QualificationController();
        
        $qualifications = $qualificationController->GetQualifications();
        
        $this->assertNotEquals(0,count($qualifications));
    }
    
    // Test Update Qualification Name
    public function testUpdateQualificationName()
    {
       $qualificationController = new QualificationController(); 
       
       $qualificationController->updateQualificationName(6, "17");
       
       $qualification = $qualificationController->GetQualificationByID(6);
       
       $this->assertEquals("17",$qualification->qualificationName);
       
       $qualificationController->updateQualificationName(6, "Age 17+");
    }
    
    // Test Update Qualification Name
    public function testGetQualificationByID()
    {
        $qualificationController = new QualificationController(); 
        
        $qualification = $qualificationController->GetQualificationByID(6);
        
        $this->assertEquals("Age 17+",$qualification->qualificationName);
    }
}
