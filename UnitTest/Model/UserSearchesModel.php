<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserSearchesModel
 *
 * @author Jake Valino
 */
require ("Entities/UserSearchesEntities.php");

class UserSearchesModel {
    
    //Insert user searches in database
    function InsertANewReview($userId,$keyword,$dateofsearch,$numResult)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        
            $query = sprintf("INSERT INTO usersearches"
                . "(userId,keyword,dateofsearch,numResult)"
                . "VALUES('%s','%s','%s','%s')",
                mysqli_real_escape_string($connection,$userId),
                mysqli_real_escape_string($connection,$keyword),
                mysqli_real_escape_string($connection,$dateofsearch),
                mysqli_real_escape_string($connection,$numResult));
            
        if (mysqli_query($connection,$query)) {

        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        mysqli_close($connection);
    }
    
    // Get All keyword search From A Specific User
    function GetUserSearhesById($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM usersearches WHERE userid=$id ORDER BY dateofsearch DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $searchesArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId = $row['id'];
                $dbuserId = $row['userId'];
                $dbkeyword= $row['Keyword'];
                $dbdateofsearch= $row['dateofsearch'];
                $dbnumResult = $row['numResult'];
                
                $userSearchEntities = new UserSearchesEntities($dbId,$dbuserId,$dbkeyword,$dbdateofsearch,$dbnumResult);
                array_push($searchesArray, $userSearchEntities);
            }
            
            return $searchesArray;
        }else
        {
            return 0;
        }
    }
    
    // Number of keyword search per user
    function  CountNumberOfUserSearhesById($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM usersearches WHERE userid=$id") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        if($numrows != 0)
        {
            return $numrows;
        }else
        {
            return 0;
        } 
    }
    
    //Update date fo search
    function updateDateOfSearch($id,$dateOfSearch)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE usersearches SET dateofsearch='$dateOfSearch' WHERE id=$id";

        if (mysqli_query($connection, $sql)) {
           
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
    
    // Update date fo search
    function updateNumResult($id,$numResult)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE usersearches SET numResult='$numResult' WHERE id=$id";

        if (mysqli_query($connection, $sql)) {
           
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
    
    //Delete all user keyword searches
    function deleteKeywordSearches($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
                // sql to delete a record
        $sql = "DELETE FROM usersearches WHERE userId=$id";

        if ($connection->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $connection->error;
        }

        $connection->close();
    } 
    
    
}
