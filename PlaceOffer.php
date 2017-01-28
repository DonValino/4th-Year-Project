<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require ("Controller/PlacedOffersController.php");
session_start();
$placedOffersController = new PlacedOffersController();

$epr='';

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr == 'placed')
{
    $date = new DateTime();
    $dateTime = $date->format('Y-m-d H:i:s');
    $placedOffersController->PlaceAnOffer($_SESSION['jobId'], $_GET['userId'],  $_GET['comment'], $dateTime, $_GET['offerprice'],$_SESSION['username'],$_GET['tousername']);
    header('Location: ViewJob.php?epr=offerPlaced');
}
?>
