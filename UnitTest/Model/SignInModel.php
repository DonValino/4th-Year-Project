<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SignInModel
 *
 * @author Jake Valino
 */
require ("Entities/SignInEntities.php");

class SignInModel {
    
    //Insert a user sign in
    function InsertAUserSignIn($userId,$jobId,$date,$latest)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO signin"
                . "(userId,jobId,date,latest)"
                . "VALUES('%s','%s','%s','%s')",
                mysqli_real_escape_string($connection,$userId),
                mysqli_real_escape_string($connection,$jobId),
                mysqli_real_escape_string($connection,$date),
                mysqli_real_escape_string($connection,$latest));
            
        //Define and execute query
        $result = mysqli_query($connection,$query) or die(mysql_error());
        mysqli_close($connection);
    }
    
    //Get All Sign In Records by jobId.
    function GetAllSignInRecordsByJobId($jobId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM signin WHERE jobId=$jobId ORDER BY date") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $signInArray = array();
        
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbUserId= $row['userId'];
                $dbJobId= $row['jobId'];
                $dbDate= $row['date'];
                $dbLatest= $row['latest'];
                
                $signInEntities = new SignInEntities($dbId,$dbUserId,$dbJobId,$dbDate,$dbLatest);
                array_push($signInArray, $signInEntities);
            }
            
            return $signInArray;
        }else
        {
            return 0;
        }
    }
    
    //Get All Sign In.
    function GetAllSignIn()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM signin ORDER BY date") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $signInArray = array();
        
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbUserId= $row['userId'];
                $dbJobId= $row['jobId'];
                $dbDate= $row['date'];
                $dbLatest= $row['latest'];
                
                $signInEntities = new SignInEntities($dbId,$dbUserId,$dbJobId,$dbDate,$dbLatest);
                array_push($signInArray, $signInEntities);
            }
            
            return $signInArray;
        }else
        {
            return 0;
        }
    }
    
    //Get Sign In Records by userId And jobId.
    function GetSignInRecordsByUserIdAndJobId($userId,$jobId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM signin WHERE userId=$userId AND jobId=$jobId AND latest=1 ORDER BY date") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbUserId= $row['userId'];
                $dbJobId= $row['jobId'];
                $dbDate= $row['date'];
                $dbLatest= $row['latest'];
                
                $signInEntities = new SignInEntities($dbId,$dbUserId,$dbJobId,$dbDate,$dbLatest);
            }
            
            return $signInEntities;
        }else
        {
            return 0;
        }
    }
    
    // Count Attendance To A Job
    function CountAttendanceToAJob($userId,$jobId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM signin WHERE userId=$userId AND jobId=$jobId ORDER BY date") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        
        if($numrows != 0)
        {
            return $numrows;
        }else
        {
            return 0;
        }
    }
    
    //Update latest status
    function updateLatestStatus($latest,$userId,$jobId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE signin SET latest=$latest WHERE userId=$userId AND jobId=$jobId";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        

        $connection->close();
    }
    
}
