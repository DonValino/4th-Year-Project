<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RequestModel
 *
 * @author Jake Valino
 */

require ("Entities/RequestEntities.php");
class RequestModel {
    
    //Insert a new request 
    function InsertANewRequest($userId,$targetUserId,$typeId,$date, $status)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO requesttable"
                . "(userId,targetUserId,typeId,date,status,seen)"
                . "VALUES('%s','%s','%s','%s','%s','%s')",
                mysqli_real_escape_string($connection,$userId),
                mysqli_real_escape_string($connection,$targetUserId),
                mysqli_real_escape_string($connection,$typeId),
                mysqli_real_escape_string($connection,$date),
                mysqli_real_escape_string($connection,$status),
                mysqli_real_escape_string($connection,0));
            
        //Define and execute query
        $result = mysqli_query($connection,$query) or die(mysql_error());
        mysqli_close($connection);
    }
    
    //Get Requests.
    function GetRequests()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM requesttable ORDER BY date") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $requestArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbUserId= $row['userId'];
                $dbTargetUserId= $row['targetUserId'];
                $dbTypeId= $row['typeId'];
                $dbDate= $row['date'];
                $dbStatus= $row['status'];
                $dbSeen= $row['seen'];
                
                $requestEntities = new RequestEntities($dbId,$dbUserId,$dbTargetUserId,$dbTypeId,$dbDate,$dbStatus,$dbSeen);
                
                array_push($requestArray, $requestEntities);
            }
            
            return $requestArray;
        }else
        {
            return 0;
        }
    }
    
    //Get Requests By userId.
    function GetRequestsByUserId($userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM requesttable where userId=$userId ORDER BY date") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $requestArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbUserId= $row['userId'];
                $dbTargetUserId= $row['targetUserId'];
                $dbTypeId= $row['typeId'];
                $dbDate= $row['date'];
                $dbStatus= $row['status'];
                $dbSeen= $row['seen'];
                
                $requestEntities = new RequestEntities($dbId,$dbUserId,$dbTargetUserId,$dbTypeId,$dbDate,$dbStatus,$dbSeen);
                
                array_push($requestArray, $requestEntities);
            }
            
            return $requestArray;
        }else
        {
            return 0;
        }
    }
    
    //Get Requests By targetUserId.
    function GetRequestsByTargetUserId($targetUserId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM requesttable where targetUserId=$targetUserId ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $requestArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbUserId= $row['userId'];
                $dbTargetUserId= $row['targetUserId'];
                $dbTypeId= $row['typeId'];
                $dbDate= $row['date'];
                $dbStatus= $row['status'];
                $dbSeen= $row['seen'];
                
                $requestEntities = new RequestEntities($dbId,$dbUserId,$dbTargetUserId,$dbTypeId,$dbDate,$dbStatus,$dbSeen);
                
                array_push($requestArray, $requestEntities);
            }
            
            return $requestArray;
        }else
        {
            return 0;
        }
    }
    
    //Get Requests By targetUserId Test.
    function GetRequestsByUserIdAndTargetUserIdTest($userId, $targetUserId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM requesttable where userId=$userId AND targetUserId=$targetUserId ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);

        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbUserId= $row['userId'];
                $dbTargetUserId= $row['targetUserId'];
                $dbTypeId= $row['typeId'];
                $dbDate= $row['date'];
                $dbStatus= $row['status'];
                $dbSeen= $row['seen'];
                
                $requestEntities = new RequestEntities($dbId,$dbUserId,$dbTargetUserId,$dbTypeId,$dbDate,$dbStatus,$dbSeen);
            }
            
            return $requestEntities;
        }else
        {
            return 0;
        }
    }
    
    //Count Requests By targetUserId.
    function CountRequestsByTargetUserId($targetUserId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM requesttable where targetUserId=$targetUserId and seen=0 ORDER BY date") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        if($numrows != 0)
        {
            return $numrows;
        }else
        {
            return 0;
        }
    }
    
    //Get Requests By userId And targetUserId.
    function GetRequestsByUserIdANDTargetUserId($userId, $targetUserId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM requesttable where userId=$userId AND targetUserId=$targetUserId ORDER BY date") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $requestArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbUserId= $row['userId'];
                $dbTargetUserId= $row['targetUserId'];
                $dbTypeId= $row['typeId'];
                $dbDate= $row['date'];
                $dbStatus= $row['status'];
                $dbSeen= $row['seen'];
                
                $requestEntities = new RequestEntities($dbId,$dbUserId,$dbTargetUserId,$dbTypeId,$dbDate,$dbStatus,$dbSeen);
                
                array_push($requestArray, $requestEntities);
            }
            
            return $requestArray;
        }else
        {
            return 0;
        }
    }
    
    //Get CV / CoverLetter Requests By userId And targetUserId.
    function GetCVCoverLetterRequestsByUserIdANDTargetUserId($userId, $targetUserId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM requesttable where userId=$userId AND targetUserId=$targetUserId AND typeId=1 ORDER BY date") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbUserId= $row['userId'];
                $dbTargetUserId= $row['targetUserId'];
                $dbTypeId= $row['typeId'];
                $dbDate= $row['date'];
                $dbStatus= $row['status'];
                $dbSeen= $row['seen'];
                
                $requestEntities = new RequestEntities($dbId,$dbUserId,$dbTargetUserId,$dbTypeId,$dbDate,$dbStatus,$dbSeen);
            }
            
            return $requestEntities;
        }else
        {
            return 0;
        }
    }
    
    // Cancel Request
    function cancelRequest($userId, $targetUserId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
                // sql to delete a record
        $sql = "DELETE FROM requesttable WHERE userId=$userId AND targetUserId=$targetUserId";

        if ($connection->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $connection->error;
        }

        $connection->close();
    }
    
    //Update seen request
    function updateRequestSeen($targetUserId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE requesttable SET seen=1 WHERE targetUserId=$targetUserId";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        

        $connection->close();
    }
    
    //Update request status
    function updateRequestStatus($statusId, $userId, $targetUserId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE requesttable SET status=$statusId WHERE userId=$userId AND targetUserId=$targetUserId";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        

        $connection->close();
    }
}
