<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FavoriteJobs
 *
 * @author Jake Valino
 */

require ("Entities/FavoriteJobsEntities.php");

class FavoriteJobsModel {
    
    // Post a new favorite job
    function InsertANewFavoriteJob($jobId,$userId, $dateAdded)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO favoritejobs"
                . "(jobId,userId,dateAdded)"
                . "VALUES('%s','%s','%s')",
                mysqli_real_escape_string($connection,$jobId),
                mysqli_real_escape_string($connection,$userId),
                mysqli_real_escape_string($connection,$dateAdded));
            
        if (mysqli_query($connection,$query)) {

        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        mysqli_close($connection);
    }
    
    // Get Active FavoriteJobs
    function GetActiveFavoriteJobsByUserId($userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT f.* FROM jobs j, favoritejobs f WHERE j.jobid = f.jobId and f.userId=$userId AND j.isActive=1") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $favoriteArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $id= $row['id'];
                $dbJobid= $row['jobId'];
                $dbUserId= $row['userId'];
                $dbDateAdded= $row['dateAdded'];
                
                $favoriteJobsEntities = new FavoriteJobsEntities($id,$dbJobid,$dbUserId,$dbDateAdded);

                array_push($favoriteArray, $favoriteJobsEntities);
            }
            
            return $favoriteArray;
        }else
        {
            return 0;
        }  
    }
    
    // Count Number Of FavoriteJobs By UserId
    function CountNumberFavoriteJobs($userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM favoritejobs WHERE userId=$userId") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);

        if($numrows != 0)
        {
            return $numrows;
        }else
        {
            return 0;
        }  
    }
    
    // Get Active FavoriteJobs By jobId and userId
    function GetFavoriteJobsByJobIdANDUserId($jobId,$userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM favoritejobs WHERE jobId=$jobId AND userId=$userId") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $favoriteArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $id= $row['id'];
                $dbJobid= $row['jobId'];
                $dbUserId= $row['userId'];
                $dbDateAdded= $row['dateAdded'];
                
                $favoriteJobsEntities = new FavoriteJobsEntities($id,$dbJobid,$dbUserId,$dbDateAdded);

                array_push($favoriteArray, $favoriteJobsEntities);
            }
            
            return $favoriteArray;
        }else
        {
            return 0;
        }  
    }
    
    // Delete A Favorite Job
    function deleteAFavoriteJob($jobId,$userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
                // sql to delete a record
        $sql = "DELETE FROM favoritejobs WHERE jobId=$jobId AND userId=$userId";

        if ($connection->query($sql) === TRUE) {
           
        } else {
            echo "Error deleting record: " . $connection->error;
        }

        $connection->close();
    } 
}
