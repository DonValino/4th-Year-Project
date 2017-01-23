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
    function InsertNotification($fromusername,$tousername,$typeId,$seen,$dateofnotification,$jobid)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO notification"
                . "(fromusername,tousername,typeId,seen,dateofnotification,jobid)"
                . "VALUES('%s','%s','%s','%s','%s','%s')",
                mysqli_real_escape_string($connection,$fromusername),
                mysqli_real_escape_string($connection,$tousername),
                mysqli_real_escape_string($connection,$typeId),
                mysqli_real_escape_string($connection,$seen),
                mysqli_real_escape_string($connection,$dateofnotification),
                mysqli_real_escape_string($connection,$jobid));
            
        //Define and execute query
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
    }

    // Get Notification By Id
    function GetNotificationById($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM notification WHERE id=$id") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);

        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbFromUsername= $row['fromusername'];
                $dbToUsername= $row['tousername'];
                $dbTypeId= $row['typeId'];
                $dbSeen= $row['seen'];
                $dbDateofnotification= $row['dateofnotification'];
                $dbJobId= $row['jobid'];
                
                $notificationEntities = new NotificationTypeEntities($dbId,$dbFromUsername,$dbToUsername,$dbTypeId,$dbSeen,$dbDateofnotification,$dbJobId);
            }
            
            return $notificationEntities;
        }else
        {
            return 0;
        }
    }
    
    // Get Notification By FromUsername
    function GetNotificationByFromUsername($fromUsername)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM notification WHERE fromusername='$fromUsername'") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $notificationArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbFromUsername= $row['fromusername'];
                $dbToUsername= $row['tousername'];
                $dbTypeId= $row['typeId'];
                $dbSeen= $row['seen'];
                $dbDateofnotification= $row['dateofnotification'];
                $dbJobId= $row['jobid'];
                
                $notificationEntities = new NotificationTypeEntities($dbId,$dbFromUsername,$dbToUsername,$dbTypeId,$dbSeen,$dbDateofnotification,$dbJobId);
                array_push($notificationArray, $notificationEntities);
            }
            
            return $notificationArray;
        }else
        {
            return 0;
        }
    }    
    
    
    // Get Notification By ToUsername
    function GetNotificationByToUsername($toUsername)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM notification WHERE toUsername='$toUsername'") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $notificationArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbFromUsername= $row['fromusername'];
                $dbToUsername= $row['tousername'];
                $dbTypeId= $row['typeId'];
                $dbSeen= $row['seen'];
                $dbDateofnotification= $row['dateofnotification'];
                $dbJobId= $row['jobid'];
                
                $notificationEntities = new NotificationEntities($dbId,$dbFromUsername,$dbToUsername,$dbTypeId,$dbSeen,$dbDateofnotification,$dbJobId);
                array_push($notificationArray, $notificationEntities);
            }
            
            return $notificationArray;
        }else
        {
            return 0;
        }
    }    

}
