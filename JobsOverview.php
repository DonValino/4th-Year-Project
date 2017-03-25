<?php
session_start();
 
require 'Controller/JobController.php';
$jobController = new JobController();

$loginStatus= "";
$log = "";

if(isset($_SESSION['username']))
{
   $loginStatus="Home";
   $log = "Home.php";
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

$title = "Job Overview";
$content = $jobController->CreateJobOverview();
$errorMessage = "";
$sidebar = $jobController->CreateJobOverviewSidebar();

 include 'Template.php'
 ?>