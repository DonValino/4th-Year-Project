<?php
session_start();
 
require 'Controller/JobController.php';
$jobController = new JobController();

$title = "Job Overview";
$content = $jobController->CreateJobOverview();
$loginStatus= "";
$log = "";
$errorMessage = "";
$sidebar = $jobController->CreateJobOverviewSidebar();
if(isset($_SESSION['username']))
{
   $loginStatus="Home";
   $log = "home.php";
}

 
 include 'Template.php'
 ?>