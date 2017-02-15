<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PlacedOffersModel
 *
 * @author Jake Valino
 */

require ("Entities/PlacedOffersEntities.php");

class PlacedOffersModel {
    
    // Place An Offer To A Job
    function PlaceAnOffer($jobId, $userId, $comment, $date, $offerPrice)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO placedoffers"
                . "(jobId,userID,comment,placeMentDate,offerPrice)"
                . "VALUES('%s','%s','%s','%s','%s')",
                mysqli_real_escape_string($connection,$jobId),
                mysqli_real_escape_string($connection,$userId),
                mysqli_real_escape_string($connection,$comment),
                mysqli_real_escape_string($connection,$date),
                mysqli_real_escape_string($connection,$offerPrice));
            
        //Define and execute query

        if (mysqli_query($connection,$query)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        mysqli_close($connection);
    }
    
    // Get All Placed Offers in a specific job
    function GetAllPlacedOffersByJobId($jobid)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM placedoffers WHERE jobId=$jobid") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $jobArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobId'];
                $dbUserID= $row['userID'];
                $dbComment= $row['comment'];
                $dbPlacementDate = $row['placementDate'];
                $dbOfferPrice = $row['offerPrice'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice);
                array_push($jobArray, $placedOffersEntities);
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    // Get All Placed Offers in a specific job
    function CountNoPlacedOffersByJobId($jobid)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM placedoffers WHERE jobId=$jobid") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        if($numrows != 0)
        {
            
            return $numrows;
        }else
        {
            return 0;
        }
    }
    
    // Get All Placed Offers By UserID
    function GetAllPlacedOffersByUserID($UserID)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM placedoffers WHERE UserID=$UserID") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $jobArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobId'];
                $dbUserID= $row['userID'];
                $dbComment= $row['comment'];
                $dbPlacementDate = $row['placementDate'];
                $dbOfferPrice = $row['offerPrice'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice);
                array_push($jobArray, $placedOffersEntities);
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
 
    // Get All Placed Offers By UserID
    function GetAllPlacedOffersToUsersJob($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT p.* FROM jobs j, placedoffers p WHERE j.jobid = p.jobid AND j.id =$id") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $jobArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobId'];
                $dbUserID= $row['userID'];
                $dbComment= $row['comment'];
                $dbPlacementDate = $row['placementDate'];
                $dbOfferPrice = $row['offerPrice'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice);
                array_push($jobArray, $placedOffersEntities);
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    // Get The Lowest Placed Offers Price in a specific job
    function GetLowestPlacedOffersByJobId($jobid)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM placedoffers WHERE jobId=$jobid order by offerPrice limit 1") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $jobArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobId'];
                $dbUserID= $row['userID'];
                $dbComment= $row['comment'];
                $dbPlacementDate = $row['placementDate'];
                $dbOfferPrice = $row['offerPrice'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice);
                array_push($jobArray, $placedOffersEntities);
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    // Get All Placed Offers in a specific job by a specific person and return a boolean value
    function GetAllPlacedOffersByJobIdAndUserId($jobid,$userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM placedoffers WHERE jobId=$jobid AND userID=$userId") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $jobArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobId'];
                $dbUserID= $row['userID'];
                $dbComment= $row['comment'];
                $dbPlacementDate = $row['placementDate'];
                $dbOfferPrice = $row['offerPrice'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice);
                array_push($jobArray, $placedOffersEntities);
            }
            
            return 1;
        }else
        {
            return 0;
        }
    }
    
    //Update an offer
    function updateAnOffer($jobid,$userId,$newDate,$offerPrice,$comment)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE placedoffers SET comment='$comment' WHERE jobid=$jobid AND userID=$userId";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $sql = "UPDATE placedoffers SET offerPrice=$offerPrice WHERE jobid=$jobid AND userID=$userId";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }

        $sql = "UPDATE placedoffers SET placementDate='$newDate' WHERE jobid=$jobid AND userID=$userId";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $connection->close();
    }
    
    // Get Placed Offers in a specific job by a specific person
    function GetPlacedOffersByJobIdAndUserId($jobid,$userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM placedoffers WHERE jobId=$jobid AND userID=$userId") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobId'];
                $dbUserID= $row['userID'];
                $dbComment= $row['comment'];
                $dbPlacementDate = $row['placementDate'];
                $dbOfferPrice = $row['offerPrice'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice);
            }
            return $placedOffersEntities;
        }else
        {
            return 0;
        }
    }
    
}
