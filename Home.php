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
$content .= $jobController->AboutFreelanceMeModal();

///////////////// Check For Notification And display it in badges in the header of the page ///////////////////

$_SESSION['countBadge'] = 0;

require_once 'Model/NotificationModel.php';
$notificationController = new NotificationModel();

require_once 'Model/RequestModel.php';
$requestController = new RequestModel();

require_once 'Model/MessagesModel.php';
$messageController = new MessagesModel();

require_once 'Model/CancelRequestModel.php';
$cancelRequestModel = new CancelRequestModel();

$numOfNotification = $notificationController->CountNotificationByToUsername($_SESSION['username']);
$numOfRequest = $requestController->CountRequestsByTargetUserId($_SESSION['id']);
$numberOfMessages = $messageController->CountAllMyMessages($_SESSION['username']);
$numberOfOfferCancellationRequest = $cancelRequestModel->CountCancelRequestByTargetUserId($_SESSION['id']);

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

if($numberOfOfferCancellationRequest != NULL)
{
     $_SESSION['countBadge'] =  $_SESSION['countBadge'] + $numberOfOfferCancellationRequest;
}
/////////////////                                                              ///////////////////


$errorMessage = "";
$sidebar = $jobController->CreateHomeSideBar();

if(isset($_POST['search']) && !empty($_POST['keyword']))
{
    $keyword = htmlspecialchars($_POST['keyword'],ENT_QUOTES,"UTF-8");
    $_SESSION['search'] = $keyword;
    
    
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

if($epr=='AdminCat')
{
    $id =$_GET['id'];
    $_SESSION['search'] = $id;
    
    //Go to Search Result Page
    header('Location: SearchResult.php?epr=AdminCat');
}

// User Is Admin
if(isset($_SESSION['admin']))
{
    if($_SESSION['admin'] == 1)
    {
        $content = $jobController->CreateAdminDashboard();
        $sidebar = $jobController->CreateAdminHomeSideBar();
        $log = "AccountSettings.php";
    }
}

// Change Year
if(isset($_POST['searchAdminDashboard']) && !empty($_POST['year']))
{

    $_SESSION['yearDate'] = $_POST['year'];
    //Go to Search Result Page
    header('Location: Home.php');
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

if(isset($_SESSION['active']))
{
    if ($_SESSION['active'] == 0)
    {
        require_once 'Model/UserModel.php';
        $userModel = new UserModel();
        $adminusers = $userModel->GetActiveUsers();
        $content = "<p style='color:blue;font-size:18px;text-align:center;'>Your account has been deactivated. Please Contact one of the listed administrator: </p>";
        
        if ($adminusers != null)
        {
            foreach($adminusers as $row)
            {
                if($row->admin == 1)
                {
                    $log = "Logout.php";
                    $loginStatus = "Logout";
                    $sidebar = "";
                    $content .= "<p style='color:green;font-size:18px;text-align:center;'>$row->email</p>";
                }
            }
        }
        
    }
}
 
 include 'Template.php'
 ?>

