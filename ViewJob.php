<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require 'Controller/JobController.php';
require 'Controller/PlacedOffersController.php';
session_start();

$jobController = new JobController();
$placedOffersController = new PlacedOffersController();
$epr='';
$title = "View Job";
$content = "";

$loginStatus= "Login";
$log = "";
$errorMessage = "";
$sidebar = $jobController->ViewJobDetailsSideBar();
if(isset($_SESSION['username']))
{
   $loginStatus=$_SESSION['username'];
   $log = $_SESSION['log'];
   $content = $jobController->ViewJobDetails($_SESSION['jobId']);
   $content .= $placedOffersController->PlaceAnOfferModal();
   $content .= $placedOffersController->UpdateAnOfferModal();
}


if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr == 'offerPlaced')
{
    $errorMessage="Thanks, Offer Placed!!";
}

if($epr == 'offerUpdated')
{
    $errorMessage="Thanks, Offer Updated!!";
}
    
//Code to place an offer
//First Check to ensure all fields are not empty
if (isset($_POST['placeOffer']) && !empty($_POST['offerPrice']) && !empty($_POST['comment'])) 
{
    $userId = $_SESSION['id'];
    $date = new DateTime();
    $dateTime = $date->format('Y-m-d H:i:s');
    $placedOffersController->PlaceAnOffer($_SESSION['jobId'], $userId, $_POST['comment'], $dateTime, $_POST['offerPrice']);
    header('Location: ViewJob.php?epr=offerPlaced');
}

//Code to update an offer
//First Check to ensure all fields are not empty
if (isset($_POST['updateOffer']) && !empty($_POST['updateOfferPrice']) && !empty($_POST['updateComment'])) 
{
    $userId = $_SESSION['id'];
    $date = new DateTime();
    $dateTime = $date->format('Y-m-d H:i:s');
    $placedOffersController->updateAnOffer($_SESSION['jobId'], $userId, $dateTime, $_POST['updateOfferPrice'], $_POST['updateComment']);
    header('Location: ViewJob.php?epr=offerUpdated');
}

 
 include 'Template.php'
 ?>

