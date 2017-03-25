<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/NotificationController.php';
$notificationController = new NotificationController();

$loginStatus= "Login";
$log = "";

if(isset($_SESSION['username']))
{
   $loginStatus=$_SESSION['username'];
   $log = $_SESSION['log'];
}else
{
    header('Location: index.php');
}

// User Is Admin
if(isset($_SESSION['admin']))
{
    if($_SESSION['admin'] == 1)
    {
        // Go Back To Home Page
         header('Location: Home.php');
    }
}

$epr='';
$title = "Notification";
$content = $notificationController->NotificationContent();
$content .= $notificationController->CategoryModal();
$content .= $notificationController->PriceModal();

$errorMessage = "";
$sidebar = $notificationController->CreateNotificationSideBar();

if(isset($_POST['search']) && !empty($_POST['keyword']))
{
    $_SESSION['search'] = $_POST['keyword'];
    //Go to Search Result Page
    header('Location: SearchResult.php');
}

if(isset($_POST['searchByPrice']))
{
    $min =$_POST['min'];
    $max =$_POST['max'];
    header('Location: SearchResult.php?epr=price&min='.$min.'&max='.$max.'');
}

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='cat')
{
    $id =$_GET['id'];
    $_SESSION['search'] = $id;
    //Go to Search Result Page
    header('Location: SearchResult.php?epr=cat');
}

if($epr=='CancellationOfferAccepted')
{
    $tousername =$_GET['tousername'];
    $jobId =$_GET['jobId'];
    
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
    
    $notificationController->InsertNotification($_SESSION['username'], $tousername, 9, 0, $dateTime, $jobId);
    
    //Go to Search Result Page
    header('Location: CancelOfferRequest.php?epr=NotificationSentAccepted');
}

if($epr=='CancellationOfferDenied')
{
    $tousername =$_GET['tousername'];
    $jobId =$_GET['jobId'];
    
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
    
    $notificationController->InsertNotification($_SESSION['username'], $tousername, 10, 0, $dateTime, $jobId);
    
    //Go to Search Result Page
    header('Location: CancelOfferRequest.php?epr=NotificationSentDenied');
}

if($epr=='sendAccepted')
{
    $userId =$_GET['userId'];
    $tousername = $_GET['tousername'];
    
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
    $notificationController->InsertNotification($_SESSION['username'], $tousername, 3, 0, $dateTime, $_SESSION['jobId']);
    //Go to ViewJob Page
    header('Location: ViewJob.php?epr=viewJobAcceptedOffer&jobid='.$_SESSION['jobId']);
}

if($epr=='sendDeclined')
{
    $userId =$_GET['userId'];
    $tousername = $_GET['tousername'];
    
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
    $notificationController->InsertNotification($_SESSION['username'], $tousername, 4, 0, $dateTime, $_SESSION['jobId']);
    //Go to ViewJob Page
    header('Location: ViewJob.php?epr=viewDeclineOffer&jobid='.$_SESSION['jobId']);
}
 
include 'Template.php'
?>

