<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReportModel
 *
 * @author Jake Valino
 */
require ("Entities/ReportEntities.php");
class ReportModel {
    
    //Insert a new report 
    function InsertANewReport($userId,$description,$typeId,$date, $seen, $status)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO report"
                . "(userId,description,typeId,date,seen,status)"
                . "VALUES('%s','%s','%s','%s','%s','%s')",
                mysqli_real_escape_string($connection,$userId),
                mysqli_real_escape_string($connection,$description),
                mysqli_real_escape_string($connection,$typeId),
                mysqli_real_escape_string($connection,$date),
                mysqli_real_escape_string($connection,$seen),
                mysqli_real_escape_string($connection,$status));
            
        //Define and execute query
        $result = mysqli_query($connection,$query) or die(mysql_error());
        mysqli_close($connection);
    }
    
    //Get My Reports.
    function GetMyReports($userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM report WHERE userId=$userId ORDER BY date") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $reportsArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbUserId= $row['userId'];
                $dbDescription= $row['description'];
                $dbTypeId= $row['typeId'];
                $dbDate= $row['date'];
                $dbSeen= $row['seen'];
                $dbStatus= $row['status'];
                
                $reportEntities = new ReportEntities($dbId,$dbUserId,$dbDescription,$dbTypeId,$dbDate,$dbSeen,$dbStatus);
                
                array_push($reportsArray, $reportEntities);
            }
            
            return $reportsArray;
        }else
        {
            return 0;
        }
    }
    
    //Get Reports.
    function GetReports()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM report WHERE YEAR(date) = $_SESSION[yearDate] ORDER BY date") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $reportsArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbUserId= $row['userId'];
                $dbDescription= $row['description'];
                $dbTypeId= $row['typeId'];
                $dbDate= $row['date'];
                $dbSeen= $row['seen'];
                $dbStatus= $row['status'];
                
                $reportEntities = new ReportEntities($dbId,$dbUserId,$dbDescription,$dbTypeId,$dbDate,$dbSeen,$dbStatus);
                
                array_push($reportsArray, $reportEntities);
            }
            
            return $reportsArray;
        }else
        {
            return 0;
        }
    }
    
    // Count Reports.
    function CountReports()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM report WHERE YEAR(date) = $_SESSION[yearDate] ORDER BY date") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        if($numrows != 0)
        {
            
            return $numrows;
        }else
        {
            return 0;
        }
    }
    
    // Count My Reports.
    function CountMyReports($userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM report WHERE userId=$userId ORDER BY date") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        if($numrows != 0)
        {
            
            return $numrows;
        }else
        {
            return 0;
        }
    }
    
    //Get Sum Of Reports By Type Id, Month and Year
    function GetSumReportsByMonthYear($month,$year,$typeId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT COUNT(*) FROM report WHERE MONTH(date) =$month AND YEAR(date) = $year AND typeId=$typeId GROUP BY id");
        
        $numrows = mysqli_num_rows($result);
        
        if($numrows != 0)
        {
            return $numrows;
        }else
        {
            return 0;
        }
    }
    
    //Get Sum Of Reports By Type Id and Year
    function GetSumReportsByYear($year,$typeId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT COUNT(*) FROM report WHERE YEAR(date) = $year AND typeId=$typeId GROUP BY id");
        
        $numrows = mysqli_num_rows($result);
        
        if($numrows != 0)
        {
            return $numrows;
        }else
        {
            return 0;
        }
    }
    
    //Get Reports Test.
    function GetReportsTest($year)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM report WHERE YEAR(date) = $year ORDER BY date") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $reportsArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbUserId= $row['userId'];
                $dbDescription= $row['description'];
                $dbTypeId= $row['typeId'];
                $dbDate= $row['date'];
                $dbSeen= $row['seen'];
                $dbStatus= $row['status'];
                
                $reportEntities = new ReportEntities($dbId,$dbUserId,$dbDescription,$dbTypeId,$dbDate,$dbSeen,$dbStatus);
                
                array_push($reportsArray, $reportEntities);
            }
            
            return $reportsArray;
        }else
        {
            return 0;
        }
    }
    
    //Get Report By Id.
    function GetReportById($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM report WHERE id = $id") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbUserId= $row['userId'];
                $dbDescription= $row['description'];
                $dbTypeId= $row['typeId'];
                $dbDate= $row['date'];
                $dbSeen= $row['seen'];
                $dbStatus= $row['status'];
                
                $reportEntities = new ReportEntities($dbId,$dbUserId,$dbDescription,$dbTypeId,$dbDate,$dbSeen,$dbStatus);
            }
            
            return $reportEntities;
        }else
        {
            return 0;
        }
    }
    
    //Update report status
    function updateReportStatus($status,$id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE report SET status=$status WHERE id=$id";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        

        $connection->close();
    }
}
