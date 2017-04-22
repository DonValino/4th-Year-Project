<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotificationTypeModel
 *
 * @author Jake Valino
 */

require ("Entities/NotificationTypeEntities.php");

class NotificationTypeModel {

    // Insert A New Notification Type
    function InsertNotificationType($notificationTypeParameter)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO notificationtype"
                . "(name)"
                . "VALUES('%s')",
                mysqli_real_escape_string($connection,$notificationTypeParameter->name));
            
        //Define and execute query
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
    }
    
    // Get Notification Type By Id
    function GetNotificationTypeById($typeId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM notificationtype WHERE typeId=$typeId") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);

        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbTypeid= $row['typeId'];
                $dbName= $row['name'];

                $notificationTypeEntities = new NotificationTypeEntities($dbTypeid,$dbName);
            }
            
            return $notificationTypeEntities;
        }else
        {
            return 0;
        }
    }
    
    // Get All Notification Types
    function GetAllNotificationTypes()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM notificationtype ORDER BY typeId") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $notificationTypes = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbTypeid= $row['typeId'];
                $dbName= $row['name'];

                $notificationTypeEntities = new NotificationTypeEntities($dbTypeid,$dbName);
                array_push($notificationTypes, $notificationTypeEntities);
            }
            
            return $notificationTypes;
        }else
        {
            return 0;
        }
    }
    
    // Update A Notification Type By Id
    function updateACountyById($id, $name)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE notificationtype SET name='$name' WHERE typeId=$id";

        if (mysqli_query($connection, $sql)) {
           
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
    
    //Delete a notification type
    function deleteANotificationType($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
                // sql to delete a record
        $sql = "DELETE FROM notificationtype WHERE typeId=$id";

        if ($connection->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $connection->error;
        }

        $connection->close();
    }
    
}
