<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CancelRequestTest
 *
 * @author Jake Valino
 */
require ("Controller/CancelRequestController.php");
class CancelRequestTest extends \PHPUnit_Framework_TestCase
{
    // Return A User By user Id
    public function testInsertANewActiveUser()
    {
        $cancelRequestController = new CancelRequestController();
        
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
        $countBefore = $cancelRequestController->GetCancelRequestByTargetUserId(36);
        
        $cancelRequestController->InsertANewCancelRequest(38, 36, 138, "Selected Wrond Candidate", $dateTime, 0);
        
        $countAfter = $cancelRequestController->GetCancelRequestByTargetUserId(36);
        //echo "before: ".count($countBefore)." \after: ".count($countAfter);
        $this->assertEquals(count($countBefore)+1,count($countAfter));
    }
    
    // Update A Status Of A Cancel Request
    public function testUpdateCancelRequestStatus()
    {
        $cancelRequestController = new CancelRequestController();
        
        $cancelRequestController->updateCancelRequestStatus(2, 38, 36, 138);
        
        $after = $cancelRequestController->GetCancelRequestByUserIdANDTargetUserId(38, 36);
        
        $this->assertEquals(2,$after->status);
    }
    
    // Update A Cancellation Reason
    public function testUpdateCancelReason()
    {
        $cancelRequestController = new CancelRequestController();
        
        $cancelRequestController->updateCancelReason("Updated", 38, 36, 138);
        
        $after = $cancelRequestController->GetCancelRequestByUserIdANDTargetUserId(38, 36);
        
        $this->assertEquals("Updated",$after->reason);
    }
    
    // Update A Cancellation Seen
    public function testUpdateCancelSeen()
    {
        $cancelRequestController = new CancelRequestController();
        
        $cancelRequestController->updateCancelSeen(1, 38, 36, 138);
        
        $after = $cancelRequestController->GetCancelRequestByUserIdANDTargetUserId(38, 36);
        
        $this->assertEquals(1,$after->seen);
    }
}
