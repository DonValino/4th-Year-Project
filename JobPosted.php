<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/JobController.php';
$jobController = new JobController();

$epr='';
$title = "Job Posted";
$content = "";

$loginStatus= "Login";
$log = "";
$errorMessage = "";
$sidebar = "";
if(isset($_SESSION['username']))
{
   $loginStatus="Home";
   $log = "home.php";
}

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='view')
{
    $userId = $_GET['id'];
    $content = $jobController->JobPostedContent($userId);
    $content.= $jobController->SendMessageFromUserJobPostedModal($userId);
    $sidebar = $jobController->ViewUserProfileSideBar($userId);
}
 
 include 'Template.php'
 ?>