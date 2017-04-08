<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/ReportController.php';
$reportController = new ReportController();

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
$title = "Submit A Report";

$content = "";

$errorMessage = "";
$sidebar = $reportController->CreateUserProfileSidebar();

if(isset($_POST['submitReport']) && !empty($_POST['description']))
{
    //Today's date
    $date = new DateTime();
    $dateTime = $date->format('Y-m-d H:i:s');
    
    require_once 'Model/JobModel.php';
    $jobModel = new JobModel();
    
    $job = $jobModel->GetJobsByID($_SESSION['jobReportJobId']);
    $description = "Job: ".$job->name.", ".$_POST['description'];
        
    $reportController->InsertANewReport($_SESSION['id'], $description, 4, $dateTime, 0, 1);
   
    header('Location: ReportJob.php?epr=submitted');
}

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='submitted')
{
    $errorMessage="<p style='color:green;font-size:22px;'>Report Submitted :)</p>";
    $content = $reportController->InsertANewJobReportForm($_SESSION['jobReportJobId']);
}

if($epr=='AdminCat')
{
    $id =$_GET['id'];
    $_SESSION['search'] = $id;
    
    //Go to Search Result Page
    header('Location: SearchResult.php?epr=AdminCat');
}

if($epr=='reportjob')
{
    $_SESSION['jobReportJobId'] =$_GET['jobId'];
    $content = $reportController->InsertANewJobReportForm($_SESSION['jobReportJobId']);
}

// User Is Admin
if(isset($_SESSION['admin']))
{
    if($_SESSION['admin'] == 1)
    {
        $log = "AccountSettings.php";
    }
}
 
 include 'Template.php'
 ?>

