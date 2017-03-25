<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeactivatedJobsModel
 *
 * @author Jake Valino
 */

require ("Entities/DeactivatedJobsEntities.php");

class DeactivatedJobsModel {
    
    // Insert A De-Activated Job
    function InsertANewDeactivatedJob($jobId,$userId,$reason,$date)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO deactivatedjobs"
                . "(jobId,userId,reason,date)"
                . "VALUES('%s','%s','%s','%s')",
                mysqli_real_escape_string($connection,$jobId),
                mysqli_real_escape_string($connection,$userId),
                mysqli_real_escape_string($connection,$reason),
                mysqli_real_escape_string($connection,$date));
            
        if (mysqli_query($connection,$query)) {

        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        mysqli_close($connection);
    }
    
    // Get All The Deactivated Jobs
    function GetAllDeactivatedJobs()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM deactivatedjobs ORDER BY date") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $deactivatedJobsArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $id= $row['id'];
                $dbJobId= $row['jobId'];
                $dbUserId= $row['userId'];
                $dbReason= $row['reason'];
                $dbdate= $row['date'];
                
                $deactivatedJobsEntities = new DeactivatedJobsEntities($id, $dbJobId, $dbUserId, $dbReason, $dbdate);
                array_push($deactivatedJobsArray, $deactivatedJobsEntities);
            }
            
            return $deactivatedJobsArray;
        }else
        {
            return 0;
        }  
    }

}
