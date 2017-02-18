<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CountyModel
 *
 * @author Jake Valino
 */

require ("Entities/CountyEntities.php");
class CountyModel {
    
    // Insert A new County
    function InsertANewCounty($county)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO county"
                . "(County)"
                . "VALUES('%s')",
                mysqli_real_escape_string($connection,$county));
            
        if (mysqli_query($connection,$query)) {

        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        mysqli_close($connection);
    }
    
    // Get All The Counties
    function GetAllCounties()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM county ORDER BY County") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $countyArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $id= $row['id'];
                $dbCounty= $row['County'];
                
                $countyEntities = new CountyEntities($id, $dbCounty);
                array_push($countyArray, $countyEntities);
            }
            
            return $countyArray;
        }else
        {
            return 0;
        }  
    }
    
    // Get County By Id
    function GetCountyById($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM county WHERE id=$id") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $id= $row['id'];
                $dbCounty= $row['County'];
                
                $countyEntities = new CountyEntities($id, $dbCounty);
            }
            
            return $countyEntities;
        }else
        {
            return 0;
        }  
    }
    
    // Get County By Name
    function GetCountyByName($name)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM county WHERE County='$name'") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $id= $row['id'];
                $dbCounty= $row['County'];
                
                $countyEntities = new CountyEntities($id, $dbCounty);
            }
            
            return $countyEntities;
        }else
        {
            return 0;
        }  
    }
    
    // Update A County By Id
    function updateACountyById($county,$id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE county SET County='$county' WHERE id=$id";

        if (mysqli_query($connection, $sql)) {
           
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
    
    // Delete A County By Id
    function deleteACountyByID($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
                // sql to delete a record
        $sql = "DELETE FROM county WHERE id=$id";

        if ($connection->query($sql) === TRUE) {
           
        } else {
            echo "Error deleting record: " . $connection->error;
        }

        $connection->close();
    }
}
