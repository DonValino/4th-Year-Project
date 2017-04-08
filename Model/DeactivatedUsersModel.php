<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeactivatedUsersModel
 *
 * @author Jake Valino
 */
require ("Entities/DeactivatedUsersEntities.php");
class DeactivatedUsersModel {
    
    // Insert A De-Activated Job
    function InsertANewDeactivatedUser($userId,$reason,$date)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO deactivatedusers"
                . "(userId,reason,date)"
                . "VALUES('%s','%s','%s')",
                mysqli_real_escape_string($connection,$userId),
                mysqli_real_escape_string($connection,$reason),
                mysqli_real_escape_string($connection,$date));
            
        if (mysqli_query($connection,$query)) {

        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        mysqli_close($connection);
    }
    
    // Get All The Deactivated Users
    function GetAllDeactivatedUsers()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM deactivatedusers ORDER BY date") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $deactivatedUsersArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $id= $row['id'];
                $dbUserId= $row['userId'];
                $dbReason= $row['reason'];
                $dbdate= $row['date'];
                
                $deactivatedUsersEntities = new DeactivatedUsersEntities($id, $dbUserId, $dbReason, $dbdate);
                array_push($deactivatedUsersArray, $deactivatedUsersEntities);
            }
            
            return $deactivatedUsersArray;
        }else
        {
            return 0;
        }  
    }
    
    // Get All The Deactivated Users by UserId
    function GetAllDeactivatedUsersByUserId($userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM deactivatedusers WHERE userId=$userId ORDER BY date") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);

        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $id= $row['id'];
                $dbUserId= $row['userId'];
                $dbReason= $row['reason'];
                $dbdate= $row['date'];
                
                $deactivatedUsersEntities = new DeactivatedUsersEntities($id, $dbUserId, $dbReason, $dbdate);

            }
            
            return $deactivatedUsersEntities;
        }else
        {
            return 0;
        }  
    }
    
}
