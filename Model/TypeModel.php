<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TypeModel
 *
 * @author Jake Valino
 */
require ("Entities/TypeEntities.php");

class TypeModel {
    //put your code here
    
 //Get Qualification By ID.
    function GetTypeByID($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM type WHERE typeId=$id") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);

        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbTypeId= $row['typeId'];
                $dbName= $row['name'];
                
                $typeEntities = new TypeEntities($dbTypeId,$dbName);  
            }
            
            return $typeEntities;
        }else
        {
            return 0;
        }
    }
    
    //Get Qualifications.
    function GetTypes()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM type") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $typeArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbTypeId= $row['typeId'];
                $dbName= $row['name'];
                
                $typeEntities = new TypeEntities($dbTypeId,$dbName);
                
                array_push($typeArray, $typeEntities);
            }
            
            return $typeArray;
        }else
        {
            return 0;
        }
    } 
    
    //Insert a new Qualification into the database
    function InsertANewType($typeParameter)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO type"
                . "(name)"
                . "VALUES('%s')",
                mysqli_real_escape_string($connection,$typeParameter->name));
            
        //Define and execute query
        $result = mysqli_query($connection,$query) or die(mysql_error());
        mysqli_close($connection);
    }
    
    //Update a user
    function updateType($id, $name)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE type SET name='$name' WHERE typeId=$id";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        

        $connection->close();
    }
    
    //Delete a Type
    function deleteType($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
                // sql to delete a record
        $sql = "DELETE FROM type WHERE typeid=$id";

        if ($connection->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $connection->error;
        }

        $connection->close();
    } 
}
