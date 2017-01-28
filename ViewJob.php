<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require 'Controller/JobController.php';
require 'Model/MessagesModel.php';

session_start();

$jobController = new JobController();

$MessagesModel = new MessagesModel();
$epr='';
$title = "View Job";
$content = "";

$loginStatus= "Login";
$log = "";
$errorMessage = "";

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr == 'view')
{
    $_SESSION['jobId'] = $_GET['jobid'];
    $content = $jobController->ViewJobDetails($_SESSION['jobId']);
    $content .= $jobController->PlaceAnOfferModal();
    $content .= $jobController->UpdateAnOfferModal();
}

if($epr == 'viewfromnotification')
{
    header('Location: updateNotification.php?epr=updateNofication&jobid='.$_GET['jobid'].'&date='.$_GET['date']); 
}

$userobjectForChecking = $jobController->GetUserByJobId($_SESSION['jobId']);

if($userobjectForChecking->username != $_SESSION['username'])
{
    $sidebar = $jobController->ViewJobDetailsSideBar($_SESSION['jobId']);
}  else {
    $sidebar= $jobController->ViewJobDetailsOfYourJobSideBar();
}


if(isset($_SESSION['username']))
{
   $loginStatus="Home";
   $log ="home.php";
   $content = $jobController->ViewJobDetails($_SESSION['jobId']);
   $content .= $jobController->PlaceAnOfferModal();
   $content .= $jobController->UpdateAnOfferModal();
}

$content .= $jobController->SendMessageModal($_SESSION['jobId']);

if (isset($_POST['sendMessage']) && !empty($_POST['messages'])) 
{
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
        // Store the message in the database
        $MessagesModel->SendAMessage($_SESSION['username'], $_SESSION['SendUsername'], $_POST['messages'], $dateTime);
        
        $errorMessage = "Message Sent :)";

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
    
    $tousername = $jobController->GetUserByJobId($_SESSION['jobId'])->username;
    header('Location: placeOffer.php?epr=placed&userId='.$userId.'&comment='.$_POST['comment'].'&offerprice='.$_POST['offerPrice'].'&tousername='.$tousername);
}

//Code to update an offer
//First Check to ensure all fields are not empty
if (isset($_POST['updateOffer']) && !empty($_POST['updateOfferPrice']) && !empty($_POST['updateComment'])) 
{
    $userId = $_SESSION['id'];
    
    $tousername = $jobController->GetUserByJobId($_SESSION['jobId'])->username;
    header('Location: UpdateOffer.php?epr=placed&userId='.$userId.'&comment='.$_POST['updateComment'].'&offerprice='.$_POST['updateOfferPrice'].'&tousername='.$tousername);
}

 
 include 'Template.php'
 ?>

