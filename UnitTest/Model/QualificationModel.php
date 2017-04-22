<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QualificationModel
 *
 * @author Jake Valino
 */
require ("Entities/QualificationEntities.php");

class QualificationModel {
    //put your code here
    
    //Get Qualification By ID.
    function GetQualificationByID($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM qualification WHERE QualificationId=$id") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);

        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbQualificationId= $row['QualificationId'];
                $dbQualificationName= $row['qualificationName'];
                $dbDescription= $row['description'];
                
                $qualificationEntities = new QualificationEntities($dbQualificationId,$dbQualificationName,$dbDescription);  
            }
            
            return $qualificationEntities;
        }else
        {
            return 0;
        }
    }
    
    //Get Qualifications.
    function GetQualifications()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM qualification") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $qualificationArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbQualificationId= $row['QualificationId'];
                $dbQualificationName= $row['qualificationName'];
                $dbDescription= $row['description'];
                
                $qualificationEntities = new QualificationEntities($dbQualificationId,$dbQualificationName,$dbDescription); 
                array_push($qualificationArray, $qualificationEntities);
            }
            
            return $qualificationArray;
        }else
        {
            return 0;
        }
    } 
    
    //Insert a new Qualification into the database
    function InsertANewQualification($qualificationParameter)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO qualification"
                . "(qualificationName,description)"
                . "VALUES('%s','%s')",
                mysqli_real_escape_string($connection,$qualificationParameter->qualificationName),
                mysqli_real_escape_string($connection,$qualificationParameter->description));
            
        //Define and execute query
        $result = mysqli_query($connection,$query) or die(mysql_error());
        mysqli_close($connection);
    }
    
    //Update Qualification Name
    function updateQualificationName($id, $qualificationName)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE qualification SET qualificationName='$qualificationName' WHERE qualificationId=$id";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }

        $connection->close();
    }
    
    //Update a user
    function updateQualification($id, $qualificationName, $description)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE qualification SET qualificationName='$qualificationName' WHERE qualificationId=$id";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $sql = "UPDATE qualification SET description='$description' WHERE qualificationId=$id";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }

        $connection->close();
    } 
    
    //Delete a Qualification
    function deleteQualification($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
                // sql to delete a record
        $sql = "DELETE FROM qualification WHERE QualificationId=$id";

        if ($connection->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $connection->error;
        }

        $connection->close();
    }
    
    
}
