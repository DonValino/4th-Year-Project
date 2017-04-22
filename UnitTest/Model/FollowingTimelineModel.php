<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FollowingTimeline
 *
 * @author Jake Valino
 */
require ("Entities/FollowingTimelineEntities.php");

class FollowingTimelineModel {
    // Post a new event in the timeline
    function InsertTimeline($userid,$typeid, $dateposted, $jobid)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);

            $query = sprintf("INSERT INTO followingtimeline"
                . "(userid,typeid,dateposted,jobid)"
                . "VALUES('%s','%s','%s','%s')",
                mysqli_real_escape_string($connection,$userid),
                mysqli_real_escape_string($connection,$typeid),
                mysqli_real_escape_string($connection,$dateposted),
                mysqli_real_escape_string($connection,$jobid));
            
        if (mysqli_query($connection,$query)) {

        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        mysqli_close($connection);
    }
    
    //Get All Timeline Events
    function GetAllTimelineEvents()
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM followingtimeline ORDER BY dateposted DESC") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);
        $timelineArray = array();
        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbid= $row['id'];
                $dbuserid= $row['userid'];
                $dbtypeid= $row['typeid'];
                $dbdateposted = $row['dateposted'];
                $dbjobid = $row['jobid'];
                
                $timelineEntities = new FollowingTimelineEntities($dbid,$dbuserid,$dbtypeid,$dbdateposted,$dbjobid);  
                array_push($timelineArray, $timelineEntities);
            }
            
            return $timelineArray;
        }else
        {
            return 0;
        }
    }
}
