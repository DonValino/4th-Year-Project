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
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE type=$type AND isActive=1") or die(mysql_error());
        
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
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id);
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
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE jobid=$id AND isActive=1") or die(mysql_error());
        
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
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id);  
            }
            
            return $jobEntities;
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
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE id=$id AND isActive=1") or die(mysql_error());
        
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
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id);  
                array_push($jobArray, $jobEntities);
            }
            
            return $jobArray;
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
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id);  
                array_push($jobArray, $jobEntities);
            }
            
            return $jobArray;
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
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE name LIKE '%$name%' AND isActive=1") or die(mysql_error());
        
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
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id);
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
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE typeId=$typeId AND isActive=1") or die(mysql_error());
        
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
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id);
                array_push($jobArray, $jobEntities);
            }
            
            return $jobArray;
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
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE address LIKE '%$address%' AND isActive=1") or die(mysql_error());
        
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
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id);
                array_push($jobArray, $jobEntities);
            }
            
            return $jobArray;
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
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE qualificationId=$qualification AND isActive=1") or die(mysql_error());
        
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
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id);
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
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE numberOfPeopleRequired=$numberOfPeopleRequired AND isActive=1") or die(mysql_error());
        
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
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id);
                array_push($jobArray, $jobEntities);
                
            }
            
            return $jobArray;
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
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE numberOfDays=$numberOfdaysRequired AND isActive=1") or die(mysql_error());
        
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
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id);
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
        $result = mysqli_query($connection," SELECT * FROM jobs WHERE price BETWEEN $minPrice AND $maxPrice AND isActive=1") or die(mysql_error());
        
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
                $dbNumberOfDays = $row['numberOfDays'];
                $dbNumberOfPeopleRequired = $row['numberOfPeopleRequired'];
                $dbPrice = $row['price'];
                $isActive = $row['isActive'];
                $id = $row['id'];
                
                $jobEntities = new JobEntities($dbJobid,$dbName,$dbDescription,$dbType,$dbQualification,$dbAddress,$dbNumberOfDays,$dbNumberOfPeopleRequired,$dbPrice,$isActive,$id);
                array_push($jobArray, $jobEntities);
                
            }
            
            return $jobArray;
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
                . "(name,description,typeId,qualificationId,address,numberOfDays,numberOfPeopleRequired,price,isActive,id)"
                . "VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
                mysqli_real_escape_string($connection,$jobParameter->name),
                mysqli_real_escape_string($connection,$jobParameter->description),
                mysqli_real_escape_string($connection,$jobParameter->type),
                mysqli_real_escape_string($connection,$jobParameter->qualification),
                mysqli_real_escape_string($connection,$jobParameter->address),
                mysqli_real_escape_string($connection,$jobParameter->numberOfDays),
                mysqli_real_escape_string($connection,$jobParameter->numberOfPeopleRequired),
                mysqli_real_escape_string($connection,$jobParameter->price),
                mysqli_real_escape_string($connection,$jobParameter->isActive),
                mysqli_real_escape_string($connection,$jobParameter->id));
            
        //Define and execute query
        $result = mysqli_query($connection,$query) or die(mysql_error());
        mysqli_close($connection);
    }
    
    //Update a user
    function updateJob($name,$description1,$type,$qualification,$address,$numberOfDays,$numberOfPeopleRequired,$price,$jobid)
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
