<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotificationModel
 *
 * @author Jake Valino
 */

require ("Entities/NotificationEntities.php");

class NotificationModel {

    // Insert A New Notification
    function InsertNotification($notificationParameter)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO notification"
                . "(fromusername,tousername,typeId,seen)"
                . "VALUES('%s','%s','%s','%s')",
                mysqli_real_escape_string($connection,$notificationParameter->fromusername),
                mysqli_real_escape_string($connection,$notificationParameter->tousername),
                mysqli_real_escape_string($connection,$notificationParameter->typeId),
                mysqli_real_escape_string($connection,$notificationParameter->seen));
            
        //Define and execute query
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
    }
    
}
