<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FollowingModel
 *
 * @author Jake Valino
 */
require ("Entities/FollowingEntities.php");

class FollowingModel {
    
    // Follow A User
    function FollowAUser($userId,$followinguserId, $dateoffollowed)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO following"
                . "(userId,followinguserId,dateoffollowed)"
                . "VALUES('%s','%s','%s')",
                mysqli_real_escape_string($connection,$userId),
                mysqli_real_escape_string($connection,$followinguserId),
                mysqli_real_escape_string($connection,$dateoffollowed));
            
        if (mysqli_query($connection,$query)) {

        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        mysqli_close($connection);
    }
    
    // Check if a user already follows another user
    function CheckIfUserAlreadyFollowedAnotherUser($userId,$followinguserId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM following WHERE userId=$userId AND followinguserId=$followinguserId") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);

        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbid= $row['id'];
                $dbuserId= $row['userId'];
                $dbfollowinguserId= $row['followinguserId'];
                $dbdateoffollowed = $row['dateoffollowed'];
                
                $followingEntities = new FollowingEntities($dbid,$dbuserId,$dbfollowinguserId,$dbdateoffollowed); 
            }
            
            return $followingEntities;
        }else
        {
            return 0;
        }
    }
    
    // Get User's Followers
    function GetFollowersByUserId($userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM following WHERE userId=$userId Order BY dateoffollowed DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $followArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbid= $row['id'];
                $dbuserId= $row['userId'];
                $dbfollowinguserId= $row['followinguserId'];
                $dbdateoffollowed = $row['dateoffollowed'];
                
                $followingEntities = new FollowingEntities($dbid,$dbuserId,$dbfollowinguserId,$dbdateoffollowed); 
                array_push($followArray, $followingEntities);
            }
            
            return $followArray;
        }else
        {
            return 0;
        }
    }
    
    // Get My Followers
    function GetFollowersByFollowingUserId($followinguserId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM following WHERE followinguserId=$followinguserId Order BY dateoffollowed DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $followArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbid= $row['id'];
                $dbuserId= $row['userId'];
                $dbfollowinguserId= $row['followinguserId'];
                $dbdateoffollowed = $row['dateoffollowed'];
                
                $followingEntities = new FollowingEntities($dbid,$dbuserId,$dbfollowinguserId,$dbdateoffollowed); 
                array_push($followArray, $followingEntities);
            }
            
            return $followArray;
        }else
        {
            return 0;
        }
    }
    
    //Unfollow a user
    function unfollowAUser($userId,$followinguserId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
                // sql to delete a record
        $sql = "DELETE FROM following WHERE userId=$userId AND followinguserId=$followinguserId";

        if ($connection->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $connection->error;
        }

        $connection->close();
    } 
}
