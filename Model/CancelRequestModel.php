<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CancelRequestModel
 *
 * @author Jake Valino
 */

require ("Entities/CancelRequestEntities.php");
class CancelRequestModel {
    
    // Insert A Cancel Request
    function InsertANewCancelRequest($userId, $tagerUserId, $jobId, $reason, $date, $seen)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO cancelrequest"
                . "(userId,tagerUserId,jobId,reason,date,seen)"
                . "VALUES('%s','%s','%s','%s','%s','%s')",
                mysqli_real_escape_string($connection,$userId),
                mysqli_real_escape_string($connection,$tagerUserId),
                mysqli_real_escape_string($connection,$jobId),
                mysqli_real_escape_string($connection,$reason),
                mysqli_real_escape_string($connection,$date),
                mysqli_real_escape_string($connection,$seen));
            
        if (mysqli_query($connection,$query)) {

        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        mysqli_close($connection);
    }
    
    // Get Cancel Request by Target User Id
    function GetCancelRequestByTargetUserId($tagerUserId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM cancelrequest WHERE tagerUserId='$tagerUserId' ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $cancelRequestArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $id= $row['id'];
                $dbUserId= $row['userId'];
                $dbTargetUserId= $row['tagerUserId'];
                $dbJobId= $row['jobId'];
                $dbReason= $row['reason'];
                $dbStatus= $row['status'];
                $dbDate= $row['date'];
                $dbSeen= $row['seen'];
                
                $cancelRequestEntities = new CancelRequestEntities($id,$dbUserId,$dbTargetUserId,$dbJobId,$dbReason,$dbStatus,$dbDate,$dbSeen);
                
                array_push($cancelRequestArray, $cancelRequestEntities);
            }
            
            return $cancelRequestArray;
        }else
        {
            return 0;
        }  
    }
    
    // Count Cancel Request by Target User Id
    function CountCancelRequestByTargetUserId($tagerUserId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM cancelrequest WHERE tagerUserId='$tagerUserId' AND seen = 0") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        if($numrows != 0)
        {
            return $numrows;
        }else
        {
            return 0;
        }  
    }
    
    // Get Cancel Request by User Id
    function GetCancelRequestByUserId($userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM cancelrequest WHERE userId='$userId'") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $cancelRequestArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $id= $row['id'];
                $dbUserId= $row['userId'];
                $dbTargetUserId= $row['targetUserId'];
                $dbJobId= $row['jobId'];
                $dbReason= $row['reason'];
                $dbStatus= $row['status'];
                $dbDate= $row['date'];
                $dbSeen= $row['seen'];
                
                $cancelRequestEntities = new CancelRequestEntities($id,$dbUserId,$dbTargetUserId,$dbJobId,$dbReason,$dbStatus,$dbDate,$dbSeen);
                
                array_push($cancelRequestArray, $cancelRequestEntities);
            }
            
            return $cancelRequestArray;
        }else
        {
            return 0;
        }  
    }
    
    // Update A Cancel Request Status
    function updateCancelRequestStatus($status,$userId,$targetUserId,$jobId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE cancelrequest SET status=$status WHERE userId=$userId AND tagerUserId=$targetUserId AND jobId=$jobId";

        if (mysqli_query($connection, $sql)) {
           
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
    }
    
    // Update A Cancel Request Reason
    function updateCancelReason($reason,$userId,$targetUserId,$jobId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE cancelrequest SET reason='$reason' WHERE userId=$userId AND tagerUserId=$targetUserId AND jobId=$jobId";

        if (mysqli_query($connection, $sql)) {
           
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
    }
    
    // Update A Cancel Request Seen
    function updateCancelSeen($seen,$userId,$targetUserId,$jobId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE cancelrequest SET seen=1 WHERE userId=$userId AND tagerUserId=$targetUserId AND jobId=$jobId";

        if (mysqli_query($connection, $sql)) {
           
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
    }
}
