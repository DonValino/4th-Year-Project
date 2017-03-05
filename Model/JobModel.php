<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JobModel
 *
 * @author Jake Valino
 */
require ("Entities/JobEntities.php");

class JobModel {
    //put your code here
    
    //Get Jobs in a particular type from the database.
    function GetJobByType($type)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE type=$type AND isActive=1");
        
        $numrows = mysqli_num_rows($result);
        $jobArray = array();
        
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobid'];
                $dbName= $row['name'];
                $dbDescription= $row['description'];
                $dbType = $row['typeId'];
                $dbQualification = $row['qualificationId'];
                $dbAddress = $row['address'];
                $dbCounty = $row['County'];
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                $date = $row['date'];
                $startDate = $row['startDate'];
                $adType = $row['adType'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbCounty,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id,$date,$startDate,$adType);
                array_push($jobArray, $jobEntities);
                
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    //Get Job By ID.
    function GetJobsByID($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE jobid=$id") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);

        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobid'];
                $dbName= $row['name'];
                $dbDescription= $row['description'];
                $dbType = $row['typeId'];
                $dbQualification = $row['qualificationId'];
                $dbAddress = $row['address'];
                $dbCounty = $row['county'];
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                $date = $row['date'];
                $startDate = $row['startDate'];
                $adType = $row['adType'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbCounty,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id,$date,$startDate,$adType);  
            }
            
