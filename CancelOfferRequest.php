<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/CancelRequestController.php';

$cancelRequestController = new CancelRequestController();


$loginStatus= "Login";
$log = "";

if(isset($_SESSION['username']))
{
   $loginStatus="Home";
   $log = "Home.php";
}else
{
    header('Location: index.php');
}

$epr='';
$title = "home";
$content = $cancelRequestController->CancelRequestInfoContent();
$errorMessage = "";
$sidebar = $cancelRequestController->CancelRequestSideBar();

$userIdd = 0;
$jobIdd = 0;
if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='accept')
{
    require_once 'Model/UserModel.php';
    require_once 'Model/PlacedOffersModel.php';
    
    $userIdd =$_GET['userId'];
    $jobIdd =$_GET['jobId'];
    
    $userModel = new UserModel();
    $placedModel = new PlacedOffersModel();
    
    $tousername = $userModel->GetUserById($userIdd)->username;
    
    $cancelRequestController->updateCancelSeen(1, $userIdd, $_SESSION['id'], $jobIdd);
    $cancelRequestController->updateCancelRequestStatus(2, $userIdd, $_SESSION['id'], $jobIdd);
    
    $placedModel->deleteAnOffer($jobIdd, $_SESSION['id']);
    
    header('Location: Notification.php?epr=CancellationOfferAccepted&tousername='.$tousername.'&jobId='.$jobIdd);
    
}

if($epr=='NotificationSentAccepted')
{
    $errorMessage = "Cancellation Request Accepted. Your offer is now cancelled :)";
}

if($epr=='denied')
{
    require_once 'Model/UserModel.php';
    require_once 'Model/PlacedOffersModel.php';
    
    $userIdd =$_GET['userId'];
    $jobIdd =$_GET['jobId'];
    
    $userModel = new UserModel();
    $placedModel = new PlacedOffersModel();
    
    $tousername = $userModel->GetUserById($userIdd)->username;
    
    $cancelRequestController->updateCancelSeen(1, $userIdd, $_SESSION['id'], $jobIdd);
    $cancelRequestController->updateCancelRequestStatus(0, $userIdd, $_SESSION['id'], $jobIdd);
    
    header('Location: Notification.php?epr=CancellationOfferDenied&tousername='.$tousername.'&jobId='.$jobIdd);
}

if($epr=='NotificationSentDenied')
{
    $errorMessage = "Cancellation Request Denied.";
}

 
 include 'Template.php'
 ?>

