<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PayPalMeModel
 *
 * @author Jake Valino
 */

require ("Entities/PayPalMeEntities.php");
class PayPalMeModel {

    // Insert A New User Pay Pal Me Account
    function InsertANewPayPalMeAccount($userId, $payPalMeUrl)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO paypalme"
                . "(userId,payPalMeUrl)"
                . "VALUES('%s','%s')",
                mysqli_real_escape_string($connection,$userId),
                mysqli_real_escape_string($connection,$payPalMeUrl));

        if (mysqli_query($connection,$query)) {
            
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        mysqli_close($connection);
    }
    
    // Get PayPalMe Account by userId
    function GetPayPalMeAccountByUserId($userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM paypalme WHERE userId=$userId") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);

        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbUserID= $row['userId'];
                $dbPayPalMeUrl= $row['payPalMeUrl'];
                
                $payPalMeEntities = new PayPalMeEntities($dbId, $dbUserID, $dbPayPalMeUrl);
            }
            return $payPalMeEntities;
        }else
        {
            return 0;
        }
    }
    
    //Update a user's PayPalMe Account
    function updateUserPayPalMeAccount($payPalMeUrl,$userId)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        $sql = "UPDATE paypalme SET payPalMeUrl='$payPalMeUrl' WHERE userId=$userId";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        $connection->close();
    }
}
