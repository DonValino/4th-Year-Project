<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotificationTypeController
 *
 * @author Jake Valino
 */

require 'Model/NotificationTypeModel.php';

class NotificationTypeController {

    // Insert A New Notification Type
    function InsertNotificationType()
    {
        $name = $_POST["name"];

        $notificationType = new NotificationTypeEntities(-1, $name);
        $notificationModel = new NotificationTypeModel();
        $notificationModel->InsertNotificationType($notificationType);
    }
    
    // Get Notification Type By Id
    function GetNotificationTypeById($typeId)
    {
        $notificationTypeModel = new NotificationTypeModel(); 
        
        return $notificationTypeModel->GetNotificationTypeById($typeId);
    }
}
