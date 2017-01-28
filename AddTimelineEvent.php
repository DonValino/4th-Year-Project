<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

require 'Controller/FollowingTimelineController.php';
$followingTimelineController = new FollowingTimelineController();

$epr='';

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='add')
{
    //Today's date
    $date = new DateTime();
    $dateoffollowed = $date->format('H:i:s d/m/Y');
    $jobid = $_GET['jobid'];
    $followingTimelineController->InsertTimeline($_SESSION['id'], 6, $dateoffollowed, $_GET['jobid']);
    header('Location: home.php');
}

    
?>