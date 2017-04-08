<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RevenueModel
 *
 * @author Jake Valino
 */

require ("Entities/RevenueEntities.php");
class RevenueModel {
    
    // Insert A New Revenue
    function InsertANewRevenue($amount,$date,$userId, $adType)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO revenue"
                . "(amount,date,userId,adType)"
                . "VALUES('%s','%s','%s','%s')",
                mysqli_real_escape_string($connection,$amount),
                mysqli_real_escape_string($connection,$date),
                mysqli_real_escape_string($connection,$userId),
                mysqli_real_escape_string($connection,$adType));
            
        if (mysqli_query($connection,$query)) {

        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        mysqli_close($connection);
    }
    
    // Get Revenue User By Id
    function GetRevenueByUserId($userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM revenue WHERE userId=$userId") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $revenues = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $id= $row['id'];
                $dbAmount= $row['amount'];
                $dbDate= $row['date'];
                $dbUserId= $row['userId'];
                $dbAdType= $row['adType'];
                
                
                $revenueEntities = new RevenueEntities($id, $dbAmount, $dbDate, $dbUserId, $dbAdType);
                array_push($revenues, $revenueEntities);
            }
            
            return $revenues;
        }else
        {
            return 0;
        }  
    }
    
    // Get Revenues By adType
    function GetRevenueByAdType($adType)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM revenue WHERE adType=$adType") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $revenues = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $id= $row['id'];
                $dbAmount= $row['amount'];
                $dbDate= $row['date'];
                $dbUserId= $row['userId'];
                $dbAdType= $row['adType'];
                
                
                $revenueEntities = new RevenueEntities($id, $dbAmount, $dbDate, $dbUserId, $dbAdType);
                array_push($revenues, $revenueEntities);
            }
            
            return $revenues;
        }else
        {
            return 0;
        }  
    }
    
    //Get Sum Of Revenue By Month And Year.
    function GetSumRevenueByMonthYear($month,$year,$adType)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT COUNT(*) FROM revenue WHERE MONTH(date) =$month AND YEAR(date) = $year AND adType=$adType GROUP BY id");
        
        $numrows = mysqli_num_rows($result);
        
        if($numrows != 0)
        {
            return $numrows;
        }else
        {
            return 0;
        }
    }
    
    
}
