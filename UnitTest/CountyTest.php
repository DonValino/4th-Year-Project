<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CountyTest
 *
 * @author Jake Valino
 */
require ("Controller/CountyController.php");
class CountyTest extends \PHPUnit_Framework_TestCase
{
    // Insert A New County
     public function testInsertAndDeleteACounty()
     {
	$countyController = new CountyController();
        
        $countiesBeforeInsertion = $countyController->GetAllCounties();
        
        $countyController->InsertANewCounty("Dulkan");
        
        $countiesAfterInsertion = $countyController->GetAllCounties();
        
        $county = $countyController->GetCountyByName("Dulkan");
        
        $countyController->deleteACountyByID($county->id);
        
        echo "newCount: ".count($countiesBeforeInsertion) ."\nCount: ".count($countiesAfterInsertion);
        $this->assertEquals(count($countiesBeforeInsertion)+1,count($countiesAfterInsertion));
     }
     
    // Update A New County By Id
     public function testupdateACountyById()
     {
         $countyController = new CountyController();
         
         $countyController->updateACountyById("Updated", 1);
         
         $county = $countyController->GetCountyById(1);
         
         $this->assertEquals("Updated",$county->county);
         
         $countyController->updateACountyById("County Dublin", 1);
     }
    
}
