<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ActiveUsersModel
 *
 * @author Jake Valino
 */

require ("Entities/ActiveUsersEntities.php");
class ActiveUsersModel {
    
    // Insert A New Active User
    function InsertANewActiveUser($userId, $date, $latest)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO activeusers"
                . "(userId,date,latest)"
                . "VALUES('%s','%s','%s')",
                mysqli_real_escape_string($connection,$userId),
                mysqli_real_escape_string($connection,$date),
                mysqli_real_escape_string($connection,$latest));
            
        if (mysqli_query($connection,$query)) {

        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        mysqli_close($connection);
    }
    
    // Get Active User By Id
    function GetActiveUserByUserId($userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM activeusers WHERE userId=$userId AND latest=1") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);

        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $id= $row['id'];
                $dbUserId= $row['userId'];
                $dbDate= $row['date'];
                $dbLatest= $row['latest'];
                
                $activeUserEntities = new ActiveUsersEntities($id,$dbUserId,$dbDate,$dbLatest);
                
            }
            
            return $activeUserEntities;
        }else
        {
            return 0;
        }  
    }
    
    // Get All Active Users
    function GetAllActiveUsers()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM activeusers") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $activeUsers = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $id= $row['id'];
                $dbUserId= $row['userId'];
                $dbDate= $row['date'];
                $dbLatest= $row['latest'];
                
                $activeUserEntities = new ActiveUsersEntities($id,$dbUserId,$dbDate,$dbLatest);
                array_push($activeUsers, $activeUserEntities);
            }
            
            return $activeUsers;
        }else
        {
            return 0;
        }  
    }
    
    //Get Sum Of Active Users By Month And Year.
    function GetSumActiveUsersByMonthYear($month,$year)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT COUNT(*) FROM activeusers WHERE MONTH(date) =$month AND YEAR(date) = $year GROUP BY id");
        
        $numrows = mysqli_num_rows($result);
        
        if($numrows != 0)
        {
            return $numrows;
        }else
        {
            return 0;
        }
    }
    
    // Update Latest Active User By UserId
    function updateLatestActiveUserByUserId($latest,$userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE activeusers SET latest=$latest WHERE userId=$userId";

        if (mysqli_query($connection, $sql)) {
           
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
    }
    
    // Delete Active User By Id
    function deleteActiveUserByID($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
                // sql to delete a record
        $sql = "DELETE FROM activeusers WHERE userId=$id";

        if ($connection->query($sql) === TRUE) {
           
        } else {
            echo "Error deleting record: " . $connection->error;
        }

        $connection->close();
    }
}
