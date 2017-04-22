<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotificationTypeTest
 *
 * @author Jake Valino
 */
require ("Controller/NotificationTypeController.php");
class NotificationTypeTest extends \PHPUnit_Framework_TestCase
{
    /* Test Insert A New Notification Type
    public function testInsertNotificationType()
    {
        $notificationTypeController = new NotificationTypeController();
        
        $notificationTypesBeforeInsertion = $notificationTypeController->GetAllNotificationTypes();
        
        $notificationTypeController->InsertNotificationType();
        
        $notificationTypesAfterInsertion = $notificationTypeController->GetAllNotificationTypes();
        
        $this->assertEquals(count($notificationsBeforeInsertion)+1,count($notificationsAfterInsertion));
    }*/
    
    // Test Get Notification Type By Id
    public function testGetNotificationTypeById()
    {
        $notificationTypeController = new NotificationTypeController();
        
        $notificationType = $notificationTypeController->GetNotificationTypeById(2);
        
        $this->assertEquals("Placed An Offer",$notificationType->name);
    }
    
    // Test Update A Notification Type
    public function testUpdateANotificationTypeById()
    {
        $notificationTypeController = new NotificationTypeController();
        
        $notificationTypeController->updateACountyById(2, "Updated");
        
        $notificationType = $notificationTypeController->GetNotificationTypeById(2);
        
        $this->assertEquals("Updated",$notificationType->name);
        
        $notificationTypeController->updateACountyById(2, "Placed An Offer");
    }
        
    
    
}
