<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotificationTest
 *
 * @author Jake Valino
 */
require ("Controller/NotificationController.php");
class NotificationTest extends \PHPUnit_Framework_TestCase
{
    // Test Insert A New Notification
    public function testInsertNotification()
    {
        $notificationController = new NotificationController();
        
        $notificationsBeforeInsertion = $notificationController->GetNotificationByToUsername("donvalino");
        
        $notificationController->InsertNotification("a", "donvalino", 2, 0, "Test Date", 138);
        
        $notificationsAfterInsertion = $notificationController->GetNotificationByToUsername("donvalino");
        
        $this->assertEquals(count($notificationsBeforeInsertion)+1,count($notificationsAfterInsertion));
    }
    
    // Test Get Notification By Id
    public function testGetNotificationById()
    {
        $notificationController = new NotificationController();
        
        $notification = $notificationController->GetNotificationById(26);
        
         $this->assertEquals(26,$notification->id);
    }
    
   // Test Update a notification
    public function testUpdateNotification()
    {
        $notificationController = new NotificationController();
        
        $notification = $notificationController->GetSpecificNotification("a", "donvalino");
        
        $notificationController->updateNotification("donvalino",$notification->dateofnotification);
        
        $notification = $notificationController->GetSpecificNotification("a", "donvalino");
        
        $this->assertEquals(1,$notification->seen);
    }
    
   // Test Update a notification
    public function testCountNotificationByToUsername()
    {
        $notificationController = new NotificationController();
        
        $count = $notificationController->CountNotificationByToUsernameTest("donvalino");
        
        $this->assertNotEquals(0,$count);
    }
}
