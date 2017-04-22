<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MessageTest
 *
 * @author Jake Valino
 */
require ("Controller/MessageController.php");
class MessageTest extends \PHPUnit_Framework_TestCase
{
    // Test Send A New Message
    public function testSendAMessage()
    {
        $messageController = new MessageController();
        $myMessagesBeforeReceivingANewOne = $messageController->GetAllMyMessages("donvalino");
        
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
        $messageController->SendAMessage("a", "donvalino", "Test Message", $dateTime);
        
        $myMessagesAfterReceivingANewOne = $messageController->GetAllMyMessages("donvalino");
        
        $this->assertEquals(count($myMessagesBeforeReceivingANewOne)+1,count($myMessagesAfterReceivingANewOne));
    }
    
    // Test Set Messages Seen by user
    public function testSetMessagesSeen()
    {
        $messageController = new MessageController();
        
        $messageController->SetMessagesSeen("a", "donvalino");
        
        $message = $messageController->GetASpecificMessage("a", "donvalino");
        
        $this->assertEquals(1,$message->seen);
    }
    
    // Test Count Number Of Message By A User
    public function testCountAllMyMessages()
    {
        $messageController = new MessageController();
        
        $count = $messageController->CountAllMyMessagesTest("donvalino");
        
        $this->assertNotEquals(0,$count);
    }
    
    // Test Return The Inbox Of A User
    public function testGetMyInbox()
    {
        $messageController = new MessageController();
        
        $count = $messageController->GetMyInbox();
        
        $this->assertNotEquals(0,count($count));
    }
    
    
}
