<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require ("Controller/PlacedOffersController.php");
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
    $placedOffersController->updateAnOffer($_SESSION['jobId'], $_GET['userId'], $dateTime, $_GET['offerprice'], $_GET['comment'] ,$_SESSION['username'],$_GET['tousername'],$_GET['numberOfDays'],$_GET['startDate']);
    header('Location: ViewJob.php?epr=offerUpdated');
}

if($epr == 'placedPB')
{
    $date = new DateTime();
    $dateTime = $date->format('Y-m-d H:i:s');
    $placedOffersController->updateAnOffer($_SESSION['jobId'], $_GET['userId'], $dateTime, $_GET['offerprice'], $_GET['comment'] ,$_SESSION['username'],$_GET['tousername'],$_GET['numberOfDaysUpdate'],$_GET['prefferedCommenceDateUpdate']);
    header('Location: ViewJob.php?epr=offerUpdated');
}
?>
