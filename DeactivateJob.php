<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/DeactivatedJobsController.php';
$deactivatedJobsController = new DeactivatedJobsController();

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
$title = "Job Deactivation";
$id = 0;
$content = "";
$loc = "";

$errorMessage = "";
$sidebar = $deactivatedJobsController->CreateAdminJobSideBar();

if(isset($_POST['submitJobDeactivation']) && !empty($_POST['reason']))
{
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
    require_once 'Model/UserModel.php';
    $userModel = new UserModel();
    
    require_once 'Model/JobModel.php';
    $jobModel = new JobModel();
    
    $userId = $jobModel->GetJobsByID($_SESSION['adminJId'])->id;
    
   $deactivatedJobsController->InsertANewDeactivatedJob($_SESSION['adminJId'], $userId, $_POST['reason'], $dateTime);
   
   $jobModel->updateJobActiveStatus($_SESSION['adminJId'], 0);
   
    require_once 'Model/NotificationModel.php';
    $notificationModel = new NotificationModel();
    
    $notificationModel->InsertNotification("Admin", $userModel->GetUserById($userId)->username, 12, 0, $dateTime, $_SESSION['adminJId']);
   
   header($_SESSION['loc']);
}

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='deactivateFromViewAllJobs')
{
    $_SESSION['adminJId'] =$_GET['id'];
    $_SESSION['loc'] = "location: SearchResult.php?epr=allJobs";
    $content= $deactivatedJobsController->DeactivateJobForm();
}

if($epr=='deactivateFromCategories')
{
    $id =$_GET['id'];
    $_SESSION['loc'] = "location: SearchResult.php?epr=AdminCat";
    $content= $deactivatedJobsController->DeactivateJobForm();
}

if($epr=='deactivateFromPrice')
{
    $id =$_GET['id'];
    $_SESSION['loc'] = "location: SearchResult.php?epr=AdminSearchByPrice";
    $content= $deactivatedJobsController->DeactivateJobForm();
}

// User Is Admin
if(isset($_SESSION['admin']))
{
    if($_SESSION['admin'] == 1)
    {
        $sidebar = $deactivatedJobsController->CreateAdminJobSideBar();
        $log = "AccountSettings.php";
        
    }
}
 
 include 'Template.php'
 ?>

