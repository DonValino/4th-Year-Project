<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserReviewModel
 *
 * @author Jake Valino
 */
require ("Entities/UserReviewEntities.php");

class UserReviewModel {

    //Insert a new review into the database
    function InsertANewReview($reviewer,$userdid,$description,$punctionalities,$workSatisfaction,$skills, $date)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        
            $query = sprintf("INSERT INTO userreview"
                . "(reviewer,userid,description,punctionality,worksatisfaction,skill,date)"
                . "VALUES('%s','%s','%s','%s','%s','%s','%s')",
                mysqli_real_escape_string($connection,$reviewer),
                mysqli_real_escape_string($connection,$userdid),
                mysqli_real_escape_string($connection,$description),
                mysqli_real_escape_string($connection,$punctionalities),
                mysqli_real_escape_string($connection,$workSatisfaction),
                mysqli_real_escape_string($connection,$skills),
                mysqli_real_escape_string($connection,$date));
            
        if (mysqli_query($connection,$query)) {

        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        mysqli_close($connection);
    }
    
    // Get All Reviews From A Specific User
    function GetUserReviewById($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM userreview WHERE userid=$id") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $reviewsArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId = $row['id'];
                $dbreviewer= $row['reviewer'];
                $dbuserid= $row['userid'];
                $dbdescription = $row['description'];
                $dbpunctionalities = $row['punctionality'];
                $dbworksatisfaction = $row['worksatisfaction'];
                $dbskill = $row['skill'];
                $dbdate = $row['date'];
                
                $userReviewEntities = new UserReviewEntities($dbId,$dbreviewer,$dbuserid,$dbdescription,$dbpunctionalities,$dbworksatisfaction,$dbskill,$dbdate);
                array_push($reviewsArray, $userReviewEntities);
            }
            
            return $reviewsArray;
        }else
        {
            return 0;
        }
    }
    
    // Number of reviews per user
    function GetNumberOfUserReviewById($id)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM userreview WHERE userid=$id") or die(mysql_error());
        
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