            return $jobEntities;
        }else
        {
            return 0;
        }
    }  
    
    //Get Job By ID.
    function GetActiveJobsByUserID($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE id=$id ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $jobArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobid'];
                $dbName= $row['name'];
                $dbDescription= $row['description'];
                $dbType = $row['typeId'];
                $dbQualification = $row['qualificationId'];
                $dbAddress = $row['address'];
                $dbCounty = $row['county'];
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                $date = $row['date'];
                $startDate = $row['startDate'];
                $adType = $row['adType'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbCounty,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id,$date,$startDate,$adType);  
                array_push($jobArray, $jobEntities);
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    //Get Job By ID.
    function GetJobsByUserID($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE id=$id ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $jobArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobid'];
                $dbName= $row['name'];
                $dbDescription= $row['description'];
                $dbType = $row['typeId'];
                $dbQualification = $row['qualificationId'];
                $dbAddress = $row['address'];
                $dbCounty = $row['county'];
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                $date = $row['date'];
                $startDate = $row['startDate'];
                $adType = $row['adType'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbCounty,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id,$date,$startDate,$adType);  
                array_push($jobArray, $jobEntities);
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    // Get Jobs By Location
    function GetJobsByLocation($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE county=$id AND isActive=1 ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $jobArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobid'];
                $dbName= $row['name'];
                $dbDescription= $row['description'];
                $dbType = $row['typeId'];
                $dbQualification = $row['qualificationId'];
                $dbAddress = $row['address'];
                $dbCounty = $row['county'];
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                $date = $row['date'];
                $startDate = $row['startDate'];
                $adType = $row['adType'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbCounty,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id,$date,$startDate,$adType);  
                array_push($jobArray, $jobEntities);
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    // Get Number Of Jobs Per Category
    function GetNumberOfJobsPerCategory($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE typeId=$id AND isActive=1 ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        if($numrows != 0)
        { 
            return $numrows;
        }else
        {
            return 0;
        }
    }
    
    // Get Number Of Jobs Per Category
    function GetNumberOfJobsPerQualification($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE qualificationId=$id AND isActive=1 ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        if($numrows != 0)
        { 
            return $numrows;
        }else
        {
            return 0;
        }
    }
    
    // Get Number Of Jobs Per Location
    function GetNumberOfJobsPerLocation($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE county=$id AND isActive=1 ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        if($numrows != 0)
        { 
            return $numrows;
        }else
        {
            return 0;
        }
    }
    
    // Get Highest Priced Jobs
    function GetHighestPricedJobs($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE id NOT IN ( $id ) ORDER BY price DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $jobArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobid'];
                $dbName= $row['name'];
                $dbDescription= $row['description'];
                $dbType = $row['typeId'];
                $dbQualification = $row['qualificationId'];
                $dbAddress = $row['address'];
                $dbCounty = $row['county'];
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                $date = $row['date'];
                $startDate = $row['startDate'];
                $adType = $row['adType'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbCounty,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id,$date,$startDate,$adType);  
                array_push($jobArray, $jobEntities);
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    //Get Job By Name.
    function CountJobsByName($name)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE name LIKE '%$name%' AND isActive=1") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);

        if($numrows != 0)
        {
            return $numrows;
        }else
        {
            return 0;
        }
    }

    //Get Job By Name.
    function GetJobsByName($name)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE name LIKE '%$name%' AND isActive=1 ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $jobArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobid'];
                $dbName= $row['name'];
                $dbDescription= $row['description'];
                $dbType = $row['typeId'];
                $dbQualification = $row['qualificationId'];
                $dbAddress = $row['address'];
                $dbCounty = $row['county'];
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                $date = $row['date'];
                $startDate = $row['startDate'];
                $adType = $row['adType'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbCounty,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id,$date,$startDate,$adType);
                array_push($jobArray, $jobEntities);
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    //Get Job By Category.
    function GetJobsByCategory($typeId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE typeId=$typeId AND isActive=1 ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $jobArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobid'];
                $dbName= $row['name'];
                $dbDescription= $row['description'];
                $dbType = $row['typeId'];
                $dbQualification = $row['qualificationId'];
                $dbAddress = $row['address'];
                $dbCounty = $row['county'];
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                $date = $row['date'];
                $startDate = $row['startDate'];
                $adType = $row['adType'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbCounty,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id,$date,$startDate,$adType);
                array_push($jobArray, $jobEntities);
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    //Get Job By Category.
    function CountJobsByCategory($typeId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE typeId=$typeId AND isActive=1 ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);

        if($numrows != 0)
        {
            return $numrows;
        }else
        {
            return 0;
        }
    }
    
    //Get Job By Top 4 Category.
    function GetJobsByTop4Category($typeId1,$typeId2,$typeId3,$typeId4)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE typeId=$typeId1 OR typeId=$typeId2 OR typeId=$typeId3 OR typeId=$typeId4 AND isActive=1 ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $jobArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobid'];
                $dbName= $row['name'];
                $dbDescription= $row['description'];
                $dbType = $row['typeId'];
                $dbQualification = $row['qualificationId'];
                $dbAddress = $row['address'];
                $dbCounty = $row['county'];
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                $date = $row['date'];
                $startDate = $row['startDate'];
                $adType = $row['adType'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbCounty,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id,$date,$startDate,$adType);
                array_push($jobArray, $jobEntities);
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    //Get Job By Top 4 Category.
    function CountJobsByTop4Category($typeId1,$typeId2,$typeId3,$typeId4)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE typeId=$typeId1 OR typeId=$typeId2 OR typeId=$typeId3 OR typeId=$typeId4 AND isActive=1 ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);

        if($numrows != 0)
        {
            return $numrows;
        }else
        {
            return 0;
        }
    }
    
     //Get Job By Name.
    function GetJobsByAddress($address)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE address LIKE '%$address%' AND isActive=1 ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $jobArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobid'];
                $dbName= $row['name'];
                $dbDescription= $row['description'];
                $dbType = $row['typeId'];
                $dbQualification = $row['qualificationId'];
                $dbAddress = $row['address'];
                $dbCounty = $row['county'];
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                $date = $row['date'];
                $startDate = $row['startDate'];
                $adType = $row['adType'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbCounty,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id,$date,$startDate,$adType);
                array_push($jobArray, $jobEntities);
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
     //Get All Job Addresses.
    function GetJobAddresses()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE isActive=1 ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $address = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbAddress = $row['address'];

                array_push($address, $dbAddress);
            }
            
            return $address;
        }else
        {
            return 0;
        }
    }
    
     //Get All Job Names.
    function GetJobNames()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE isActive=1 ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $address = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbName = $row['name'];

                array_push($address, $dbName);
            }
            
            return $address;
        }else
        {
            return 0;
        }
    }
    
     //Get All Job Ids.
    function GetJobIds()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE isActive=1 ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $ids = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId = $row['jobid'];

                array_push($ids, $dbId);
            }
            
            return $ids;
        }else
        {
            return 0;
        }
    }
    
     //Get All Descriptions.
    function GetJobDescription()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE isActive=1 ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $descriptions = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbDescription = $row['description'];

                array_push($descriptions, $dbDescription);
            }
            
            return $descriptions;
        }else
        {
            return 0;
        }
    }
    
    //Get Jobs By Qualification.
    function GetJobsByQualification($qualification)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE qualificationId=$qualification AND isActive=1 ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $jobArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobid'];
                $dbName= $row['name'];
                $dbDescription= $row['description'];
                $dbType = $row['typeId'];
                $dbQualification = $row['qualificationId'];
                $dbAddress = $row['address'];
                $dbCounty = $row['county'];
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                $date = $row['date'];
                $startDate = $row['startDate'];
                $adType = $row['adType'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbCounty,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id,$date,$startDate,$adType);
                array_push($jobArray, $jobEntities);
                
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    //Get Jobs By Number of people Required.
    function GetJobsByNumberOfPeopleRequired($numberOfPeopleRequired)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE numberOfPeopleRequired=$numberOfPeopleRequired AND isActive=1 ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $jobArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobid'];
                $dbName= $row['name'];
                $dbDescription= $row['description'];
                $dbType = $row['typeId'];
                $dbQualification = $row['qualificationId'];
                $dbAddress = $row['address'];
                $dbCounty = $row['county'];
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                $date = $row['date'];
                $startDate = $row['startDate'];
                $adType = $row['adType'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbCounty,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id,$date,$startDate,$adType);
                array_push($jobArray, $jobEntities);
                
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    //Get Jobs By Number of Days Required.
    function GetLastpostedJobs()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE isActive=1 ORDER BY jobid DESC LIMIT 1") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);

        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobid'];
                $dbName= $row['name'];
                $dbDescription= $row['description'];
                $dbType = $row['typeId'];
                $dbQualification = $row['qualificationId'];
                $dbAddress = $row['address'];
                $dbCounty = $row['county'];
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                $date = $row['date'];
                $startDate = $row['startDate'];
                $adType = $row['adType'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbCounty,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id,$date,$startDate,$adType);  
            }
            
            return $jobEntities;
        }else
        {
            return 0;
        }
    }
    
    //Get Jobs By Number of Days Required.
    function GetJobsByNumberOfDaysRequired($numberOfdaysRequired)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE numberOfDays=$numberOfdaysRequired AND isActive=1 ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $jobArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobid'];
                $dbName= $row['name'];
                $dbDescription= $row['description'];
                $dbType = $row['typeId'];
                $dbQualification = $row['qualificationId'];
                $dbAddress = $row['address'];
                $dbCounty = $row['county'];
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                $date = $row['date'];
                $startDate = $row['startDate'];
                $adType = $row['adType'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbCounty,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id,$date,$startDate,$adType);
                array_push($jobArray, $jobEntities);
                
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    
    //Get Jobs By between prices.
    function GetJobsBetweenPrices($minPrice,$maxPrice)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE price BETWEEN $minPrice AND $maxPrice AND isActive=1 ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $jobArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbJobid= $row['jobid'];
                $dbName= $row['name'];
                $dbDescription= $row['description'];
                $dbType = $row['typeId'];
                $dbQualification = $row['qualificationId'];
                $dbAddress = $row['address'];
                $dbCounty = $row['county'];
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                $date = $row['date'];
                $startDate = $row['startDate'];
                $adType = $row['adType'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbCounty,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id,$date,$startDate,$adType);
                array_push($jobArray, $jobEntities);
                
            }
            
            return $jobArray;
        }else
        {
            return 0;
        }
    }
    
    // Count Jobs By between prices.
    function CountJobsBetweenPrices($minPrice,$maxPrice)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE price BETWEEN $minPrice AND $maxPrice AND isActive=1 ORDER BY date DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        
        if($numrows != 0)
        {
            return $numrows;
        }else
        {
            return 0;
        }
    }
    
    
    //Insert a new user into the database
    function InsertANewJob($jobParameter)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO jobs"
                . "(name,description,typeId,qualificationId,address,county,numberOfDays,numberOfPeopleRequired,price,isActive,id,date,startDate,adType)"
                . "VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
                mysqli_real_escape_string($connection,$jobParameter->name),
                mysqli_real_escape_string($connection,$jobParameter->description),
                mysqli_real_escape_string($connection,$jobParameter->type),
                mysqli_real_escape_string($connection,$jobParameter->qualification),
                mysqli_real_escape_string($connection,$jobParameter->address),
                mysqli_real_escape_string($connection,$jobParameter->county),
                mysqli_real_escape_string($connection,$jobParameter->numberOfDays),
                mysqli_real_escape_string($connection,$jobParameter->numberOfPeopleRequired),
                mysqli_real_escape_string($connection,$jobParameter->price),
                mysqli_real_escape_string($connection,$jobParameter->isActive),
                mysqli_real_escape_string($connection,$jobParameter->id),
                mysqli_real_escape_string($connection,$jobParameter->date),
                mysqli_real_escape_string($connection,$jobParameter->startDate),
                mysqli_real_escape_string($connection,$jobParameter->adType));
            

        if (mysqli_query($connection, $query)) {
           
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        mysqli_close($connection);
    }
    
    //Insert a new job into the database
    function InsertANewJobPaymentCompleted($name, $description, $type, $qualification, $address, $county, $numberOfDays, $numberOfPeopleRequired, $price, $isActive, $id, $dateTime,$startDate, $adType)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO jobs"
                . "(name,description,typeId,qualificationId,address,county,numberOfDays,numberOfPeopleRequired,price,isActive,id,date,startDate,adType)"
                . "VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
                mysqli_real_escape_string($connection,$name),
                mysqli_real_escape_string($connection,$description),
                mysqli_real_escape_string($connection,$type),
                mysqli_real_escape_string($connection,$qualification),
                mysqli_real_escape_string($connection,$address),
                mysqli_real_escape_string($connection,$county),
                mysqli_real_escape_string($connection,$numberOfDays),
                mysqli_real_escape_string($connection,$numberOfPeopleRequired),
                mysqli_real_escape_string($connection,$price),
                mysqli_real_escape_string($connection,$isActive),
                mysqli_real_escape_string($connection,$id),
                mysqli_real_escape_string($connection,$dateTime),
                mysqli_real_escape_string($connection,$startDate),
                mysqli_real_escape_string($connection,$adType));
            

        if (mysqli_query($connection, $query)) {
           
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        mysqli_close($connection);
    }
    
    //Update a job
    function updateJob($name,$description1,$type,$qualification,$address,$numberOfDays,$county,$numberOfPeopleRequired,$price,$jobid,$startDate)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE jobs SET name='$name' WHERE jobid=$jobid";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $sql = "UPDATE jobs SET description='$description1' WHERE jobid=$jobid";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $sql = "UPDATE jobs SET typeid='$type' WHERE jobid=$jobid";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $sql = "UPDATE jobs SET qualificationId='$qualification' WHERE jobid=$jobid";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $sql = "UPDATE jobs SET address='$address' WHERE jobid=$jobid";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $sql = "UPDATE jobs SET numberOfDays='$numberOfDays' WHERE jobid=$jobid";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }  
        
        $sql = "UPDATE jobs SET numberOfPeopleRequired='$numberOfPeopleRequired' WHERE jobid=$jobid";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        } 
         
        $sql = "UPDATE jobs SET price=$price WHERE jobid=$jobid";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        } 
        
        $sql = "UPDATE jobs SET county=$county WHERE jobid=$jobid";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $sql = "UPDATE jobs SET startDate='$startDate' WHERE jobid=$jobid";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $connection->close();
    }
    
    //Update a job to be a featured job
    function updateStandardJobToFeaturedJob($jobid,$adType)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        $sql = "UPDATE jobs SET adType='$adType' WHERE jobid=$jobid";

        if (mysqli_query($connection, $sql)) {

        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $connection->close();
    }
    
    //Update a job posted date
    function updateJobPostedDate($jobid,$date)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        $sql = "UPDATE jobs SET date='$date' WHERE jobid=$jobid";

        if (mysqli_query($connection, $sql)) {

        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $connection->close();
    }
    
    //Update a job active status
    function updateJobActiveStatus($jobid,$activeStatus)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        $sql = "UPDATE jobs SET isActive='$activeStatus' WHERE jobid=$jobid";

        if (mysqli_query($connection, $sql)) {

        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $connection->close();
    }
    
    //Update a job Ad Type
    function updateJobAdType($jobid,$adType)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        $sql = "UPDATE jobs SET adType='$adType' WHERE jobid=$jobid";

        if (mysqli_query($connection, $sql)) {

        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $connection->close();
    }
    
    //Update a job Date
    function updateJobDate($jobid,$date)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        $sql = "UPDATE jobs SET date='$date' WHERE jobid=$jobid";

        if (mysqli_query($connection, $sql)) {

        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $connection->close();
    }
    
    //Delete a job
    function deleteJob($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
                // sql to delete a record
        $sql = "DELETE FROM jobs WHERE id=$id";

        if ($connection->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $connection->error;
        }

        $connection->close();
    }
    
    
}
