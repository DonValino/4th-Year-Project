<?php
require ("Controller/FavoriteJobsController.php");
class SimpleTest extends \PHPUnit_Framework_TestCase
{
     public function testSimple1()
     {
	$favoriteJobsController = new FavoriteJobsController();
        $faveJobs = $favoriteJobsController->GetActiveFavoriteJobsByUserId(36);		 
        $this->assertEquals(4,count($faveJobs));
      
     }
     public function testSimple2()
     {
      $this->assertEquals(2, 1+1);
     }
}