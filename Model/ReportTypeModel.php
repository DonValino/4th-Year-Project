<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReportTypeModel
 *
 * @author Jake Valino
 */
require ("Entities/ReportTypeEntities.php");
class ReportTypeModel {
    
    //Insert a new report type
    function InsertANewReportType($name)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO report"
                . "(name)"
                . "VALUES('%s')",
                mysqli_real_escape_string($connection,$name));
            
        //Define and execute query
        $result = mysqli_query($connection,$query) or die(mysql_error());
        mysqli_close($connection);
    }
    
    //Get Report Type By Id.
    function GetReportTypeById($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM reporttype WHERE id=$id") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);

        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbName= $row['name'];
                
                $reportTypeEntities = new ReportTypeEntities($dbId,$dbName);
            }
            
            return $reportTypeEntities;
        }else
        {
            return 0;
        }
    }
    
    //Get All Report Types.
    function GetAllReportTypes()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM reporttype ORDER BY name") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $types = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbName= $row['name'];
                
                $reportTypeEntities = new ReportTypeEntities($dbId,$dbName);
                array_push($types, $reportTypeEntities);
            }
            
            return $types;
        }else
        {
            return 0;
        }
    }
    
}
