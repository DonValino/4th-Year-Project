<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/JobController.php';
require 'Controller/RecommenderController.php';
$jobController = new JobController();
$recommenderController = new RecommenderController();

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

$epr='';
$title = "home";
$content = $jobController->CreateSearchBar();
$content .= $jobController->CategoryModal();
$content .= $jobController->CreateHomeContent($_SESSION['id']);

$content .= $jobController->PriceModal();

///////////////// Check For Notification And display it in badges in the header of the page ///////////////////

$_SESSION['countBadge'] = 0;

require_once 'Model/NotificationModel.php';
$notificationController = new NotificationModel();

require_once 'Model/RequestModel.php';
$requestController = new RequestModel();

require_once 'Model/MessagesModel.php';
$messageController = new MessagesModel();

$numOfNotification = $notificationController->CountNotificationByToUsername($_SESSION['username']);
$numOfRequest = $requestController->CountRequestsByTargetUserId($_SESSION['id']);
$numberOfMessages = $messageController->CountAllMyMessages($_SESSION['username']);

if($numOfNotification != NULL)
{
    $_SESSION['countBadge'] = $numOfNotification;
}

if($numOfRequest != NULL)
{
    $_SESSION['countBadge'] = $_SESSION['countBadge'] + $numOfRequest;
}

if($numberOfMessages != NULL)
{
     $_SESSION['countBadge'] =  $_SESSION['countBadge'] + $numberOfMessages;
}
/////////////////                                                              ///////////////////


$errorMessage = "";
$sidebar = $jobController->CreateHomeSideBar();

if(isset($_POST['search']) && !empty($_POST['keyword']))
{
    $_SESSION['search'] = $_POST['keyword'];
    //Go to Search Result Page
    header('Location: SearchResult.php');
}

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='cat')
{
    $id =$_GET['id'];
    $_SESSION['search'] = $id;
    
    //Today's date
    $date = new DateTime();
    $dateTime = $date->format('d-m-Y H:i:s');
    
    // Check if a record already exist
    $exist = $recommenderController->GetRecordByCatIdAndUserId($id, $_SESSION['id']);
    
    if($exist != NULL)
    {
        $qty = $exist->qty;
        $qty = $qty + 1;
        $recommenderController->updateQtyByCatIdAndUserId($qty, $id, $_SESSION['id']);
    }else
    {
        // Add a new record to recommender table database
        $recommenderController->InsertANewRecord($id, $_SESSION['id'],1, $dateTime);  
    }

    //Go to Search Result Page
    header('Location: SearchResult.php?epr=cat');
}

if($epr=='clear')
{
    // Go to DeleteKeywordSearches.php
    header('Location: DeleteKeywordSearches.php?epr=delete');
}

if($epr=='qua')
{
    $id =$_GET['id'];
    $_SESSION['search'] = $id;
    //Go to Search Result Page
    header('Location: SearchResult.php?epr=qua');
}

if($epr=='location')
{
    $id =$_GET['id'];
    $_SESSION['search'] = $id;
    //Go to Search Result Page
    header('Location: SearchResult.php?epr=location');
}

    if(isset($_POST['searchByPrice']))
    {
        $min =$_POST['min'];
        $max =$_POST['max'];
        header('Location: SearchResult.php?epr=price&min='.$min.'&max='.$max.'');
    }
 
 include 'Template.php'
 ?>

