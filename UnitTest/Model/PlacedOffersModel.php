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
    function PlaceAnOffer($jobId, $userId, $comment, $date, $offerPrice, $bidType, $numberOfDays, $prefferedCommenceDate)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO placedoffers"
                . "(jobId,userID,comment,placeMentDate,offerPrice,bidType,numberOfDays,prefferedCommenceDate)"
                . "VALUES('%s','%s','%s','%s','%s','%s','%s','%s')",
                mysqli_real_escape_string($connection,$jobId),
                mysqli_real_escape_string($connection,$userId),
                mysqli_real_escape_string($connection,$comment),
                mysqli_real_escape_string($connection,$date),
                mysqli_real_escape_string($connection,$offerPrice),
                mysqli_real_escape_string($connection,$bidType),
                mysqli_real_escape_string($connection,$numberOfDays),
                mysqli_real_escape_string($connection,$prefferedCommenceDate));
            
        //Define and execute query

        if (mysqli_query($connection,$query)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        mysqli_close($connection);
    }
    
    // Get All Placed Offers in a specific job
    function GetAllFullTimeBidPlacedOffersByJobId($jobid)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM placedoffers WHERE jobId=$jobid AND bidType=0") or die(mysql_error());
        
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
                $dbBidType= $row['bidType'];
                $dbNumberOfDays= $row['numberOfDays'];
                $dbPrefferedCommenceDate = $row['prefferedCommenceDate'];
                $dbSeen = $row['seen'];
                $dbStatusChangeDate = $row['statusChangeDate'];
                $dbBidStatus = $row['bidStatus'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice,$dbBidType,$dbNumberOfDays,$dbPrefferedCommenceDate,$dbSeen,$dbStatusChangeDate,$dbBidStatus);
                array_push($jobArray, $placedOffersEntities);
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    // Get All Placed Offers by other users I accepted
    function GetAllPlacedOffersIAccepted($userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT p.* FROM placedoffers p, jobs j WHERE p.jobId=j.jobid AND j.id=$userId AND p.bidStatus=1") or die(mysql_error());
        
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
                $dbBidType= $row['bidType'];
                $dbNumberOfDays= $row['numberOfDays'];
                $dbPrefferedCommenceDate = $row['prefferedCommenceDate'];
                $dbSeen = $row['seen'];
                $dbStatusChangeDate = $row['statusChangeDate'];
                $dbBidStatus = $row['bidStatus'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice,$dbBidType,$dbNumberOfDays,$dbPrefferedCommenceDate,$dbSeen,$dbStatusChangeDate,$dbBidStatus);
                array_push($jobArray, $placedOffersEntities);
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    // Get All Placed Offers in a specific job
    function GetAllPartTimeBidPlacedOffersByJobId($jobid)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM placedoffers WHERE jobId=$jobid AND bidType=1") or die(mysql_error());
        
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
                $dbBidType= $row['bidType'];
                $dbNumberOfDays= $row['numberOfDays'];
                $dbPrefferedCommenceDate = $row['prefferedCommenceDate'];
                $dbSeen = $row['seen'];
                $dbStatusChangeDate = $row['statusChangeDate'];
                $dbBidStatus = $row['bidStatus'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice,$dbBidType,$dbNumberOfDays,$dbPrefferedCommenceDate,$dbSeen,$dbStatusChangeDate,$dbBidStatus);
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
        $result = mysqli_query($connection," SELECT * FROM placedoffers WHERE jobId=$jobid AND bidStatus=1") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        if($numrows != 0)
        {
            return $numrows;
        }else
        {
            return 0;
        }
    }
    
    // Get All Placed In User PrO ffers in a specific job
    function CountViewUserJobNoPlacedOffersByJobId($jobid)
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
                $dbBidType= $row['bidType'];
                $dbNumberOfDays= $row['numberOfDays'];
                $dbPrefferedCommenceDate = $row['prefferedCommenceDate'];
                $dbSeen = $row['seen'];
                $dbStatusChangeDate = $row['statusChangeDate'];
                $dbBidStatus = $row['bidStatus'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice,$dbBidType,$dbNumberOfDays,$dbPrefferedCommenceDate,$dbSeen,$dbStatusChangeDate,$dbBidStatus);
                array_push($jobArray, $placedOffersEntities);
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    // Get All Placed Offers By jobId
    function GetAllPlacedOffersByJobID($jobId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM placedoffers WHERE jobId=$jobId") or die(mysql_error());
        
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
                $dbBidType= $row['bidType'];
                $dbNumberOfDays= $row['numberOfDays'];
                $dbPrefferedCommenceDate = $row['prefferedCommenceDate'];
                $dbSeen = $row['seen'];
                $dbStatusChangeDate = $row['statusChangeDate'];
                $dbBidStatus = $row['bidStatus'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice,$dbBidType,$dbNumberOfDays,$dbPrefferedCommenceDate,$dbSeen,$dbStatusChangeDate,$dbBidStatus);
            }
            
            return $placedOffersEntities;
        }else
        {
            return 0;
        }
    }
    
    // Get All Accepted Placed Offers By UserID
    function GetAllAcceptedPlacedOffersByUserID($UserID)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM placedoffers WHERE UserID=$UserID AND bidStatus=1") or die(mysql_error());
        
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
                $dbBidType= $row['bidType'];
                $dbNumberOfDays= $row['numberOfDays'];
                $dbPrefferedCommenceDate = $row['prefferedCommenceDate'];
                $dbSeen = $row['seen'];
                $dbStatusChangeDate = $row['statusChangeDate'];
                $dbBidStatus = $row['bidStatus'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice,$dbBidType,$dbNumberOfDays,$dbPrefferedCommenceDate,$dbSeen,$dbStatusChangeDate,$dbBidStatus);
                array_push($jobArray, $placedOffersEntities);
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    // Get All Placed Offers By UserID
    function GetAllPlacedOffers()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM placedoffers") or die(mysql_error());
        
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
                $dbBidType= $row['bidType'];
                $dbNumberOfDays= $row['numberOfDays'];
                $dbPrefferedCommenceDate = $row['prefferedCommenceDate'];
                $dbSeen = $row['seen'];
                $dbStatusChangeDate = $row['statusChangeDate'];
                $dbBidStatus = $row['bidStatus'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice,$dbBidType,$dbNumberOfDays,$dbPrefferedCommenceDate,$dbSeen,$dbStatusChangeDate,$dbBidStatus);
                array_push($jobArray, $placedOffersEntities);
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    // Get All Accepted Placed Offers By UserID
    function GetAllAcceptedPlacedOffers()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM placedoffers WHERE bidStatus=1") or die(mysql_error());
        
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
                $dbBidType= $row['bidType'];
                $dbNumberOfDays= $row['numberOfDays'];
                $dbPrefferedCommenceDate = $row['prefferedCommenceDate'];
                $dbSeen = $row['seen'];
                $dbStatusChangeDate = $row['statusChangeDate'];
                $dbBidStatus = $row['bidStatus'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice,$dbBidType,$dbNumberOfDays,$dbPrefferedCommenceDate,$dbSeen,$dbStatusChangeDate,$dbBidStatus);
                array_push($jobArray, $placedOffersEntities);
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    // Get All Denied Placed Offers By UserID
    function GetAllDeniedPlacedOffers()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM placedoffers WHERE bidStatus=0") or die(mysql_error());
        
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
                $dbBidType= $row['bidType'];
                $dbNumberOfDays= $row['numberOfDays'];
                $dbPrefferedCommenceDate = $row['prefferedCommenceDate'];
                $dbSeen = $row['seen'];
                $dbStatusChangeDate = $row['statusChangeDate'];
                $dbBidStatus = $row['bidStatus'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice,$dbBidType,$dbNumberOfDays,$dbPrefferedCommenceDate,$dbSeen,$dbStatusChangeDate,$dbBidStatus);
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
                $dbBidType= $row['bidType'];
                $dbNumberOfDays= $row['numberOfDays'];
                $dbPrefferedCommenceDate = $row['prefferedCommenceDate'];
                $dbSeen = $row['seen'];
                $dbStatusChangeDate = $row['statusChangeDate'];
                $dbBidStatus = $row['bidStatus'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice,$dbBidType,$dbNumberOfDays,$dbPrefferedCommenceDate,$dbSeen,$dbStatusChangeDate,$dbBidStatus);
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
                $dbBidType= $row['bidType'];
                $dbNumberOfDays= $row['numberOfDays'];
                $dbPrefferedCommenceDate = $row['prefferedCommenceDate'];
                $dbSeen = $row['seen'];
                $dbStatusChangeDate = $row['statusChangeDate'];
                $dbBidStatus = $row['bidStatus'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice,$dbBidType,$dbNumberOfDays,$dbPrefferedCommenceDate,$dbSeen,$dbStatusChangeDate,$dbBidStatus);
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
                $dbBidType= $row['bidType'];
                $dbNumberOfDays= $row['numberOfDays'];
                $dbPrefferedCommenceDate = $row['prefferedCommenceDate'];
                $dbSeen = $row['seen'];
                $dbStatusChangeDate = $row['statusChangeDate'];
                $dbBidStatus = $row['bidStatus'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice,$dbBidType,$dbNumberOfDays,$dbPrefferedCommenceDate,$dbSeen,$dbStatusChangeDate,$dbBidStatus);
                array_push($jobArray, $placedOffersEntities);
            }
            
            return 1;
        }else
        {
            return 0;
        }
    }
    
    // Get All User Placed Offers in a specific job by a specific person and return a boolean value
    function GetUserlacedOffersByJobIdAndUserId($jobid,$userId)
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
                $dbBidType= $row['bidType'];
                $dbNumberOfDays= $row['numberOfDays'];
                $dbPrefferedCommenceDate = $row['prefferedCommenceDate'];
                $dbSeen = $row['seen'];
                $dbStatusChangeDate = $row['statusChangeDate'];
                $dbBidStatus = $row['bidStatus'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice,$dbBidType,$dbNumberOfDays,$dbPrefferedCommenceDate,$dbSeen,$dbStatusChangeDate,$dbBidStatus);
            }
            
            return $placedOffersEntities;
        }else
        {
            return 0;
        }
    }
    
    // Get Users Placed Offers
    function GetUsersPlacedOffer($jobid,$userId)
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
                $dbBidType= $row['bidType'];
                $dbNumberOfDays= $row['numberOfDays'];
                $dbPrefferedCommenceDate = $row['prefferedCommenceDate'];
                $dbSeen = $row['seen'];
                $dbStatusChangeDate = $row['statusChangeDate'];
                $dbBidStatus = $row['bidStatus'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice,$dbBidType,$dbNumberOfDays,$dbPrefferedCommenceDate,$dbSeen,$dbStatusChangeDate,$dbBidStatus);
            }
            
            return $placedOffersEntities;
        }else
        {
            return 0;
        }
    }
    
    //Update an offer
    function updateAnOffer($jobid,$userId,$newDate,$offerPrice,$comment,$numberOfDays,$prefferedCommenceDate)
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
        
        $sql = "UPDATE placedoffers SET numberOfDays='$numberOfDays' WHERE jobid=$jobid AND userID=$userId";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $sql = "UPDATE placedoffers SET prefferedCommenceDate='$prefferedCommenceDate' WHERE jobid=$jobid AND userID=$userId";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $connection->close();
    }
    
    //Update seen
    function updateSeen($seen,$jobid,$userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        $sql = "UPDATE placedoffers SET seen='$seen' WHERE jobid=$jobid AND userID=$userId";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $connection->close();
    }
    
    //Update Bid Status
    function updateBidStatus($status,$jobid,$userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        $sql = "UPDATE placedoffers SET bidStatus='$status' WHERE jobid=$jobid AND userID=$userId";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
        $sql = "UPDATE placedoffers SET statusChangeDate='$dateTime' WHERE jobid=$jobid AND userID=$userId";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $connection->close();
    }
    
    //Delete an Offer
    function deleteAnOffer($jobid,$userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
                // sql to delete a record
        $sql = "DELETE FROM placedoffers WHERE jobid=$jobid AND userID=$userId";

        if ($connection->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $connection->error;
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
                $dbBidType= $row['bidType'];
                $dbNumberOfDays= $row['numberOfDays'];
                $dbPrefferedCommenceDate = $row['prefferedCommenceDate'];
                $dbSeen = $row['seen'];
                $dbStatusChangeDate = $row['statusChangeDate'];
                $dbBidStatus = $row['bidStatus'];
                
                $placedOffersEntities = new PlacedOffersEntities($dbJobid,$dbUserID,$dbComment,$dbPlacementDate,$dbOfferPrice,$dbBidType,$dbNumberOfDays,$dbPrefferedCommenceDate,$dbSeen,$dbStatusChangeDate,$dbBidStatus);
            }
            return $placedOffersEntities;
        }else
        {
            return 0;
        }
    }
    
}
