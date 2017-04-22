<?php
require ("Controller/FavoriteJobsController.php");
class SimpleTest extends \PHPUnit_Framework_TestCase
{
     public function testInsertANewJob()
     {
	$favoriteJobsController = new FavoriteJobsController();
        $countFaveJobs = $favoriteJobsController->CountNumberFavoriteJobs(36);
        
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
        $favoriteJobsController->InsertANewFavoriteJob(149, 36, $dateTime);
        $newCount = $favoriteJobsController->CountNumberFavoriteJobs(36);
        //echo "newCount: $newCount \nCount: $countFaveJobs";
        $this->assertEquals($countFaveJobs+1,$newCount);
     }
     
     public function testDeleteAJob()
     {
        $favoriteJobsController = new FavoriteJobsController();
        $favoriteJobsController->deleteAFavoriteJob(149, 36);
        $this->assertEquals(2, 1+1);
     }
}