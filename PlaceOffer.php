<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require ("Controller/PlacedOffersController.php");
require ("Model/JobModel.php");
session_start();
$placedOffersController = new PlacedOffersController();

if(!isset($_SESSION['username']))
{
    header('Location: index.php');
}

$epr='';

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr == 'placedFB')
{
    $date = new DateTime();
    $dateTime = $date->format('Y-m-d H:i:s');
    
    $jobModel = new JobModel();
    $numberOfDays = $jobModel->GetJobsByID($_SESSION['jobId'])->numberOfDays;
    $placedOffersController->PlaceAnOffer($_SESSION['jobId'], $_GET['userId'],  $_GET['comment'], $dateTime, $_GET['offerprice'],$_SESSION['username'],$_GET['tousername'],0,$numberOfDays,$_GET['startDate']);
    header('Location: ViewJob.php?epr=offerPlaced');
}

if($epr == 'placedPB')
{
    $date = new DateTime();
    $dateTime = $date->format('Y-m-d H:i:s');
    
    $numberOfDays=$_GET['numberOfDays'];
    $prefferedCommenceDate = $_GET['prefferedCommenceDate'];
    
    $placedOffersController->PlaceAnOffer($_SESSION['jobId'], $_GET['userId'],  $_GET['comment'], $dateTime, $_GET['offerprice'],$_SESSION['username'],$_GET['tousername'],1,$numberOfDays,$prefferedCommenceDate);
    header('Location: ViewJob.php?epr=offerPlaced');
}

if($epr == 'update')
{
    $jobId = $_GET['jobId'];
    $userId = $_GET['userId'];
    
    $placedOffersController->updateSeen(1, $jobId, $userId);
    header('Location: ViewUserProfile.php?epr=view&id='.$userId);
}

if($epr == 'delete')
{
    $userId = $_GET['userId'];
    $placedOffersController->deleteAnOffer($_SESSION['jobId'], $userId);
    header('Location: ViewJob.php?epr=view&jobid='.$_SESSION['jobId']);
}
?>
