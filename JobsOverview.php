<?php
session_start();
 
require 'Controller/JobController.php';
$jobController = new JobController();

$loginStatus= "";
$log = "";

if(isset($_SESSION['username']))
{
   $loginStatus="Home";
   $log = "home.php";
}else
{
    header('Location: index.php');
}

$title = "Job Overview";
$content = $jobController->CreateJobOverview();
$errorMessage = "";
$sidebar = $jobController->CreateJobOverviewSidebar();

 include 'Template.php'
 ?>