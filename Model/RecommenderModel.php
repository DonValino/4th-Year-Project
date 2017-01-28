<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecommenderModel
 *
 * @author Jake Valino
 */

require ("Entities/RecommenderEntities.php");
class RecommenderModel {
    
    //Insert a new record
    function InsertANewRecord($catId,$userId,$qty,$date)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO recommender"
                . "(catId,userId,qty,date)"
                . "VALUES('%s','%s','%s','%s')",
                mysqli_real_escape_string($connection,$catId),
                mysqli_real_escape_string($connection,$userId),
                mysqli_real_escape_string($connection,$qty),
                mysqli_real_escape_string($connection,$date));
            
        //Define and execute query
        $result = mysqli_query($connection,$query) or die(mysql_error());
        mysqli_close($connection);
    }
    
    // Get Record By userId
    function GetRecordByUserId($userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM recommender WHERE userId=$userId ORDER BY qty DESC LIMIT 4") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $recommenderArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbcatId= $row['catId'];
                $dbuserId= $row['userId'];
                $dbqty= $row['qty'];
                $dbdate= $row['date'];
                
                $recommenderEntities = new RecommenderEntities($dbId,$dbcatId,$dbuserId,$dbqty,$dbdate);  
                array_push($recommenderArray, $recommenderEntities);
            }
            
            return $recommenderArray;
        }else
        {
            return 0;
        }
    }
    
    // Get Record By userId
    function GetRecordByCatIdAndUserId($catId,$userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM recommender WHERE catId='$catId' AND userId=$userId") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);

        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbcatId= $row['catId'];
                $dbuserId= $row['userId'];
                $dbqty= $row['qty'];
                $dbdate= $row['date'];
                
                $recommenderEntities = new RecommenderEntities($dbId,$dbcatId,$dbuserId,$dbqty,$dbdate);  
            }
            
            return $recommenderEntities;
        }else
        {
            return 0;
        }
    }
    
    // Update qty by catId and userId
    function updateQtyByCatIdAndUserId($qty,$catId,$userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE recommender SET qty='$qty' WHERE catId=$catId AND userId=$userId";

        if (mysqli_query($connection, $sql)) {
           
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
}
