<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MessagesModel
 *
 * @author Jake Valino
 */
require ("Entities/MessagesEntities.php");

class MessagesModel {
    
    // Send A Message
    function SendAMessage($fromusername,$tousername, $message, $dateofmessage)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO messages"
                . "(fromusername,tousername,message,dateofmessage,seen)"
                . "VALUES('%s','%s','%s','%s','%s')",
                mysqli_real_escape_string($connection,$fromusername),
                mysqli_real_escape_string($connection,$tousername),
                mysqli_real_escape_string($connection,$message),
                mysqli_real_escape_string($connection,$dateofmessage),
                mysqli_real_escape_string($connection,0));
            
        //Define and execute query
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
    }
    
    //Get Messages Sent by / to a User.
    function GetMyInbox()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection,"SELECT t1.*
FROM messages t1
WHERE t1.id = (SELECT t2.id
                 FROM messages t2
                 WHERE t2.fromusername = t1.fromusername            
                 ORDER BY t2.id DESC
                 LIMIT 1)") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $messageArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbFromUserName= $row['fromusername'];
                $dbToUsername= $row['tousername'];
                $dbMessage = $row['message'];
                $dbDateOfMessage = $row['dateofmessage'];
                $dbSeen = $row['seen'];
                
                $messagesEntities = new MessagesEntities($dbId,$dbFromUserName,$dbToUsername,$dbMessage,$dbDateOfMessage,$dbSeen);
                array_push($messageArray, $messagesEntities);
            }
            
            return $messageArray;
        }else
        {
            return 0;
        }
    }
    
    //Get Messages Sent by / to a User.
    function GetMessages()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM messages") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $messageArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbFromUserName= $row['fromusername'];
                $dbToUsername= $row['tousername'];
                $dbMessage = $row['message'];
                $dbDateOfMessage = $row['dateofmessage'];
                $dbSeen = $row['seen'];
                
                $messagesEntities = new MessagesEntities($dbId,$dbFromUserName,$dbToUsername,$dbMessage,$dbDateOfMessage,$dbSeen);
                array_push($messageArray, $messagesEntities);
            }
            
            return $messageArray;
        }else
        {
            return 0;
        }
    }
    
    
    // Get All Messages Belonging to a user
    function GetAllMyMessages($username)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM messages WHERE tousername='$username'") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $messageArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbId= $row['id'];
                $dbFromUserName= $row['fromusername'];
                $dbToUsername= $row['tousername'];
                $dbMessage = $row['message'];
                $dbDateOfMessage = $row['dateofmessage'];
                $dbSeen = $row['seen'];
                
                $messagesEntities = new MessagesEntities($dbId,$dbFromUserName,$dbToUsername,$dbMessage,$dbDateOfMessage,$dbSeen);
                array_push($messageArray, $messagesEntities);
            }
            
            return $messageArray;
        }else
        {
            return 0;
        }
    }
    
    // Set Message Seen by user.
    function SetMessagesSeen($fromusername,$tousername)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE messages SET seen=1 WHERE fromusername= '$fromusername' AND tousername='$tousername'";

        if (mysqli_query($connection, $sql)) {

        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
    }
    
}
