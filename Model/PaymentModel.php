<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PaymentModel
 *
 * @author Jake Valino
 */

require ("Entities/PaymentEntities.php");
class PaymentModel {
    
    // Insert A Payment
    function InsertANewPayment($userId, $targetUserId, $jobId, $amount, $date, $paymentType, $status, $seen)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO payment"
                . "(userId,targetUserId,jobId,amount,date,paymentType,status,seen)"
                . "VALUES('%s','%s','%s','%s','%s','%s','%s','%s')",
                mysqli_real_escape_string($connection,$userId),
                mysqli_real_escape_string($connection,$targetUserId),
                mysqli_real_escape_string($connection,$jobId),
                mysqli_real_escape_string($connection,$amount),
                mysqli_real_escape_string($connection,$date),
                mysqli_real_escape_string($connection,$paymentType),
                mysqli_real_escape_string($connection,$status),
                mysqli_real_escape_string($connection,$seen));

        if (mysqli_query($connection,$query)) {
            
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        mysqli_close($connection);
    }
    
    // Get Payment by targetUserId
    function GetPaymentMeAccountByUserIdTargetUserIdAndJobId($userId, $targetUserId, $jobId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM payment WHERE userId=$userId AND jobId=$jobId AND targetUserId=$targetUserId") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbUserID= $row['userId'];
                $dbTargetUserId= $row['targetUserId'];
                $dbJobId= $row['jobId'];
                $dbAmount= $row['amount'];
                $dbDate= $row['date'];
                $dbPaymentType= $row['paymentType'];
                $dbStatus= $row['status'];
                $dbSeen= $row['seen'];
                
                $paymentEntities = new PaymentEntities($dbId, $dbUserID, $dbTargetUserId, $dbJobId, $dbAmount, $dbDate, $dbPaymentType, $dbStatus, $dbSeen);
            }
            return $paymentEntities;
        }else
        {
            return 0;
        }
    }
    
    // Get Payment by targetUserId
    function GetPaymentMeAccountByUserId($targetUserId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM payment WHERE targetUserId=$targetUserId") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        
        $paymentArray = array();
        
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbUserID= $row['userId'];
                $dbTargetUserId= $row['targetUserId'];
                $dbJobId= $row['jobId'];
                $dbAmount= $row['amount'];
                $dbDate= $row['date'];
                $dbPaymentType= $row['paymentType'];
                $dbStatus= $row['status'];
                $dbSeen= $row['seen'];
                
                $paymentEntities = new PaymentEntities($dbId, $dbUserID, $dbTargetUserId, $dbJobId, $dbAmount, $dbDate, $dbPaymentType, $dbStatus, $dbSeen);
                array_push($paymentArray, $paymentEntities);
            }
            return $paymentArray;
        }else
        {
            return 0;
        }
    }
    
    // Get Payment by targetUserId And nobId
    function GetPayPalMeAccountByUserIdAndJobId($targetUserId,$jobId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM payment WHERE targetUserId=$targetUserId AND jobId=$jobId") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        
        
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbUserID= $row['userId'];
                $dbTargetUserId= $row['targetUserId'];
                $dbJobId= $row['jobId'];
                $dbAmount= $row['amount'];
                $dbDate= $row['date'];
                $dbPaymentType= $row['paymentType'];
                $dbStatus= $row['status'];
                $dbSeen= $row['seen'];
                
                $paymentEntities = new PaymentEntities($dbId, $dbUserID, $dbTargetUserId, $dbJobId, $dbAmount, $dbDate, $dbPaymentType, $dbStatus, $dbSeen);
            }
            return $paymentEntities;
        }else
        {
            return 0;
        }
    }
    
    // Count Payment by targetUserId And nobId
    function CountPaymentByUserIdAndJobId($targetUserId,$jobId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM payment WHERE targetUserId=$targetUserId AND jobId=$jobId") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        
        if($numrows != 0)
        {
            return $numrows;
        }else
        {
            return 0;
        }
    }
    
    // Count Payment by targetUserId
    function CountPaymentByTargetUserId($targetUserId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM payment WHERE targetUserId=$targetUserId AND seen = 0") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        
        if($numrows != 0)
        {
            return $numrows;
        }else
        {
            return 0;
        }
    }
    
    //Update a Payment Confirmation
    function updatePaymentConfirmation($status, $targetUserId, $userId, $jobId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        $sql = "UPDATE payment SET status=$status WHERE targetUserId=$targetUserId AND userId=$userId AND jobId=$jobId";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $sql = "UPDATE payment SET seen=1 WHERE targetUserId=$targetUserId AND userId=$userId AND jobId=$jobId";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $connection->close();
    }
    
}
