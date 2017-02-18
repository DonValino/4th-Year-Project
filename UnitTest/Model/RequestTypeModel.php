<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RequestTypeModel
 *
 * @author Jake Valino
 */

require ("Entities/RequestTypeEntities.php");
class RequestTypeModel {
    
    //Insert a new request type
    function InsertARequestType($name)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO requesttype"
                . "(name)"
                . "VALUES('%s')",
                mysqli_real_escape_string($connection,$name));
            
        //Define and execute query
        $result = mysqli_query($connection,$query) or die(mysql_error());
        mysqli_close($connection);
    }
    
    //Get Request Type.
    function GetRequestTypes()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM requesttype ORDER BY name") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $requestTypeArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbRequestTypeId= $row['id'];
                $dbName= $row['name'];
                
                $requestTypeEntities = new RequestTypeEntities($dbRequestTypeId,$dbName);
                
                array_push($requestTypeArray, $requestTypeEntities);
            }
            
            return $requestTypeArray;
        }else
        {
            return 0;
        }
    } 
    
    //Get A Request Type By Id.
    function GetARequestTypeById($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM requesttype WHERE id=$id ORDER BY name") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbRequestTypeId= $row['id'];
                $dbName= $row['name'];
                
                $requestTypeEntities = new RequestTypeEntities($dbRequestTypeId,$dbName);
            }
            
            return $requestTypeEntities;
        }else
        {
            return 0;
        }
    }
    
    
}
